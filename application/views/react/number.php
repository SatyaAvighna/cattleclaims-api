<Row>
  <Col  lg="4" md="4">
  <Form.Label style={{ paddingTop: "8px" }}><?php echo $displayName;?></Form.Label>
  </Col>
  <Col lg="8" md="8">
  <Form.Control type="number" onChange={this.handle<?php echo $fieldName;?>Change} className="form-control" name="<?php echo $fieldName;?>" value={this.state.<?php echo $fieldName;?>} required="required" placeholder="Enter <?php echo $fieldName;?>" />
  </Col>  
  <div className="errorMsg" style={{ color: "red" }}> {this.state.errors.<?php echo $fieldName;?>} </div>
</Row>