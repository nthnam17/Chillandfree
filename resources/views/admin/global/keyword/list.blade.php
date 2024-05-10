<div class="card mb-0">
    <div class="d-flex justify-content-end mb-3">
        <div class="card-header-actions">
            <button class="btn btn-outline-primary btn-custom add-modal-intro" data-toggle="modal" data-target="#modal-form-keyword">
                <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
            </button>
        </div>
    </div>
    <div id="idTable_keyword">
        <div class="scroll-table" id="scroll-table-css">
            <table class="table table-striped border table-hover datatable dataTable no-footer"
                   role="grid"
                   aria-describedby="table-users_info">
                <thead>
                <tr role="row" class="header-tableData">
                    <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">STT</th>
                    <th title="Từ khóa" class=" column-key-email " style="width: 150px;">Từ khóa</th>
                    <th title="Từ khóa" class=" column-key-email " style="width: 150px;">Số lượt tra cứu</th>
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
            urlGetLítModelToDb: "/admin/keyword/list",
        }

        $('#modal-lookup-tab').on('click', '#nav-keyword-tab', function () {
            window.loadDataTableKeyword()
        });

        // load data thông tin
        window.loadDataTableKeyword = function() {
            $('#idTable_keyword tbody tr').remove();

            let lookup_id = $("input[name='id-intro']").val();
            let data = {
                id: lookup_id
            }
            let result = ajaxQuery(config.urlGetLítModelToDb, data, 'GET');
            let lstData = result.data;

            $.each(lstData, function(index, item){
                let status = '<span class="label badge badge-success sucsess-status">Hoạt động</span>';
                if(item.status != 1) status = '<span class="label badge badge-warning">Ngừng hoạt động</span>';
                let stt = index + 1;
                let newRow = "<tr>" +
                    "<td>" + stt + "</td>" +
                    "<td>" + item.name + "</td>" +
                    "<td>" + item.count + "</td>" +
                    "<td>" + status + "</td>" +
                    "<td>" +
                    '<a title="Chỉnh sửa" class="btn btn-sm active edit-keyword" href="" name="id" style="color: #4B49AC" data-toggle="modal" data-target="#modal-edit-keyword" data-id="' + item.id + '"><i class="mdi mdi-pencil"></i></a>' +
                    '<a title="Xóa" class="btn btn-sm active delete-keyword" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-delete-keyword" data-id="' + item.id + '"><i class="mdi mdi-delete"></i></a>' +
                    "</td>" +
                    "</tr>";
                $('#idTable_keyword tbody').append(newRow);
            });
        }

    });
</script>
