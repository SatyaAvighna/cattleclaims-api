<div class="page-content" style=""><!--padding-top:120px-->
  <div style="text-align:center">
  
  	 <h3 style="margin:15px 15px 30px;">Patient Details</h3>
    <ul style="list-style:none; margin-top:5px; text-align:left">
      <li style="width:49%; float:left">Patient Id : <?php echo $patient['patientId'];?>.</li>
      <li style="width:49%; float:left">Appointment Id : <?php echo $patient['lastAId'];?></li>
      <li style="width:49%; float:left">Patient Name: <?php echo $patient['name'];?></li>
      <li style="width:49%; float:left">Age : <?php echo $patient['age'];?></li>
      <li style="width:49%; float:left">Gender : <?php echo $patient['gender'];?> </li>
      <li style="width:49%; float:left">City : <?php echo $patient['city'];?> </li>
      <li style="width:49%; float:left">Contact : <?php echo $patient['mobile'];?> </li>
    </ul>
   <?php foreach($patient['labtests'] as $labtest){ if($lId == $labtest['lId']) { ?>
    <h3 style="margin:15px; text-align:center; width:100%"><b> Report for <?php echo $labtest['lName'];?></b></h3>
   
    <table style="margin: 30px auto 30px; width:100%;border-collapse: collapse;border-spacing: 0; text-align:center">
      <thead><tr>
        <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">#</th>
              <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Entity</th>
              <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Observed Values</th>
              <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Units</th>
              <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Default Values</th>
              </tr>
      </thead>
      <tbody>
      <?php $templates = $this->common->getLtHasReport($labtest['lId']);
							if(!empty($templates))
							{
							  $i=1;
							  foreach($templates as $template)
							  { 
							  	$report = $this->common->getLtObserverdValues($labtest['lId'],$template['lhrId'],$labtest['pttId']);
							  ?>
            <tr >
              <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $i; ?></td>
              <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $template['entity']; ?></td>
              <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php if(!empty($report)) echo $report['observedunits']; ?></td>
              <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $template['units']; ?></td>
              <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $template['defaultV']; ?></td>
            </tr>
            <?php $i++; } }else{ ?>
            <tr>
              <td colspan="5" style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">No lab templates</td>
            </tr>
            <?php } ?>
      </tbody>
    </table>
   <?php }} ?>
  </div>
  
  <!-- END PAGE CONTENT--> 
</div>
