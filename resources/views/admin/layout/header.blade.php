<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | {{Config::get('constants.app_title')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/admin/confirm.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 

        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/tokeninput/tokeninput.css') }}" rel="stylesheet" type="text/css" />
    
        <style>
            .actionsBtn {display: flex;}
            .editSurvey,.editFolder,.editQuota {margin-right: 1rem;}
            .editSurvey:hover,.editFolder:hover,.editQuota:hover {
                background: #4099de;
                border-color: #4099de;
            }
            .createBtn {display: flex;justify-content: flex-end;margin-right: 3rem;margin-bottom: 3rem;}
            .createBtn a {color: white;}
            .select2-container{width:100% !important;}
            .privateusers {display:none;}
            .privateusers .form-group.mb-0,.surveyfoldername .form-group.mb-0{display: flex;flex-direction: column-reverse;}
            .btn-primary{color: #fff;background-color: #4099de;border-color: #4099de;}
            .page-item.active .page-link {background-color: #4099de !important;border-color: #4099de !important;}

            ul.token-input-list-bootstrap {
                border: 1px solid #ced4da !important;
            }

            .play-button-container {
                align-content: center;
            }

            .play-button {
                position: relative;
                display: block;
                height: 25px;
                width: 25px;
                box-shadow: 0 0 0 3px #4099de;
                border-radius: 15%;
                cursor: pointer;
            }

            .play-button__triangle {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-30%, -50%);
                z-index: 0;
                border: solid #4099de;
                border-right-width: 0;
                border-left-width: 13.5px;
                border-top-width: 8.1px;
                border-bottom-width: 8.1px;
                border-top-color: transparent;
                border-bottom-color: transparent;
                height: 0;
                width: 0;
                transition: 0.6s, 0s border-color;
            }
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
                                        <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="18">
                                    </span>
                                </a>
                
                                <a href="dashboard" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ asset('assets/images/logo-light-sm.png') }}" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="18">
                                    </span>
                                </a>
                            </div>