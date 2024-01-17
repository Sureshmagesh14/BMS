@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Drezon</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="avatar-sm mr-3 p-1 border rounded border-soft-primary">
                                    <div class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="icon-sm" data-feather="watch"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-size-15"><a href="#" class="text-dark">Smart Watch
                                            Series 5</a></h5>
                                    <p class="text-muted mb-0"><i
                                            class="icon-xxs icon text-warning icon-fill-warning mr-2"
                                            data-feather="star"></i>5.0</p>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4">
                                <div class="col-7">
                                    <h6 class="mb-1 font-size-15">300k <span
                                            class="text-muted font-size-13 ml-1">Product</span></h6>
                                    <a href="#" class="h6 font-weight-normal text-muted">$250.00 - $650.00</a>
                                </div>
                                <!-- end col-->
                                <div class="col-5">
                                    <div>
                                        <div class="apex-charts" id="sparkline-chart-1"></div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="avatar-sm mr-3 p-1 border rounded border-soft-primary">
                                    <div class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="icon-sm" data-feather="headphones"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-size-15"><a href="#" class="text-dark">Boot
                                            Headphones 10X</a></h5>
                                    <p class="text-muted mb-0"><i
                                            class="icon-xxs icon text-warning icon-fill-warning mr-2"
                                            data-feather="star"></i>4.9</p>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4">
                                <div class="col-7">
                                    <h6 class="mb-1 font-size-15">80k <span
                                            class="text-muted font-size-13 ml-1">Product</span></h6>
                                    <a href="#" class="h6 font-weight-normal text-muted">$36.00 - $75.00</a>
                                </div>
                                <!-- end col-->
                                <div class="col-5">
                                    <div>
                                        <div class="apex-charts" id="sparkline-chart-2"></div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="avatar-sm mr-3 p-1 border rounded border-soft-primary">
                                    <div class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="icon-sm" data-feather="monitor"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-size-15"><a href="#" class="text-dark">Smart Led
                                            Screen</a></h5>
                                    <p class="text-muted mb-0"><i
                                            class="icon-xxs icon text-warning icon-fill-warning mr-2"
                                            data-feather="star"></i>5.0</p>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4">
                                <div class="col-7">
                                    <h6 class="mb-1 font-size-15">90k <span
                                            class="text-muted font-size-13 ml-1">Product</span></h6>
                                    <a href="#" class="h6 font-weight-normal text-muted">$160.00 - $720.00</a>
                                </div>
                                <!-- end col-->
                                <div class="col-5">
                                    <div>
                                        <div class="apex-charts" id="sparkline-chart-3"></div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="avatar-sm mr-3 p-1 border rounded border-soft-primary">
                                    <div class="avatar-title rounded bg-soft-primary text-primary">
                                        <i class="icon-sm" data-feather="camera"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-size-15"><a href="#" class="text-dark">Canon Lbp
                                            2900b</a></h5>
                                    <p class="text-muted mb-0"><i
                                            class="icon-xxs icon text-warning icon-fill-warning mr-2"
                                            data-feather="star"></i>4.8</p>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4">
                                <div class="col-7">
                                    <h6 class="mb-1 font-size-15">120k <span
                                            class="text-muted font-size-13 ml-1">Product</span></h6>
                                    <a href="#" class="h6 font-weight-normal text-muted">$500.00 - $1200.00</a>
                                </div>
                                <!-- end col-->
                                <div class="col-5">
                                    <div>
                                        <div class="apex-charts" id="sparkline-chart-4"></div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                    </div>
                </div>
                <!-- end col-->
            </div>
            <!-- end row-->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn btn-light" href="#" id="dropdownMenuButton5"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="font-weight-semibold">Sort By:</span> <span
                                            class="text-muted">Yearly<i class="mdi mdi-chevron-down ml-1"></i></span>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                        <a class="dropdown-item" href="#">Weekly</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Statistics</h4>

                            <ul class="nav nav-pills tabs-custom-justify mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-impresstions-tab" data-toggle="pill"
                                        href="#pills-impresstions" role="tab" aria-controls="pills-impresstions"
                                        aria-selected="true">Impresstions</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-click-tab" data-toggle="pill" href="#pills-click"
                                        role="tab" aria-controls="pills-click" aria-selected="false">Click</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-sale-tab" data-toggle="pill" href="#pills-sale"
                                        role="tab" aria-controls="pills-sale" aria-selected="false">Sale</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-comissions-tab" data-toggle="pill"
                                        href="#pills-comissions" role="tab" aria-controls="pills-comissions"
                                        aria-selected="false">Comissions</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-order-tab" data-toggle="pill" href="#pills-order"
                                        role="tab" aria-controls="pills-order" aria-selected="false">Order
                                        Value</a>
                                </li>
                            </ul>
                            <!-- end nav-pill-->
                            <div class="tab-content mt-4" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-impresstions" role="tabpanel"
                                    aria-labelledby="pills-impresstions-tab">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div>
                                                <div class="apex-charts" id="area-charts-1"></div>
                                            </div>
                                        </div>
                                        <!-- end col-->

                                        <div class="col-md-4">
                                            <ul class="list-unstyled mt-sm-0 mt-4">
                                                <li class="border-bottom pb-3">Date<span
                                                        class="float-right text-dark font-weight-semibold ">22/09/2020</span>
                                                </li>
                                                <li class="border-bottom py-3">Total user <span
                                                        class="float-right text-dark font-weight-semibold">220k</span>
                                                </li>
                                                <li class="border-bottom py-3">Avarage sale <span
                                                        class="float-right text-dark font-weight-semibold">120k</span>
                                                </li>
                                                <li class="border-bottom py-3">Annual income <span
                                                        class="float-right text-dark font-weight-semibold">$35,000.00</span>
                                                </li>
                                                <li class="pt-3">Orders <span
                                                        class="float-right text-dark font-weight-semibold">1250</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                                <div class="tab-pane fade" id="pills-click" role="tabpanel"
                                    aria-labelledby="pills-click-tab">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div>
                                                <div class="apex-charts" id="area-charts-2"></div>
                                            </div>
                                        </div>
                                        <!-- end col-->

                                        <div class="col-md-4">
                                            <ul class="list-unstyled mt-sm-0 mt-4">
                                                <li class="border-bottom pb-3">Date <span
                                                        class="float-right text-dark font-weight-semibold">26/10/2020</span>
                                                </li>
                                                <li class="border-bottom py-3">Total user <span
                                                        class="float-right text-dark font-weight-semibold">180k</span>
                                                </li>
                                                <li class="border-bottom py-3">Avarage sale <span
                                                        class="float-right text-dark font-weight-semibold">156k</span>
                                                </li>
                                                <li class="border-bottom py-3">Annual income <span
                                                        class="float-right text-dark font-weight-semibold">$42,600.00</span>
                                                </li>
                                                <li class="pt-3">Orders <span
                                                        class="float-right text-dark font-weight-semibold">2450</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end col-->
                                </div>
                                <div class="tab-pane fade" id="pills-sale" role="tabpanel"
                                    aria-labelledby="pills-sale-tab">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div>
                                                <div class="apex-charts" id="area-charts-3"></div>
                                            </div>
                                        </div>
                                        <!-- end col-->

                                        <div class="col-md-4">
                                            <ul class="list-unstyled mt-sm-0 mt-4">
                                                <li class="border-bottom pb-3">Date <span
                                                        class="float-right text-dark font-weight-semibold">28/10/2020</span>
                                                </li>
                                                <li class="border-bottom py-3">Total user <span
                                                        class="float-right text-dark font-weight-semibold">350k</span>
                                                </li>
                                                <li class="border-bottom py-3">Avarage sale <span
                                                        class="float-right text-dark font-weight-semibold">265k</span>
                                                </li>
                                                <li class="border-bottom py-3">Annual income <span
                                                        class="float-right text-dark font-weight-semibold">$38,580.00</span>
                                                </li>
                                                <li class="pt-3">Orders <span
                                                        class="float-right text-dark font-weight-semibold">20k</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                                <div class="tab-pane fade" id="pills-comissions" role="tabpanel"
                                    aria-labelledby="pills-comissions-tab">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div>
                                                <div class="apex-charts" id="area-charts-4"></div>
                                            </div>
                                        </div>
                                        <!-- end col-->

                                        <div class="col-md-4">
                                            <ul class="list-unstyled mt-sm-0 mt-4">
                                                <li class="border-bottom pb-3">Date <span
                                                        class="float-right text-dark font-weight-semibold">29/10/2020</span>
                                                </li>
                                                <li class="border-bottom py-3">Total user <span
                                                        class="float-right text-dark font-weight-semibold">425k</span>
                                                </li>
                                                <li class="border-bottom py-3">Avarage sale <span
                                                        class="float-right text-dark font-weight-semibold">400k</span>
                                                </li>
                                                <li class="border-bottom py-3">Annual income <span
                                                        class="float-right text-dark font-weight-semibold">$43,400.00</span>
                                                </li>
                                                <li class="pt-3">Orders <span
                                                        class="float-right text-dark font-weight-semibold">3500</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                                <div class="tab-pane fade" id="pills-order" role="tabpanel"
                                    aria-labelledby="pills-order-tab">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div>
                                                <div class="apex-charts" id="area-charts-5"></div>
                                            </div>
                                        </div>
                                        <!-- end col-->

                                        <div class="col-md-4">
                                            <ul class="list-unstyled mt-sm-0 mt-4">
                                                <li class="border-bottom pb-3">Date <span
                                                        class="float-right text-dark font-weight-semibold">30/10/2020</span>
                                                </li>
                                                <li class="border-bottom py-3">Total user <span
                                                        class="float-right text-dark font-weight-semibold">200k</span>
                                                </li>
                                                <li class="border-bottom py-3">Avarage sale <span
                                                        class="float-right text-dark font-weight-semibold">165k</span>
                                                </li>
                                                <li class="border-bottom py-3">Annual income <span
                                                        class="float-right text-dark font-weight-semibold">$26,540.00</span>
                                                </li>
                                                <li class="pt-3">Orders <span
                                                        class="float-right text-dark font-weight-semibold">1140</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="btn-link text-muted dropdown-toggle arrow-none" href="#"
                                        role="button" id="dropdownMenuLink-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-sm" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink-2">
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="refresh-cw"></i> Refresh</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="activity"></i> Action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"><i
                                                class="icon-xs icon mr-2" data-feather="trash-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Product Results</h4>

                            <div class="table-responsive">
                                <table class="table table-centered mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="py-3">
                                                <div class="media py-1 align-items-center">
                                                    <i class="bx bx-headphone text-primary h3 mb-0 mr-3"></i>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Headphone Xe</h6>
                                                        <p class="text-uppercase text-muted mb-0 font-size-11">Boot</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <h6 class="mb-1">6.5k</h6>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">Sell</p>
                                            </td>
                                            <td class="py-3">
                                                <div class="progress mb-2 mt-1" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 60%;"
                                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">60%</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3">
                                                <div class="media py-1 align-items-center">
                                                    <i class="bx bxs-watch-alt text-primary h3 mb-0 mr-3"></i>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Smart Watch S5</h6>
                                                        <p class="text-uppercase text-muted mb-0 font-size-11">Titan
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <h6 class="mb-1">5.0k</h6>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">Sell</p>
                                            </td>
                                            <td class="py-3">
                                                <div class="progress mb-2 mt-1" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 40%;"
                                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">40%</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3">
                                                <div class="media py-1 align-items-center">
                                                    <i class="bx bxs-t-shirt text-primary h3 mb-0 mr-3"></i>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Man & Woman T-shirt</h6>
                                                        <p class="text-uppercase text-muted mb-0 font-size-11">T-shirt
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <h6 class="mb-1">12K</h6>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">Sell</p>
                                            </td>
                                            <td class="py-3">
                                                <div class="progress mb-2 mt-1" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 80%;"
                                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">80%</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3">
                                                <div class="media py-1 align-items-center">
                                                    <i class="bx bx-desktop text-primary h3 mb-0 mr-3"></i>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Smart Led Screen</h6>
                                                        <p class="text-uppercase text-muted mb-0 font-size-11">Sony</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <h6 class="mb-1">6.2K</h6>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">Sell</p>
                                            </td>
                                            <td class="py-3">
                                                <div class="progress mb-2 mt-1" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 60%;"
                                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">60%</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3">
                                                <div class="media py-1 align-items-center">
                                                    <i class="bx bx-camera text-primary h3 mb-0 mr-3"></i>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Nicon S4 IXUS</h6>
                                                        <p class="text-uppercase text-muted mb-0 font-size-11">Canon
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <h6 class="mb-1">2.5k</h6>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">Sell</p>
                                            </td>
                                            <td class="py-3">
                                                <div class="progress mb-2 mt-1" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 45%;"
                                                        aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <p class="text-uppercase text-muted mb-0 font-size-11">45%</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- end table-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="btn-link text-muted dropdown-toggle arrow-none" href="#"
                                        role="button" id="dropdownMenuLink-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-sm" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink-2">
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="refresh-cw"></i> Refresh</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="activity"></i> Action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"><i
                                                class="icon-xs icon mr-2" data-feather="trash-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4 pb-2">Top Products</h4>

                            <div class="media align-items-center border-bottom pb-3 mb-3">
                                <img src="assets/images/product/product-x/pro-4.png" class="mr-3 avatar-sm"
                                    alt="...">
                                <div class="media-body">
                                    <h6 class="font-size-14 mb-0">Smart Mobile</h6>
                                    <ul class="list-inline text-warning mb-0">
                                        <li class="list-inline-item font-size-15 mr-0"><i class="mdi mdi-star"></i>
                                        </li>
                                        <li class="list-inline-item font-size-12 text-muted">2.5K Rattings</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-sm btn-soft-primary ml-2">View More</a>
                            </div>
                            <div class="media align-items-center border-bottom pb-3 mb-3">
                                <img src="assets/images/product/product-x/pro-3.png" class="mr-3 avatar-sm"
                                    alt="...">
                                <div class="media-body">
                                    <h6 class="font-size-14 mb-0">Man & Woman T-shirt</h6>
                                    <ul class="list-inline text-warning mb-0">
                                        <li class="list-inline-item font-size-15 mr-0"><i class="mdi mdi-star"></i>
                                        </li>
                                        <li class="list-inline-item font-size-12 text-muted">1.6K Rattings</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-sm btn-soft-primary ml-2">View More</a>
                            </div>
                            <div class="media align-items-center border-bottom pb-3 mb-3">
                                <img src="assets/images/product/product-x/pro-2.png" class="mr-3 avatar-sm"
                                    alt="...">
                                <div class="media-body">
                                    <h6 class="font-size-14 mb-0">Smart Watch C2</h6>
                                    <ul class="list-inline text-warning mb-0">
                                        <li class="list-inline-item font-size-15 mr-0"><i class="mdi mdi-star"></i>
                                        </li>
                                        <li class="list-inline-item font-size-12 text-muted">1.8K Rattings</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-sm btn-soft-primary ml-2">View More</a>
                            </div>
                            <div class="media align-items-center border-bottom pb-3 mb-4">
                                <img src="assets/images/product/product-x/pro-1.png" class="mr-3 avatar-sm"
                                    alt="...">
                                <div class="media-body">
                                    <h6 class="font-size-14 mb-0">Boot Headphones 8x</h6>
                                    <ul class="list-inline text-warning mb-0">
                                        <li class="list-inline-item font-size-15 mr-0"><i class="mdi mdi-star"></i>
                                        </li>
                                        <li class="list-inline-item font-size-12 text-muted">1.5K Rattings</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-sm btn-soft-primary ml-2">View More</a>
                            </div>
                            <div class="media align-items-center pb-3 mb-2">
                                <img src="assets/images/product/product-x/pro-3.png" class="mr-3 avatar-sm"
                                    alt="...">
                                <div class="media-body">
                                    <h6 class="font-size-14 mb-0">Man & Woman T-shirt</h6>
                                    <ul class="list-inline text-warning mb-0">
                                        <li class="list-inline-item font-size-15 mr-0"><i class="mdi mdi-star"></i>
                                        </li>
                                        <li class="list-inline-item font-size-12 text-muted">3.2K Rattings</li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-sm btn-soft-primary ml-2">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->
            </div>
            <!-- End row -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="btn-link text-muted dropdown-toggle arrow-none" href="#"
                                        role="button" id="dropdownMenuLink-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-sm" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink-2">
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="refresh-cw"></i> Refresh</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="activity"></i> Action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"><i
                                                class="icon-xs icon mr-2" data-feather="trash-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Current Month</h4>
                            <div class="row align-items-end">
                                <div class="col-lg-5">
                                    <div class="pr-lg-5">
                                        <h4 class="font-weight-bold mb-3">1800 <span
                                                class="text-muted font-size-14 font-weight-normal ml-1">New
                                                items</span></h4>
                                        <div class="progress rounded-pill">
                                            <div class="progress-bar" role="progressbar" style="width: 40%"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col-->
                                <div class="col-lg-7">
                                    <div class="row mt-lg-0 mt-4">
                                        <div class="col-md-4">
                                            <div class="media mb-sm-0 mb-4">
                                                <i class="bx bxs-circle font-size-12 text-primary mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-2">Headphones</h6>
                                                    <p class="text-muted mb-0">800 <span
                                                            class="badge badge-soft-primary ml-1">New</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-->
                                        <div class="col-md-4">
                                            <div class="media mb-sm-0 mb-4">
                                                <i class="bx bxs-circle font-size-12 text-success mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-2">Smart Watch</h6>
                                                    <p class="text-muted mb-0">625 <span
                                                            class="badge badge-soft-success ml-1">New</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-->
                                        <div class="col-md-4">
                                            <div class="media mb-sm-0 mb-4">
                                                <i class="bx bxs-circle font-size-12 text-danger mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-2">Canon camera</h6>
                                                    <p class="text-muted mb-0">1.0k <span
                                                            class="badge badge-soft-danger ml-1">New</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end roe-->
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="text-slider">
                                <ul class="list-inline mb-0 move-text">
                                    <li class="list-inline-item mr-5 pr-5">
                                        <div class="media">
                                            <i class="icon-sm sw-1_5 text-primary mr-3" data-feather="users"></i>
                                            <div class="media-body">
                                                <h6 class="my-0">Total Subscription</h6>
                                                <p class="text-muted mb-0">5680 <i class="icon-xs text-success ml-1"
                                                        data-feather="trending-up"></i></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item mr-5 pr-5">
                                        <div class="media">
                                            <i class="icon-sm sw-1_5 text-primary mr-3"
                                                data-feather="shopping-cart"></i>
                                            <div class="media-body">
                                                <h6 class="my-0">Order Status</h6>
                                                <p class="text-muted mb-0">3.5k <i class="icon-xs text-success ml-1"
                                                        data-feather="trending-up"></i></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item mr-5 pr-5">
                                        <div class="media">
                                            <i class="icon-sm sw-1_5 text-primary mr-3" data-feather="smile"></i>
                                            <div class="media-body">
                                                <h6 class="my-0">Happy Customers</h6>
                                                <p class="text-muted mb-0">25.8k</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item mr-5 pr-5">
                                        <div class="media">
                                            <i class="icon-sm sw-1_5 text-primary mr-3" data-feather="archive"></i>
                                            <div class="media-body">
                                                <h6 class="my-0">Daily Sales</h6>
                                                <p class="text-muted mb-0">80,500</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-inline-item mr-5 pr-5">
                                        <div class="media">
                                            <i class="icon-sm sw-1_5 text-primary mr-3" data-feather="twitter"></i>
                                            <div class="media-body">
                                                <h6 class="my-0">Followers</h6>
                                                <p class="text-muted mb-0">5.6M</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <i class="icon-xl sw-1 text-primary icon-dual-primary"
                                                data-feather="shopping-bag"></i>
                                            <h6 class="text-muted font-size-15 mt-4 pt-2">Awaiting Delivery</h6>
                                            <h4 class="font-size-18">160k Order</h4>
                                        </div>
                                        <!-- end col-->
                                        <div class="col-6">
                                            <img src="assets/images/delivery-1.png" alt=""
                                                class="img-fluid mx-auto">
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <i class="icon-xl sw-1 text-primary icon-dual-primary"
                                                data-feather="package"></i>
                                            <h6 class="text-muted font-size-15 mt-4 pt-2">Successful Delivery</h6>
                                            <h4 class="font-size-18">200k</h4>
                                        </div>
                                        <!-- end col-->
                                        <div class="col-6">
                                            <img src="assets/images/delivery-2.png" alt=""
                                                class="img-fluid mx-auto">
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="dropdown-toggle btn btn-light" href="#" id="dropdownMenuButton5"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">Monthly<i
                                                class="mdi mdi-chevron-down ml-1"></i></span>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                        <a class="dropdown-item" href="#">Weekly</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-5">Sales Top Product</h4>

                            <div class="card border rounded shadow-none mb-1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="media mb-sm-0 my-2">
                                                <i class="mdi mdi-radiobox-marked text-danger h6 mb-0 mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-1"> Headphone</h6>
                                                    <p class="text-muted font-size-13 mb-0">Total sale 20k</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="media mb-sm-0 my-2">
                                                <i class="mdi mdi-radiobox-marked text-primary h6 mb-0 mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-1"> Mobiles</h6>
                                                    <p class="text-muted font-size-13 mb-0">Total sale 5.6k</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="media mb-sm-0 my-2">
                                                <i class="mdi mdi-radiobox-marked text-warning h6 mb-0 mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-1"> Accessories</h6>
                                                    <p class="text-muted font-size-13 mb-0">Total sale 12.8k</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="media mb-sm-0 my-2">
                                                <i class="mdi mdi-radiobox-marked text-light h6 mb-0 mr-2"></i>
                                                <div class="media-body">
                                                    <h6 class="mb-1"> LED TV</h6>
                                                    <p class="text-muted font-size-13 mb-0">Total sale 8.6k</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="apex-charts" id="mixed-charts-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->
            </div>
            <!-- end row-->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 col-9">
                                    <h5 class="mb-1 font-size-18 font-weight-semibold">12.6M</h5>
                                    <p class="text-muted font-size-13">Total Visitors</p>
                                    <span class="bg-light text-muted font-size-14 py-1 px-2"><i class="icon-xs mr-1"
                                            data-feather="trending-up"></i> 6.58%</span>
                                </div>
                                <!-- end col-->
                                <div class="col-md-4 col-3">
                                    <div class="avatar rounded float-right p-1 border border-soft-primary">
                                        <div class="avatar-title bg-soft-primary text-primary h3">
                                            <i class="mdi mdi-account-outline"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                        <div>
                            <div class="apex-charts" id="sparkline-chart-5"></div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 col-9">
                                    <h5 class="mb-1 font-size-18 font-weight-semibold">56.20K</h5>
                                    <p class="text-muted font-size-13">Total Orders</p>
                                    <span class="bg-light text-muted font-size-14 py-1 px-2"><i class="icon-xs mr-1"
                                            data-feather="trending-up"></i> 30.50%</span>
                                </div>
                                <!-- end col-->
                                <div class="col-md-4 col-3">
                                    <div class="avatar rounded float-right p-1 border border-soft-info">
                                        <div class="avatar-title bg-soft-info text-info h3">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                        <div>
                            <div class="apex-charts" id="sparkline-chart-6"></div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 col-9">
                                    <h5 class="mb-1 font-size-18 font-weight-semibold">35.2M</h5>
                                    <p class="text-muted font-size-13">Number of Sale</p>
                                    <span class="bg-light text-muted font-size-14 py-1 px-2"><i class="icon-xs mr-1"
                                            data-feather="trending-up"></i> 8.20%</span>
                                </div>
                                <!-- end col-->
                                <div class="col-md-4 col-3">
                                    <div class="avatar rounded float-right p-1 border border-soft-danger">
                                        <div class="avatar-title bg-soft-danger text-danger h3">
                                            <i class="mdi mdi-shopping-outline"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                        <div>
                            <div class="apex-charts" id="sparkline-chart-7"></div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 col-9">
                                    <h5 class="mb-1 font-size-18 font-weight-semibold">20.0M</h5>
                                    <p class="text-muted font-size-13">New Products</p>
                                    <span class="bg-light text-muted font-size-14 py-1 px-2"><i class="icon-xs mr-1"
                                            data-feather="trending-up"></i> 10.26%</span>
                                </div>
                                <!-- end col-->
                                <div class="col-md-4 col-3">
                                    <div class="avatar rounded float-right p-1 border border-soft-success">
                                        <div class="avatar-title bg-soft-success text-success h3">
                                            <i class="mdi mdi-package-variant-closed"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                        <div>
                            <div class="apex-charts" id="sparkline-chart-8"></div>
                        </div>
                    </div>
                </div>
                <!-- end col-->
            </div>
            <!-- end row-->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card tasks-box">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="btn-link text-muted dropdown-toggle arrow-none" href="#"
                                        role="button" id="dropdownMenuLink-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-sm" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink-2">
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="refresh-cw"></i> Refresh</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="activity"></i> Action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"><i
                                                class="icon-xs icon mr-2" data-feather="trash-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Tasks</h4>
                            <h6 class="mb-4 font-weight-medium">Today Tasks</h6>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="mr-3 dashboard_name">Admin Dashboard</span> <span
                                        class="badge rounded-sm badge-outline-secondary">30 Min Left</span></label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck2" checked>
                                <label class="custom-control-label" for="customCheck2">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">Creative Landing Page</span>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                <label class="custom-control-label" for="customCheck3">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">Business Lanidng Page</span> <span
                                        class="badge rounded-sm badge-outline-secondary ml-3">3 Hours
                                        Left</span></label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck4" checked>
                                <label class="custom-control-label" for="customCheck4">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">Skote Admin Dashboard</span></label>
                            </div>
                            <h6 class="my-4 font-weight-medium">Tomorrow Tasks</h6>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck5">
                                <label class="custom-control-label" for="customCheck5">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">Sketch Landing page Design</span></label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck6">
                                <label class="custom-control-label" for="customCheck6">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">Sketch New Ui-Kit</span></label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck7">
                                <label class="custom-control-label" for="customCheck7">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">New Admin Dashboard</span></label>
                            </div>
                            <h6 class="my-4 font-weight-medium">Next Week Tasks</h6>
                            <div class="custom-control custom-checkbox mb-3">
                                <span class="float-right edit-icon">
                                    <a href="javascript:void(0)" class="text-muted"><i class="icon-sm"
                                            data-feather="edit-2"></i></a>
                                </span>
                                <input type="checkbox" class="custom-control-input" id="customCheck8">
                                <label class="custom-control-label" for="customCheck8">
                                    <input type="text" class="form-control h-auto py-0 dashboard_new_name"
                                        name="dashboard_new_name" style="display: none" />
                                    <span class="dashboard_name">New Admin Dashboard</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-4">
                    <div class="card">
                        <div class="chat-conversation">
                            <div class="border-bottom p-3 mb-1">
                                <div class="media align-items-center">
                                    <img src="assets/images/users/avatar-1.jpg" class="avatar-sm rounded-circle mr-3"
                                        alt="">
                                    <div class="media-body">
                                        <h5 class="user-name mb-1 font-size-15">Dianna Miller</h5>
                                        <p class="text-muted font-size-13 mb-0"><i
                                                class="mdi mdi-circle text-success mr-1"></i>Online</p>
                                    </div>
                                    <a href="#" class="text-secondary mr-3"><i class="icon icon-sm"
                                            data-feather="phone"></i></a>
                                    <a href="#" class="text-secondary mr-3"><i class="icon icon-sm"
                                            data-feather="video"></i></a>
                                    <div class="dropdown">
                                        <a class="btn-link text-muted dropdown-toggle arrow-none" href="#"
                                            role="button" id="dropdownMenuLink-7" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="icon icon-sm" data-feather="more-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right"
                                            aria-labelledby="dropdownMenuLink-7">
                                            <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                    data-feather="user"></i> View Profile</a>
                                            <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                    data-feather="search"></i> Search</a>
                                            <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                    data-feather="menu"></i> More</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#"><i
                                                    class="icon-xs icon mr-2" data-feather="x-circle"></i> Block</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div data-simplebar style="max-height: 338px;">
                                    <ul class="conversation-list p-0">
                                        <li class="clearfix">
                                            <div class="media">
                                                <img src="assets/images/users/avatar-1.jpg"
                                                    class="avatar-xs rounded-circle align-self-end" alt="...">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <p>Hello! How r u...?</p>
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:01AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                        <a href="#" class="chat-share-icon"><i
                                                                class="mdi mdi-reply font-size-20 ml-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="clearfix odd">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <p>I m always good. & What r u doing now..?</p>
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:02AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="media">
                                                <img src="assets/images/users/avatar-1.jpg"
                                                    class="avatar-xs rounded-circle align-self-end" alt="...">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <p>Working now! What about our next meeting?</p>
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:02AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                        <a href="#" class="chat-share-icon"><i
                                                                class="mdi mdi-reply font-size-20 ml-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="clearfix odd">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <p>Yeah everything is fine..😍</p>
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:03AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="media">
                                                <img src="assets/images/users/avatar-1.jpg"
                                                    class="avatar-xs rounded-circle align-self-end" alt="...">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <p>Please sent me metting location img.</p>
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:04AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                        <a href="#" class="chat-share-icon"><i
                                                                class="mdi mdi-reply font-size-20 ml-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="clearfix odd">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <p>Ok. Wait.!</p>
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:04AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="clearfix odd">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <img src="assets/images/small/img-1.jpg" alt=""
                                                                class="img-fluid">
                                                            <img src="assets/images/small/img-2.jpg" alt=""
                                                                class="img-fluid">
                                                        </div>
                                                        <div class="msg-seen">
                                                            <p class="text-muted font-size-12 mb-0 t mt-1"><i
                                                                    class="mdi mdi-clock-outline"></i> 09:06AM <i
                                                                    class="mdi mdi-check-all text-success ml-1"></i>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="row align-items-center pt-2 chat-input-box">
                                    <div class="col-sm-9 col-8 chat-inputbar">
                                        <input type="text" class="form-control chat-input"
                                            placeholder="Type Message...">
                                        <ul class="list-inline mb-0 chat-icon">
                                            <li class="list-inline-item mr-2"><a href="#"
                                                    class="text-secondary" data-toggle="tooltip"
                                                    data-placement="top" title="Emoji"><i class="icon-xs"
                                                        data-feather="smile"></i></a></li>
                                            <li class="list-inline-item mr-2"><a href="#"
                                                    class="text-secondary" data-toggle="tooltip"
                                                    data-placement="top" title="File"><i class="icon-xs"
                                                        data-feather="paperclip"></i></a></li>
                                            <li class="list-inline-item mr-2"><a href="#"
                                                    class="text-secondary" data-toggle="tooltip"
                                                    data-placement="top" title="Camera"><i class="icon-xs"
                                                        data-feather="camera"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-3 col-4">
                                        <button type="submit" class="btn btn-block btn-primary"><i
                                                class="uil uil-message"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-->

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right">
                                <div class="dropdown">
                                    <a class="btn-link text-muted dropdown-toggle arrow-none" href="#"
                                        role="button" id="dropdownMenuLink-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-sm" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="dropdownMenuLink-2">
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="refresh-cw"></i> Refresh</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#"><i class="icon-xs icon mr-2"
                                                data-feather="activity"></i> Action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#"><i
                                                class="icon-xs icon mr-2" data-feather="trash-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Recent Activity</h4>
                            <ol class="activity-feed mb-0 pl-2" data-simplebar style="max-height: 420px;">
                                <li class="feed-item">
                                    <p
                                        class="text-muted mb-1 font-size-13 py-1 px-2 bg-light border rounded d-inline-block">
                                        Today : 12:20 pm</p>
                                    <p class="mt-1 mb-0">Andrei Coman magna sed porta finibus, risus posted a new
                                        article: <span class="text-primary">Forget UX Rowland</span></p>
                                </li>
                                <li class="feed-item">
                                    <p
                                        class="text-muted mb-1 font-size-13 py-1 px-2 bg-light border rounded d-inline-block">
                                        22 Jul, 2020</p>
                                    <p class="mt-0 mb-0">Andrei Coman posted a new article: <span
                                            class="text-primary">Designer Alex</span></p>
                                </li>
                                <li class="feed-item">
                                    <p
                                        class="text-muted mb-1 font-size-13 py-1 px-2 bg-light border rounded d-inline-block">
                                        18 Jul, 2020</p>
                                    <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace Commented
                                        <span class="text-primary"> Developer Moreno</span></p>
                                </li>
                                <li class="feed-item">
                                    <p
                                        class="text-muted mb-1 font-size-13 py-1 px-2 bg-light border rounded d-inline-block">
                                        10 Jul, 2020</p>
                                    <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                                            class="text-primary">UX Murphy</span></p>
                                </li>
                                <li class="feed-item">
                                    <p
                                        class="text-muted mb-1 font-size-13 py-1 px-2 bg-light border rounded d-inline-block">
                                        23 Jun, 2020</p>
                                    <p class="mt-0 mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace Commented
                                        <span class="text-primary"> Developer Moreno</span></p>
                                </li>
                                <li class="feed-item pb-1">
                                    <p
                                        class="text-muted mb-1 font-size-13 py-1 px-2 bg-light border rounded d-inline-block">
                                        20 Jun, 2020</p>
                                    <p class="mt-0 mb-0">Zack Wetass, Chris combined Commented <span
                                            class="text-primary">UX Murphy</span></p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end col-->
            </div>
            <!-- end row-->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @yield('adminside-script')
@include('admin.layout.footer')
