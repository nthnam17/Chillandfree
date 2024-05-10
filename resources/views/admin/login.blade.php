@inject('setting', 'App\CustomClasses\Setting')
@extends('admin.layouts.auth')
@section('content')

    <link rel="stylesheet" type="text/css" href="frontend/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="admin/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="admin/login/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="/admin/css/simple-notify.min.css">
{{--    <link rel="stylesheet" type="text/css" href="admin/css/ipad-landscape.css">--}}
    <link rel="stylesheet" type="text/css" href="admin/login/css/main.css">
    <link rel="stylesheet" type="text/css" href="frontend/css/all.min.css">


    <div class="container">
        <section id="formHolder">

            <div class="row">

                <!-- Brand Box -->
                <div class="col-sm-6 brand">
                    <div class="heading">
                        <h2>CMS</h2>
                        <p>CAF</p>
                    </div>
                </div>
                <!-- Form Box -->
                <div class="col-sm-6 form">
                    <!-- Login Form -->
                    <div class="login form-peice ">
                        <form class="login-form" action="#" method="post" autocomplete="new-password">
                            <div class="form-group">
                                <label for="loginemail">Tài khoản</label>
                                <input type="email" name="username" id="loginemail" autocomplete="off" required>
                            </div>

                            <div class="form-group" style="position: relative">
                                 <span class="btn-show-pass">
                                        <i class="zmdi zmdi-eye"></i>
                                    </span>
                                <label for="loginPassword">Mật khẩu</label>
                                <input type="password" name="password"  id="loginPassword" autocomplete="new-password" required>
                            </div>

                            <div class="CTA">
                                <input type="submit" class="submit-btn" style="cursor: pointer" value="Đăng nhập">
                            </div>
                        </form>
                    </div><!-- End Login Form -->
                </div>
            </div>
        </section>
    </div>

@endsection

@push('custom-scripts')
    <script src="admin/login/js/main.js"></script>
    <script>
        var showPass = 0;
        $('.btn-show-pass').on('click', function () {
            if (showPass == 0) {
                $(this).parent().find('input').attr('type', 'text');
                $(this).find('i').removeClass('zmdi-eye');
                $(this).find('i').addClass('zmdi-eye-off');
                showPass = 1;
            } else {
                $(this).parent().find('input').attr('type', 'password');
                $(this).find('i').addClass('zmdi-eye');
                $(this).find('i').removeClass('zmdi-eye-off');
                showPass = 0;
            }

        });
        var urlLogin = '/login';

        $(".submit-btn").click(function (e) {
            e.preventDefault();
            login();
        });

        $(".submit-btn").on('keypress', function (e) {
            if (e.key === "Enter" || e.keyCode === " ") {
                e.preventDefault();
                login();
            }
        });

        function login() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            var username = $("input[name='username']").val();
            var password = $("input[name='password']").val();
            let remember = $("input[name='remmember']").is(':checked') ? '1' : '0';
            console.log('234234234')
            if (!username || !password) {
                // showAlert('Chưa nhập tên đăng nhập hoặc mật khẩu', "danger", 5000);
                notifyError('Chưa nhập tên đăng nhập hoặc mật khẩu');
                return;
            }

            var data = {
                "_token": _token,
                "username": username,
                "password": password,
                "remember": remember
            };
            //query
            let result = ajaxQuery(urlLogin, data, 'POST');
            if (!result) {
                //noti
                notifyError("Có lỗi vui lòng thử lại");
            } else {
                //noti
                // showAlert(result.message, result.notify, 5000);

                if (result.code == 200) window.location.href = "/admin/dashboard";
                if (result.code == 0) notifyError(result.message);
            }
        }
    </script>

    <script>
        var urlRegister = '/register';

        $(".btn_register").click(function (e) {
            e.preventDefault();
            register();
        });

        $(".btn_register").on('keypress', function (e) {
            if (e.key === "Enter" || e.keyCode === " ") {
                e.preventDefault();
                register();
            }
        });

        function register() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            var username = $("input[name='username1']").val();
            var name = $("input[name='name1']").val();
            var email = $("input[name='email1']").val();
            var phone = $("input[name='phone1']").val();
            var password = $("input[name='password1']").val();
            var password_confirm = $("input[name='password_confirm']").val();
            var data = {
                "_token": _token,
                "username": username,
                "name": name,
                "email": email,
                "phone": phone,
                "password": password,
                "password_confirm": password_confirm,
                "status": 1,
                "created_by": "",
                "updated_by": "",
            };
            console.log(data,'data');
            //query
            let result = ajaxQuery(urlRegister, data, 'POST');
            if(result == undefined || result.length==0) {
                //noti
                showAlert("@Lang('global.msg_error')", "danger", 5000);
            }
            else if(result.code == 200) {
                //noti
                showAlert(result.message, result.notify, 5000);

                if(result.code==200) window.location.href = "/login";

            } else if(result.code == 401) {
                //noti
                showAlert(result.message, result.notify, 5000);
            } else {
                Object.keys(result.errors).forEach(function(key) {
                    //noti
                    showAlert(result.errors[key], result.notify, 5000);
                });
            }
        };
    </script>

    <script>
        /*global $, document, window, setTimeout, navigator, console, location*/
        $(document).ready(function () {

            // Detect browser for css purpose
            if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                $('.form form label').addClass('fontSwitch');
            }

            // Label effect
            $('input').focus(function () {

                $(this).siblings('label').addClass('active');
            });



            // form switch
            $('a.switch').click(function (e) {
                $(this).toggleClass('active');
                e.preventDefault();

                if ($('a.switch').hasClass('active')) {
                    $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');
                } else {
                    $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
                }
            });
        });

    </script>
    <script src="frontend/js/all.min.js"></script>
@endpush
