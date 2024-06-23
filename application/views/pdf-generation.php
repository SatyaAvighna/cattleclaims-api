<div class="page-content" style="padding-top:10px;"><!--padding-top:120px-->
  <div style="text-align:justify">
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;font-size:16px;font-weight:bold;"><img src="<?php echo base_url();?>uploads/apnapolicyLogo.png"  style="height:100px; float:right"/></div>
        </div>
     </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;text-align:Center;font-size:16px;font-weight:bold; "> Sample Cattle Policy Pdf	</div>
        </div>
     </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;text-align:left;font-size:16px;font-weight:bold; "> Owner Details	</div>
        </div>
        <div style="float:left; width:98%; margin:0 0% 0 1%; text-align:left;">
        <ul style="list-style:none;  margin:0;margin-top:5px; text-align:left;; padding:0;">
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Owner Name: </b> <?php echo $cattle['owner']['oName'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Owner Mobile: </b> <?php echo $cattle['owner']['oMobile'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Owner AAadhar: </b> <?php echo $cattle['owner']['oAadhar'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Owner Address: </b> <?php echo $cattle['owner']['oAddress'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Pincode: </b> <?php echo $cattle['owner']['oPincode'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>District: </b> <?php echo $cattle['owner']['oDistrict'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>State: </b> <?php echo $cattle['owner']['oState'];?></li>         
        </ul>        
        </div>
     </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;text-align:left;font-size:16px;font-weight:bold; "> Cattle Details	</div>
        </div>
        <div style="float:left; width:98%; margin:0 0% 0 1%; text-align:left;">
        <ul style="list-style:none;  margin:0;margin-top:5px; text-align:left;; padding:0;">
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Sum Insured: </b> <?php echo $cattle['sumInsured'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Animal Type: </b> <?php echo $cattle['animalType'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Tag Number: </b> <?php echo $cattle['tagnumber'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Breed: </b> <?php echo $cattle['breed'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Gender: </b> <?php echo $cattle['gender'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Age: </b> <?php echo $cattle['age'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Address: </b> <?php echo $cattle['cAddress'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>Pincode: </b> <?php echo $cattle['cPincode'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>District: </b> <?php echo $cattle['cDistrict'];?></li>
          <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'>State: </b> <?php echo $cattle['cState'];?></li> 
          
        </ul>        
        </div>
     </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;text-align:left;font-size:16px;font-weight:bold; "> Medical Questions	</div>
        </div>
        <div style="float:left; width:98%; margin:0 0% 0 1%; text-align:left;">
        <ul style="list-style:none;  margin:0;margin-top:5px; text-align:left;; padding:0;">
          <?php foreach($cattle['medicalqns'] as $qns){?>
            <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'><?php echo $qns['qnDescription'];?></b></li>
            <li style="width:50%; float:left; padding:0; margin:0;"><?php echo $qns['ans'];?></li>
          <?php } ?>
        </ul>        
        </div>
     </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;text-align:left;font-size:16px;font-weight:bold; "> Animal Questions (VD Certificate)	</div>
        </div>
        <div style="float:left; width:98%; margin:0 0% 0 1%; text-align:left;">
        <ul style="list-style:none;  margin:0;margin-top:5px; text-align:left;; padding:0;">
        <?php foreach($cattle['vdqns'] as $qns){?>
            <li style="width:50%; float:left; padding:0; margin:0;"><b style='font-weight:bold'><?php echo $qns['qnDescription'];?></b></li>
            <li style="width:50%; float:left; padding:0; margin:0;"><?php echo $qns['ans'];?></li>
          <?php } ?>
        </ul>        
        </div>
     </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" style="float:left; margin-top:5px;">
        <div style="float:left; width:98%; margin:0 3% 0 0; padding-top:5px">
            <div style="width:100%;text-align:left;font-size:16px;font-weight:bold;"> Animal Images	</div>
        </div>
        <div style="float:left; width:98%; margin:0 0% 0 1%; text-align:left;">
        <ul style="list-style:none;  margin:0;margin-top:5px; text-align:left;; padding:0;">
        <li style="width:48%; float:left; padding:0; margin:0 1%;"><b style='font-weight:bold;float:left'>Ear Tag: </b> <img src="<?php echo base_url().$cattle['earTag'];?>"  style="height:100px; float:left"/></li>
          <li style="width:48%; float:left; padding:0; margin:0 1%;"><b style='font-weight:bold;float:left'>Left Side: </b> <img src="<?php echo base_url().$cattle['lSidePath'];?>" style="height:100px; float:left"/></li>
          <li style="width:48%; float:left; padding:0; margin:0 1%;"><b style='font-weight:bold;float:left'>Right Side: </b> <img src="<?php echo base_url().$cattle['rSidePath'];?>" style="height:100px; float:left" /></li>        
        </ul>        
        </div>
     </div>
    </div>
  </div>  
  <!-- END PAGE CONTENT--> 
</div>
