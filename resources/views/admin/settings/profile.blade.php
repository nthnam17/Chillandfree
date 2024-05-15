<?php

use App\Models\Role;

?>
@extends('admin.layouts.index')
@section('pageTitle', 'Cài đặt chung')
@section('content')
    <style>
        .btn-show-pass {
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>
    <div class="container-fluid pd-form">
        <div class="animated fadeIn">
            <div class="card">
                <div class="table-wrapper">
                    <div class="portlet light bordered portlet-no-padding">
                        <div class="portlet-body">
                            <div class="table-responsive table-has-actions table-has-filter ">
                                <div id="table-users_wrapper"
                                     class="dataTables_wrapper pd-fluid dt-bootstrap4 no-footer">
                                    <div class="user-profile row">
                                        <div class="col-md-3 col-sm-5 crop-avatar">
                                            <div class="profile-userpic mt-card-item">
                                                <div class="avatar-view mt-card-avatar mt-overlay-1"
                                                     data-original-title="" title="">
                                                     <div class="widget-body">
                                                        <div class="fileupload-preview fileupload-exists">
                                                            <div class="preview-image-wrapper-white">
                                                                <div class="field-news-image">
                                                                    <label class="btn btnChoose" onclick="setImage('image');">
                                                                        <i class="fas fa-image" aria-hidden="true"></i>
                                                                    </label>
                                                                </div>
                                                                    @php 
                                                                        if(isset($data)) {
                                                                            $img = $data['image'];
                                                                        }else {
                                                                            $img = '/admin/image/boy.png';
                                                                        }
                                                                    @endphp
                                                                   
                                                                    <img src="{{$img}}" width="150" alt="" id="image"
                                                                    name="image"
                                                                    group="data">
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-card-content">
                                                    <h3 class="mt-card-name">{!! isset($data) ? $data['name'] : null !!}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-7">
                                            <div class="profile-content">
                                                <div class="tabbable-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item">
                                                            <a href="#tab_1_1" class="nav-link active profile-per"
                                                               data-toggle="tab" aria-expanded="true">Thông tin người
                                                                dùng</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            <div id="profile-form" class="row">
                                                                <input type="hidden" name="_token"
                                                                       value="{{csrf_token()}}">
                                                                <input type="hidden" name="txtId"
                                                                       value="{!! isset($data) ? $data['id'] : null !!}">
                                                                <div class="form-group col-md-6">
                                                                    <label for="first_name"
                                                                           class="control-label required">Tên người
                                                                        dùng</label>
                                                                    <input class="form-control form-input" data-counter="30" data-field="name"
                                                                           name="name" type="text" group="data" id="namne"
                                                                           value="{!! isset($data) ? $data['name'] : null !!}">
                                                                    <div class="err-input error-message" data-field="name"></div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="first_name"
                                                                           class="control-label required">Tài khoản đăng
                                                                        nhập</label>
                                                                    <input class="form-control" data-counter="30"
                                                                           name="username" type="text" id="username"
                                                                           readonly
                                                                           value="{!! isset($data) ? $data['username'] : null !!}">

                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="email" class="control-label required">Email</label>
                                                                    <input class="form-control form-input " data-field="email" onkeydown="validatePassword(event)" lang="en"
                                                                           placeholder="Ex: example@gmail.com"
                                                                           data-counter="60" name="email" type="text"
                                                                           id="email"
                                                                           value="{!! isset($data) ? $data['email'] : null !!}">
                                                                    <div class="err-input error-message" data-field="email"></div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="email" class="control-label required">Số diện thoại</label>
                                                                    <input class="form-control form-input " data-field="email" lang="en"
                                                                           placeholder="Ex: 0333279xxx"
                                                                           data-counter="60" name="phone" type="text"
                                                                           id="phone"
                                                                           value="{!! isset($data) ? $data['phone'] : null !!}">
                                                                    {{-- <div class="err-input error-message" data-field="email"></div> --}}
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <div class="form-group col-12">
                                                                    <div class="form-actions">
                                                                        <div class="btn-set d-flex">
                                                                            <button type="submit" name="submit"
                                                                                    value="submit"
                                                                                    class="btn btn-primary save-data d-flex align-items-center">
                                                                                <i class="mdi mdi-content-save mr-2"></i> <span>Cập nhật</span>
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="btn btn-primary btn-icon-text ml-2 d-flex align-items-center"
                                                                                    group="data" convertToAttr="data-id"
                                                                                    data-toggle="modal"
                                                                                    data-target="#popup-change-password">
                                                                                <i class="mdi mdi-lock mr-2"></i>
                                                                                Đổi mật khẩu
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="popup-change-password" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 500px; ">
            <div class="modal-content">
                <div class="modal-header bg-modal my-modal">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>Cập nhật mật khẩu</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-body">
                        <input group="data" type="hidden" name="id">
                        <div class="form-group col-md-12">
                            <label for="password" class="control-label required">Mật khẩu hiện tại<span>*</span></label>
                            <div class="position-relative">
                                <input class="form-control form-input" data-counter="60" data-field="current_password"
                                       name="current_password" type="password" onkeydown="validatePassword(event)"
                                       id="password"> <span class="btn-show-pass">
                                <i class="mdi mdi-eye"></i>
                            </span>
                            </div>
                            <div class="err-input error-message" data-field="current_password"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password" class="control-label required">Mật khẩu
                                mới <span>*</span></label>
                            <div class="position-relative">
                                 <span class="btn-show-pass">
                                <i class="mdi mdi-eye"></i>
                            </span>
                                <input class="form-control form-input" data-counter="60" data-field="new_password"
                                       onkeydown="validatePassword(event)"
                                       name="new_password" type="password"
                                       id="password">
                            </div>
                            <div class="err-input error-message" data-field="new_password"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password_confirmation"
                                   class="control-label required">Nhập lại mật khẩu
                                mới<span>*</span></label>
                            <div class="position-relative">
                                   <span class="btn-show-pass">
                                <i class="mdi mdi-eye"></i>
                            </span>
                                <input class="form-control form-input" data-counter="60"
                                       data-field="confirm_new_password" onkeydown="validatePassword(event)"
                                       name="confirm_new_password" type="password"
                                       id="password_confirmation">
                            </div>
                            <div class="err-input error-message" data-field="confirm_new_password"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success active btn-custom" id="btnUpdatePassword">
                        Cập nhật
                    </button>
                    <button type="button" class="btn btn-danger btn-canel active btn-custom btn-cancel"
                            data-dismiss="modal">
                        Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .mt-overlay-1 {
            cursor: default;
            float: left;
            height: 100%;
            overflow: hidden;
            position: relative;
            text-align: center;
            width: 100%;
            margin-bottom: 15px;
        }

        .mt-card-content {
            text-align: center;
        }

        .main
        .table-wrapper {
            padding-top: 30px;
        }

        .profile-per {
            border-style: none !important;
            border-radius: 0px !important;
            border-top: 3px solid rgb(221, 75, 57) !important;
            color: rgb(51, 51, 51) !important;
            font-weight: 600;
            padding: 11px 14px 12px;
        }

        .pd-form {
            padding: 30px !important;
        }

        .pd-fluid {
            width: 100%;
            margin: 0 auto;
            padding: 30px;
        }
    </style>
    @push('custom-scripts')
        <script>
            var showPass = 0;
            $('.btn-show-pass').on('click', function () {
                if (showPass == 0) {
                    $(this).parent().find('input').attr('type', 'text');
                    $(this).find('i').removeClass('mdi-eye');
                    $(this).find('i').addClass('mdi-eye-off');
                    showPass = 1;
                } else {
                    $(this).parent().find('input').attr('type', 'password');
                    $(this).find('i').addClass('mdi-eye');
                    $(this).find('i').removeClass('mdi-eye-off');
                    showPass = 0;
                }

            });


            const urlEdit = '/admin/settings/editProfile';
            const urlEditPassword = '/admin/settings/editPassword';

            //save data
            $(".save-data").click(function (e) {
                e.preventDefault();

                let _token = $('meta[name="csrf-token"]').attr('content');
                let txtId = $("input[name='txtId']").val();
                let txtName = $("input[name='name']").val();
                let txtEmail = $("input[name='email']").val();
                let txtPhone = $("input[name='phone']").val();
                let txtImg = $("img[name='image']").attr('src');

                let data = {
                    "_token": _token,
                    "id": txtId,
                    "name": txtName,
                    "image": txtImg,
                    "email": txtEmail,
                    "phone": txtPhone,
                };


                let result = ajaxQuery(urlEdit, data, 'POST');
                if (result.code == 200 || result.code == 401) {
                    swalSuccess(result.message);
                    loadDataTable();
                    $("[data-dismiss=modal]").trigger({type: "click"});
                    $("[data-field]").val(null);
                    $("[data-field]").removeClass('invalid');
                    $(".err-input.error-message").empty();
                    //close popup
                } else if (result.code == 0) {
                    validateUpdatePopup(result.errors)
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        showAlert(result.errors[key], result.notify, 5000);
                    });
                }
            });

            $("#btnUpdatePassword").click(function (e) {
                e.preventDefault();

                let _token = $('meta[name="csrf-token"]').attr('content');
                let txtId = $("input[name='txtId']").val();
                let currentPassword = $("input[name='current_password']").val();
                let newPassword = $("input[name='new_password']").val();
                let confirmNewPassword = $("input[name='confirm_new_password']").val();

                let data = {
                    "_token": _token,
                    "id": txtId,
                    "current_password": currentPassword,
                    "new_password": newPassword,
                    "confirm_new_password": confirmNewPassword
                };

                let result = ajaxQuery(urlEditPassword, data, 'POST');

                if (result.code == 200 || result.code == 401) {
                    swalSuccess(result.message);
                    $("[data-dismiss=modal]").trigger({type: "click"});
                    $("#popup-change-password [data-field]").val(null);
                    $("#popup-change-password [data-field]").removeClass('invalid');
                    $(".err-input.error-message").empty();
                    //close popup
                } else if (result.code == 0) {
                    validateUpdatePopup(result.errors)
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        showAlert(result.errors[key], result.notify, 5000);
                    });
                }
            });

            $(".modal-header .close").on("click", function () {
                showErrorMessage("name", "");
                $(".error-message [data-field]").val(null);
                $(".error-message [data-field]").val(null).trigger("change");
                $(".error-message [data-field]").removeClass('invalid');
                $("input[type='password']").val(null);
                $(".position-relative input[type='text']").val(null);
                $(".err-input.error-message").empty();
                $('.show-invalid').remove();
                $('html').css('overflow-y', 'inherit');
            });

            $(".btn-cancel").on("click", function () {
                showErrorMessage("name", "");
                $(".error-message [data-field]").val(null);
                $(".error-message [data-field]").val(null).trigger("change");
                $(".error-message [data-field]").removeClass('invalid');
                $("input[type='password']").val(null);
                $(".position-relative input[type='text']").val(null);
                $(".err-input.error-message").empty();
                $('.show-invalid').remove();
                $('html').css('overflow-y', 'inherit');
            });
        </script>

        <script>
            function validatePassword(event) {
                const passwordInput = document.getElementById("password");
                const passwordError = document.getElementById("passwordError");

                if (event.keyCode === 32) {
                    event.preventDefault();
                    passwordError.style.display = "inline";
                } else {
                    passwordError.style.display = "none";
                }
            }
        </script>

        

    @endpush
@endsection
