<div class="container body">
  <div class="main_container row" style="margin:20px auto; border:1px solid #000">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="row" style="text-align:center;border-bottom:1px solid #000;">
        <div class="col-md-8 col-sm-8 col-xs-8" style="border-right:1px solid #000;padding:5px 0 5px 0px;"><span style="font-weight:800">NAME OF HOSPITAL :</span> <?php echo $hospitalName; ?></div>
        <div class="col-md-4 col-sm-4 col-xs-4" style="padding:5px 0 5px 0px;"><span style="font-weight:800">DATE :</span><?php echo date("d-M-Y"); ?></div>
      </div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">TYPE OF  BILL :</span><?php echo $typeofBill; ?></div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;">
        <div class="col-md-8 col-sm-8 col-xs-8" style="padding:0"><span style="font-weight:800">NAME OF THE PATIENT   :</span> <?php echo $patientName; ?></div>
        <div class="col-md-2 col-sm-2 col-xs-2" style="padding:0"><span style="font-weight:800">AGE :</span> <?php echo $age; ?> </div>
        <div class="col-md-2 col-sm-2 col-xs-2" style="padding:0"><span style="font-weight:800">SEX :</span> <?php echo $sex; ?> </div>
      </div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">HEALTHE CARD NO :</span> <?php echo $healthcardno; ?></div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">AADHAR NO :</span> <?php echo $aadharno; ?></div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px"><span style="font-weight:800">PARENT/ GUARDIAN NAME :</span> <?php echo $parentName; ?></div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px"><span style="font-weight:800">PATIENT RESIDENTIAL ADDRESS :</span> <?php echo $address; ?></div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;">
        <div class="col-md-6 col-sm-6 col-xs-6" style="padding:0"><span style="font-weight:800">HOSPITAL CONTACT NO :</span> <?php echo $contactno; ?> </div>
        <div class="col-md-6 col-sm-6 col-xs-6" style="padding:0"><span style="font-weight:800">MAIL ID :</span> <?php echo $mailId; ?></div>
      </div>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">CONSULTANT :</span><?php echo $doctorName; ?></div>
      <?php if(!empty($eprocedure)){  ?>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">PROCEDURE NAME :</span> <?php echo $eprocedure; ?></div>
      <?php }  ?>
      <?php if(!empty($diagnosis)){  ?>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">DIAGNOSIS  :</span> <?php echo $diagnosis; ?></div>
      <?php }  ?>
      <?php if(!empty($treatment)){  ?>
      <div class="row" style="text-align:left;border-bottom:1px solid #000;padding:5px 0 5px 5px;"><span style="font-weight:800">PROPOSED TREATMENT :</span> <?php echo $treatment; ?></div>
      <?php }  ?>
      <div class="row" >
        <table style="width:100%;text-align:center; border:1px solid #000; border-width:0px 0 1px 0;">
          <thead>
            <tr>
              <th style="width:50px; text-align:center; border-right:1px solid #000;border-bottom:1px solid #000; padding:3px;">S.NO</th>
              <th style="text-align:center; border-right:1px solid #000;border-bottom:1px solid #000;padding:3px;">Particulars</th>
              <th style="text-align:center;border-bottom:1px solid #000;padding:3px;">Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 
					$particulars = json_decode($particulars);
					 $i=1;$total=0.0;
					 if($particulars){ foreach($particulars as $particular){$total = $total + (float) $particular->btamount;
									 ?>
            <tr>
              <td style="text-align:center; border-right:1px solid #000;border-bottom:1px solid #000;padding:3px;"><?php echo $i; ?></td>
              <td style="text-align:center; border-right:1px solid #000;border-bottom:1px solid #000;padding:3px;"><?php echo $particular->particulars;?></td>
              <td style="text-align:center;border-bottom:1px solid #000;padding:3px;"><?php echo (float) $particular->btamount;?></td>
            </tr>
            <?php $i++; } } else{ ?>
            <tr>
              <td colspan="3" style="border-bottom:1px solid #000;padding:3px;">No Records</td>
            </tr>
            <?php }?>
            <tr style="text-align:right; font-weight:800;">
              <td colspan="2" style="border-right:1px solid #000;padding-right:10px">Total Amount : </td>
              <td colspan="1" style="text-align:center; width:200px;"><span id="bttotal"><?php echo (float) $total;?></span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="row" style="text-align:right;margin:80px 20px 40px;"> Signature of the authorized signatory </div>
    </div>
  </div>
</div>
