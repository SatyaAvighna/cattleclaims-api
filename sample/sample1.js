import React, { useState, useEffect } from "react" ;
import './{{tableName}}.css';
   const {{tableName}} = () =>{
      const [addFormData,setAddFormData] = useState ([]);
      const [editFormData,setEditFormData] = useState ([]);
      const [tableData,set{{tableName}}tableData] = useState ([]);
      const [edit,setEdit] = useState(false)
     const handleAddFormChange =(e) =>{
      e.preventDefault();
      const fieldName = e.target.getAttribute('name');
      const fieldvalue = e.target.value;
      const newFormData = {...addFormData};
      newFormData[fieldName] =fieldvalue;
      setAddFormData(newFormData);
     };
   
    const handleReset = () => {
      Array.from(document.querySelectorAll("input")).forEach(
        input => (input.value = "")
      );
    };
    useEffect(() => {
      {{tableName}}fetchHandler()
    }, [])
    const {{tableName}}fetchHandler=(e)=>{
        fetch('https://playright-api.ihms360.com/C_{{tableName}}/list', {  // Enter your IP address here
    
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

    fetch('https://playright-api.ihms360.com/C_{{tableName}}/add', {  // Enter your IP address here

      method: 'POST', 
      //headers :{ 'Content-Type' : 'application/json'},
      mode: 'cors', 
      body: formData// body data type must match "Content-Type" header
    }).then(response => response.json())
    .then((data) => {
      if (data.status === "true") {
        {{tableName}}fetchHandler();
        handleReset();
      }
    });
   }
   const {{tableName}}editHandler=(index,e)=>{
    e.preventDefault();
    const updateFormData = {...editFormData};
    updateFormData['{{tableName1}}_Id'] = e.target.parentElement.getAttribute("id");
    setEditFormData(updateFormData);
    setEdit(true);
    const newtableData = [...tableData];
    const rowIndex = newtableData[index];
    Array.from(document.querySelectorAll("input")).forEach(
      input => (input.value = rowIndex[input.name])
    );
     }
     const {{tableName}}updateHandler=(e)=>{
      e.preventDefault();
        //   setButtons(contacts);
       
        var formData = new FormData();
        formData.append('{{tableName1}}_Id', editFormData.{{tableName1}}_Id);
        {{tableData1}}
        // formData.append('fields', JSON.stringify(contacts));
    
        fetch('https://playright-api.ihms360.com/C_{{tableName}}/update', {  // Enter your IP address here
    
          method: 'POST', 
          //headers :{ 'Content-Type' : 'application/json'},
          mode: 'cors', 
          body: formData// body data type must match "Content-Type" header
        }).then(response => response.json())
        .then((data) => {
          if (data.status === "true") {
            {{tableName}}fetchHandler();
            handleReset();
          }
        });
       }
     const {{tableName}}deleteHandler=(e)=>{
      e.preventDefault();
      var formData = new FormData();
      const {{tableName}}_Id = e.target.parentElement.getAttribute("id");
      console.log(e.target.parentElement);
      formData.append('{{tableName1}}_Id', {{tableName}}_Id);
      //formData.append('{{tableName}}_Id', id);
  
      fetch('https://playright-api.ihms360.com/C_{{tableName}}/delete', {  // Enter your IP address here
  
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
    return(
        <div className="container">
            <form  noValidate>
               <dl>
                  {{tableContent}}
                  <div className="row d-flex justify-content-end"> 
                  <div className=" col-2 d-flex justify-content-end  ">
                  {edit ? (<button onClick={{{tableName}}updateHandler}  className="btn btn-primary" >Update</button>) : (<button onClick={{{tableName}}submitHandler}  className="btn btn-primary" >Submit</button>)}
                    </div>
                   
                  </div> </dl>
                </form>
                {{tableDataContent}}
            </div>
    )
 }
 export default {{tableName}}