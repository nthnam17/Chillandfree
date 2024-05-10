<?php
use App\Models\Permission;

$url = '/' . Request::path();
$permission = Permission::where('slug', $url)->first();

?>
@extends('admin.layouts.index')
@section('pageTitle', 'Quyền')
@section('content')
    <style>
        .table th, .table td {
            vertical-ali gn: middle;
        }

        .scroll-table {
            max-height: calc(100vh - 300px);
        }

        .card-header {
            padding: 0.5rem 1rem !important;
        }
    </style>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Trang chủ</li>
        <li class="breadcrumb-item active">Danh sách quyền</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Danh sách quyền
                </div>
                <div class="card-body">
                    <div class="row align-items-center" id="searchForm">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="clearable-input w-100">
                                    <label for="status" class="control-label" aria-required="true">Từ khóa</label>
                                    <input type="text" group="data" name="anyField" class="form-control"
                                           placeholder="Từ khóa" aria-controls="table"/>
                                    <span data-clear-input>&times;</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Trạng thái</label>
                                <select class="form-control select-status" group="data" name="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="2">Khóa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-outline-primary btn-custom" id="btnSearch">
                                    <i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
                                </button>
                                <button class="btn btn-outline-success btn-custom ml-2" id="btn-reset">
                                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                </button>
                                {{--                                @if(Auth::user()->hasPermissionTo(Config::get('constants.ADD_PERMISSION')))--}}
                                <button class="btn btn-outline-primary btn-custom add-modal ml-2"
                                        data-toggle="modal"
                                        data-target="#modal-form">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                                {{--                                @endif--}}
                            </div>
                        </div>
                    </div>
                    <div id="idTable" class="mt-3">
                        <table class="table table-striped border table-hover datatable dataTable no-footer" role="grid"
                               aria-describedby="table-users_info">
                            <thead>
                            <tr role="row">
                                <th title="STT" class="text-left column-key-username sorting_desc" style="width: 50px;">
                                    STT
                                </th>
                                <th title="Tên quyền" class="text-left column-key-email sorting"
                                    style="width: 150px;">Tên quyền
                                </th>
                                <th title="Nhóm cha" class="text-left column-key-email sorting"
                                    style="width: 150px;">Nhóm cha
                                </th>
                                <th title="Trạng thái" class="column-key-created_at sorting" style="width: 100px;">Trạng
                                    thái
                                </th>
                                <th title="Thời gian tạo" class="column-key-status sorting" style="width: 100px;">Thời
                                    gian tạo
                                </th>
                                <th title="Thời gian sửa" class="column-key-status sorting" style="width: 100px;">Thời
                                    gian sửa
                                </th>
                                <th title="Thao tác" class="sorting_disabled" style="width: 100px;">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="align-middle odd" id="templateRow" style="display: none">
                                <td name="stt"></td>
                                <td group="data" name="name"></td>
                                <td group="data" name="parent_name"></td>
                                <td><span group="data autoConvertData" name="status"></span></td>
                                <td group="data autoConvertTime" name="created_at"></td>
                                <td group="data autoConvertTime" name="updated_at"></td>
                                <td>
                                    {{--                                    @if(Auth::user()->hasPermissionTo(Config::get('constants.EDIT_PERMISSION')))--}}
                                    <a class="btn btn-sm active update-modal" href="" name="id"
                                       group="data"
                                       convertToAttr="data-id" data-toggle="modal" data-target="#modal-form"><i
                                            class="fa-solid fa-pencil" style="color: #4B49AC"></i></a>
                                    {{--                                    @endif--}}
                                    {{--                                    @if(Auth::user()->hasPermissionTo(Config::get('constants.DELETE_PERMISSION')))--}}
                                    <a class="btn btn-sm active deleteDialog" href="" name="id"
                                       group="data"
                                       convertToAttr="data-id" data-toggle="modal" data-target="#popup-delete"><i
                                            class="fa-solid fa-trash-can"
                                            style="color: red"></i></a>
                                    {{--                                    @endif--}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                        Thêm mới
                    </button>
                    <button type="button" class="btn btn-danger btn-canel my-btn-default" data-dismiss="modal">
                        Hủy bỏ
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
                urlGetModelFromDb: "/admin/system/permission/getPer",
                urlAddModelToDb: "/admin/system/permission/add",
                urlUpdateModelToDb: "/admin/system/permission/edit",
                urlDeleteModelToDb: "/admin/system/permission/delete",
                urlGetParentPer: "/admin/system/permission/parentPer",
                titleModalAdd: " Thêm mới",
                titleModalEdit: "Cập nhật ",

                autoConvertData: [
                    {
                        name: "status",
                        convert: [
                            "1->Hoạt động->label badge badge-success sucsess-status",
                            "0->Ngừng hoạt động->label badge active btn-danger error-status"
                        ]
                    }
                ],
                idTableElement: "#idTable"

            };
            setupCRUD(config);

            //event onchange parent id
            $('.select-parent_id').on('change', function () {
                setRequiredSlug(this.value);
            });

            //event show model
            $('#modal-form').on('shown.bs.modal', function (e) {
                setRequiredSlug(null);
            });

            //event hidden model
            $('#modal-form').on('hidden.bs.modal', function () {
                console.log('###EVENT RELOAD PARENT_ID###');
                reLoadOption();
            });

            function reLoadOption() {
                let arrResult = ajaxQuery(config.urlGetParentPer, null, 'GET');
                if (arrResult.code == 200) {
                    $(".select-parent_id").children().remove();
                    let html = '';
                    html += '<option value="0">Chọn loại cha</option>';

                    for (let item of arrResult.data) {
                        html += '<option value="' + item.id + '">' + item.name + '</option>';
                    }
                    $(".select-parent_id").append(html);
                }
            }

            function setRequiredSlug(val) {
                if (val == '' || val == null) {
                    $('.label-slug').removeClass("required");
                } else {
                    $('.label-slug').addClass("required");

                }
            }
        });
    </script>
@endsection
