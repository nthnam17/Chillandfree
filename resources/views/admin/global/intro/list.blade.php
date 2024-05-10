<?php
use \App\Models\Role_has_permissions;
?>
<div class="card mb-0">
    <div class="d-flex justify-content-end mb-3">
        <div class="card-header-actions">
            @if(Role_has_permissions::hasPermissionByName('Thêm mới giới thiệu'))
            <button class="btn btn-outline-primary btn-custom add-modal-intro" data-toggle="modal" data-target="#modal-form-intro">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
            </button>
            @endif
        </div>
    </div>
    <div id="idTable_intro">
        <div class="scroll-table" id="scroll-table-css">
            <table class="table table-striped border table-hover datatable dataTable no-footer"
                   role="grid"
                   aria-describedby="table-users_info">
                <thead>
                <tr role="row" class="header-tableData">
                    <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">STT</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Tên</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Hình ảnh</th>
                    <th title="Trạng thái" class="column-key-created_at " style="width: 150px;">Trạng thái</th>
                    <th title="Thao tác" class="column-key-status " style="width: 100px;">Thao tác</th>
                </tr>
                </thead>
                <tbody>
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

<script>
    $(document).ready(function () {
        const config = {
            urlGetIntro: "/admin/intro/list",
            urlUpdateModelToDb: "/admin/look_up/edit",
            urlDeleteModelToDb: "/admin/look_up/delete",
        }

        $('#modal-lookup-tab').on('click', '#nav-intro-tab', function () {
            window.loadDataTableIntro()
        });

        // load data thông tin
        window.loadDataTableIntro = function() {
            $('#idTable_intro tbody tr').remove();

            let lookup_id = $("input[name='id-intro']").val();
            let data = {
                id: lookup_id
            }
            let result = ajaxQuery(config.urlGetIntro, data, 'GET');
            let lstData = result.data;
            console.log(lstData)
            $.each(lstData, function(index, item){
                let status = '<span class="label badge badge-success sucsess-status">Hoạt động</span>';
                if(item.status != 1) status = '<span class="label badge badge-warning">Ngừng hoạt động</span>';
                let stt = index + 1;
                let newRow = "<tr>" +
                    "<td>" + stt + "</td>" +
                    "<td>" + item.name + "</td>" +
                    "<td><img width='80' src='" + item.image + "'></td>" +
                    "<td>" + status + "</td>" +
                    "<td>" +
                    '<a title="Chỉnh sửa" class="btn btn-sm active edit-intro" href="" name="id" style="color: #4B49AC" data-toggle="modal" data-target="#modal-edit-intro" data-id="' + item.id + '"><i class="mdi mdi-pencil"></i></a>' +
                    '<a title="Xóa" class="btn btn-sm active delete-intro" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-delete-intro" data-id="' + item.id + '"><i class="mdi mdi-delete"></i></a>' +
                    "</td>" +
                    "</tr>";
                $('#idTable_intro tbody').append(newRow);
            });
        }

    });
</script>
