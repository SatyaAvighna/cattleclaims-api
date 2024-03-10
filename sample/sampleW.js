import React, { Component } from "react";
import {
  Button,
  Container,
  Row,Form,
  Col,
  Offcanvas,
} from "react-bootstrap";
import { toast } from "react-toastify";
import DataTable from "react-data-table-component";
import configData from '../config.json';

export default class {{ tableName }} extends Component {
  constructor(props) {
    super(props);
    this.state = { 
      show: false,
      data: [],
      sId: sessionStorage.getItem("sessionId"),
      uId: sessionStorage.getItem("uId"),
      errors: {},
      filteredData: null,
      tableClms: [
        {
          name: "S.NO",
          selector: (row, i) => row.{{ tableName1 }}_Id,
          sortable: true,
          cell: (row) => <span>{row.{{ tableName1 }}_Id}</span>,
        },
        {{ tableClms }}
        {
          name: "Actions",
          sortable: false,
          cell: (row) => (
            <div>
              {/* edit button and delete button */}
              <Button
                variant="primary"
                onClick={this.handleOffcanvasShow}
                className="bi bi-pen" style={{"marginRight":"3px"}}
              >
                
              </Button>
              <Button
                variant="danger"
                onClick={() => this.handleDelete(row)}
                className="bi bi-trash danger"
              >
                
              </Button>
            </div>
          ),
        },
      ],
      currentPage: 1,
      itemsPerPage: 10,
      {{ state }}
    };
  }
  // offcanvas Open
  handleOffcanvasShow = () => {
    this.setState({ show: true });
  };
  // Offcanvas close button
  handleOffcanvasClose = () => {
    this.setState({ show: false });
  };
  showToast = (msg, type) => {
    var tType = toast.TYPE.INFO;
    if (type === "success") tType = toast.TYPE.SUCCESS;
    if (type === "error") tType = toast.TYPE.ERROR;
    if (type === "warning") tType = toast.TYPE.WARNING;
    toast(msg, { type: tType });
  };
  {{ tableName }}editHandler=(e)=>{
      e.preventDefault();
      // const updateFormData = {...editFormData};
      // updateFormData['{{ tableName }}_Id'] = e.target.parentElement.getAttribute("id");
      // setEditFormData(updateFormData);
      // setEdit(true);
  
       }
       
{{ tableName }}fetchHandler = () => {
  var formData = new FormData();
  formData.append("sId", this.state.sId);
 formData.append("uId", this.state.uId);
            fetch(configData.api_url +'C_{{ tableName }}/list', {  // Enter your IP address here
        
              method: 'POST', 
              //headers :{ 'Content-Type' : 'application/json'},
              mode: 'cors', 
              body: formData// body data type must match "Content-Type" header
            }).then(response => response.json())
            .then((data) => {
              if (data.status === "success") {
                this.setState({ data: data.list });
              }
            });
           }
           {{ tableName }}submitHandler=(e)=>{
            e.preventDefault();
              //   setButtons(contacts);
             var formData = new FormData();
             formData.append("sId", this.state.sId);
              formData.append("uId", this.state.uId);
             {{ tableData }}
             fetch(configData.api_url + 'C_{{ tableName }}/add', {  // Enter your IP address here
          
               method: 'POST',
               //headers :{ 'Content-Type' : 'application/json'},
               mode: 'cors',
               body: formData// body data type must match "Content-Type" header
             }).then(response => response.json())
               .then((data) => {
                 this.showToast(data.message, data.status);
                 if (data.status === "success") {
                   this.{{ tableName }}fetchHandler();
                   this.handleOffcanvasClose();
                   this.setState({{{ state }}});
                }
              });
             }
   {{ tableName }}updateHandler=(e)=>{
        e.preventDefault();
     var formData = new FormData();
     formData.append("sId", this.state.sId);
    formData.append("uId", this.state.uId);
          {{ tableData1 }}
      
          fetch(configData.api_url +'C_{{ tableName }}/update', {  
            method: 'POST', 
            mode: 'cors', 
            body: formData
          }).then(response => response.json())
            .then((data) => {
              this.showToast(data.message, data.status);
            if (data.status === "success") {
              this.{{ tableName }}fetchHandler();
              this.handleOffcanvasClose();
            }
          });
         }

  componentDidMount() {
    this.{{ tableName }}fetchHandler();
    {{ componentDidMount }}
  }
  {{ inputFunctions }}
  handleRowSelect = (row) => {
    this.setState({
      selectedRow: row.index,
    });
  };
  handleRowUpdate = (newData, oldData) => {
    const data = [...this.state.data];
    const index = oldData.index;
    data[index] = newData;
    this.setState({ data });
  };

  handleEdit = (row) => {
    console.log(`Editing row with ID ${row.id}`);
    // implement your edit logic here
  };
handleDelete = (row, index) => {
  var formData = new FormData();
    formData.append('{{ tableName1 }}_Id', row.{{ tableName1 }}_Id);
    fetch(configData.api_url +'C_{{ tableName }}/delete', {
          method: 'POST', 
        mode: 'cors', 
        body: formData
      }).then(response => response.json())
      .then((data) => {
        this.showToast(data.message, data.status);
        if (data.status === "success") {
          this.{{ tableName }}fetchHandler();
        }
      });
  };
  handlePageChange = (page) => {
    this.setState({ currentPage: page });
  };

  handlePerRowsChange = (newPerPage, page) => {
    this.setState({ itemsPerPage: newPerPage, currentPage: page });
  };

  handleFilter = (e) => {
    const searchValue = e.target.value.toLowerCase();
    const filteredData = this.state.data.filter((row) => {
      return Object.values(row).join(" ").toLowerCase().includes(searchValue);
    });
    this.setState({ filteredData });
  };

  render() {
    const paginatedData = this.state.filteredData
      ? this.state.filteredData.slice(
          (this.state.currentPage - 1) * this.state.itemsPerPage,
          this.state.currentPage * this.state.itemsPerPage
        )
      : this.state.data.slice(
          (this.state.currentPage - 1) * this.state.itemsPerPage,
          this.state.currentPage * this.state.itemsPerPage
        );

    return (
      <div className="page-title">
      <div className="row">
        <div className="title_left">
          <h2 style={{ textAlign: "start" }}>{{ formName }}</h2>
        </div>
        <div className="col-md-12 col-sm-12 col-xs-12">
          <div className="x_panel">
            <div className="x_content">
              <div
                id="datatable_wrapper"
                className="dataTables_wrapper form-inline
                                   dt-bootstrap no-footer"
              >
                <Row className="row">
            <Col
            className="d-flex justify-content-end"
            style={{ marginRight: "5px", marginTop: "20px" }}
          >
            <Button
              variant="primary"
              className="bi bi-plus "
              onClick={this.handleOffcanvasShow}
            >
              New
            </Button>
            <Offcanvas
              show={this.state.show}
              onHide={this.handleOffcanvasClose}
              {...this.props}
              style={{ width: "500px" }}
              placement="end"
              backdrop="true"
            >
              <Offcanvas.Header closeButton>
                <Offcanvas.Title>{{ tableName }} page</Offcanvas.Title>
              </Offcanvas.Header>
              <Offcanvas.Body>
                <Container style={{ "overflowY": "auto", height: "auto" }}>
                <Row className="divstyle">
                    <Row>
                      <Form>
                  {{ tableContent }}
                  </Form>
                  </Row>
                  </Row>
                  <Row>
                    <Col
                      className="d-flex justify-content-end"
                      style={{ marginRight: "50px" }}
                    >
                      <Button
                        className="button"
                        variant="success"
                        onClick={this.{{ tableName }}submitHandler}
                        style={{
                          marginTop: "20px",
                        }}
                      >
                        Save
                      </Button>
                    </Col>
                  </Row>
                </Container>
              </Offcanvas.Body>
            </Offcanvas>
        {/*offcanvas is over */}
                  </Col> 
                  </Row>
        <br />
        {{ tableDataContent }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    );
  }
}
