import React,{useState} from 'react';
import { Col, Container, Row,Offcanvas,Button } from 'react-bootstrap';
import './{{tableName}}Form.css';
import CheckBox from '../Header/FormControllers/CheckBox';
import Color from '../Header/FormControllers/Color';
import Date from '../Header/FormControllers/Date';
import DateTimeLocal from '../Header/FormControllers/DateTimeLocal';
import File from '../Header/FormControllers/File';
import List from '../Header/FormControllers/List';
import Mail from '../Header/FormControllers/Mail';
import Month from '../Header/FormControllers/Month';
import Number from '../Header/FormControllers/Number';
import Radio from '../Header/FormControllers/Radio';
import Range from '../Header/FormControllers/Range';
import Reset from '../Header/FormControllers/Reset';
import Search from '../Header/FormControllers/Search';
import Telephone from '../Header/FormControllers/Telephone';
import Text from '../Header/FormControllers/Text';
import Time from '../Header/FormControllers/Time';
import Url from '../Header/FormControllers/Url';
import Week from '../Header/FormControllers/Week';



function OffCanvasExample({ name, ...props }) {
    const [show, setShow] = useState(false);
  
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
  
    const [{{tableName}}Data , set{{tableName}}Data]= useState(
      {
           Text:'',
           Radio:'',
           Telephone:'',
           Number:'',
           File:'',
           Mail:'',
           Date:'',
           Color:'',
           Week:'',
           Search:'',
           Time:'',
           Month:'',
           DateTimeLocal:'',
           Reset:'',
            Url:'',
            List:'',
           Range:'',
           CheckBox:''
     
       });
       const handle{{tableName}}FormChange =(e) =>{
           e.preventDefault();
            const fieldName = e.target.getAttribute('name');
            const fieldvalue = e.target.value;
            const new{{tableName}}Data = {...{{tableName}}Data};
            new{{tableName}}Data[ fieldName]  = fieldvalue;
            set{{tableName}}Data(new{{tableName}}Data);     
          };
      
            const handle{{tableName}}FormSubmit =(e)=>{                                                   
             e.preventDefault();
             const new{{tableName}}edData ={
                Text:{{tableName}}Data.Text,
               Telephone:{{tableName}}Data.Telephone,
               Number:{{tableName}}Data.Number,
               File:{{tableName}}Data.File,
               Mail:{{tableName}}Data.Mail,
               Date:{{tableName}}Data.Date,
               Color:{{tableName}}Data.Color,
               Week:{{tableName}}Data.Week,
               Search:{{tableName}}Data.Search,
               Range:{{tableName}}Data.Range,
               Month:{{tableName}}Data.Month,
               DateTimeLocal:{{tableName}}Data.DateTimeLocal,
               Url:{{tableName}}Data.Url,
               Time:{{tableName}}Data.Time,
               Radio:{{tableName}}Data.Radio,
               List:{{tableName}}Data.List,   
               CheckBox:{{tableName}}Data.CheckBox,
               Reset:{{tableName}}Data.Reset
             };
        
             const new{{tableName}}edDatas =[ ...{{tableName}}Data , new{{tableName}}edData];
     
               set{{tableName}}Data(new{{tableName}}edDatas);
              JSON.stringify({{tableName}}Data)
            };
    return (
      <>
        <Button variant="primary" onClick={handleShow} className="me-2">
        Controllers
        </Button>
        <Offcanvas show={show} onHide={handleClose} {...props} style={{"width":"600px"}}>
          <Offcanvas.Header closeButton>
            <Offcanvas.Title>sample form</Offcanvas.Title>
          </Offcanvas.Header>
          <Offcanvas.Body>
          <div className='container-fluid noValidates FcOne ' >
        <h1 className='text-center'>FormControlsMaster</h1>
        <hr/>
      <form  noValidate   onSubmit={handle{{tableName}}FormSubmit}>
        <div  onChange={handle{{tableName}}FormChange}>
        <Text/>
        <br/>
        <Telephone/>
        <br/>
        <Number/>
        <br/>
        <File/>
        <br/>
        <Mail/>
        <br/>
        <Color/>
        <br/>
        <Date/>
        <br/>
        <Week/>
        <br/>
        <Month/>
        <br/>
        <DateTimeLocal/>
        <br/>
        <Time/>
        <br/> 
        <Search/>
        <br/>
        <Range/>
        <br/>
        <Url/>
        <br/>
        <Radio/>
        <br/>
        <List/>
        <br/>
        <CheckBox/>
        <br/>
        <Reset/>
        <br/>
        </div>
        <div className='row justify-content-end' >
            <div className='col-4 ' style={{"margin":"20px 30px 10px 10px"}}> 
            
                     <button className="btn btn-success">Submit</button>
             
            </div>
            
        </div>
      </form>
    </div>
          </Offcanvas.Body>
        </Offcanvas>
      </>
    );
  }

const {{tableName}}Form = () => {
  return (
    <Container>
    <section>
     <div>
         <Row>
             <Col className="d-flex justify-content-end mt-3">
             {[ 'end',].map((placement, idx) => (
     <OffCanvasExample key={idx} placement={placement} name={placement} />
   ))}
             </Col>
         </Row>
     </div>
    </section>
    <br/>
       <section>
        <div>
            <Row>
                <Col>
                <table className='table table-hover'>
            <thead>
              <tr>
                <th>S.no</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                <button className='btn btn-outline-info'><span className='bi bi-pen-fill'>Edit</span></button>
                <button className='btn btn-outline-danger'><span className='bi bi-eye-fill'>Show</span></button>
                </td>
              </tr>
            </tbody>
           </table>
                </Col>
            </Row>
        </div>
       </section>
 </Container>
  )
}

export default {{tableName}}Form
