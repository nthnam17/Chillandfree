<?php

use \App\Models\Role_has_permissions;

?>
<div id="modal-form-related" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 1500px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Danh sách thông tin liên quan </strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card mb-0">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="card-header-actions">
                            @if(Role_has_permissions::hasPermissionByName('Thêm tin liên quan'))
                                <button class="btn btn-outline-primary btn-custom add-modal-related" data-toggle="modal"
                                        data-target="#modal-form-related-add">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                            @endif
                        </div>
                    </div>
                    <div id="idTable_related">
                        <div class="scroll-table" id="scroll-table-css">
                            <table class="table table-striped border table-hover datatable dataTable no-footer"
                                   role="grid"
                                   aria-describedby="table-users_info">
                                <thead>
                                <tr role="row" class="header-tableData">
                                    <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">STT
                                    </th>
                                    <th title="Tên" class=" column-key-email " style="width: 250px;">Tên</th>
                                    <th title="Hình ảnh" class=" column-key-email " style="width: 150px;">Hình ảnh</th>
                                    <th title="Ưu tiên" class=" column-key-email " style="width: 50px;">Ưu tiên</th>
                                    <th title="Trạng thái" class="column-key-created_at " style="width: 100px;">Trạng
                                        thái
                                    </th>
                                    <th title="Thao tác" class="column-key-status " style="width: 100px;">Thao tác
                                    </th>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-canel active btn-custom btn-close" data-dismiss="modal">
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        const config = {
            urlGetRelated: "/admin/related/list",
        };

        // load data thông tin
        window.loadDataTableRelated = function () {
            $('#idTable_related tbody tr').remove();

            let news_battles_id = $('#modal-form-related-add input[name="news_battles_id"]').val();
            let data = {
                news_battles_id: news_battles_id
            };
            let result = ajaxQuery(config.urlGetRelated, data, 'GET');
            let lstData = result.data;

            $.each(lstData, function (index, item) {
                let status = '<span class="label badge badge-success sucsess-status">Hoạt động</span>';
                if (item.status != 1) status = '<span class="label badge badge-warning">Ngừng hoạt động</span>';
                let stt = index + 1;
                let newRow = "<tr>" +
                    "<td>" + stt + "</td>" +
                    "<td>" + item.name + "</td>" +
                    "<td><img width='80' src='" + item.image + "'></td>" +
                    "<td>" + (item.priority !== null ? item.priority : '') + "</td>" +
                    "<td>" + status + "</td>" +
                    "<td>" +
                    '<a title="Chỉnh sửa" class="btn btn-sm active edit-related" href="" name="id" style="color: #4B49AC" data-toggle="modal" data-target="#modal-edit-related" data-id="' + item.id + '"><i class="mdi mdi-pencil"></i></a>' +
                    '<a title="Xóa" class="btn btn-sm active delete-related" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-delete-related" data-id="' + item.id + '"><i class="mdi mdi-delete"></i></a>' +
                    "</td>" +
                    "</tr>";
                $('#idTable_related tbody').append(newRow);
            });
        };

        $('.add-modal-related').click(function () {
            clearData();
        });

        function clearData() {
            $("#modal-form-related-add input[name='name']").val('');
            $("#modal-form-related-add input[name='priority']").val('');
            $("#modal-form-related-add select[name='status']").val(1);
            $("#modal-form-related-add img[name='image']").attr('src', '/admin/img/placeholder.png');

            let fncCallback = function () {
                CKEDITOR.instances['content_related'].focus();
                CKEDITOR.instances['content_related'].setData('');
            };
            CKEDITOR.instances['content_related'].setData("", fncCallback);

            $("#modal-form-related-add .show-invalid").remove();
        }
    });
</script>
