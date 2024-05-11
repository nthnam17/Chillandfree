<?php
use \App\Models\Role_has_permissions;
?>
@extends('admin.layouts.index')
@section('pageTitle', 'Quản lý nhóm quyền')
@section('content')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

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
    <link rel="stylesheet" type="text/css" href="/admin/css/jquery-ui.css">
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card mb-0">
                <div class="card-header">
                    <h4 class="card-title">Quản lý nhóm quyền</h4>
                </div>
                <div class="card-body main-content-group">
                    <div class="main-search ">
                        <div class="title-searh-cus-header">
                            <p>BỘ LỌC</p>
                        </div>
                        <div class="row" id="searchForm">
                            <div class="col-xs-2 col-md-4">
                                <input class="form-control" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Tên nhóm quyền">
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
                            {{-- @if(Role_has_permissions::hasPermissionByName('Thêm nhóm quyền')) --}}
                            <button class="btn btn-outline-primary btn-custom add-modal" data-toggle="modal" data-target="#modal-form">
                                <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                            </button>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div id="idTable">
                        <div class="scroll-table" id="scroll-table-css">
                            <table class="table table-striped border table-hover datatable dataTable no-footer"
                                   role="grid"
                                   aria-describedby="table-users_info">
                                <thead>
                                <tr role="row" class="header-tableData">
                                    <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">
                                        STT
                                    </th>
                                    <th title="Tên" class=" column-key-email " style="width: 150px;">Tên
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
                                    <td class="text-center" name="stt"></td>
                                    <td group="data" name="name"></td>
                                    <td class="text-left"><span group="data autoConvertData" name="status"></span>
                                    </td>
                                    <td class="text-left" group="data autoConvertTime" name="created_at"></td>
                                    <td class="text-left" group="data autoConvertTime" name="updated_at"></td>
                                    <td class="text-left">
                                        {{-- @if(Role_has_permissions::hasPermissionByName('Cập nhật nhóm quyền')) --}}
                                        <a title="Chỉnh sửa" class="btn btn-sm  active update-modal-role" href=""
                                           name="id" style="color: #39b2d5"
                                           group="data" convertToAttr="data-id" data-toggle="modal"
                                           data-target="#modal-form"><i class="mdi mdi-pencil"></i></a>
                                        {{-- @endif --}}
                                        {{-- @if(Role_has_permissions::hasPermissionByName('Xóa nhóm quyền')) --}}
                                        <a title="Xóa" class="btn btn-sm active deleteDialog" href=""
                                           name="id" style="color: #f5302e"
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



    @include('admin.global.popupDelete')

    <!-- Modal User -->
    <div id="modal-form" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 500px; ">
            <!-- Modal content-->
            <div class="modal-content" >
                <div class="modal-header bg-modal my-modal">
                    <h4 class="modal-title">
                        <i class="til_img"></i>
                        <strong>Thêm mới nhóm quyền</strong>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-body">
                        <input group="data" type="hidden" name="id">
                        <div class="form-group">
                            <label class="control-label required">Tên nhóm quyền <span>*</span></label>
                            <input class="form-control" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Tên đầy đủ">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Trạng thái</label>
                            <select class="form-control select-status" group="data" name="status">
                                <option value="1">Hoạt động</option>
                                <option value="2">Ngừng hoạt động</option>
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
                                        <?php $data_per = \App\Models\Permission::findParentId(0);?>
                                        @foreach($data_per as $item)
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
                                        @endforeach
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
    <!-- End Modal User -->

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
                urlList: "/admin/system/roles/list",
                urlGetModelFromDb: "/admin/system/roles/getOne",
                urlAddModelToDb: "/admin/system/roles/add",
                urlUpdateModelToDb: "/admin/system/roles/edit",
                urlDeleteModelToDb: "/admin/system/roles/delete",
                titleModalAdd: "Thêm mới nhóm quyền",
                titleModalEdit: "Cập nhật nhóm quyền",

                autoConvertData: [
                    {
                        name: "status",
                        convert: [
                            "1->Hoạt động->label badge badge-success sucsess-status",
                            "2->Ngừng hoạt động->label badge badge-warning"
                        ]
                    },
                ],
                idTableElement: "#idTable"

            };
            setupCRUD(config);

            $(".select2").select2({ tags: true });
            $('#modal-form .select2').val(null).trigger('change');

            $('#auto-checkboxes').tree({});

            // ### Event show popup add
            $(".add-modal-custom").click(function () {
                setUpModal(config.titleModalAdd);
                $("#btnAddCustom").contents().last()[0].textContent = config.titleModalAdd;
                $('.form-body input[type="checkbox"]').prop("checked", false);
            });

            //### event show role ###
            $(config.idTableElement + ' tbody').on('click', '.update-modal-role', function () {
                setUpModal(config.titleModalEdit);
                $("#btnAddCustom").contents().last()[0].textContent = config.titleModalEdit;
                $('input[name="checkbox-per"]').each(function (i, obj) {
                    $(obj).prop('checked', false);
                });

                let data = {
                    "id": $(this).data("id")
                };
                let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
                if (result.code == 200) {
                    updateDataView("#modal-form", result.data);
                    $('#modal-form .select2').val(result.data.field_id);

                    $('input[name="checkbox-per"]').each(function (i, obj) {
                        console.log('234234234234');
                        result.data.permissions.forEach(function (item) {
                            if (item == obj.value) $(obj).prop('checked', true);
                        });
                    });

                } else if (result.code == 401) {
                    //notify error
                    showNotiError(result.message)
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
                    id: $("#modal-form input[name='id']").val(),
                    name: $(" #modal-form input[name='name']").val(),
                    status: $("#modal-form .select-status").val(),
                    permission: lstPer,
                    field_id: $('#modal-form .select2').val()
                };
                let result = ajaxQuery(data.id == '' || data.id == undefined ? config.urlAddModelToDb : config.urlUpdateModelToDb, data, 'POST');
                if (result.code == 200) {
                    //notify success
                    swalSuccess(result.message);
                    loadDataTable();

                    //close modal
                    $("[data-dismiss=modal]").trigger({type: "click"});

                    $('.modal').modal('hide');
                    $('.modal-backdrop').remove();

                } else if (result.code == 401) {
                    //notify error
                    // showAlert(result.message, result.notify, 5000);
                    showNotiError(result.message)
                } else {
                    if (result.errors == null) {
                        // showAlert(result.message, result.notify, 5000);
                        showNotiError(result.message)
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

