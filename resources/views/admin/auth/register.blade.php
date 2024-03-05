@include('login_register.layout.header')
@yield('favicon')
@yield('login-css')
<div class="row align-items-center justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">
            
            <div class="card-body p-4"> 
                <div class="text-center mt-2">
                    <h5 class="text-primary">Register Account</h5>
                    <p class="text-muted">Sign up to continue to Brand Surgen.</p>
                </div>
                <div class="p-2 mt-4">
                    <form action="{{ route('register.custom') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Enter password">
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="auth-remember-check">
                            <label class="custom-control-label" for="auth-remember-check">I accept Terms and Conditions</label>
                        </div>
                        
                        <div class="mt-3 text-right">
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit"><i class="icon-xs icon mr-1" data-feather="log-in"></i> Log In</button>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="{{ route('login') }}" class="font-weight-medium text-primary"> Register </a> </p>
                        </div>

                        {{-- @yield('social') --}}
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center">
            <p>© 2020 Drezon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
        </div>
    </div>
</div>
@yield('login-script')
@include('login_register.layout.footer')