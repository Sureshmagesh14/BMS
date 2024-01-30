@include('login_register.layout.header')
@yield('favicon')
@yield('login-css')
<div class="row align-items-center justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">
            
            <div class="card-body p-4"> 
                <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p class="text-muted">Sign in to continue to {{Config::get('constants.app_title')}}.</p>
                </div>
                <div class="p-2 mt-4">
                    <form method="POST" action="{{ route('login.custom') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <!-- <div class="float-right">
                                <a href="auth-recoverpw.html" class="text-muted">Forgot password?</a>
                            </div> -->
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Enter password">
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="auth-remember-check">
                            <label class="custom-control-label" for="auth-remember-check">Remember me</label>
                        </div>
                        
                        <div class="mt-3 text-right">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit"><i class="icon-xs icon mr-1" data-feather="log-in"></i> Log In</button>
                        </div>

                        <!-- <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="font-weight-medium text-primary"> Signup now </a> </p>
                        </div> -->

                        {{-- @yield('social') --}}
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center">
            <p>© {{ date('Y') }} {{Config::get('constants.app_title')}}.</p>
        </div>
    </div>
</div>
@yield('login-script')
@include('login_register.layout.footer')