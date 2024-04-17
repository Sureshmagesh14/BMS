<footer class="bg-white">
    <div class="container">
        <div class="container py-3">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-end">
                        <p class="mb-0 pb-0">@
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ Config::get('constants.app_title') }}
                        </p>
                        <a href="{{ route('terms') }}" class="nav-link px-5 mb-0 pb-0">Terms & Conditions</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="social-icons text-end">
                        <a href="https://www.instagram.com/thebrandsurgeon/?igshid=YmMyMTA2M2Y%3D"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="https://www.facebook.com/thebrandsurgeonsa"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://www.linkedin.com/company/the-brand-surgeon-company/"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('assets/js/admin/jquery.validate.js') }}"></script>
</html>
