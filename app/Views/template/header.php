<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible">
    <title>E-Raport</title>
    <!-- <style type="text/css" id="debugbar_dynamic_style"></style> -->
    <link rel="stylesheet" href="<?php echo base_url('public/AdminLTE/dist'); ?>/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo base_url('public/AdminLTE/plugins'); ?>/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url('public/AdminLTE/plugins'); ?>/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url('public/AdminLTE/plugins'); ?>/overlayScrollbars/css/OverlayScrollbars.css">
    <link rel="stylesheet" href="<?php echo base_url('public/AdminLTE/plugins'); ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <style>
        .wrapper {
            /*min-height: 100%;
            position: relative;
            overflow: hidden;*/
            width: 100%;
            min-height: 100%;
            height: auto !important;
            position: absolute;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav navbar navbar-static-top">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="image mr-2">
                        <img src="<?= base_url('public/img/profile.png'); ?>" class="img-circle" width="30" height="30" alt="User Image">
                        <a><?= session()->get('nama'); ?></a>
                    </div>
                </li>
                <!-- <li>
                    <div class="mt-1 text-red">
                        <i class="fas fa-sign-out-alt"></i>
                        <a class="text-decoration-none text-red" href="#" data-toggle="modal" data-target="#logoutModal">
                            Logout
                        </a>
                    </div>
                </li> -->
            </ul>
        </nav>