<?php

use \App\Models\Role_has_permissions;

?>
<div id="modal-form-battles" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 1500px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Danh sách thông tin khác</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card mb-0">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="card-header-actions">
                            @if(Role_has_permissions::hasPermissionByName('Thêm mới thông tin khác'))
                                <button class="btn btn-outline-primary btn-custom add-modal-battles" data-toggle="modal"
                                        data-target="#modal-form-battles-add">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                            @endif
                        </div>
                    </div>
                    <div id="idTable_battles">
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
            urlGetBattles: "/admin/battles/list",
        };

        // load data thông tin
        window.loadDataTableBattles = function () {
            $('#idTable_battles tbody tr').remove();

            let news_id = $('#modal-form-battles-add input[name="news_id"]').val();
            let data = {
                news_id: news_id
            };
            let result = ajaxQuery(config.urlGetBattles, data, 'GET');
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
                    '<a title="Tin liên quan" class="btn btn-sm active id-news-battles" href="" name="id" style="color: #57B657" data-toggle="modal" data-target="#modal-form-related" data-id="' + item.id + '"><i class="mdi mdi-set-center"></i></a>' +
                    '<a title="Chỉnh sửa" class="btn btn-sm active edit-battles" href="" name="id" style="color: #4B49AC" data-toggle="modal" data-target="#modal-edit-battles" data-id="' + item.id + '"><i class="mdi mdi-pencil"></i></a>' +
                    '<a title="Xóa" class="btn btn-sm active delete-battles" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-delete-battles" data-id="' + item.id + '"><i class="mdi mdi-delete"></i></a>' +
                    "</td>" +
                    "</tr>";
                $('#idTable_battles tbody').append(newRow);
            });
        };

        $('.add-modal-battles').click(function () {
            clearData();
        });

        $('#idTable_battles').on('click', '.id-news-battles', function () {
            $('#modal-form-related-add input[name="news_battles_id"]').val($(this).attr('data-id'));
            window.loadDataTableRelated();
        });

        function clearData() {
            $("#modal-form-battles-add input[name='name']").val('');
            $("#modal-form-battles-add input[name='priority']").val('');
            $("#modal-form-battles-add select[name='status']").val(1);
            $("#modal-form-battles-add img[name='image']").attr('src', '/admin/img/placeholder.png');

            let fncCallback = function () {
                CKEDITOR.instances['content_battles'].focus();
                CKEDITOR.instances['content_battles'].setData('');
            };
            CKEDITOR.instances['content_battles'].setData("", fncCallback);

            $("#modal-form-battles-add .show-invalid").remove();
        }
    });
</script>
