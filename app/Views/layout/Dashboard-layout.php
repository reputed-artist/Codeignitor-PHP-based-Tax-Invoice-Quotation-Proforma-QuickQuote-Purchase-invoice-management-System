
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>

  <base href="/">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
    <?= $this->include('include/links.php');?>

    <link rel="stylesheet" type="text/css" href="<?= base_url();?>/public/dist/css/stylefortimer.css">

    <link rel="stylesheet" href="<?= base_url();?>/public/bower_components/morris.js/morris.css">
  

<script src="<?= base_url();?>/public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="<?= base_url();?>/public/bower_components/font/font.css">

  <style>
    .dashboard-chart.is-loading {
      position: relative;
    }

    .dashboard-chart.is-loading::after {
      animation: dashboard-spin 0.8s linear infinite;
      border: 3px solid rgba(60, 141, 188, 0.2);
      border-radius: 50%;
      border-top-color: #3c8dbc;
      content: '';
      height: 30px;
      left: 50%;
      margin: -15px 0 0 -15px;
      position: absolute;
      top: 50%;
      width: 30px;
      z-index: 2;
    }

    .dashboard-chart.is-loading::before {
      background: rgba(255, 255, 255, 0.75);
      bottom: 0;
      content: '';
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      z-index: 1;
    }

    @keyframes dashboard-spin {
      to { transform: rotate(360deg); }
    }

    .dashboard-details-overlay {
      background: rgba(0, 0, 0, 0.92);
      opacity: 0;
      height: 100vh;
      left: 0;
      overflow-y: auto;
      padding: 30px;
      position: fixed;
      top: 0;
      transition: opacity 0.25s ease, visibility 0.25s ease;
      visibility: hidden;
      width: 100vw;
      z-index: 2000;
    }

    .dashboard-details-overlay.is-open {
      opacity: 1;
      visibility: visible;
    }

    .dashboard-details-dialog {
      background: #fff;
      box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
      margin: 0 auto;
      min-height: 70vh;
      padding: 30px;
      transform: scale(0.55) translateY(35px);
      transition: min-height 0.35s ease, transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1), width 0.35s ease;
      width: min(720px, calc(100vw - 60px));
    }

    .dashboard-details-overlay.is-open .dashboard-details-dialog {
      min-height: calc(100vh - 60px);
      transform: scale(1) translateY(0);
      width: calc(100vw - 60px);
    }

    .dashboard-details-header {
      border-bottom: 1px solid #eee;
      margin: 0 0 30px;
      padding-bottom: 20px;
      position: relative;
    }

    .dashboard-details-header h2 {
      color: #333;
      margin: 0;
    }

    .dashboard-details-close {
      background: transparent;
      border: 0;
      color: #333;
      cursor: pointer;
      font-size: 30px;
      line-height: 1;
      padding: 5px 10px;
      position: absolute;
      right: 0;
      top: -5px;
    }

    .dashboard-details-grid {
      display: grid;
      gap: 20px;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      margin: 0 auto;
      max-width: 1100px;
    }

    .dashboard-detail-card {
      background: #fff;
      border-left: 5px solid #3c8dbc;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.12);
      min-height: 150px;
      padding: 25px 20px;
    }

    .dashboard-detail-card h3 {
      color: #777;
      font-size: 16px;
      margin: 0 0 18px;
    }

    .dashboard-detail-card strong {
      color: #222;
      display: block;
      font-size: 32px;
    }

    .dashboard-details-view {
      display: none;
    }

    .dashboard-details-view.is-active {
      display: block;
    }

    /* --- Registered clients table (AdminLTE 2 consistent UI) --- */
    .dashboard-table-box {
      background: #fff;
      border: 1px solid #e7eaec;
      border-top: 3px solid #3c8dbc;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
      margin-bottom: 5px;
    }

    .dashboard-table-box-header {
      align-items: center;
      background: #f7f7f7;
      border-bottom: 1px solid #e7eaec;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: space-between;
      padding: 12px 15px;
    }

    .dashboard-table-box-title {
      color: #333;
      font-size: 15px;
      font-weight: 600;
      margin: 0;
    }

    .dashboard-table-box-title i {
      color: #3c8dbc;
      margin-right: 5px;
    }

    .dashboard-client-count-badge {
      background: #00a65a;
      border-radius: 3px;
      color: #fff;
      display: inline-block;
      font-size: 12px;
      font-weight: 700;
      line-height: 1;
      margin-left: 6px;
      min-width: 24px;
      padding: 5px 8px;
      text-align: center;
      vertical-align: middle;
    }

    .dashboard-clients-search {
      width: 220px;
    }

    .dashboard-details-table-wrap {
      -webkit-overflow-scrolling: touch;
      max-width: 100%;
      overflow-x: auto;
    }

    .dashboard-details-table {
      background: #fff;
      border-collapse: separate;
      border-spacing: 0;
      margin: 0;
      width: 100%;
    }

    .dashboard-details-table thead th {
      background: #f4f4f4;
      border-bottom: 2px solid #3c8dbc;
      color: #333;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.3px;
      padding: 10px 14px;
      text-align: left;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .dashboard-details-table tbody td {
      border-bottom: 1px solid #eee;
      padding: 10px 14px;
      text-align: left;
      vertical-align: middle;
      white-space: nowrap;
    }

    .dashboard-details-table tbody tr:nth-child(even) td {
      background: #fafafa;
    }

    .dashboard-details-table tbody tr:hover td {
      background: #ecf0f5;
    }

    .dashboard-details-table .dashboard-col-address {
      max-width: 280px;
      min-width: 180px;
      white-space: normal;
      word-break: break-word;
    }

    .dashboard-details-table .dashboard-col-date {
      color: #777;
    }

    .dashboard-client-type {
      background: #fff;
      border: 1px solid #d2d6de;
      border-radius: 3px;
      color: #444;
      display: inline-block;
      font-size: 12px;
      font-weight: 600;
      padding: 3px 10px;
    }

    .dashboard-details-table-footer {
      background: #fff;
      border-top: 1px solid #e7eaec;
      color: #777;
      font-size: 12px;
      padding: 10px 15px;
      text-align: right;
    }

    #detailsTurnoverChart {
      min-height: 360px;
    }

    #detailsBounceRateChart {
      min-height: 360px;
    }

    .dashboard-turnover-controls {
      margin-bottom: 15px;
      text-align: right;
    }

    .dashboard-turnover-controls button {
      background: #fff;
      border: 1px solid #ccc;
      color: #555;
      cursor: pointer;
      padding: 7px 16px;
    }

    .dashboard-turnover-controls button.is-active {
      background: #dd4b39;
      border-color: #dd4b39;
      color: #fff;
    }

    .dashboard-turnover-controls button[data-range="demo"] {
      border-color: #00a65a;
      color: #008d4c;
      margin-left: 8px;
    }

    .dashboard-details-loading,
    .dashboard-details-empty,
    .dashboard-details-error {
      color: #777;
      padding: 35px 10px;
      text-align: center;
    }

    @media (max-width: 767px) {
      .dashboard-details-overlay { padding: 20px; }
      .dashboard-details-dialog,
      .dashboard-details-overlay.is-open .dashboard-details-dialog {
        width: calc(100vw - 40px);
      }
      .dashboard-details-grid { grid-template-columns: 1fr; }
      .dashboard-clients-search { width: 100%; }
      .dashboard-table-box-header { flex-direction: column; align-items: stretch; }
      .dashboard-details-table thead th,
      .dashboard-details-table tbody td { padding: 9px 10px; }
    }
  </style>

<!-- <script src="<?= base_url();?>/public/dist/js/app.js"></script> -->


    <!-- <script src=""></script> -->
</head>
<body class="hold-transition skin-blue sidebar-mini <?= getState('fixed-layout') ? 'fixed ' : ''; ?>
    <?= getState('boxed-layout') ? 'layout-boxed ' : ''; ?>
    <?= getState('sidebar-collapse') ? 'sidebar-collapse ' : ''; ?>
    <?= getState('expand-on-hover') ? 'expandOnHover ' : ''; ?>
    <?= getState('control-sidebar-open') ? 'control-sidebar-open ' : ''; ?>
    <?= getState('sidebar-skin-toggle') ? 'sidebar-light ' : ''; ?>">
    
<div class="wrapper">

<?= $this->include('include/header.php'); ?>
  
<?= $this->include('include/sidebar.php'); ?> 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

    <?= $this->renderSection('content'); ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="neworder"><?= isset($invcount) ? $invcount : 0; ?></h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer dashboard-more-info" data-stat="orders">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= ($bounceRate > 0 ? '+' : '') . $bounceRate; ?><sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer dashboard-more-info" data-stat="bounce">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="newclient"><?= isset($clientcount) ? $clientcount : 0; ?></h3>

              <p>Clients Registered</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer dashboard-more-info" data-stat="clients">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="monthlyturnover"><?= isset($monthturn) ? moneyFormatIndia($monthturn).".00" : 0; ?></h3>

              <p>Turnover of <?php echo date('M') ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer dashboard-more-info" data-stat="turnover">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->


<div class="row">

      <div class="col-md-9">

          
          <!-- BAR CHART -->
          <div class="box box-info col-md-10" style="overflow: auto;" >
            <div class="box-header">
              <h3 class="box-title" id="FY">Turnover Chart of the FY : <?= $startYear."-".$endYear;  ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
           <div class="chart-responsive col-md-8" style="padding-top:25px;">
                <select name="brand" id="brand" class="form-control select2 pull-right" style="height: 34px;width:30%">
                      <?php foreach ($fy as $year): ?>
                          <option><?= esc($year['financial_year']) ?></option>
                      <?php endforeach; ?>

                     </select>
                     </br></br></br>
                     <p class="text-center"> 
                     <strong id="Fyz" style="font-size: 18px;"><?= "Sales: 1 Apr,"." ".$startYear." - 30 Mar,"." ".$endYear;?>
                       
                     </strong> </p>
              
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>


              <div class="box-body col-md-4" id="bars" style="padding-top: 80px;">
               <p class="text-center">
                    <strong style="font-size: 18px;"> Items Sold</strong>
                  </p>
                      </br>
               
    <?php 
      $colors = ['primary', 'success', 'info', 'warning', 'danger'];
            if (!empty($productcategorycount2) && is_array($productcategorycount2)): ?>
          <?php foreach ($productcategorycount2 as $index => $item): ?>
              <div class="progress-group">
                  <span class="progress-text"><?= $item['label']; ?></span>
                  <span class="progress-number"><b><?= $item['value']; ?></b>/100</span>

                  <div class="progress sm">
                      <div class="progress-bar progress-bar-<?= isset($colors[$index]) ? $colors[$index] : 'default'; ?>" 
                           style="width:<?= (100 * $item['value']) / 100; ?>%">
                      </div>
                  </div>
              </div> 
          <?php endforeach; ?>
      <?php endif; ?>

      <?php 
      $displayCount = count($productcategorycount2 ?? []);
      if ($displayCount < 5): 
          $emptySlots = 5 - $displayCount;
          for ($i = 0; $i < $emptySlots; $i++):
      ?>
    <div class="progress-group">
        <span class="progress-text">No-Items</span>
        <span class="progress-number"><b>00</b>/100</span>

        <div class="progress sm">
            <div class="progress-bar progress-bar-default" style="width: 0%"></div>
        </div>
    </div>
      <?php 
          endfor;
      endif; 
      ?>
              

            </div>


            <div class="box-body col-md-12">
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header" id="invval"><?= $mainchart->total_invoices ?? 0; ?></h5>
                    <span class="description-text">TOTAL Invoices</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header" id="totalitemval"><?= $mainchart->total_items ?? 0; ?></h5>
                    <span class="description-text">TOTAL ITEMS SOLD</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%
                    </span>
                    <h5 class="description-header" id="yeartotalval"><?= moneyFormatIndia($mainchart->total_amount).".00" ?? 0; ?>

                    <?php //echo indian_number_format($invval[2]).".00"." Rs"; ?></h5>
                    <span class="description-text">TOTAL TURNOVER</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <h5 class="description-header" id="taxtotalvalz"><?= moneyFormatIndia($mainchart->total_tax).".00" ?? 0; ?>
                    <?php //echo indian_number_format($invval[3]).".00"." Rs"; ?></h5>
                    <span class="description-text">GST Collection of Year </span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
         
          </div>    



      </div>    



 </div>





<div class="col-md-3 timer" >
    <div class="box box-info" style="height: 180px;">
          <div class="box-header with-border">
              <h3 class="box-title"> Timer </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>

            </div>

      <div class="timeDiv">
        <span class="font-color" id="time"></span>
        <span class="font-color" id="sec"></span>
        <span class="font-color" id="med"></span>
      </div>
      <div class="dayDiv">
        <span class="font-color day">SUN</span>
        <span class="font-color day">MON</span>
        <span class="font-color day">TUE</span>
        <span class="font-color day">WED</span>
        <span class="font-color day">THU</span>
        <span class="font-color day">FRI</span>
        <span class="font-color day">SAT</span>
      </div>
      <span class="font-color" id="full-date"></span>
    </div>

   </div>


        <div class="col-md-3">
          
          <!-- BAR CHART -->
          <div class="box box-info" style="height: 350px;">
            <div class="box-header with-border">
              <h3 class="box-title">Consumables sold in FY </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id='chart_pie_5' class='chart_morris dashboard-chart is-loading' style="height: 230px;"></div>
            <div id='chart_pie_5_legend' class='text-center'></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>     


</div>




<div class="row">
  
      <div class="col-md-3">  

              <div class="box box-info" style="height: 350px;">
            <div class="box-header with-border">
              <h3 class="box-title">Client Type </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart_morris dashboard-chart is-loading" id="chart_pie_1" style="height: 230px;"></div>
                          <div id='chart_pie_1_legend' class='text-center'></div>
                          </br></br>
            </div>
            <!-- /.box-body -->
          </div>

      </div>
 
      <div class="col-md-3">
          
          <!-- BAR CHART -->
          <div class="box box-info" style="height: 350px;">
            <div class="box-header with-border">
              <h3 class="box-title">Clients in Countries</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id='chart_pie_2' class='chart_morris dashboard-chart is-loading' style="height: 230px;"></div>
            <div id='chart_pie_2_legend' class='text-center'></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       


     
       
       <div class="col-md-3">
          
          <!-- BAR CHART -->
          <div class="box box-info" style="height: 350px;">
            <div class="box-header with-border">
              <h3 class="box-title">Products Count</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id='chart_pie_4' class='chart_morris dashboard-chart is-loading' style="height: 230px;"></div>
            <div id='chart_pie_4_legend' class='text-center'></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       


     
         <div class="col-md-3">
          
          <div class="box box-info" style="height: 350px; ">
            <div class="box-header with-border">
              <h3 class="box-title">Billed / NB Clients</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id='chart_pie_3' class='chart_morris dashboard-chart is-loading' style="height: 230px;"></div>
            <div id='chart_pie_3_legend' class='text-center'></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       


          
        <div class="col-md-3">
          
          <!-- BAR CHART -->
          <div class="box box-info" style="height: 350px;">
            <div class="box-header with-border">
              <h3 class="box-title">Count of Doc. in FY </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id='chart_pie_6' class='chart_morris dashboard-chart is-loading' style="height: 230px;"></div>
            <div id='chart_pie_6_legend' class='text-center'></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       

  
        <div class="col-md-9">
          <div class="box box-info" style="overflow: auto;">
            <div class="box-header with-border">
              <h3 class="box-title">Reminder for Clients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered" id="reminder">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>proforma Id</th>
                  <th>Company Name</th>
                  <th>Item name</th>
                  <th> Mob</th>

                </tr>
                </thead>
                <tbody id="tbody">
                  
                </tbody>
              </table>
            </div>

          </div> 
          </div>    
  
  
      <div class="col-md-6">
          <div class="box box-info" style="height: 425px">
            <div class="box-header with-border">
              <h3 class="box-title"> Location Tree Data Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>

            </div>
                <div class="box-body chart-responsive" style="margin-top: -15px;">
                   <div class="chart dashboard-chart is-loading" id="ebar-chart-tree" style="height: 400px;"></div>
                </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       



 

      <div class="col-md-6">
          <div class="box box-info" style="height: 425px">
            <div class="box-header with-border">
              <h3 class="box-title"> Annual Turnover Data Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>

            </div>
                <div class="box-body chart-responsive">
            </br>              </br>
                   <div class="chart dashboard-chart is-loading" id="bar-chart3" style="height: 300px;"></div>
               </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       





        <div class="col-md-3">
          
          <!-- BAR CHART -->
          <div class="box box-info" style="height: 350px;">
            <div class="box-header with-border">
              <h3 class="box-title">Count client types </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id='chart_pie_7' class='chart_morris dashboard-chart is-loading' style="height: 230px;"></div>
            <div id='chart_pie_7_legend' class='text-center'></div>
            </div>
            <!-- /.box-body -->
          </div>
            <!-- /.box -->
        </div>       

  
        <div class="col-md-9">
          <div class="box box-info" style="overflow: auto;">
            <div class="box-header with-border">
              <h3 class="box-title">Quick Quotation Reminder for Clients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered" id="reminder">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Quote Id</th>                  
                  <th>Item name</th>
                  <th> Mob</th>
                  <th>Quantity</th>
                  <th>subtotal</th>
                  <th>GST 18%</th>
                  <th>Total</th>

                </tr>
                </thead>
                <tbody id="tbody2">
                  
                </tbody>
              </table>
            </div>

          </div> 
          </div> 


      </div><!-- </section> -->

      
  
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?= $this->include('include/footer.php');?>
<?= $this->include('include/settings.php');?>
   <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

<div id="dashboardDetailsOverlay" class="dashboard-details-overlay" role="dialog" aria-modal="true" aria-labelledby="dashboardDetailsTitle">
  <div class="dashboard-details-dialog">
    <div class="dashboard-details-header">
      <h2 id="dashboardDetailsTitle">Current Month Dashboard Details</h2>
      <button type="button" class="dashboard-details-close" aria-label="Close dashboard details">&times;</button>
    </div>
    <div class="dashboard-details-view" data-view="summary">
      <div class="dashboard-details-grid">
        <!-- <div class="dashboard-detail-card">
          <h3 id="detailsSummaryLabel">New Orders</h3>
          <strong id="detailsSummaryValue">0</strong>
        </div> -->
      </div>
      <div id="detailsOrdersContent" class="dashboard-details-loading"></div>
    </div>
    <div class="dashboard-details-view" data-view="clients">
      <div id="detailsClientsContent" class="dashboard-details-loading">Loading registered clients...</div>
    </div>
    <div class="dashboard-details-view" data-view="bounce">
      <div id="detailsBounceRateContent1" class="dashboard-details-loading">Loading bounce rate...</div>
      <div id="detailsBounceRateChart"></div>
    </div>
    <div class="dashboard-details-view" data-view="turnover">
      <div id="detailsTurnoverContent" class="dashboard-details-loading">Loading turnover...</div>
      <div class="dashboard-turnover-controls">
        <button type="button" class="turnover-range-button is-active" data-range="days">Days</button>
        <button type="button" class="turnover-range-button" data-range="weeks">Weeks</button>
        <!-- <button type="button" class="turnover-range-button" data-range="demo">Demo data</button> -->
      </div>
      <div id="detailsTurnoverChart"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>
<script>
function loadDashboardCharts(callback) {
  var scripts = [
    base_url + '/public/bower_components/raphael/raphael.min.js',
    base_url + '/public/bower_components/morris.js/morris.min.js',
    base_url + '/public/bower_components/apexcharts/dist/apexcharts.min.js'
  ];
  var remaining = scripts.length;

  scripts.forEach(function (src) {
    var script = document.createElement('script');
    script.src = src;
    var complete = function () {
      remaining -= 1;
      if (remaining === 0) {
        callback();
      }
    };
    script.onload = complete;
    script.onerror = complete;
    document.head.appendChild(script);
  });
}

$(document).ready(function () {
  var startDashboard = window.requestIdleCallback || function (callback) {
    window.setTimeout(callback, 150);
  };

  startDashboard(function () {
    loadDashboardCharts(function () {
    // Initialize date picker
    $('#calendar').datepicker();

let areaChartData = [];
    // Fetch data for pie charts
 $.ajax({
    url: base_url + '/dashboard/getCurrentMonthStatistics',
    type: 'GET',
    dataType: 'json', // Ensures the response is parsed into a JavaScript object
    success: function(response) {
        // Log the entire response to understand the structure
        console.log('Full Response:', response);

        // $('#neworder').text(response.invcount);

        // $('#newclient').text(response.clientcount);

        // $('#monthlyturnover').text(response.monthturn);

        // Process treechart data
        console.log('Treechart Data:');
        
        response.treechart.forEach(function(item) {
           let locationParts = item.location.split('-');
            let city = locationParts[0].trim(); // Get the left side (city)
            let count = item.count; // This will be the y value
            //console.log(`x: ${city}, y: ${count}`);
            areaChartData.push({ x: city, y: count });
            //console.log(`x: ${item.location}, y: ${item.count}`);
        });


          var options = {
      series: [
        {
          data: areaChartData,
        }
      ],
      legend: {
        show: false
      },
      chart: {
        height: 360,
        type: 'treemap',
        toolbar: {
      show: false, // Disable the toolbar
    },
      },
      title: {
        //text: 'Distributed Treemap (different color for each cell)',
        align: 'center'
      },
      colors: [
        '#3B93A5',
        '#F7B844',
        '#ADD8C7',
        '#EC3C65',
        '#CDD7B6',
        '#C1F666',
        '#D43F97',
        '#1E5D8C',
        '#421243',
        '#7F94B0',
        '#EF6537',
        '#C0ADDB'
      ],
      plotOptions: {
        treemap: {
          distributed: true,
          enableShades: false
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#ebar-chart-tree"), options);
    chart.render();




                    let consumableData = [];

                    // Process consumables data
                    console.log('Consumables Data:'+ response.consumables);
                    response.consumables.forEach(function(item) {
                        //console.log(item);
                        //console.log(`Label: ${item.item_name}, Value: ${item.item_sold}`);
                          //let locationParts = item.location.split('-');
                        let label = item.label; // Get the left side (city)
                        let sold = item.value; // This will be the y value


                        consumableData.push({ label: label, value: sold });
                    });


   
                    Morris.Donut({
                    element: 'chart_pie_5',
                    data:consumableData,
                    resize:true,    
                    dataLabels: true,
                    showPercentage: true,
                    //colors:bootstrapColorPalette,
                    //dataLabelsPosition: 'outside',
                  }).options.colors.forEach(function(color, d){ 
                    if (consumableData[d] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i>'+consumableData[d].label+'</span>';
                      document.getElementById("chart_pie_5_legend").appendChild(node);
                    }
                  });   // Repeat similar logic for other charts


                  let productcategoryCount = []       

                  // Process productcategorycount data
                  //console.log('Product Category Count:');
                  response.productcategorycount.forEach(function(item) {
                      //console.log(`Category: ${item.label}, Value: ${item.value}`);
                       let label = item.label; // Get the left side (city)
                      let sold = item.value; // This will be the y value
                      productcategoryCount.push({ label: label, value: sold })
                  });


                    Morris.Donut({
                        element: 'chart_pie_4',
                        data: productcategoryCount,
                    }).options.colors.forEach(function(color, index) {
                      if (productcategoryCount[index] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+productcategoryCount[index].label+'</span>';
                      document.getElementById("chart_pie_4_legend").appendChild(node);
                    }
                        // Your legend generation logic here
                    });




                  let usercategoryCount = []       

                  // Process productcategorycount data
                  //console.log('User Category Count:');
                  response.usercategory.forEach(function(item) {
                      //console.log(`Category: ${item.category}, Value: ${item.count}`);
                       let label = item.label; // Get the left side (city)
                      let sold = item.value; // This will be the y value
                      usercategoryCount.push({ label: label, value: sold })
                  });


                    Morris.Donut({
                    element: 'chart_pie_1',
                    data:usercategoryCount,
                    resize:true,    
                    //dataLabels: true,
                    //showPercentage: true,
                    dataLabelsPosition: 'outside'
                  }).options.colors.forEach(function(color, b){ 
                    
              //b is parameter variable
                    if (usercategoryCount[b] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+usercategoryCount[b].label+'</span>';
                      document.getElementById("chart_pie_1_legend").appendChild(node);
                    }
                  });



                   let countryCount = []       

                  // Process productcategorycount data
                  //console.log('country Category Count:');
                  response.countrycount.forEach(function(item) {
                      //console.log(`Category: ${item.label}, Value: ${item.value}`);
                       let label = item.label; // Get the left side (city)
                      let sold = item.value; // This will be the y value
                      countryCount.push({ label: label, value: sold })
                  });


         
                    Morris.Donut({
                    element: 'chart_pie_2',
                    data:countryCount,
                    resize:true,    
                    //dataLabels: true,
                    //showPercentage: true,
                    //dataLabelsPosition: 'outside',
                  }).options.colors.forEach(function(color, c){ 
                    if (countryCount[c] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+countryCount[c].label+'</span>';
                      document.getElementById("chart_pie_2_legend").appendChild(node);
                    }
                  });




                   let docCount = []       

                  // Process productcategorycount data
                  //console.log('doc Category Count:');
                  response.doccount.forEach(function(item) {
                      //console.log(`Category: ${item.label}, Value: ${item.value}`);
                       let label = item.label; // Get the left side (city)
                      let sold = item.value; // This will be the y value
                      docCount.push({ label: label, value: sold })
                  });


                 
                    Morris.Donut({
                    element: 'chart_pie_3',
                    data:docCount,
                    resize:true,    
                    //dataLabels: true,
                    //showPercentage: true,
                    //dataLabelsPosition: 'outside',
                  }).options.colors.forEach(function(color, d){ 
                    if (docCount[d] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+docCount[d].label+'</span>';
                      document.getElementById("chart_pie_3_legend").appendChild(node);
                    }
                  });   // Repeat similar logic for other charts



                   let doczCount = []       

                  // Process productcategorycount data
                  console.log('docz Category Count:');
                  response.doczcount.forEach(function(item) {
                      //console.log(`Category: ${item.label}, Value: ${item.value}`);
                       let label = item.label; // Get the left side (city)
                      let sold = item.value; // This will be the y value
                      doczCount.push({ label: label, value: sold })
                  });


                 
                    Morris.Donut({
                    element: 'chart_pie_6',
                    data:doczCount,
                    resize:true,    
                    //dataLabels: true,
                    //showPercentage: true,
                    //dataLabelsPosition: 'outside',
                  }).options.colors.forEach(function(color, d){ 
                    if (doczCount[d] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+doczCount[d].label+'</span>';
                      document.getElementById("chart_pie_6_legend").appendChild(node);
                    }
                  });   // Repeat similar logic for other charts



                
                     let TnCount1 = []       

                  // Process productcategorycount data
                  //console.log('Tn Count:');
                  response.allyearsalesdata.forEach(function(item) {
                      //console.log(`${item.y},${item.a},${item.b},${item.c},${item.label}`);
                       let a = item.a; // Get the left side (city)
                      let b = item.b;
                      let c= item.c;
                      let y=item.y;
                      let label=item.label; // This will be the y value
                      TnCount1.push({y:y,a:a,b:b,c:c, label:label  })
                  });





                    var x = Morris.Bar({
                    element: 'bar-chart',
                    data: TnCount1,
                    //'#f56954','#00a65a'
                    barColors: [ '#03a9f3','#55ce63','#f56954'],
                        xkey: 'y',
                        ykeys: ['b','a','c'],
                        labels: ['GST','Turnover','item_sold'],
                        hideHover: 'auto',    
                        xLabelAngle: 60,

                        nbYkeys2: 1,
                        dataLabels:false,  
                        gridTextWeight:'Bold',
                        
                        hoverCallback: function(index, options, content, row) {
                          var dataLabel = row.label; // Assuming 'label' is the key for item_name
                          return "<div style='text-align:center;'>" + content + "<br>" + dataLabel + "</div>";
                      },
                       
                  });


                     let clienttypeCount = []       

                  // Process productcategorycount data
                  //console.log('country Category Count:');
                  response.clientcategorycount.forEach(function(item) {
                      //console.log(`Category: ${item.label}, Value: ${item.value}`);
                       let label = item.label; // Get the left side (city)
                      let sold = item.value; // This will be the y value
                      clienttypeCount.push({ label: label, value: sold })
                  });


         
                    Morris.Donut({
                    element: 'chart_pie_7',
                    data:clienttypeCount,
                    resize:true,    
                    //dataLabels: true,
                    //showPercentage: true,
                    //dataLabelsPosition: 'outside',
                  }).options.colors.forEach(function(color, c){ 
                    if (clienttypeCount[c] != undefined) {
                      var node = document.createElement('span');
                      node.innerHTML += '<span style="color:'+color+'"><i style="margin-left: 15px;" class="fas fa-square"></i> '+clienttypeCount[c].label+'</span>';
                      document.getElementById("chart_pie_7_legend").appendChild(node);
                    }
                  });




                     let TnCount = []       

                  // Process productcategorycount data
                  //console.log('Tn Count:');
                  response.allyeardata.forEach(function(item) {
                      //console.log(`${item.y},${item.a},${item.b},${item.c},${item.label}`);
                       let a = item.a; // Get the left side (city)
                      let b = item.b;
                      let c= item.c;
                      let y=item.y;
                      let label=item.label; // This will be the y value
                      TnCount.push({y:y,a:a,b:b,c:c, label:label  })
                  });

  

                  var bar = new Morris.Bar({
                  element: 'bar-chart3',
                  resize: true,
                  data: TnCount, 
                  barColors: ['#00a65a','#FFBF00','#f56954'],
                  xkey: 'y',
                  ykeys: ['b','a','c'],
                  labels: ['GST','Turnover','item_sold'],
                  dataLabels:false,
                  hideHover: 'auto',
                  xLabelAngle: 60,
                  nbYkeys2:1,
                  //gridTextSize: '14px',
                  gridTextWeight:'Bold',
                  hoverCallback: function(index, options, content, row) {
                    var dataLabel = row.label; // Assuming 'label' is the key for item_name
                    return "<div style='text-align:center;'>" + content + "<br>" + dataLabel + "</div>";
                },
                 
                });  


         $('#brand').change(function(){  
                //var data21,data22; 
                var brand_id = $(this).val();
                //console.log(brand_id);
                var startyear =brand_id.substr(0,4);
                //console.log(startyear);
                var endyear =brand_id.substr(5,10);
                //console.log(endyear);
               $.ajax({  
                url:base_url+"/dashboard/loadData",  
                method:"GET",  
                data:{brand_id:brand_id},  
                dataType:'json',
                showLoader:true,
                success:function(data){  
                  
                var data21=data['arr1'];
                var data22=data['arr2'];
                console.log(data21+"data21");
                console.log(data22[0].item_name);
                      
                x.setData(data21);
                x.redraw();

                console.log("Total Length"+data22.length);
                      //console.log(data['1']['item_name']);
                   // console.log(data[2]);

                    var arr=["aqua","red","green","yellow","primary","red","purple"];
              
                      $('#bars').empty();
                      var title='<p class="text-center"><strong style="font-size: 18px;"> Items Sold</strong></p></br>';
                      $('#bars').append(title);
                      var v=data22.length;
                      var val2= 5 - v;
                      console.log("V value:"+val2);
                        
                        if(val2 != 0)
                      { 
                        var sp='</br>'
                      }
                      
                      for(var i=0;i<=5;i++){
                      console.log(i);
                      
                      if(val2 == 0)
                      {
                      
                        console.log("Enters if");

                     $('#bars').append('<div class="progress-group"><span class="progress-text" id="'+i+'">'+data22[i].item_name+'</span><span class="progress-number"><b>'+data22[i].item_sold+'</b>/100</span><div class="progress sm"><div class="progress-bar progress-bar-'+arr[i]+'" style="width:'+(100 * data22[i].item_sold)/100+'%"></div></div></div>');
                     //v+=1;
                       }

                      else if (val2 < 5)
                      {
                          for(var i=0;i<v;i++){
                             console.log("else if "+i);
                                $('#bars').append('<div class="progress-group"><span class="progress-text" id="'+i+'">'+data22[i].item_name+'</span><span class="progress-number"><b>'+data22[i].item_sold+'</b>/100</span><div class="progress sm"><div class="progress-bar progress-bar-'+arr[i]+'" style="width:'+(100 * data22[i].item_sold)/100+'%"></div></div></div>');
                          }

                            for(var j=val2;j<=5;j++){
                                                            console.log("enter else if 2nd loop"+j);

                              $('#bars').append('<div class="progress-group"><span class="progress-text" id="'+j+'">No-Items</span><span class="progress-number"><b>'+"0"+'</b>/200</span><div class="progress sm"><div class="progress-bar progress-bar-'+arr[j]+'" style="width:100%"></div></div></div>');
                              val2+=1;


                            }

                      }                    
                      else 
                      {

                        console.log("enter else");

                      }
                      }

                    console.log("For loop complete");                  

                }
                
                });

                $.ajax({  
                url:base_url+"/dashboard/load_turn",  
                method:"GET",  
                data:{brand_y:brand_id},
                showLoader:true,  
                dataType:'json',
                success:function(data){  
                      //console.log(data);
                      //console.log(data['invoices']);

                       $('#invval').text(data['invoices']);
                       $('#totalitemval').text(data['totalitems']);
                      
                       $('#yeartotalval').text(addCommas(data['turnovery'])).append(".00 Rs");
                       $('#taxtotalvalz').text(addCommas(data['taxy'])).append(".00 Rs");
                      $('#FY').text("Turnover Chart of the FY : ").append(brand_id);
                      $('#Fyz').text("Sales: 1 Apr," +" "+ startyear+" - 30 Mar," +" "+ endyear);    
                     //console.log(data[1]);
                      // console.log(data[2]);
                      // console.log(data[3]);  
                    
                }
                });
              

  });


    function currentTime() {
    var date = new Date();
    var day = date.getDay();
    var hour = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();
    var month = date.getMonth();
    var currDate = date.getDate();
    var year = date.getFullYear();
    var monthName = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    var showDay = $('.dayDiv span')
    var midDay= "AM"
    midDay = (hour>=12)? "PM":"AM";
    hour = (hour==0)?12:((hour<12)? hour:(hour-12));
    hour = updateTime(hour);
    min = updateTime(min);
    sec = updateTime(sec);
    currDate= updateTime(currDate);
    $("#time").html(`${hour}:${min}`);
    $("#sec").html(`${sec}`);
    $("#med").html(`${midDay}`);
    $("#full-date").html(`${monthName[month]} ${currDate} ${year}`);
    showDay.eq(day).css('opacity','1')
  }
  updateTime = function(x){
    if(x<10){
      
      return "0"+x
    }
    else{
      
      return x;
    }
    
  }
  setInterval(currentTime,1000);

    $('.dashboard-chart').removeClass('is-loading');

    },
    error: function(xhr, status, error) {
      $('.dashboard-chart').removeClass('is-loading');
        console.error('AJAX Error:', error);
        console.log('Response Text:', xhr.responseText);
    }
});

    });
  });
});
</script>
<script>

function addCommas(numberString) {
  numberString += '';
  var x = numberString.split('.'),
      x1 = x[0],
      x2 = x.length > 1 ? '.' + x[1] : '',
      rgxp = /(\d+)(\d{3})/;

  while (rgxp.test(x1)) {
    x1 = x1.replace(rgxp, '$1' + ',' + '$2');
  }

  return x1 + x2;
}
function reminder() {
    $.ajax({
        url: base_url + '/dashboard/clientreminder',
        type: 'GET',
        dataType: 'json', // Parse response as JSON
        success: function (response) {
            console.log('Full Response:', response); // Log the full response

        if (response.client_data.aaData) {
        const tableBody = $('#tbody'); 
        tableBody.empty(); // Clear any existing rows
        
        response.client_data.aaData.forEach((record, index) => {
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${record.invid}</td>
                    <td>${record.c_name}</td>
                    <td>${record.item_name}</td>
                    <td>${record.mob}</td>
                </tr>
            `;
            tableBody.append(row);
        });
    } else {
        console.warn('No client data available.');
    }


     if (response.quickquote_data.aaData) {
        //console.log('QuickQuote Data:', response.quickquote_data.aaData);
         const tableBody = $('#tbody2'); 
        tableBody.empty(); // Clear any existing rows
        
        response.quickquote_data.aaData.forEach((record, index) => {
            const row = `
                <tr>
                    <td>${index+1}</td>
                    <td>${record.q_id}</td>
                    <td>${record.name}</td>
                    <td>${record.mob}</td>
                    <td>${record.quantity}</td>
                    <td>${record.subtotal}</td>
                    <td>${record.gst}</td>
                    <td>${record.total}</td>
                </tr>
            `;
            tableBody.append(row);
        });

    }


        },
        error: function (xhr, status, error) {
            // Handle errors gracefully
            console.error('Error occurred:', error);
        }
    });
}

// Call the function to load data into the table
(window.requestIdleCallback || function (callback) {
  window.setTimeout(callback, 150);
})(reminder);



</script>
<script>
$(function () {
  var overlay = $('#dashboardDetailsOverlay');
  var lastFocusedElement;
  var turnoverDetailsChart;
  var bounceRateDetailsChart;
  var turnoverDailyData = [];
  var turnoverDemoMode = false;


  function showSummary(stat) {
    var summaries = {
      orders: ['New Orders', $('#neworder').text()],
      bounce: ['Bounce Rate', $('.small-box.bg-green h3').first().text().trim()],
      clients: ['New Clients Registered', $('#newclient').text()],
      turnover: ['Current Month Turnover', $('#monthlyturnover').text()]
    };
    var summary = summaries[stat] || summaries.orders;
    $('#detailsSummaryLabel').text(summary[0]);
    $('#detailsSummaryValue').text(summary[1]);
  }

  function renderTurnoverDetailsChart(range) {
    if (typeof Morris === 'undefined') {
      $('#detailsTurnoverContent').text('Turnover chart is unavailable.');
      return;
    }

    var chartData = turnoverDailyData;
    
if (range === 'weeks') {

    var weeklyTotals = {};

    chartData.forEach(function (item, index) {

        var week = Math.floor(index / 7) + 1;

        if (!weeklyTotals[week]) {
            weeklyTotals[week] = {
                gst: 0,
                turnover: 0,
                item_count: 0,
                max_item_sold: 'No item'
            };
        }

        // Total GST for week
        weeklyTotals[week].gst += Number(item.gst) || 0;

        // Total turnover for week
        weeklyTotals[week].turnover += Number(item.turnover) || 0;

        // Total items sold for week
        weeklyTotals[week].item_count += Number(item.item_count) || 0;

        // Keep item name from the day with highest item count
        if (
            Number(item.item_count) >
            Number(weeklyTotals[week].max_item_count || 0)
        ) {
            weeklyTotals[week].max_item_count =
                Number(item.item_count) || 0;

            weeklyTotals[week].max_item_sold =
                item.max_item_sold || 'No item';
        }
    });

    chartData = Object.keys(weeklyTotals).map(function (week) {

        return {
            day: 'Week ' + week,
            gst: weeklyTotals[week].gst,
            turnover: weeklyTotals[week].turnover,
            item_count: weeklyTotals[week].item_count,
            max_item_sold: weeklyTotals[week].max_item_sold
        };
    });
}
    if (turnoverDetailsChart) {
      $('#detailsTurnoverChart').empty();
    }
    
    turnoverDetailsChart = Morris.Bar({
    element: 'detailsTurnoverChart',

    data: chartData,

    barColors: [
        '#03a9f3',   // GST
        '#55ce63',   // Turnover
        '#f56954'    // Item Sold
    ],

    xkey: 'day',

    ykeys: [
        'gst',
        'turnover',
        'item_count'
    ],

    labels: [
        'GST',
        'Turnover',
        'Item Sold'
    ],

    hideHover: 'auto',

    //xLabelAngle: 60,

    nbYkeys2: 1,

    dataLabels: false,

    gridTextWeight: 'Bold',

    resize: true,

    yLabelFormat: function(value) {
        return Number(value).toLocaleString('en-IN');
    },

    hoverCallback: function(index, options, content, row) {

        var itemName = row.max_item_sold || 'No item';

        return "<div style='text-align:center;'>" +

            "<strong>" + row.day + "</strong><br>" +

            "GST: " +
            Number(row.gst || 0).toLocaleString('en-IN') +

            "<br>Turnover: " +
            Number(row.turnover || 0).toLocaleString('en-IN') +

            "<br>Item Sold: " +
            Number(row.item_count || 0).toLocaleString('en-IN') +

            "<br>Item: <strong>" +
            itemName +
            "</strong>" +

            "</div>";
    }
});
  }

  function renderBounceRateChart(currentMonthData, previousMonthData) {
    if (typeof Morris === 'undefined') {
      $('#detailsBounceRateContent').text('Bounce rate chart is unavailable.');
      return;
    }

var previousLookup = {};

(previousMonthData || []).forEach(function (item) {

    var dayText = String(item.day || '');
    var day = parseInt(
        dayText.length >= 10
            ? dayText.substring(8, 10)
            : dayText,
        10
    );

    if (!isNaN(day)) {
        previousLookup[day] = Number(item.turnover) || 0;
    }
});


var bounceRateData = (currentMonthData || []).map(function (item) {

    var dayText = String(item.day || '');

    var day = parseInt(
        dayText.length >= 10
            ? dayText.substring(8, 10)
            : dayText,
        10
    );

    return {
        day: day,
        currentMonth: Number(item.turnover) || 0,
        previousMonth: previousLookup[day] || 0
    };
});


console.log('Bounce chart data:', bounceRateData);


if (bounceRateDetailsChart) {
    $('#detailsBounceRateChart').empty();
}


bounceRateDetailsChart = Morris.Area({

    element: 'detailsBounceRateChart',

    data: bounceRateData,

    xkey: 'day',

    ykeys: [
        'currentMonth',
        'previousMonth'
    ],

    labels: [
        'Current Month Turnover',
        'Last Month Turnover'
    ],

    lineColors: [
        '#00a65a',
        '#3c8dbc'
    ],

    fillOpacity: 0.35,

    hideHover: 'auto',

    resize: true,

    behaveLikeLine: true,

    pointSize: 3,

    parseTime: false,

    // DO NOT use xLabelFormat

    yLabelFormat: function(value) {
        return Number(value).toLocaleString('en-IN');
    },

    hoverCallback: function(index, options, content, row) {

        return '<div style="text-align:center;">' +

            '<strong>Day ' + row.day + '</strong><br>' +

            'Current Month Turnover: ' +
            Number(row.currentMonth || 0).toLocaleString('en-IN') +

            '<br>' +

            'Last Month Turnover: ' +
            Number(row.previousMonth || 0).toLocaleString('en-IN') +

            '</div>';
    }
});
    $('#detailsBounceRateContent')
      .text('Daily bounce rate comparison')
      .css({  'font-size': '18px','font-weight': 'bold', 'text-align':'center'})
      .removeClass('dashboard-details-loading');
  }

  function renderClientsTable(target, clients) {
    if (!target || !target.length) {
      return;
    }

    if (clients.length === 0) {
      target.html('<div class="dashboard-details-empty"><i class="fa fa-user-plus"></i> No clients registered this month.</div>');
      return;
    }

    var table = $(
      '<div class="dashboard-table-box">' +
        '<div class="dashboard-table-box-header">' +
          '<h4 class="dashboard-table-box-title"><i class="fa fa-users"></i> Clients Registered' +
            '<span class="dashboard-client-count-badge">' + clients.length + '</span>' +
          '</h4>' +
          '<div class="dashboard-clients-toolbar">' +
            '<input type="text" class="form-control input-sm dashboard-clients-search" placeholder="Search clients..." aria-label="Search clients">' +
          '</div>' +
        '</div>' +
        '<div class="dashboard-details-table-wrap">' +
          '<table class="table table-hover dashboard-details-table">' +
            '<thead><tr>' +
              '<th>#</th>' +
              '<th>Date</th>' +
              '<th>Client</th>' +
              '<th class="dashboard-col-address">Address</th>' +
              '<th>Mobile</th>' +
              '<th>GST</th>' +
              '<th>Country</th>' +
              '<th>Client Type</th>' +
            '</tr></thead>' +
            '<tbody></tbody>' +
          '</table>' +
        '</div>' +
        '<div class="dashboard-details-table-footer">Showing ' + clients.length + ' client' + (clients.length === 1 ? '' : 's') + ' registered this month</div>' +
      '</div>'
    );

    var tbody = table.find('tbody');

    clients.forEach(function (client, index) {
      var created = client.created || '';
      var dateParts = created.split('-');
      var formattedDate = dateParts.length === 3
        ? dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]
        : (created || '');

      var typeText = client.c_type || '';
      var typeLabel = $('<span class="dashboard-client-type"></span>').text(typeText);

      var row = $('<tr></tr>');
      $('<td class="text-muted"></td>').text(index + 1).appendTo(row);
      $('<td class="dashboard-col-date"></td>').text(formattedDate).appendTo(row);
      $('<td></td>').text(client.c_name || '').appendTo(row);
      $('<td class="dashboard-col-address"></td>').text(client.c_add || '').appendTo(row);
      $('<td></td>').text(client.mob || '').appendTo(row);
      $('<td></td>').text(client.gst || '').appendTo(row);
      $('<td></td>').text(client.country || '').appendTo(row);
      $('<td>').append(typeLabel).appendTo(row);

      row.appendTo(tbody);
    });

    // Live client-side search / filter
    table.find('.dashboard-clients-search').on('input', function () {
      var query = $.trim($(this).val()).toLowerCase();
      tbody.find('tr').each(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
      });
    });

    target.empty().append(table);
  }



function renderOrdersTable(target, orders) {
    if (!target || !target.length) {
        return;
    }

    if (orders.length === 0) {
        target.html(
            '<div class="dashboard-details-empty">' +
            '<i class="fa fa-shopping-cart"></i> No new orders found.' +
            '</div>'
        );
        return;
    }

    var table = $(
        '<div class="dashboard-table-box">' +
            '<div class="dashboard-table-box-header">' +
                '<h4 class="dashboard-table-box-title">' +
                    '<i class="fa fa-shopping-cart"></i> New Orders' +
                    '<span class="dashboard-client-count-badge">' +
                        orders.length +
                    '</span>' +
                '</h4>' +

                '<div class="dashboard-clients-toolbar">' +
                    '<input type="text" ' +
                    'class="form-control input-sm dashboard-orders-search" ' +
                    'placeholder="Search orders..." ' +
                    'aria-label="Search orders">' +
                '</div>' +
            '</div>' +

            '<div class="dashboard-details-table-wrap">' +
                '<table class="table table-hover dashboard-details-table">' +
                    '<thead>' +
                        '<tr>' +
                            '<th>#</th>' +
                            '<th>Date</th>' +
                            '<th>Invoice No</th>' +
                            '<th>Client</th>' +
                            '<th>Item</th>' +
                            '<th>Location</th>' +
                            '<th>GST</th>' +
                            '<th>Type</th>' +
                            '<th>Subtotal</th>' +
                            '<th>Tax</th>' +
                            '<th>Total</th>' +
                        '</tr>' +
                    '</thead>' +
                    '<tbody></tbody>' +
                '</table>' +
            '</div>' +

            '<div class="dashboard-details-table-footer">' +
                'Showing ' + orders.length +
                ' order item' + (orders.length === 1 ? '' : 's') +
            '</div>' +
        '</div>'
    );

    var tbody = table.find('tbody');

    orders.forEach(function(order, index) {

        var created = order['inv date'] || order.inv_date || '';
        var formattedDate = created;

        // YYYY-MM-DD → DD-MM-YYYY
        var dateParts = created.split('-');

        if (dateParts.length === 3) {
            formattedDate =
                dateParts[2] + '-' +
                dateParts[1] + '-' +
                dateParts[0];
        }

        var row = $('<tr></tr>');

        $('<td class="text-muted"></td>')
            .text(index + 1)
            .appendTo(row);

        $('<td></td>')
            .text(formattedDate)
            .appendTo(row);

        $('<td></td>')
            .text(order['inv no'] || order.inv_no || '')
            .appendTo(row);

        $('<td></td>')
            .text(order.client || '')
            .appendTo(row);

        $('<td></td>')
            .text(order.item || '')
            .appendTo(row);

        $('<td></td>')
            .text(order.location || '')
            .appendTo(row);

        $('<td></td>')
            .text(order.GST || '')
            .appendTo(row);

        $('<td></td>')
            .text(order.c_type || '')
            .appendTo(row);

        $('<td class="text-right"></td>')
            .text(
                Number(order.subtotal || 0).toLocaleString('en-IN')
            )
            .appendTo(row);

        $('<td class="text-right"></td>')
            .text(
                Number(order.taxamount || 0).toLocaleString('en-IN')
            )
            .appendTo(row);

        $('<td class="text-right"></td>')
            .text(
                Number(order.totalamount || 0).toLocaleString('en-IN')
            )
            .appendTo(row);

        row.appendTo(tbody);
    });

    // Search
    table.find('.dashboard-orders-search').on('input', function () {

        var query = $.trim($(this).val()).toLowerCase();

        tbody.find('tr').each(function () {

            $(this).toggle(
                $(this).text().toLowerCase().indexOf(query) > -1
            );

        });
    });

    target.empty().append(table);
}

  // function loadOrdersDetails() {
  //   $.ajax({
  //     url: base_url + '/dashboard/getDashboardDetails',
  //     type: 'GET',
  //     dataType: 'json',
  //     success: function (response) {
  //       if (turnoverDemoMode) {
  //         return;
  //       }
  //       var clients = response.clients || [];
  //       var ordersContent = $('#detailsOrdersContent');
  //       renderClientsTable(ordersContent, clients);
  //       ordersContent.removeClass('dashboard-details-loading');
  //     },
  //     error: function () {
  //       $('#detailsOrdersContent').text('Unable to load registered clients.');
  //     }
  //   });
  // }

function loadOrdersDetails() {
    $.ajax({
        url: base_url + '/dashboard/getDashboardDetails',
        type: 'GET',
        dataType: 'json',

        success: function (response) {

            if (turnoverDemoMode) {
                return;
            }

            var orders = response.orders || [];

            var ordersContent = $('#detailsOrdersContent');

            renderOrdersTable(ordersContent, orders);

            ordersContent.removeClass('dashboard-details-loading');
        },

        error: function () {

            $('#detailsOrdersContent')
                .text('Unable to load orders.');
        }
    });
}
  function loadDetailsData() {
    $.ajax({
      url: base_url + '/dashboard/getDashboardDetails',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (turnoverDemoMode) {
          return;
        }
        var clients = response.clients || [];
        var dailyTurnover = response.dailyTurnover || [];
        var previousDailyTurnover = response.previousDailyTurnover || [];
        var clientContent = $('#detailsClientsContent');
        var turnoverContent = $('#detailsTurnoverContent');

        renderClientsTable(clientContent, clients);
        clientContent.removeClass('dashboard-details-loading');

        turnoverContent
        .text(dailyTurnover.length === 0 ? 'No turnover recorded this month.' : 'Daily turnover')
        .css({  'font-size': '18px','font-weight': 'bold'});

//         turnoverDailyData = dailyTurnover.map(function (item) {
//     return {
//         day: item.day.substr(8, 2),
//         gst: Number(item.gst) || 0,
//         turnover: Number(item.turnover) || 0,
//         max_item_sold: item.max_item_sold || 'No item',
//         item_count: Number(item.item_count) || 0
//     };
// });
var year = new Date().getFullYear();
var month = new Date().getMonth(); // 0 = January

var daysInMonth = new Date(year, month + 1, 0).getDate();

// Create lookup from DB data
var turnoverLookup = {};

dailyTurnover.forEach(function (item) {

    var date = item.day;
    var dayNumber = Number(date.substr(8, 2));

    turnoverLookup[dayNumber] = {
        gst: Number(item.gst) || 0,
        turnover: Number(item.turnover) || 0,
        max_item_sold: item.max_item_sold || 'No item',
        item_count: Number(item.item_count) || 0
    };
});

// Create complete month data
turnoverDailyData = [];

for (var day = 1; day <= daysInMonth; day++) {

    var data = turnoverLookup[day];

    turnoverDailyData.push({
        day: String(day).padStart(2, '0'),

        gst: data ? data.gst : 0,

        turnover: data ? data.turnover : 0,

        max_item_sold: data ? data.max_item_sold : 'No item',

        item_count: data ? data.item_count : 0
    });
}
        renderTurnoverDetailsChart($('.turnover-range-button.is-active').data('range') || 'days');
        if (overlay.find('.dashboard-details-view[data-view="bounce"]').hasClass('is-active')) {
          renderBounceRateChart(turnoverDailyData, previousDailyTurnover);
        }
      },
      error: function () {
        $('#detailsClientsContent').text('Unable to load registered clients.');
        $('#detailsTurnoverContent').text('Unable to load daily turnover.');
      }
    });
  }

  function openDashboardDetails(event) {
    event.preventDefault();
    lastFocusedElement = event.currentTarget;
    var stat = $(event.currentTarget).data('stat');
    showSummary(stat);
    overlay.find('.dashboard-details-view').removeClass('is-active');
    var view = stat === 'clients' || stat === 'turnover' || stat === 'bounce' ? stat : 'summary';
    overlay.find('.dashboard-details-view[data-view="' + view + '"]').addClass('is-active');
    $('#detailsClientsContent').addClass('dashboard-details-loading').text('Loading registered clients...');
    $('#detailsTurnoverContent').text('Loading turnover...');
    $('#detailsTurnoverChart').empty();
    $('#detailsBounceRateContent').addClass('dashboard-details-loading').text('Loading bounce rate...');
    $('#detailsBounceRateChart').empty();
    turnoverDemoMode = false;
    $('.turnover-range-button').removeClass('is-active');
    $('.turnover-range-button[data-range="days"]').addClass('is-active');
    overlay.addClass('is-open');
    $('body').css('overflow', 'hidden');
    if (stat === 'clients' || stat === 'turnover' || stat === 'bounce') {
      loadDetailsData();
    }
    if (stat === 'orders') {
      $('#detailsOrdersContent').addClass('dashboard-details-loading');
      loadOrdersDetails();
    } else {
      // Hide the orders table for other stats that share the summary view
      $('#detailsOrdersContent')
        .addClass('dashboard-details-loading')
        .empty();
    }
    overlay.find('.dashboard-details-close').trigger('focus');
  }

  function closeDashboardDetails() {
    overlay.removeClass('is-open');
    $('body').css('overflow', '');
    if (lastFocusedElement) {
      $(lastFocusedElement).trigger('focus');
    }
  }

  $('.dashboard-more-info').on('click', openDashboardDetails);
  $('.turnover-range-button').on('click', function () {
    if ($(this).data('range') === 'demo') {
      turnoverDemoMode = true;
      turnoverDailyData = getDemoTurnoverData();
      $('.turnover-range-button').removeClass('is-active');
      $(this).addClass('is-active');
      $('#detailsTurnoverContent').text('Demo turnover data');
      renderTurnoverDetailsChart('days');
      return;
    }
    $('.turnover-range-button').removeClass('is-active');
    $(this).addClass('is-active');
    if (turnoverDailyData.length > 0) {
      renderTurnoverDetailsChart($(this).data('range'));
    }
  });
  overlay.find('.dashboard-details-close').on('click', closeDashboardDetails);
  overlay.on('click', function (event) {
    if (event.target === this) {
      closeDashboardDetails();
    }
  });
  $(document).on('keydown', function (event) {
    if (event.key === 'Escape' && overlay.hasClass('is-open')) {
      closeDashboardDetails();
    }
  });
});
</script>

</body>
</html>
