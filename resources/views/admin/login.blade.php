{{-- @inject('setting', 'App\CustomClasses\Setting') --}}
@extends('admin.layouts.auth')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>CMS VICOPRO</h1>
                        <form action="" method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="cil-user"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="text" placeholder="Tài khoản" name="username">
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="cil-lock-locked"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="password" placeholder="Mật khẩu" name="password">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4 submit-btn" type="button">Đăng nhập</button>
                                </div>
                                <div class="col-6 text-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            {{-- <img src="{{ \App\Helpers\Thumbnail::thumbnailImg($setting->get('logo_login'), 300, 80) }}"/> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        console.log('login');
        var urlLogin = '/login';

        $(".submit-btn").click(function (e) {
            e.preventDefault();
            login();
        });

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                login();
            }
        });

        function login() {
            var _token = $('meta[name="csrf-token"]').attr('content');
            var username = $("input[name='username']").val();
            var password = $("input[name='password']").val();
            let remember = $("input[name='remmember']").is(':checked') ? '1' : '0';

            if (!username || !password) {
                showAlert('Chưa nhập username hoặc password', "danger", 5000);
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
                showAlert("Có lỗi vui lòng thử lại", "danger", 5000);
            } else {
                //noti
                showAlert(result.message, result.notify, 5000);

                if (result.code == 200) window.location.href = "/admin/dashboard";
            }
        }
    </script>
@endpush
