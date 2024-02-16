<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | <?php echo e(Config::get('constants.app_title')); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="<?php echo e(asset('public/assets/images/favicon.ico')); ?>">

        <!-- Bootstrap Css -->
        <link href="<?php echo e(asset('public/assets/css/admin/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo e(asset('public/assets/css/admin/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo e(asset('public/assets/css/admin/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Confirm Css-->
        <link href="<?php echo e(asset('public/assets/css/admin/confirm.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style>
            .actionsBtn {display: flex;}
            .editSurvey,.editFolder {margin-right: 1rem;}
            .createBtn {display: flex;justify-content: flex-end;margin-right: 3rem;margin-bottom: 3rem;}
            .createBtn a {color: white;}
            .select2-container{width:100% !important;}
            .privateusers {display:none;}
            .privateusers .form-group.mb-0,.surveyfoldername .form-group.mb-0{display: flex;flex-direction: column-reverse;}
            .dataTables_paginate {float: left;}
            .dataTables_filter {float: left;}
            .dataTables_length {float: right;}
            .dataTables_info {float:right;}
        </style>
    </head>

    <body data-sidebar="dark">
        <!-- <body data-layout="horizontal" data-topbar="colored"> -->

            <!-- Begin page -->
            <div id="layout-wrapper">

                <header id="page-topbar">
                    <div class="navbar-header">
                        <div class="d-flex">
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a href="dashboard" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="<?php echo e(asset('public/assets/images/logo-dark-sm.png')); ?>" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="<?php echo e(asset('public/assets/images/logo-dark.png')); ?>" alt="" height="18">
                                    </span>
                                </a>
                
                                <a href="dashboard" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="<?php echo e(asset('public/assets/images/logo-light-sm.png')); ?>" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="<?php echo e(asset('public/assets/images/logo-light.png')); ?>" alt="" height="18">
                                    </span>
                                </a>
                            </div><?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/layout/header.blade.php ENDPATH**/ ?>