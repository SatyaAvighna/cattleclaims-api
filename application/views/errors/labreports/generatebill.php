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
    <h3 style="margin:15px; text-align:center; width:100%"><b> Lab Bill</b></h3>
    <table style="margin: 30px auto 30px; width:100%;border-collapse: collapse;border-spacing: 0; text-align:center">
      <thead>
        <tr>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">#</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Test Name</th>
          <th style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Amount</th>
        </tr>
      </thead>
      <tbody>
        <?php $price=0; $i=1;foreach($patient['labtests'] as $labtest)
		{ 
							  $labprice = $this->common->getLabtestById($labtest['lId']);
							  ?>
        <tr >
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $i; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;"><?php echo $labtest['lName']; ?></td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Rs. <?php echo $labprice['price']; ?></td>
        </tr>
        <?php $price=$price+ $labprice['price'];$i++; } ?>
        <tr >
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd; text-align:right; margin-right:20px" colspan="2">Total Amount</td>
          <td style="padding: 8px;line-height: 1.428571429;vertical-align: top;border: 1px solid #ddd;">Rs. <?php echo $price; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <!-- END PAGE CONTENT--> 
</div>
