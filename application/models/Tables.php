<?php 
Class Tables extends CI_Model
{ 

	public function __construct()
	{ 
		parent::__construct(); 
	} 
	
	public function createTable($tableName,$fld)
	{ 
		$params1 = json_decode($fld);
        $fields = array();
        $field1 = array();
        
        $field1['type'] = "INT";
        $field1['constraint'] = 11;
        $field1['unsigned'] = FALSE;
        $field1['auto_increment'] = TRUE;
        $field1['isnull'] = FALSE;
        $field1['isedit'] = 0;
        $fields[$tableName."_Id"] = $field1;
        foreach($params1 as $paramd)
        {
            $field = array();
            $field['type'] = $paramd->dataType;
            $field['constraint'] = $paramd->number;
            $field['unsigned'] = $paramd->isunsigned;
            $field['auto_increment'] = $paramd->autoincrement;
            $field['isnull'] = $paramd->isnull;
            $field['isedit'] = $paramd->iseditable;
            $field['unique'] = $paramd->isunique;
            $fields[$paramd->fieldName] = $field;
        }
        //$updated = '0 ON UPDATE CURRENT_TIMESTAMP';
        $field2 = array();
        $field2['type'] = "INT";
        $field2['constraint'] = 11;
        $field2['unsigned'] = FALSE;
        $field2['auto_increment'] = FALSE;
        $field2['isnull'] = FALSE;
        $field2['isedit'] = 0;
        $fields["createdBy"] = $field2;
        $field3 = array();
        $field3['type'] = "tinyint";
        $field3['constraint'] = 1;
        $field3['unsigned'] = FALSE;
        $field3['auto_increment'] = FALSE;
        $field3['isnull'] = FALSE;
        $field3['default'] = 1;
        $field3['isedit'] = 0;
        $fields["status"] = $field3;
        // $field4 = array();
        // $field4['type'] = "timestamp";
        // $field4['constraint'] = "";
        // $field4['unsigned'] = FALSE;
        // $field4['auto_increment'] = FALSE;
        // $field4['isnull'] = FALSE;
        // //$field4['default'] = $updated;
        // $field4['isedit'] = 1;
        // $fields["updatedOn"] = $field4;
        // $field4['isedit'] = 0;
        // $fields["createdOn"] = $field4;
        $field2['isedit'] = 1;
        $fields["updatedBy"] = $field2;
        $this->dbforge->add_field($fields);
        $this->dbforge->add_field('createdOn TIMESTAMP');
        $this->dbforge->add_field('updatedOn TIMESTAMP');
        $this->dbforge->add_key($tableName."_Id", TRUE);
        $returnvalue = array();
        
        if(!$this->db->table_exists($tableName))
        {
            $this->dbforge->create_table($tableName);
            $returnvalue = $fields;
        };
        return $returnvalue;
	} 
} 
?> 