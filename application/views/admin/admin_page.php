<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Dinua - Admin Panel</title>
    <link rel="stylesheet" href="<?php echo(base_url());?>css/screen.css" type="text/css" media="screen, projection"/>
    <link rel="stylesheet" href="<?php echo(base_url());?>css/jquery-ui-1.8.18.custom.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
    <!-- Framework CSS -->
    <!-- java script -->
    <script type="text/javascript" charset="utf-8" src="<?php echo(base_url());?>js/jquery-1.7.1.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo(base_url());?>js/jquery-ui-1.8.18.custom.min.js"></script>
    <style type="text/css">
    <!--
    #admin-page-top{
       background: #39739C;
       height: 75px;
       color: #fff;
    }
    #admin-page-top a{
        color: #fff;
    }
    -->
div.c1 {text-align: center}
    </style>
</head>
<body>
    <div class="c1" id="admin-page-top">
        <h2 style="color: #fff;"><strong>ADMIN PANEL DINUA</strong></h2>
        <div id="admin-page-menu">
            <a href="<?php echo(base_url()); ?>admin/adminpage/report">Laporan</a> | 
            <a href="<?php echo(base_url()); ?>admin/adminpage/forbidenword">Kata Terlarang</a> | 
            <a href="<?php echo(base_url()); ?>admin/adminpage/content">Konten</a> | 
            <a href="<?php echo(base_url()); ?>admin/adminpage/account">Akun</a> | 
            <a href="<?php echo(base_url()); ?>admin/adminpage/password">Password</a> | 
            <a href="<?php echo( base_url('admin/adminlogin/logout'))?>">Logout</a>
        </div>
    </div>
    <hr/>
    <?php
        include_once($page);
    ?>
</body>
</html>