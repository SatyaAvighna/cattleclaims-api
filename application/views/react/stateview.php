<?php
    if(strtolower($inputType) == 'select')
    { 
        echo "$reftableName:[],$fieldName:'',";
    }
    else
    { 
        echo "$fieldName:'',";
    }
?>