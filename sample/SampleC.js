import React,{useState,useEffect} from 'react';
import './{{tableName}}.css';
import { Col, Container, Row,Offcanvas,Button } from 'react-bootstrap';
import Search from '../Header/FormControllers/Search';
import Color from '../Header/FormControllers/Color';
import Date from '../Header/FormControllers/Date';
import DateTimeLocal from '../Header/FormControllers/DateTimeLocal';
import File from '../Header/FormControllers/File';
import Mail from '../Header/FormControllers/Mail';
import Month from '../Header/FormControllers/Month';
import Number from '../Header/FormControllers/Number';
import Telephone from '../Header/FormControllers/Telephone';
import Text from '../Header/FormControllers/Text';
import Time from '../Header/FormControllers/Time';
import Week from '../Header/FormControllers/Week';
import Range from '../Header/FormControllers/Range';
import Url from '../Header/FormControllers/Url';
import Radio from '../Header/FormControllers/Radio';
import Reset from '../Header/FormControllers/Reset';
import CheckBox from '../Header/FormControllers/CheckBox';
import List from '../Header/FormControllers/List';

function OffCanvas{{tableName}}({ name, ...props }) {    const [show, setShow] = useState(false);
  
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
    const [addData , setAddData]= useState([]);
       const handleAddFormChange =(e) =>{
           e.preventDefault();
            const fieldName = e.target.getAttribute('name');
            const fieldvalue = e.target.value;
            const newAddData = {...addData};
            newAddData[ fieldName]  = fieldvalue;
            setAddData(newAddData);     
          };
      
            
             const newAddedDatas =[ ...addData , newAddedData];
     
               setAddData(newAddedDatas);
              JSON.stringify(addData)
            };

    return (
      <>
        <Button variant="primary" onClick={handleShow} className="me-2">
        Add New
        </Button>
        <Offcanvas show={show} onHide={handleClose} {...props} style={{"width":"600px"}}>
          <Offcanvas.Header closeButton>
            <Offcanvas.Title>sample form</Offcanvas.Title>
          </Offcanvas.Header>
          <Offcanvas.Body>
          <div className='container-fluid noValidates FcOne ' >
        <h1 className='text-center'>FormControlsMaster</h1>
        <hr/>
      <form  noValidate>
        <div>
        {{tableContent}}
        </div>
        <div className='row justify-content-end' >
            <div className='col-4 ' style={{"margin":"20px 30px 10px 10px"}}> 
            <Col>{edit ? (<button onClick={{{tableName}}updateHandler}  className="btn btn-primary" >Update</button>) : (<button onClick={{{tableName}}submitHandler}  className="btn btn-primary" >Submit</button>)}</Col>             
            </div>            
        </div>
      </form>
    </div>         
	 </Offcanvas.Body>
        </Offcanvas>
      </>
    );
  }

const {{tableName}} = () => {
  const [rows, setRows] = useState([{}]);
  const [addFormData,setAddFormData] = useState ([]);
   const [editFormData,setEditFormData] = useState ([])
   const [tableData,set{{tableName}}tableData] = useState ([]);
  const [edit,setEdit] = useState(false)

    const columnsArray = [''] ; // pass columns here dynamically
    //const columnsArray1 = [''];  
    
    const handleAddRow = () => {
      const item = {};
      setRows([...rows, item]);
    };
  
    // const postResults = () => {
    //   console.log(rows); // There you go, do as you please
    // };
    const handleRemoveSpecificRow = (idx) => {
      const tempRows = [...rows]; // to avoid  direct state mutation
      tempRows.splice(idx, 1);
      setRows(tempRows);
    };
    const {{tableName}}editHandler=(e)=>{
      e.preventDefault();
      const updateFormData = {...editFormData};
      updateFormData['{{tableName}}_Id'] = e.target.parentElement.getAttribute("id");
      setEditFormData(updateFormData);
      setEdit(true);
  
       }
       const {{tableName}}updateHandler=(e)=>{
        e.preventDefault();
          //   setButtons(contacts);
         
          var formData = new FormData();
         {{tableData1}}
      
          fetch('https://api.ihms360.com/C_{{tableName}}/add', {  // Enter your IP address here
      
            method: 'POST', 
            //headers :{ 'Content-Type' : 'application/json'},
            mode: 'cors', 
            body: formData// body data type must match "Content-Type" header
          }).then(response => response.json())
          .then((data) => {
            if (data.status === "true") {
              {{tableName}}fetchHandler()
            }
          });
         }
         useEffect(() => {
          {{tableName}}fetchHandler()
        }, [])
        const {{tableName}}fetchHandler=(e)=>{
            fetch('https://api.ihms360.com/C_{{tableName}}/list', {  // Enter your IP address here
        
              method: 'POST', 
              //headers :{ 'Content-Type' : 'application/json'},
              mode: 'cors', 
              body: {}// body data type must match "Content-Type" header
            }).then(response => response.json())
            .then((data) => {
              if (data.status === "true") {
                set{{tableName}}tableData(data.list);
              }
            });
           }
           const {{tableName}}submitHandler=(e)=>{
            e.preventDefault();
              //   setButtons(contacts);
             
              var formData = new FormData();
             {{tableData}}
          
          
              // formData.append('fields', JSON.stringify(contacts));
          
              fetch('https://api.ihms360.com/C_{{tableName}}/add', {  // Enter your IP address here
          
                method: 'POST', 
                //headers :{ 'Content-Type' : 'application/json'},
                mode: 'cors', 
                body: formData// body data type must match "Content-Type" header
              }).then(response => response.json())
              .then((data) => {
                if (data.status === "true") {
                  {{tableName}}fetchHandler()
                }
              });
             }


  return (
    <Container>
    <section>
     <div>
         <Row>
             <Col className="d-flex justify-content-end mt-3">
             {[ 'end',].map((placement, idx) => (
     <OffCanvas{{tableName}} key={idx} placement={placement} name={placement} />
   ))}
             </Col>
         </Row>
     </div>
	 <div>
	 {{tableDataContent}}
	 </div>
    </section>
    <br/>
       <section>
        <div>
            <Row>
                <Col>
               {{tableDataContent}}
                </Col>
                
            </Row>
        </div>
       </section>
 </Container>
  )
}

export default Sample
