<?php
use App\Models\Role_has_permissions;
?>
@extends('admin.layouts.index')
@section('pageTitle', 'Quản lý người dùng')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card mb-0">
                <div class="card-header">
                    <h4 class="card-title">Quản lý người dùng</h4>
                </div>
                <div class="card-body main-content-group">
                    <div class="main-search ">
                        <div class="title-searh-cus-header">
                            <p>BỘ LỌC</p>
                        </div>
                        <div class="row" id="searchForm">
                            <div class="col-xs-2 col-md-4">
                                <input class="form-control" group="data" name="username" type="text" autocomplete="off"
                                    spellcheck="false" placeholder="Tên đăng nhập">
                            </div>
                            <div class="col-xs-2 col-md-4">
                                <select class="form-control select-status" group="data" name="status">
                                    <option value="">Tất cả</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="2">Ngừng hoạt động</option>
                                </select>
                            </div>
                            <div class="col-xs-2 col-md-4">
                                <button class="btn btn-outline-primary btn-custom" id="btnSearch">
                                    <i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
                                </button>
                                <button class="btn btn-outline-success btn-custom" id="btn-reset">
                                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <div class="card-header-actions">
                            @if (Role_has_permissions::hasPermissionByName('Thêm người dùng'))
                            <button class="btn btn-outline-primary btn-custom add-modal" data-toggle="modal"
                                data-target="#modal-form">
                                <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                            </button>
                            @endif
                        </div>
                    </div>
                    <div id="idTable">
                        <div class="scroll-table" id="scroll-table-css">
                            <table class="table table-striped border table-hover datatable dataTable no-footer"
                                role="grid" aria-describedby="table-users_info">
                                <thead>
                                    <tr role="row" class="header-tableData">
                                        <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">
                                            STT
                                        </th>
                                        {{--                                    <th title="Tên" class=" column-key-email " style="width: 150px;">Tên --}}
                                        {{--                                    </th> --}}
                                        <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Tên đăng
                                            nhập
                                        </th>
                                        <th title="Email" class="column-key-created_at " style="width: 100px;">
                                            Nhóm quyền
                                        </th>

                                        <th title="Trạng thái" class="column-key-created_at " style="width: 100px;">
                                            Trạng
                                            thái
                                        </th>
                                        <th title="Thời gian tạo" class="column-key-status " style="width: 100px;">
                                            Thời gian
                                            tạo
                                        </th>
                                        <th title="Thời gian sửa" class="column-key-status " style="width: 100px;">
                                            Thời gian
                                            sửa
                                        </th>
                                        <th title="Thao tác" class="column-key-status " style="width: 100px;">Thao
                                            tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="align-middle odd" id="templateRow" style="display: none">
                                        <td name="stt"></td>
                                        {{--                                    <td group="data" name="name"></td> --}}
                                        <td group="data" name="username"></td>
                                        <td group="data" name="role_name"></td>
                                        <td class="text-left"><span group="data autoConvertData" name="status"></span>
                                        </td>
                                        <td class="text-left" group="data autoConvertTime" name="created_at"></td>
                                        <td class="text-left" group="data autoConvertTime" name="updated_at"></td>
                                        <td class="text-left">
                                            <a title="Danh sách"
                                                class="btn btn-sm  active disable-modal-notification list-users-modal"
                                                href="" name="id" style="color: #57B657"group="data"
                                                convertToAttr="data-id" data-toggle="modal"
                                                data-target="#modal-users-tab"><i class="fa fa-bars" aria-hidden="true"></i>
                                            </a>
                                            <a title="Reset mật khẩu" class="btn btn-sm active password-modal" href=""
                                           name="id" style="color: #57B657"
                                           group="data" convertToAttr="data-id" data-toggle="modal"
                                           data-target="#popup-password"><i class="fa fa-refresh" style="font-size: 1.2rem" aria-hidden="true"></i></a>
                                        {{-- <a title="Chỉnh sửa" class="btn btn-sm  active update-modal" href=""
                                           name="id" style="color: #39b2d5"
                                           group="data" convertToAttr="data-id" data-toggle="modal"
                                           data-target="#modal-form"><i class="mdi mdi-pencil"></i></a>
                                        <a title="Xóa" class="btn btn-sm active deleteDialog" href=""
                                           name="id" style="color: #f5302e"
                                           group="data" convertToAttr="data-id" data-toggle="modal"
                                           data-target="#popup-delete"><i class="mdi mdi-delete"></i></a> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="datatables__info_wrap">
                            <div class="dataTables_info pull-left" id="table-users_info">
                                <span class="dt-length-records"></span>
                            </div>
                            <div class="paging_simple_numbers pull-right" id="table_paginate"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.global.popupListActionUsers')

    <!-- Modal User -->
    <div id="modal-form" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 800px; ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-modal my-modal">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>Thêm mới user</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-body">
                        <input group="data" type="hidden" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label required">Tên đầy đủ <span>*</span></label>
                                    <input class="form-control" group="data" name="name" type="text"
                                        autocomplete="off" spellcheck="false" placeholder="Tên đầy đủ">
                                </div>


                                <div class="form-group">
                                    <label class="control-label">Số điện thoại</label>
                                    <input class="form-control isNumber" group="data" name="phone" type="text"
                                        autocomplete="off" spellcheck="false" placeholder="Số điện thoại">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required ">Tài khoản đăng nhập <span>*</span></label>
                                    <input class="form-control" group="data" name="username" type="text"
                                        id="dvct" autocomplete="off" spellcheck="false"
                                        placeholder="Tài khoản đăng nhập">
                                </div>
                                <div class="form-group position-relative">
                                    <label class="control-label label-password required">Mật khẩu <span>*</span></label>
                                    <input class="form-control" group="data" name="password" id="password"
                                        type="password" autocomplete="off" placeholder="Mật khẩu">
                                    <span class="btn-show-pass">
                                        <i class="mdi mdi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label required">Email <span>*</span></label>
                                    <input class="form-control" group="data" name="email"
                                        type="text"autocomplete="off" spellcheck="false" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <select class="form-control select-status" group="data" name="status">
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Ngừng hoạt động</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Quyền truy cập</label>
                                    <select class="form-control select-status" group="data" name="role_id">
                                        <?php use App\Models\Role;
                                        $data_roles = Role::allRolesActive(); ?>
                                        @foreach ($data_roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                </div>
                                <div class="form-group position-relative">
                                    <label class="control-label label-password required">Nhập lại mật khẩu
                                        <span>*</span></label>
                                    <input class="form-control" group="data" name="re_password" id="password"
                                        type="password" autocomplete="off" placeholder="Nhập lại mật khẩu">
                                    <span class="btn-show-pass">
                                        <i class="mdi mdi-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success active btn-custom" id="btnAdd">
                        Thêm mới
                    </button>
                    <button type="button" class="btn btn-danger btn-canel active btn-custom" data-dismiss="modal">
                        Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal User -->

    <!-- Model Password -->
    <div id="popup-password" class="modal fade" role="dialog">
        <div class="modal-dialog " style="width: 500px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-modal my-modal">
                    <h4 class="modal-title text-center">
                        <i class="til_img"></i>
                        <strong>Thông báo</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center modal-body-delete">
                    <p class="title-del pt-5">Bạn có xác nhận reset mật khẩu bản ghi ?</p>
                </div>
                <div class="modal-footer modal-footer-delete">
                    <button type="button" class="btn btn-dagerdel my-btn-default btn-reset-pass">
                        <span class="pr-2"><i class="fa fa-check-circle"></i></span>Xác nhận
                    </button>
                    <button type="button" class="btn btn-black my-btn-default" data-dismiss="modal">
                        <i class="fa fa-times-circle"></i>Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="/admin/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->

    <script>
        $(document).ready(function() {
            // Model: User
            const config = {
                urlList: "/admin/system/users/list",
                urlGetModelFromDb: "/admin/system/users/get",
                urlAddModelToDb: "/admin/system/users/add",
                urlUpdateModelToDb: "/admin/system/users/edit",
                urlDeleteModelToDb: "/admin/system/users/delete",
                urlResetPasswordToDb: "/admin/system/users/reset",
                titleModalAdd: "Thêm mới người dùng",
                titleModalEdit: "Cập nhật người dùng",

                autoConvertData: [{
                        name: "status",
                        convert: [
                            "1->Hoạt động->label badge badge-success sucsess-status",
                            "2->Ngừng hoạt động->label badge badge-warning"
                        ]
                    },
                    {
                        name: "gender",
                        convert: [
                            "1->Nam->label badge badge-success sucsess-status",
                            "2->Nữ->label badge active btn-danger error-status"
                        ]
                    }
                ],
                idTableElement: "#idTable"

            };
            setupCRUD(config);

            $(document).on('click', '.update-modal', function() {
                $("[name=password]").parent().hide();
                $("[name=re_password]").parent().hide();
                $("[name=username]").prop('readonly', true);
            });
            $(document).on('click', '.add-modal', function() {
                $("[name=password]").parent().show();
                $("[name=re_password]").parent().show();
                $("[name=username]").prop('readonly', false);
            });

            $(document).on('click', '.password-modal', function() {
                $('.btn-reset-pass').attr('data-id', $(this).attr('data-id'))
            });

            $(document).on('click', '.btn-reset-pass', function() {
                resetPassword('.btn-reset-pass');
            });

            let showPass = 0;
            $('.btn-show-pass').on('click', function() {
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

            function resetPassword(t) {
                let data = {
                    "id": $(t).attr('data-id')
                }

                let result = ajaxQuery(config.urlResetPasswordToDb, data, 'POST');

                if (result.code == 200) {
                    $("[data-dismiss=modal]").trigger({
                        type: "click"
                    });
                    swalSuccess(result.message);
                } else {
                    notifyError('Có lỗi xảy ra. Vui lòng thử lại!');
                }
            }

        });




        $(document).ready(function() {


            $('.js-example-basic-multiple').select2();

            $('.bs-searchbox input').attr('spellcheck', 'false');

            $('.isNumber').on('keypress', function(event) {
                var regex = new RegExp("^[0-9]+$");
                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>


@endsection
