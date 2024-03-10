<?php
  echo '{name:"'.$displayName.'",selector:(row, i) => row.'.$fieldName.',sortable:true,cell: (row) => <span>{row.'.$fieldName.'}</span>,},';
?>