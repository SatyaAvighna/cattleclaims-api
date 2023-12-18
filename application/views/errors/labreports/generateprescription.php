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
      <li style="width:49%; float:left">Review Date : <?php echo date('d-m-Y',strtotime($patient['lADetails']['rDate'])); ?> </li>
    </ul>
    <h3 style="margin:15px; text-align:center; width:100%"><b> Prescription</b></h3>
     <table style="margin: 30px auto 30px; width:100%;border-collapse: collapse;border-spacing: 0; text-align:center">
      <thead>
        <tr>
        <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">#</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Drug Name</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Composition</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Dosage</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">When</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Frequency</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Duration </th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Notes</th>
        </tr>
      </thead>
      <tbody>
        <?php  
					if($patient['medicines']){ $i=1;foreach($patient['medicines'] as $medicine){?>
        <tr>
         <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $i; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['mName']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['mComposition']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['dosage']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['mWhen']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['frequency']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['duration']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $medicine['notes']; ?></td>
          
        </tr>
        <?php $i++;} } else{ ?>
        <tr>
          <td colspan="7">No Records</td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
  
  <!-- END PAGE CONTENT--> 
</div>
