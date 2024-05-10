<?php
use App\Models\Permission;
?>
@extends('admin.layouts.index')
@section('pageTitle', 'Nhóm quyền')
@section('content')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <style>
        .btn-search {
            margin-bottom: 10px;
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
    </style>
    <link rel="stylesheet" type="text/css" href="/admin/css/jquery-ui.css"/>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Hệ thống</li>
        <li class="breadcrumb-item active">Danh sách nhóm quyền</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Danh sách nhóm quyền
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
                                {{-- @if(Auth::user()->hasPermissionTo(Config::get('constants.ADD_ROLE'))) --}}
                                    <button class="btn btn-outline-primary btn-custom add-modal ml-2"
                                            data-toggle="modal"
                                            data-target="#modal-form">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                    </button>
                                {{-- @endif --}}
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
                                <th title="Tên nhóm quyền" class="text-left column-key-email sorting"
                                    style="width: 150px;">Tên nhóm quyền
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
                                <td><span group="data autoConvertData" name="status"></span></td>
                                <td group="data autoConvertTime" name="created_at"></td>
                                <td group="data autoConvertTime" name="updated_at"></td>
                                <td>
                                    {{-- @if(Auth::user()->hasPermissionTo(Config::get('constants.EDIT_ROLE'))) --}}
                                        <a class="btn btn-sm active update-modal" href="" name="id"
                                           group="data"
                                           convertToAttr="data-id" data-toggle="modal" data-target="#modal-form"><i
                                                class="fa-solid fa-pencil" style="color: #4B49AC"></i></a>
                                    {{-- @endif --}}
                                    {{-- @if(Auth::user()->hasPermissionTo(Config::get('constants.DELETE_ROLE'))) --}}
                                        <a href="#" name="id" group="data" convertToAttr="data-id" data-toggle="modal"
                                           title="Xóa"
                                           data-target="#popup-delete"
                                           class="btn btn-sm active deleteDialog"><i class="fa-solid fa-trash-can"
                                                                                     style="color: red"></i></a>
                                    {{-- @endif --}}
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

    <!-- Modal User -->
    <div id="modal-form" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-modal my-modal">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>Thêm nhóm quyền</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-body">
                        <input group="data" type="hidden" name="id">
                        <div class="form-group">
                            <label for="first_name" class="control-label required">Tên nhóm quyền </label>
                            <input group="data" class="form-control" name="name" type="text" spellcheck="false">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Trạng thái</label>
                            <select group="data" class="form-control select-status" id="status_role" group="data"
                                    name="status">
                                <option value="1">Hoạt động</option>
                                <option value="2">Khóa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="control-label">Quyền</label>
                            <ul id='auto-checkboxes' class="list-unstyled list-feature">
                                <li id="mainNode">
                                    <input type="checkbox" id="expandCollapseAllTree" value="0">&nbsp;&nbsp;
                                    <label for="expandCollapseAllTree" class="label label-default allTree">Chọn tất
                                        cả</label>
                                    <ul>
                                        {{-- <?php $data_per = Permission::findParentId(0);?> --}}
                                        {{-- @foreach($data_per as $item)
                                            <li class="collapsed" id="node0">
                                                <input type="checkbox" class="parent" name="checkbox-per"
                                                       value="{{ $item->id }}">
                                                <label for="checkSelect0" class="label label-warning"
                                                       style="margin: 5px;">{{ $item->name }}</label>
                                                <ul>
                                                    @foreach($item->manyChildren as $child)
                                                        <li class="collapsed stylecol" id="node_sub_0_0">

                                                            <input class="child" type="checkbox" name="checkbox-per"
                                                                   value="{{ $child->id }}">
                                                            <label for="checkSelect_sub_0_0"
                                                                   class="label label-success nameMargin">{{ $child->name }}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach --}}
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success active btn-custom" id="btnAddCustom">
                        Thêm mới
                    </button>
                    <button type="button" class="btn btn-danger btn-canel active btn-custom"
                            data-dismiss="modal">
                        Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select2-selection__choice {
            color: #28a745 !important;
            padding: 5px !important;
            background: none !important;
            border: 1px solid #28a745 !important;
        }

        .select2-selection__choice span {
            color: #28a745 !important;
        }

        .list-feature .ui-widget-content {
            background: none;
            border: none;
            margin-top: 15px;
        }

        .ui-widget.ui-widget-content {
            border: none;
        }

        .ui-widget-content {
            background: none;
        }

        #auto-checkboxes ul > li {
            padding-left: 18px;
            border-left: 1px dashed #000000;
        }

        .daredevel-tree li {
            list-style-type: none;
            position: relative;
        }

        #auto-checkboxes {
            height: 400px;
            overflow-y: scroll;
        }
    </style>
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jquery.tree.min.js"></script>
    <script>
        $(document).ready(function () {
            // Model: User
            const config = {
                urlList: "/admin/system/role/list",
                urlGetModelFromDb: "/admin/system/role/getRole",
                urlAddModelToDb: "/admin/system/role/add",
                urlUpdateModelToDb: "/admin/system/role/edit",
                urlDeleteModelToDb: "/admin/system/role/delete",
                titleModalAdd: "Thêm mới",
                titleModalEdit: "Cập nhật",

                autoConvertData: [
                    {
                        name: "status",
                        convert: [
                            "1->Hoạt động->label badge badge-success sucsess-status",
                            "2->Ngừng hoạt động->label badge active btn-danger error-status"
                        ]

                    }

                ],
                idTableElement: "#idTable"

            };
            setupCRUD(config);

            $('#auto-checkboxes').tree({});

            // ### Event show popup add
            $(".add-modal-custom").click(function () {
                setUpModal(config.titleModalAdd);
                $("#btnAddCustom").contents().last()[0].textContent = config.titleModalAdd;
                $('.form-body input[type="checkbox"]').prop("checked", false);
            });

            //### event show role ###
            $(config.idTableElement + ' tbody').on('click', '.update-modal', function () {
                setUpModal(config.titleModalEdit);
                $("#btnAddCustom").contents().last()[0].textContent = config.titleModalEdit;
                $('input[name="checkbox-per"]').each(function (i, obj) {
                    $(obj).prop('checked', false);
                });

                let data = {
                    "id": $(this).data("id")
                };
                let result = ajaxQuery(config.urlGetModelFromDb, data, 'POST');
                if (result.code == 200) {
                    updateDataView("#modal-form", result.data);

                    $('input[name="checkbox-per"]').each(function (i, obj) {
                        // if (result.data.permissions.indexOf(parseInt(this.value)) != -1) {
                        //     $(this).prop('checked', true);
                        //     //let test = $(this).parent().parent().parent();
                        //     //test.find('input.parent').prop('checked', true);
                        // }
                        result.data.permissions.forEach(function (item) {
                            if (item == obj.value) $(obj).prop('checked', true);
                        });
                    });

                } else if (result.code == 401) {
                    //notify error
                    showAlert(result.message, result.notify, 5000);
                }
            });

            //### add roles ###
            $("#btnAddCustom").click(function (e) {
                e.preventDefault();
                let lstPer = [];
                $('input[name="checkbox-per"]:checked').each(function () {
                    lstPer.push(this.value);
                });
                let data = {
                    id: $("input[name='id']").val(),
                    name: $("input[name='name']").val(),
                    status: $("#status_role").val(),
                    permission: lstPer,
                };
                let result = ajaxQuery(data.id == '' || data.id == undefined ? config.urlAddModelToDb : config.urlUpdateModelToDb, data, 'POST');
                if (result.code == 200) {
                    //notify success
                    showAlert(result.message, result.notify, 5000);

                    loadDataTable();

                    //close modal
                    $("[data-dismiss=modal]").trigger({type: "click"});

                    $('.modal').modal('hide');
                    $('.modal-backdrop').remove();

                } else if (result.code == 401) {
                    //notify error
                    showAlert(result.message, result.notify, 5000);
                } else {
                    if (result.errors == null) {
                        showAlert(result.message, result.notify, 5000);
                    } else {
                        Object.keys(result.errors).forEach(function (key) {
                            let locationAddValidate = $("input[name='" + key + "']").parent();
                            if (locationAddValidate.length == 0) {
                                locationAddValidate = $("select[name='" + key + "']").parent();
                            }
                            $("input[name='" + key + "']").addClass('invalid');
                            $("select[name='" + key + "']").addClass('invalid');
                            createdInvalid(locationAddValidate, result.errors[key]);
                        });
                    }
                }
            });

            $(document).on('change', '.parent, .child', function () {
                let flag = true;
                $('#auto-checkboxes input').each(function () {
                    if (!$(this).is(":checked")) {
                        flag = false;
                        return false;
                    }
                });

                if (!flag) $('#expandCollapseAllTree').prop('checked', false);
            });
        });

    </script>
@endsection

