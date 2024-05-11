<?php
use App\Models\Permission;
use \App\Models\Role_has_permissions;

// $url = '/' . Request::path();
// $permission = Permission::where('slug', $url)->first();

?>
@extends('admin.layouts.index')
@section('pageTitle', 'Quyền')
@section('content')
    <style>
        .main-search {
            border: 1px solid #f5f5f5;
            margin-bottom: 15px;
            border-radius: 5px;
            padding: 10px;
        }
        .title-searh-cus-header {
            padding: 5px ;
        }

        .title-searh-cus-header p {
            font-weight: bold;
            font-size: 16px;
            color: #5156be;
            position: relative;
        }
        .title-searh-cus-header p::after {
            content: "";
            width: 55px;
            border-bottom: 2px solid #5156be;
            position: absolute;
            left: 0;
            bottom: -3px;
        }

        i.fa.fa-times-circle {
            padding-right: 5px;
        }

        i.fa.fa-save {
            padding-right: 5px;
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: #e6e7e9;
        }

        .btn-sm {
            padding: 0;
        }

        .table th, .table td {
            vertical-align: middle !important;
        }

        .scroll-table {
            max-height: calc(100vh - 300px);
        }

        .card-header {
            padding: 0.5rem 1rem !important;
        }
        .btn-custom {
            margin-top: 5px;
        }
        .btn-custom i {
            font-size: 13px;
        }
    </style>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card mb-0">
                <div class="card-header">
                    <h4 class="card-title">Danh sách quyền</h4>
                </div>
                <div class="card-body main-content-group">
                    <div class="main-search ">
                        <div class="title-searh-cus-header">
                            <p>BỘ LỌC</p>
                        </div>
                        <div class="row" id="searchForm">
                            <div class="col-xs-2 col-md-4">
                                <input class="form-control" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Tên quyền">
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
                            {{-- @if(Role_has_permissions::hasPermissionByName('Thêm quyền')) --}}
                            <button class="btn btn-outline-primary btn-custom add-modal" data-toggle="modal" data-target="#modal-form">
                                <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                            </button>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div id="idTable">
                        <div class="scroll-table"  id="scroll-table-css">
                            <table class="table table-striped border table-hover datatable dataTable no-footer" role="grid"
                                   aria-describedby="table-users_info">
                                <thead>
                                <tr role="row">
                                    <th title="STT" class="text-center" style="width: 50px;">
                                        STT
                                    </th>
                                    <th title="Tên" class="text-center" style="width: 302px;">Tên
                                    </th>
                                    <th title="Nhóm cha" class="text-center" style="width: 302px;">Nhóm
                                        cha
                                    </th>
                                    <th title="Trạng thái" width="100px" class="text-center column-key-created_at"
                                        style="width: 100px;">Trạng thái
                                    </th>
                                    <th title="Thời gian tạo" width="100px" class="text-center column-key-status"
                                        style="width: 100px;">Thời gian tạo
                                    </th>
                                    <th title="Thời gian sửa" width="100px" class=" text-center column-key-status"
                                        style="width: 100px;">Thời gian sửa
                                    </th>
                                    <th title="Thao tác" width="350px" class="text-center"
                                        style="width: 100px;">Thao tác</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr role="row" class="align-middle odd" id="templateRow" style="display: none">
                                    <td class="text-center" name="stt"></td>
                                    <td group="data" name="name"></td>
                                    <td class="text-center" group="data" name="parent_name"></td>
                                    {{--                                <td group="data" name="slug"></td>--}}
                                    <td class="text-center"><span group="data autoConvertData" name="status"></span></td>
                                    <td class="text-center" group="data autoConvertTime" name="created_at"></td>
                                    <td class="text-center" group="data autoConvertTime" name="updated_at"></td>
                                    <td class="text-center">
                                        {{-- @if(Role_has_permissions::hasPermissionByName('Cập nhật quyền')) --}}
                                            <a style="color: #39b2d5" title="Chỉnh sửa" class="btn btn-sm active update-modal" href=""
                                               name="id"
                                               group="data" convertToAttr="data-id" data-toggle="modal"
                                               data-target="#modal-form"><i class="mdi mdi-pencil"></i></a>
                                        {{-- @endif --}}
                                        {{-- @if(Role_has_permissions::hasPermissionByName('Xóa quyền')) --}}
                                            <a style="color: #f5302e" title="Xóa" class="btn btn-sm active deleteDialog" href="" name="id"
                                               group="data" convertToAttr="data-id" data-toggle="modal"
                                               data-target="#popup-delete"><i class="mdi mdi-delete"></i></a>
                                        {{-- @endif --}}
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
    </div>

    @include('admin.global.popupDelete')

    <!-- Modal Permission -->
    <div id="modal-form" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-modal my-modal">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>Thêm quyền</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-body">
                        <input type="hidden" name="id" group="data">
                        <input type="hidden" name="guard_name" value="web">
                        <div class="form-group">
                            <label for="first_name" class="control-label required">Tên</label>
                            <input group="data" class="form-control" name="name" type="text" spellcheck="false">
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="control-label">Nhóm cha</label>
                            <select group="data" class="form-control select-parent_id" name="parent_id">
                                <option value="0">Chọn nhóm cha</option>
                                <?php $data_permission = Permission::findParentId(0);?>
                                @if(isset($data_permission) && count($data_permission)>0)
                                    @foreach($data_permission as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="control-label label-slug">Slug</label>
                            <input group="data" class="form-control" name="slug" type="text" spellcheck="false">
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="control-label">Mô tả</label>
                            <input group="data" class="form-control" name="description" type="text" spellcheck="false">
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="control-label">Sắp xếp</label>
                            <input group="data" class="form-control" name="order" type="number" spellcheck="false">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Trạng thái</label>
                            <select group="data" class="form-control select-status" group="data" name="status">
                                <option value="1">Hoạt động</option>
                                <option value="0">Ngừng hoạt động</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success my-btn-default btnAddPer" id="btnAdd">
                        <i class="fa fa-save"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-canel my-btn-default" data-dismiss="modal">
                        <i class="fa fa-times-circle"></i>Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Permission -->

    <script>

        $(document).ready(function () {
            // Model: Permission
            const config = {
                urlList: "/admin/system/permission/list",
                urlGetModelFromDb: "/admin/system/permission/getOne",
                urlAddModelToDb: "/admin/system/permission/add",
                urlUpdateModelToDb: "/admin/system/permission/edit",
                urlDeleteModelToDb: "/admin/system/permission/delete",
                urlGetParentPer: "/admin/system/permission/parentPer",
                titleModalAdd: "Thêm quyền",
                titleModalEdit: "Sửa quyền",

                autoConvertData: [
                    {
                        name: "status",
                        convert: [
                            "1->Hoạt động->label badge badge-success sucsess-status",
                            "0->Ngừng hoạt động->label  badge badge-warning"
                        ]
                    }
                ],
                idTableElement: "#idTable"

            };
            setupCRUD(config);

            // //event onchange parent id
            // $('.select-parent_id').on('change', function () {
            //     setRequiredSlug(this.value);
            // });
            //
            // //event show model
            // $('#modal-form').on('shown.bs.modal', function (e) {
            //     setRequiredSlug(null);
            // });
            //
            // //event hidden model
            // $('#modal-form').on('hidden.bs.modal', function () {
            //     console.log('###EVENT RELOAD PARENT_ID###');
            //     reLoadOption();
            // });
            //
            // function reLoadOption() {
            //     let arrResult = ajaxQuery(config.urlGetParentPer, null, 'GET');
            //     if (arrResult.code == 200) {
            //         $(".select-parent_id").children().remove();
            //         let html = '';
            //         html += '<option value="0">Chọn loại cha</option>';
            //
            //         for (let item of arrResult.data) {
            //             html += '<option value="' + item.id + '">' + item.name + '</option>';
            //         }
            //         $(".select-parent_id").append(html);
            //     }
            // }
            //
            // function setRequiredSlug(val) {
            //     if (val == '' || val == null) {
            //         $('.label-slug').removeClass("required");
            //     } else {
            //         $('.label-slug').addClass("required");
            //
            //     }
            // }
        });
    </script>
@endsection
