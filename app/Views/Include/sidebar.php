<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel" style="padding: 2px; padding-top: 10px;">
        <div class="pull-left image">
          <img src="<?= esc(session()->get('user_image')); ?>" id="imagePreview5" style="height: 45px; width: 45px; " class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= esc(session()->get('name')); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li class="<?= set_active('/dashboard'); ?>">
          <a href="<?=base_url()?>/dashboard/">
            <i class="fa fa-fw fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container"></span>
          </a>
        </li>

        <li class="treeview <?= set_active('/account/manageaccounts') || strpos(current_url(), base_url() . '/account/getledger/') !== false ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-book"></i>              <!-- was fa-tag -->
            <span>Accounts</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= set_active('/account/manageaccounts');?>"><a href="<?=base_url()?>/account/manageaccounts"><i class="fa fa-fw fa-list"></i> Accounts</a></li>
            <li class="<?= set_active('/account/demo');?>"><a href="<?=base_url()?>/account/demo"><i class="fa fa-fw fa-user-plus"></i> Add/View Account Type</a></li>
          </ul>
        </li>

        <li class="<?= set_active('/client/manageclients'); ?>">
          <a href="<?=base_url('/client/manageclients'); ?>">
            <i class="fa fa-fw fa-users"></i>              <!-- was fa-user-cog -->
            <span>Manage Clients</span>
            <span class="pull-right-container"><small class="label pull-right bg-green">new</small></span>
          </a>
        </li>

        <li class="<?= set_active('/product/manageproducts'); ?>">
          <a href="<?= base_url('/product/manageproducts'); ?>">
            <i class="fa fa-fw fa-cubes"></i>              <!-- was fa-boxes -->
            <span>Products</span>
            <span class="pull-right-container"><small class="label pull-right bg-green">new</small></span>
          </a>
        </li>

        <li class="<?= set_active('/supplier/managesupplier'); ?>">
          <a href="<?= base_url('/supplier/managesupplier'); ?>">
            <i class="fa fa-fw fa-truck"></i>              <!-- was fa-qrcode -->
            <span>Suppliers</span>
            <span class="pull-right-container"><small class="label pull-right bg-green">new</small></span>
          </a>
        </li>

        <li class="<?= set_active('purchaseinv/genpurchaseinv') ?>">
          <a href="<?=base_url('/purchaseinv/genpurchaseinv')?>">
            <i class="fa fa-fw fa-cart-plus"></i>          <!-- was fa-opencart -->
            <span> Add Purchase</span>
          </a>
        </li>

        <li class="<?= set_active('/purchaseinv/showdata') ?>">
          <a href="<?=base_url('/purchaseinv/showdata')?>">
            <i class="fa fa-fw fa-list"></i>               <!-- was fa-list-ul -->
            <span> Purchase List</span>
          </a>
        </li>

        <li class="<?= set_active('/quickquote/') ?>">
          <a href="<?=base_url('/quickquote/')?>">
            <i class="fa fa-fw fa-bolt"></i>               <!-- was fa-opencart -->
            <span> Quick Quotation</span>
          </a>
        </li>

        <li class="<?= set_active('/quote/genquote') ?>">
          <a href="<?=base_url('/quote/genquote')?>">
            <i class="fa fa-fw fa-file-text-o"></i>        <!-- was fa-quote-right -->
            <span>&nbsp;Gen. Quotation</span>
          </a>
        </li>

        <li class="<?= set_active('/quote/showquotedata') ?>">
          <a href="<?=base_url('/quote/showquotedata')?>">
            <i class="fa fa-fw fa-list-alt"></i>           <!-- was fa-list -->
            <span>&nbsp; Quotation List</span>
          </a>
        </li>

        <li>
          <a href="https://web.whatsapp.com/" target="_blank">
            &nbsp;<i class="fa fa-whatsapp"></i><span>Whatsapp</span>
          </a>
        </li>

        <li class="treeview <?= set_active('proinv/showprodata') || set_active('taxinv/showtaxdata') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-folder-open"></i>        <!-- was fa-cloud-download -->
            <span>Manage Invoice</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= set_active('proinv/showprodata') ?>"><a href="<?= base_url('/proinv/showprodata') ?>"><i class="fa fa-fw fa-file-text-o"></i> Proforma Invoice List</a></li>
            <li class="<?= set_active('taxinv/showtaxdata') ?>"><a href="<?= base_url('/taxinv/showtaxdata') ?>"><i class="fa fa-fw fa-file-text"></i> Tax Invoice List</a></li>
          </ul>
        </li>

        <li class="<?= set_active('transaction/managetransaction'); ?>">
          <a href="<?=base_url()?>/transaction/managetransaction">
            <i class="fa fa-fw fa-exchange"></i>           <!-- was fa-rupee -->
            <span>Transaction </span>
          </a>
        </li>

        <li class="treeview <?= set_active('proinv/genproinv') || set_active('taxinv/gentaxinv') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-plus-square"></i>        <!-- was fa-print -->
            <span> Generate </span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="<?= set_active('proinv/genproinv') ?>"><a href="<?= base_url('/proinv/genproinv') ?>"><i class="fa fa-fw fa-file-text-o"></i> Gen. Proforma Invoice </a></li>
            <li class="<?= set_active('taxinv/gentaxinv') ?>"><a href="<?= base_url('/taxinv/gentaxinv') ?>"><i class="fa fa-fw fa-file-text"></i> Gen. Tax Invoice</a></li>
          </ul>
        </li>

        <li class="treeview <?= set_active('quickquote/quickquotereport')|| set_active('quote/quoteitemreport') || set_active('quote/quotereport') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-bar-chart"></i>          <!-- was fa-download -->
            <span> Quotation Report</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="<?= set_active('quickquote/quickquotereport') ?>"><a href="<?= base_url('/quickquote/quickquotereport') ?>"><i class="fa fa-fw fa-line-chart"></i>Quick Quotation Report</a></li>
            <li class="<?= set_active('quote/quoteitemreport') ?>"><a href="<?= base_url('/quote/quoteitemreport') ?>"><i class="fa fa-fw fa-th-list"></i> Quotation Item Report</a></li>
            <li class="<?= set_active('quote/quotereport') ?>"><a href="<?= base_url('/quote/quotereport') ?>"><i class="fa fa-fw fa-line-chart"></i> Quotation Report</a></li>
          </ul>
        </li>

        <li class="treeview <?= set_active('proinv/proitemreport') || set_active('proinv/proreport') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-pie-chart"></i>          <!-- was fa-download -->
            <span> Proforma Report</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="<?= set_active('proinv/proitemreport') ?>"><a href="<?= base_url('/proinv/proitemreport') ?>"><i class="fa fa-fw fa-th-list"></i> Proforma Item Report</a></li>
            <li class="<?= set_active('proinv/proreport') ?>"><a href="<?= base_url('/proinv/proreport') ?>"><i class="fa fa-fw fa-line-chart"></i> Proforma Report</a></li>
          </ul>
        </li>

        <li class="treeview <?= set_active('purchaseinv/purchaseitemreport') || set_active('purchaseinv/purchasereport') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-shopping-cart"></i>      <!-- was fa-download -->
            <span> Purchase Report</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="<?= set_active('purchaseinv/purchaseitemreport') ?>"><a href="<?= base_url('/purchaseinv/purchaseitemreport') ?>"><i class="fa fa-fw fa-th-list"></i> Purchase Item Report</a></li>
            <li class="<?= set_active('purchaseinv/purhsnreport') ?>"><a href="<?= base_url('/purchaseinv/purhsnreport') ?>"><i class="fa fa-fw fa-code-fork"></i> Purchase Hsn Report</a></li>
            <li class="<?= set_active('purchaseinv/purchasereport') ?>"><a href="<?= base_url('/purchaseinv/purchasereport') ?>"><i class="fa fa-fw fa-bar-chart"></i> Purchase Report</a></li>
          </ul>
        </li>

        <li class="treeview <?= set_active('taxinv/saleitemreport') || set_active('taxinv/salereport') ? 'active' : '' ?>">
          <a href="#">
            <i class="fa fa-fw fa-money"></i>              <!-- was fa-download -->
            <span> Sales Report</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu" style="display: block;">
            <li class="<?= set_active('taxinv/saleitemreport') ?>"><a href="<?= base_url('/taxinv/saleitemreport') ?>"><i class="fa fa-fw fa-th-list"></i> Sale Item Report</a></li>
            <li class="<?= set_active('taxinv/salehsnreport') ?>"><a href="<?= base_url('/taxinv/salehsnreport') ?>"><i class="fa fa-fw fa-code-fork"></i> Sale Hsn Report</a></li>
            <li class="<?= set_active('taxinv/salereport') ?>"><a href="<?= base_url('/taxinv/salereport') ?>"><i class="fa fa-fw fa-line-chart"></i> Sales Report</a></li>
          </ul>
        </li>

        <li class="<?= set_active('profile/settings'); ?>">
          <a href="<?= base_url()?>/profile/settings">
            <i class="fa fa-fw fa-gear"></i>               <!-- was fa-cog -->
            <span> Settings</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url()?>/login/logout">
            <i class="fa fa-fw fa-power-off"></i>          <!-- was fa-sign-out-alt -->
            <span> Logout</span>
          </a>
        </li>
      </ul>
    </section>
</aside>