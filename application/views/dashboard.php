<?php $this->load->view('header');?>
<?php $this->load->view('sidebar');?>
<?php $this->load->view('topnav');?>
<!-- page content -->

<div class="right_col" role="main"> 
  <!-- top tiles -->
  
  <div>
    <div class="row">
      <div class="page-title">
        <div class="title_left">
          <h3>Dashboard</h3>
        </div>
      </div>
    </div>
    <div class="row top_tiles">
      <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-folder-open"></i></div>
          <div class="count">10</div>
          <h3>Open Queries</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-window-close-o"></i></div>
          <div class="count">15</div>
          <h3>Closed Queries</h3>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php $this->load->view('footer');?>
<!-- footer content --> 
