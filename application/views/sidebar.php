<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;"> <a href="<?php echo base_url();?>admin/" class="site_title"><img src="<?php echo base_url();?>images/apnapolicyLogo.png" alt="" class="apnapolicyLogo"></a> </div>
    <div class="clearfix"></div>
    
    <!-- menu p87rofile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic"> <img src="<?php echo base_url().$session['profilePic'];?>" alt="..." class="img-circle profile_img"> </div>
      <div class="profile_info"> <span>Welcome,</span>
        <h2><?php echo $session['fName']." ".$session['lName'];?></h2>
      </div>
    </div>
    <!-- /menu profile quick info --> 
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <li <?php if($sidebar=="dashboard"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>dashboard/"><i class="fa fa-home"></i> Dashboard </a></li>
          <li <?php if($sidebar=="myticket"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>myticket/"><i class="fa fa-ticket"></i> My Tickets </a></li>
          <li <?php if($sidebar=="myteam"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>myteam/"><i class="fa fa-users"></i> My Team </a></li>
          <li <?php if($sidebar=="buynewpolicy"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>buynewpolicy/"><i class="fa fa-credit-card-alt"></i> Buy New Policy </a></li>
          <li <?php if($sidebar=="userrequest"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>userrequest/"><i class="fa fa-user"></i> User Request </a></li>
          <li <?php if($sidebar=="policies"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>policies/"><i class="fa fa-file-powerpoint-o"></i> Policies </a></li>
          <li <?php if($sidebar=="ratecharts"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>ratecharts/"><i class="fa fa-file-powerpoint-o"></i> Rate Charts </a></li>
          <li <?php if($sidebar=="sourcedpolicies"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>sourcedpolicies/"><i class="fa fa-file-text"></i> Sourced Policies </a></li>
          <li <?php if($sidebar=="draftpolicies"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>draftpolicies/"><i class="fa fa-file"></i> Draft Policies </a></li>
          <li <?php if($sidebar=="companies"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>companies/"><i class="fa fa-building"></i> Companies </a></li>
          <li <?php if($sidebar=="insurancetypes"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>insurancetypes/"><i class="fa fa-building"></i> Insurance Types </a></li>
          <li <?php if($sidebar=="employees"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>employees/"><i class="fa fa-user-circle-o"></i> Employees </a></li>
          <li <?php if($sidebar=="roles"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>roles/"><i class="fa fa-user-circle"></i> Roles </a></li>
          <li <?php if($sidebar=="settings"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>settings/"><i class="fa fa-cog"></i> Settings </a></li>
          <li <?php if($sidebar=="zones"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>zones/"><i class="fa fa-cog"></i> Zones </a></li>
          <li <?php if($sidebar=="zipcodes"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>zipcodes/"><i class="fa fa-map-pin"></i> Zipcodes </a></li>
          <li <?php if($sidebar=="plantypes"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>plantypes/"><i class="fa fa-map-pin"></i> Plantypes </a></li>
          <li <?php if($sidebar=="familydefinations"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>familydefinations/"><i class="fa fa-map-pin"></i> Family Definations </a></li>
          <li <?php if($sidebar=="agebands"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>agebands/"><i class="fa fa-map-pin"></i> Age Bands </a></li>
          <li <?php if($sidebar=="notification"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>notification/"><i class="fa fa-bell"></i> Notifications </a></li>
          <li <?php if($sidebar=="supportdesk"){?>class="active"<?php } ?>><a href="<?php echo base_url();?>supportdesk/"><i class="fa fa-question-circle"></i> Support Desk </a></li>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu --> 
    
    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small"> <a href="<?php echo base_url();?>profile/"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> </a> 
    <!-- <a data-toggle="tooltip" data-placement="top" title="FullScreen"> <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span> </a> <a data-toggle="tooltip" data-placement="top" title="Lock"> <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> </a>  -->
    <a style="float:right" data-placement="top" title="Logout" href="<?php echo base_url();?>logout/"> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> </a> </div>
    <!-- /menu footer buttons --> 
  </div>
</div>
