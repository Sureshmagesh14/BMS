<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | <?php echo e(Config::get('constants.app_title')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <?php $__env->startSection('favicon'); ?>
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(asset('public/assets/images/favicon.ico')); ?>">
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('login-css'); ?>
        <!-- Bootstrap Css -->
        <link href="<?php echo e(asset('public/assets/css/admin/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo e(asset('public/assets/css/admin/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo e(asset('public/assets/css/admin/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <?php $__env->stopSection(); ?>
</head>

<body class="authentication-bg" style="background-image: url(<?php echo e(asset('public/assets/images/auth-bg.png')); ?>)">
    <div class="account-pages mt-5 mb-4 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="index.html" class="mb-5 d-block auth-logo">
                            <img src="<?php echo e(asset('public/assets/images/brand_surgen.png')); ?>" alt="" height="45" class="logo logo-dark">
                            
                        </a>
                    </div>
                </div>
            </div>

            <?php $__env->startSection('social'); ?>
                <div class="mt-4 text-center">
                    <div class="signin-other-title">
                        <h5 class="font-size-14 mb-3 title">OR</h5>
                    </div>
                    
                    <p class="text-muted mb-3">Continue with social media</p>
                    
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-1">
                            <a href="javascript:void()" class="social-list-item bg-soft-primary font-size-16 text-primary border-white">
                                <i class="uil-facebook-f"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-1">
                            <a href="javascript:void()" class="social-list-item bg-soft-info font-size-16 text-info border-white">
                                <i class="uil-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-1">
                            <a href="javascript:void()" class="social-list-item bg-soft-danger font-size-16 text-danger border-white">
                                <i class="uil-google"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void()" class="social-list-item bg-soft-purple font-size-16 text-purple border-white">
                                <i class="uil-linkedin-alt"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php $__env->stopSection(); ?><?php /**PATH C:\wamp64\www\bms_new\resources\views/login_register/layout/header.blade.php ENDPATH**/ ?>