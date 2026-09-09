<!DOCTYPE html>
<!--
    links_profile.php
    Lightweight asset include used ONLY by the profile/settings page
    (app/Views/Info layout/profileinfo.php).

    This deliberately omits the heavy DataTables / PDF / Excel / select2 /
    date-picker / wysihtml5 export stack that is loaded by include/links.php
    on the full listing pages. The profile page only needs:
        - Bootstrap CSS + JS
        - Font Awesome / Ionicons
        - AdminLTE + skins
        - Morris.js + Raphael (static line chart)
        - SweetAlert2 (Swal.*)
        - jQuery

    Removing ~3.7 MB of JS/CSS from the <head> dramatically speeds up load time.
-->

<!-- Bootstrap -->
<link rel="stylesheet" href="<?= base_url()?>/public/bower_components/bootstrap/dist/css/bootstrap.min.css">

<!-- Font Awesome 5 (all.css / fas-far classes) -->
<link rel="stylesheet" href="<?= base_url()?>/public/bower_components/Font-Awesome-Master/font-awesome/css/all.css">

<!-- Font Awesome 4 (fa fa-* classes used by the sidebar/layout icons) -->
<link rel="stylesheet" href="<?= base_url()?>/public/bower_components/font-awesome/css/font-awesome.min.css">

<!-- Ionicons -->
<link rel="stylesheet" href="<?= base_url()?>/public/bower_components/Ionicons/css/ionicons.min.css">

<!-- Morris chart -->
<link rel="stylesheet" href="<?= base_url()?>/public/bower_components/morris.js/morris.css">

<!-- Theme style -->
<link rel="stylesheet" href="<?= base_url()?>/public/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="<?= base_url()?>/public/dist/css/skins/_all-skins.min.css">

<!-- jQuery -->
<script src="<?= base_url()?>/public/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3 -->
<script src="<?= base_url()?>/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE (sidebar / push-menu / tree / control sidebar) -->
<script src="<?= base_url()?>/public/dist/js/adminlte.min.js"></script>

<!-- AdminLTE demo (initializes the Control Sidebar / settings panel tabs) -->
<script src="<?= base_url()?>/public/dist/js/demo.js"></script>

<!-- Morris.js charts -->
<script src="<?= base_url()?>/public/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url()?>/public/bower_components/morris.js/morris.min.js"></script>

<!-- SweetAlert2 (Swal.fire used by the profile AJAX handlers) -->
<script type="text/javascript" src="<?=base_url()?>/public/plugins/swal2/sweetalert2.all.min.js"></script>