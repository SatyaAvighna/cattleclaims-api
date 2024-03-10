<Row>
  <Col  lg="4" md="4">
  <Form.Label style={{ paddingTop: "8px" }}><?php echo $displayName;?></Form.Label>
  </Col>
  <Col lg="8" md="8">
  <select className="form-select" name="tableName" onChange={this.handle<?php echo $fieldName;?>Change}>
    <option defaultValue> Select <?php echo $displayName;?> </option>
     {this.state.<?php echo $reftableName;?>.map((api, index, idx) => (            
    <option key={index} value={api.<?php echo $columnName;?>}> {api.<?php echo $columnName;?>} </option>
	))}                  
  </select>
  </Col>
  <div className="errorMsg" style={{ color: "red" }}> {this.state.errors.<?php echo $fieldName;?>} </div>
</Row>