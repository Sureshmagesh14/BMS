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
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('assets/css/admin/confirm.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #ddd;
            height: 100%;
            overflow-x: hidden;
        }

        .text {
            color: brown;
            font-size: 220px;
            text-align: center;
        }

        .open {
            color: green;
            background: #000;
            padding: 10px;
            border-radius: 20px;
        }

        /* Preloader */
        .container-preloader {
            align-items: center;
            cursor: none;
            display: flex;
            height: 100%;
            justify-content: center;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            z-index: 900;
        }

        .container-preloader .animation-preloader {
            position: absolute;
            z-index: 100;
        }

        /* Spinner Loading */
        .container-preloader .animation-preloader .spinner {
            animation: spinner 1s infinite linear;
            border-radius: 50%;
            border: 10px solid rgba(0, 0, 0, 0.2);
            border-top-color: green;
            /* It is not in alphabetical order so that you do not overwrite it */
            height: 9em;
            margin: 0 auto 3.5em auto;
            width: 9em;
        }

        /* Loading text */
        .container-preloader .animation-preloader .txt-loading {
            font: bold 5em 'Montserrat', sans-serif;
            text-align: center;
            user-select: none;
        }

        .container-preloader .animation-preloader .txt-loading .characters:before {
            animation: characters 4s infinite;
            color: orange;
            content: attr(preloader-text);
            left: 0;
            opacity: 0;
            position: absolute;
            top: 0;
            transform: rotateY(-90deg);
        }

        .container-preloader .animation-preloader .txt-loading .characters {
            color: rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .container-preloader .animation-preloader .txt-loading .characters:nth-child(2):before {
            animation-delay: 0.2s;
        }

        .container-preloader .animation-preloader .txt-loading .characters:nth-child(3):before {
            animation-delay: 0.4s;
        }

        img#profile{
            border-radius: 50%;
            height: 50px;
            width: 52px !important;
        }

        .container-preloader .animation-preloader .txt-loading .characters:nth-child(4):before {
            animation-delay: 0.6s;
        }

        .container-preloader .animation-preloader .txt-loading .characters:nth-child(5):before {
            animation-delay: 0.8s;
        }

        .container-preloader .animation-preloader .txt-loading .characters:nth-child(6):before {
            animation-delay: 1s;
        }

        .container-preloader .animation-preloader .txt-loading .characters:nth-child(7):before {
            animation-delay: 1.2s;
        }

        .container-preloader .loader-section {
            background-color: #ffffff;
            height: 100%;
            position: fixed;
            top: 0;
            width: calc(50% + 1px);
        }

        .container-preloader .loader-section.section-left {
            left: 0;
        }

        .container-preloader .loader-section.section-right {
            right: 0;
        }

        /* Fade effect on loading animation */
        .loaded .animation-preloader {
            opacity: 0;
            transition: 0.3s ease-out;
        }

        /* Curtain effect */
        .loaded .loader-section.section-left {
            transform: translateX(-101%);
            transition: 0.7s 0.3s all cubic-bezier(0.1, 0.1, 0.1, 1.000);
        }

        .loaded .loader-section.section-right {
            transform: translateX(101%);
            transition: 0.7s 0.3s all cubic-bezier(0.1, 0.1, 0.1, 1.000);
        }

        /* Animation of the preloader */
        @keyframes spinner {
            to {
                transform: rotateZ(360deg);
            }
        }

        /* Animation of letters loading from the preloader */
        @keyframes characters {

            0%,
            75%,
            100% {
                opacity: 0;
                transform: rotateY(-90deg);
            }

            25%,
            50% {
                opacity: 1;
                transform: rotateY(0deg);
            }
        }

        /* Laptop size back (laptop, tablet, cell phone) */
        @media screen and (max-width: 767px) {

            /* Preloader */
            /* Spinner Loading */
            .container-preloader .animation-preloader .spinner {
                height: 8em;
                width: 8em;
            }

            /* Text Loading */
            .container-preloader .animation-preloader .txt-loading {
                font: bold 3.5em 'Montserrat', sans-serif;
            }
        }

        @media screen and (max-width: 500px) {

            /* Prelaoder */
            /* Spinner Loading */
            .container-preloader .animation-preloader .spinner {
                height: 7em;
                width: 7em;
            }

            /*Loading text */
            .container-preloader .animation-preloader .txt-loading {
                font: bold 2em 'Montserrat', sans-serif;
            }
        }

        .origin {
            text-decoration: none;
            font-size: 45px;
        }

        .vii-usr-profile {
            /* background-color: #edbf1b; */
            border-radius: 50%;
            width: 20px;
            height: 20px;
            background-image: "url(asset('public/uploads/1/1718119882.jpg'))";
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<div id="preloader">
    <div id="container" class="container-preloader">
        <div class="animation-preloader">
            <div class="spinner"></div>
            <div class="txt-loading">
                <span preloader-text="L" class="characters">L</span>

                <span preloader-text="O" class="characters">O</span>

                <span preloader-text="A" class="characters">A</span>

                <span preloader-text="D" class="characters">D</span>

                <span preloader-text="I" class="characters">I</span>

                <span preloader-text="N" class="characters">N</span>

                <span preloader-text="G" class="characters">G</span>
            </div>
        </div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
</div>

<body class="bg-greybg">
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid align-items-end">
            <a class="navbar-brand w-25 w-sm-75" href="{{ route('user.dashboard') }}"><img
                    class="img-fluid w-75 m-auto w-sm-100" src="{{ asset('user/images/small-logo.png') }}"
                    alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="{{ route('user.dashboard') }}" id="nav_dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="{{ route('user.surveys') }}" id="nav_surveys">Surveys</a>
                    </li>
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="{{ route('user.rewards') }}" id="nav_rewards"
                            href="#">Rewards</a>
                    </li>
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="{{ route('updateprofile_wizard') }}" id="nav_profile">Profile</a>
                    </li>
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="{{ route('user.share') }}" id="nav_share">Share</a>
                    </li>
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="https://thebrandsurgeon.co.za/" id="nav_share">FAQ</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center" style="padding-right: 20px">
                    <!-- <a href="#" class="px-2"
              ><img
                class="img-fluid"
                style="max-height: 21px"
                src="./assets/images/icons/1c-04.png"
                alt=""
            /></a>
            <a href="#" class="pe-4">
              <img
                class="img-fluid"
                style="max-height: 21px"
                src="./assets/images/icons/1c-05.png"
                alt=""
            /></a> -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle p-3 me-3" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @php
                                    $first_char = mb_substr(Session::get('resp_name'), 0, 1);
                                    $resp_id = Session::get('resp_id');
                                    $data = $folderspublic = \App\Models\Respondents::find($resp_id);
                                    $profile_image = $data->profile_image ?? '';

                                    $profile_path = $data->profile_path ?? '';

                                @endphp
                                @if ($profile_image != null)
                                    <img id="profile" src="{{ asset($profile_path . $profile_image) }}"
                                        style="width:100px; border: 2px solid black;">
                                @else
                                    <span class="vi-usr-profile m-auto p-4"
                                        style="text-transform: capitalize;">{{ $first_char }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('updateprofile_wizard') }}">View
                                        Profile</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="{{ route('user.change_profile') }}">Change Profile Picture</a>
                                </li>
                                {{-- {{ route('user.viewprofile') }} --}}

                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="{{ route('user.change_password') }}">Change
                                        Password</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            id="click_signout">Logout</a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <i class="fa fa-ellipsis-v m-hide dropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"></i>
                </div>
            </div>
        </div>
    </nav>
