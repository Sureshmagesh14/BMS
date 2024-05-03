<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/percentage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('assets/css/admin/confirm.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid align-items-end">
            <a class="navbar-brand w-25" href="{{ route('user.dashboard') }}"><img class="img-fluid w-75 m-auto"
                    src="{{ asset('user/images/small-logo.png') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav m-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                    <li class="nav-item pe-5">
                        <a class="nav-link" href="{{ route('user.surveys') }}" id="nav_surveys">Surveys</a>
                    </li>
                    <li class="nav-item px-5">
                        <a class="nav-link" href="{{ route('user.rewards') }}" id="nav_rewards">Rewards</a>
                    </li>
                    <li class="nav-item px-5">
                        <a class="nav-link " href="{{ route('user.dashboard') }}" id="nav_profile">Profile</a>
                    </li>
                    <li class="nav-item ps-5">
                        <a class="nav-link" href="{{ route('user.share') }}" id="nav_share">Share</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center" style="padding-right: 20px">
                    <a href="#" class="px-2"><img class="img-fluid" style="max-height: 21px"
                            src="{{ asset('user/images/icons/1c-04.png') }}" alt="" /></a>
                    <a href="#" class="pe-4">
                        <img class="img-fluid" style="max-height: 21px" src="{{ asset('user/images/icons/1c-05.png') }}"
                            alt="" /></a>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle vi-usr-profile p-3 me-3" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                V
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.viewprofile') }}">View Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" id="click_signout">Sign Out</a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </nav>
