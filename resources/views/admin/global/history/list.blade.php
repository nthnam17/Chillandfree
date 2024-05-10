

<div id="modal-his-news" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 800px; ">
        <div class="modal-content" >
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Lịch sử thay đổi</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card mb-0">
                    <div id="idTable_history">
                        <div class="scroll-table" id="scroll-table-css">
                            <table class="table table-striped border table-hover datatable dataTable no-footer"
                                   role="grid"
                                   aria-describedby="table-users_info">
                                <thead>
                                <tr role="row" class="header-tableData">
                                    <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">STT</th>
                                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Mô tả</th>
                                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Thời gian</th>
                                    <th title="Trạng thái" class="column-key-created_at " style="width: 150px;">Người thao tác</th>
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
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const config = {
            urlGetHistory: "/admin/history/list",
        }

        let news_id = null;

        $('#idTable_news').on('click', '.his-news', function () {
            news_id = $(this).attr('data-id');
            window.loadDataTableHistory()
        });

        // load data thông tin
        window.loadDataTableHistory = function() {
            $('#idTable_history tbody tr').remove();

            let data = {
                news_id
            }
            let result = ajaxQuery(config.urlGetHistory, data, 'GET');
            let lstData = result.data;

            $.each(lstData, function(index, item){
                let stt = index + 1;
                let newRow = "<tr>" +
                    "<td>" + stt + "</td>" +
                    "<td>" + item.name + "</td>" +
                    "<td>" + moment(item.created_at).format('YYYY-MM-DD HH:mm:ss') + "</td>" +
                    "<td>" + item.username + "</td>" +
                    "</tr>";
                $('#idTable_history tbody').append(newRow);
            });
        }

    });
</script>
