<?php
echo 'handle'.$fieldName.'Change = (e) => {
  e.preventDefault();
  
  const fieldValue = e.target.value;
  this.setState({ '.$fieldName.': fieldValue });
};';
echo strtolower($reftableName).'fetchHandler= () => {
    fetch(configData.api_url + "C_'.ucfirst($reftableName).'/list", {  // Enter your IP address here
              method: "POST", 
              mode: "cors", 
              body: {}// body data type must match "Content-Type" header
            }).then(response => response.json())
            .then((data) => {
              if (data.status === "success") {
                this.setState({ '.$reftableName.': data.list });
              }
            });
};';
?>