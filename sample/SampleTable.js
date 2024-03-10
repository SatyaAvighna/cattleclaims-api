import React,{useState} from 'react';
import { Col, Container, Row,Offcanvas,Button,Form } from 'react-bootstrap';
import { Table, Thead, Tbody, Tr, Th, Td } from 'react-super-responsive-table';
import './{{tableName}}Table.css'
//import Tablescreatepage from './Tablescreatepage';




function OffCanvasExample({ name, ...props }) {
    const [show, setShow] = useState(false);
  
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
  
    const [rows, setRows] = useState([{}]);
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
    return (
      <>
        <Button variant="primary" onClick={handleShow} className="mt-2">
        create table
        </Button>
        <Offcanvas show={show} onHide={handleClose} {...props} style={{"width":"600px"}}>
          <Offcanvas.Header closeButton>
            <Offcanvas.Title>{{tableName}} Table</Offcanvas.Title>
          </Offcanvas.Header>
          <Offcanvas.Body>

          <Container>
        <Row>
      <div className="col-md-12 column">
              <Table className="table table-bordered table-hover" id="tab_logic">
                <Thead>
                  <Tr>
                    <Th className="text-center">S.no </Th>
                    {columnsArray.map((column, index) => (
                      <Th className="text-center" key={index}> Table1</Th>
                    ))}
                    {columnsArray.map((column, index) => (
                      <Th className="text-center" key={index+1}>Table2</Th>
                    ))}
                      {columnsArray.map((column, index) => (
                      <Th className="text-center" key={index+2}>Table3</Th>
                    ))}
                    {columnsArray.map((column, index) => (
                      <Th className="text-center" key={index+2}>Table4</Th>
                    ))}
                    {columnsArray.map((column, index) => (
                      <Th className="text-center" key={index+2}>Table5</Th>
                    ))}
                    <Th colSpan="4"><button className="btn btn-outline-success bi bi-plus-circle" onClick={handleAddRow} >Add</button>
                      </Th>
                  </Tr>
                </Thead>
                <Tbody>
                 
                  {rows.map((item, idx) => (
                    <Tr key={idx}>
                      <Td>{idx + 1}</Td>
                      {columnsArray.map((column, index) => (
                        <Td key={index}>
                        <Form.Control type="Text" placeholder="" />
                        </Td>
                      ))}
                      {columnsArray.map((column, index) => (
                        <Td key={index}>
                        <Form.Control type="Text" placeholder="" />
                        </Td>
                      ))}
                       {columnsArray.map((column, index) => (
                      <Td key={index}>
                      <Form.Control type="Text" placeholder="" />
                       </Td>
                       ))}
                         {columnsArray.map((column, index) => (
                      <Td key={index}>
                      <Form.Control type="Text" placeholder="" />
                      </Td>
                       ))}
                      {columnsArray.map((column, index) => (
                      <Td key={index}>
                      <Form.Control type="Text" placeholder="" />
                      </Td>
                       ))}
                       <Td>
                        <Button
                        variant="danger" className="bi bi-trash3" onClick={() => handleRemoveSpecificRow(idx)}></Button>
                      </Td>
                      <Td><button className='btn btn-outline-info bi bi-pen-fill'></button></Td>
                    </Tr>
                  ))}
                  </Tbody>
                  
              </Table>
             <br/>
             <Row>
                <Col>
                <Button variant='success'>Save</Button>
                </Col>
             </Row>
            </div>
          
          
        
      </Row>
    </Container>
          </Offcanvas.Body>
        </Offcanvas>
      </>
    );
  }

const {{tableName}}Table = () => {
  
  return (
    <Container>
       <section>
        <div>
            <Row>
                <Col className="d-flex justify-content-end">
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
                <th>Table one</th>
                <th>Table two</th>
                <th>Table three</th>
                <th>Table four</th>
                <th>Table five</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
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

export default {{tableName}}Table

