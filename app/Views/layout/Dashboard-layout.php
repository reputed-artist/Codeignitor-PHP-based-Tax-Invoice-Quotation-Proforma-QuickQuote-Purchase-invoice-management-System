
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
  

<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url();?>/public/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Morris.js charts -->
<script src="<?= base_url();?>/public/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url();?>/public/bower_components/morris.js/morris.min.js"></script>

<script src="<?= base_url();?>/public/bower_components/apexcharts/dist/apexcharts.min.js"></script>

<script src="<?= base_url();?>/public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="<?= base_url();?>/public/bower_components/font/font.css">

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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
              <div id='chart_pie_5' class='chart_morris' style="height: 230px;"></div>
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
              <div class="chart_morris" id="chart_pie_1" style="height: 230px;"></div>
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
              <div id='chart_pie_2' class='chart_morris' style="height: 230px;"></div>
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
              <div id='chart_pie_4' class='chart_morris' style="height: 230px;"></div>
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
              <div id='chart_pie_3' class='chart_morris' style="height: 230px;"></div>
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
              <div id='chart_pie_6' class='chart_morris' style="height: 230px;"></div>
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
                   <div class="chart" id="ebar-chart-tree" style="height: 400px;"></div>
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
                   <div class="chart" id="bar-chart3" style="height: 300px;"></div>
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
              <div id='chart_pie_7' class='chart_morris' style="height: 230px;"></div>
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
<script type="text/javascript">
  var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>
<script>
$(document).ready(function () {
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
                    //console.log('Consumables Data:');
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


    },
    error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
        console.log('Response Text:', xhr.responseText);
    }
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
reminder();



</script>

</body>
</html>
