<?php

echo 'handle'.$fieldName.'Change = (e) => {
  e.preventDefault();
  
  const fieldValue = e.target.value;
  this.setState({'.$fieldName.': fieldValue });
};';
?>