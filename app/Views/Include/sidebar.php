   <aside class="main-sidebar" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="padding: 2px; padding-top: 10px;">
        <div class="pull-left image">
          <img src="<?= esc(session()->get('user_image')); ?>" id="imagePreview5" style="height: 45px; width: 45px; " class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= esc(session()->get('name')); ?></p>
          
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <!-- <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview <?= set_active('/dashboard') || set_active('dashboard/dashboard2') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="<?= set_active('/dashboard');?>"><a href="<?=base_url()?>/dashboard/"><i class="fa fa-circle-o"></i>Dashboard v1</a></li>
            <li class="<?= set_active('/dashboard/dashboard2');?>"><a href="<?=base_url()?>/dashboard/dashboard2"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
 -->

         <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li class="<?= set_active('/dashboard'); ?>">
          <a href="<?=base_url()?>/dashboard/">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>



        
        
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li> -->



       <li class="treeview <?= set_active('/account/manageaccounts') || strpos(current_url(), base_url() . '/account/getledger/') !== false ? 'active' : '' ?>">
    <a href="#">
        <i class="fa fa-fw fa-calculator"></i>
        <span>Accounts</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>

          <ul class="treeview-menu">
            <li class="<?= set_active('/account/manageaccounts');?>"><a href="<?=base_url()?>/account/manageaccounts"><i class="fa fa-fw fa-users"></i> Accounts</a></li>
            <li class="<?= set_active('/account/demo');?>" ><a href="<?=base_url()?>/account/demo"><i class="fa fa-fw fa-user-plus"></i> Add/View Account Type</a></li>
            <!-- <li class="<?php //if ($current_page1=="Fixed Assets") {echo "active"; }?>"><a href="fd.php"><i class="glyphicon glyphicon-fire"></i>Fixed Assets</a></li> -->
          </ul>
        </li> 
 
     
        <li class="<?= set_active('/client/manageclients'); ?>">
          <a href="<?=base_url('/client/manageclients'); ?>">
            <i class="fa fa-fw fa-shield"></i> <span>Manage Clients</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>


        <li class="<?= set_active('/product/manageproducts'); ?>">
          <a href="<?= base_url('/product/manageproducts'); ?>">
            <i class="fa fa-fw fa-gears"></i> <span>Products</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>


        <li class="<?= set_active('/supplier/managesupplier'); ?>">
          <a href="<?= base_url('/supplier/managesupplier'); ?>">
            <i class="fa fa-fw fa-qrcode"></i> <span>Suppliers</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>




         <li class="<?= set_active('purchaseinv/genpurchaseinv') ?>">
          <a href="<?=base_url('/purchaseinv/genpurchaseinv')?>">
            <i class="fa fa-fw fa-opencart"></i> <span> Add Purchase</span>
           
          </a>
        </li>

         <li class="<?= set_active('/purchaseinv/showdata') ?>">
          <a href="<?=base_url('/purchaseinv/showdata')?>">
            <i class="fa fa-fw fa-list"></i> <span> Purchase List</span>
           
          </a>
        </li>


       <!--  <li>
          <a href="<?=base_url()?>/purchaseinv/genpurchaseinv">
            <i class="glyphicon glyphicon-floppy-saved"></i> <span>Add Proforma invoice</span>
           
          </a>
        </li>

         <li class="<?php //if ($current_page=="manage-purlist") {echo "active"; }?>">
          <a href="<?=base_url()?>/purchaseinv/showdata">
            <i class="fa fa-fw fa-list"></i> <span>Proforma List</span>
           
          </a>
        </li>
  

          <li>
          <a href="<?=base_url()?>/purchaseinv/genpurchaseinv">
            <i class="fa fa-fw fa-opencart"></i> <span>Add Tax Invoice</span>
           
          </a>
        </li>

         <li class="<?php //if ($current_page=="manage-purlist") {echo "active"; }?>">
          <a href="<?=base_url()?>/purchaseinv/showdata">
            <i class="fa fa-fw fa-list"></i> <span>Tax invoice List </span>
           
          </a>
        </li>

 -->
           <li class="<?= set_active('/quickquote/') ?>">
          <a href="<?=base_url('/quickquote/')?>">
            <i class="fa fa-fw fa-opencart"></i><span> Quick Quotation</span>
           
          </a>
        </li>



         <li class="<?= set_active('/quote/genquote') ?>">
          <a href="<?=base_url('/quote/genquote')?>">
            <i class="fas fa-search-dollar"></i> <span>&nbsp;Gen. Quotation</span>
           
          </a>
        </li>

         <li class="<?= set_active('/quote/showquotedata') ?>">
          <a href="<?=base_url('/quote/showquotedata')?>">
            <i class="fa fa-fw fa-list"></i><span>&nbsp; Quotation List</span>
           
          </a>
        </li>

        <li>
          <a href="https://web.whatsapp.com/" target="_blank">
            &nbsp;<i class="fa fa-whatsapp"></i><span>Whatsapp</span>
           
          </a>
        </li>

        <!--  <li>
          <a href="email.php">
            <i class="fa fa-envelope"></i><span style="padding-left: 2px;">Festival Email</span>
           
          </a>
        </li>
 -->
         



<li class="treeview <?= set_active('proinv/showprodata') || set_active('taxinv/showtaxdata') ? 'active' : '' ?>">
    <a href="#">
        <i class="fa fa-fw fa-cloud-download"></i>
        <span>Manage Invoice</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?= set_active('proinv/showprodata') ?>"><a href="<?= base_url('/proinv/showprodata') ?>"><i class="glyphicon glyphicon-floppy-saved"></i> Proforma Invoice List</a></li>
        <li class="<?= set_active('taxinv/showtaxdata') ?>"><a href="<?= base_url('/taxinv/showtaxdata') ?>"><i class="glyphicon glyphicon-barcode"></i> Tax Invoice List</a></li>
    </ul>
</li>




 <li class="<?= set_active('transaction/managetransaction'); ?>">
          <a href="<?=base_url()?>/transaction/managetransaction">
            <i class="fa fa-fw fa-rupee"></i> <span>Transaction </span>
            
          </a>
        </li>




  <!-- Generate Section -->
<li class="treeview <?= set_active('proinv/genproinv') || set_active('taxinv/gentaxinv') ? 'active' : '' ?>">
    <a href="#">
        <i class="fa fa-fw fa-print"></i> <span> Generate </span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu" style="display: block;">
        <li class="<?= set_active('proinv/genproinv') ?>"><a href="<?= base_url('/proinv/genproinv') ?>"><i class="glyphicon glyphicon-floppy-saved"></i> Gen. Proforma Invoice </a></li>
        <li class="<?= set_active('taxinv/gentaxinv') ?>"><a href="<?= base_url('/taxinv/gentaxinv') ?>"><i class="glyphicon glyphicon-barcode"></i> Gen. Tax Invoice</a></li>
    </ul>
</li>


        


       <!-- Sales Report Section -->
      <li class="treeview <?= set_active('quickquote/quickquotereport')|| set_active('quote/quoteitemreport') || set_active('quote/quotereport') ? 'active' : '' ?>">
          <a href="#">
              <i class="fa fa-fw fa-download"></i>
              <span> Quotation Report</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
          <li class="<?= set_active('quickquote/quickquotereport') ?>"><a href="<?= base_url('/quickquote/quickquotereport') ?>"><i class="fa fa-fw fa-line-chart"></i>Quick Quotation Report</a></li>

              <li class="<?= set_active('quote/quoteitemreport') ?>"><a href="<?= base_url('/quote/quoteitemreport') ?>"><i class="fa fa-fw fa-gears"></i> Quotation Item Report</a></li>
              <li class="<?= set_active('quote/quotereport') ?>"><a href="<?= base_url('/quote/quotereport') ?>"><i class="fa fa-fw fa-line-chart"></i> Quotation Report</a></li>


          </ul>
      </li>
   

       <li class="treeview <?= set_active('proinv/proitemreport') || set_active('proinv/proreport') ? 'active' : '' ?>">
          <a href="#">
              <i class="fa fa-fw fa-download"></i>
              <span> Proforma Report</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
              <li class="<?= set_active('proinv/proitemreport') ?>"><a href="<?= base_url('/proinv/proitemreport') ?>"><i class="fa fa-fw fa-gears"></i> Proforma Item Report</a></li>
              <li class="<?= set_active('proinv/proreport') ?>"><a href="<?= base_url('/proinv/proreport') ?>"><i class="fa fa-fw fa-line-chart"></i> Proforma Report</a></li>
          </ul>
      </li>
   


      <!-- Purchase Report Section -->
      <li class="treeview <?= set_active('purchaseinv/purchaseitemreport') || set_active('purchaseinv/purchasereport') ? 'active' : '' ?>">
          <a href="#">
              <i class="fa fa-fw fa-download"></i>
              <span> Purchase Report</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
              <li class="<?= set_active('purchaseinv/purchaseitemreport') ?>"><a href="<?= base_url('/purchaseinv/purchaseitemreport') ?>"><i class="fa fa-fw fa-gears"></i> Purchase Item Report</a></li>
              <li class="<?= set_active('purchaseinv/purchasereport') ?>"><a href="<?= base_url('/purchaseinv/purchasereport') ?>"><i class="fa fa-fw fa-opencart"></i> Purchase Report</a></li>
          </ul>
      </li>

      <!-- Sales Report Section -->
      <li class="treeview <?= set_active('taxinv/saleitemreport') || set_active('taxinv/salereport') ? 'active' : '' ?>">
          <a href="#">
              <i class="fa fa-fw fa-download"></i>
              <span> Sales Report</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu" style="display: block;">
              <li class="<?= set_active('taxinv/saleitemreport') ?>"><a href="<?= base_url('/taxinv/saleitemreport') ?>"><i class="fa fa-fw fa-gears"></i> Sale Item Report</a></li>
              <li class="<?= set_active('taxinv/salereport') ?>"><a href="<?= base_url('/taxinv/salereport') ?>"><i class="fa fa-fw fa-line-chart"></i> Sales Report</a></li>
          </ul>
      </li>


  
      
          <li class="<?= set_active('profile/settings'); ?>">
          <a href="<?= base_url()?>/profile/settings">
            <i class="fa fa-fw fa-gear" ></i> <span> Settings</span>
           
          </a>
        </li>

        <li>
          <a href="<?= base_url()?>/login/logout">
            <i class="fa fa-fw fa-power-off" ></i> <span> Logout</span>
            
          </a>
        </li>



            
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
