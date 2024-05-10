<?php
use \App\Models\Role_has_permissions;

?>
<style>
    #table_paginate_news_more {
        margin-top: 15px;
    }
</style>
<div class="card mb-0">
    <div class="main-search-news">
        <div class="row" id="searchFormNewsMore">
            <div class="col-xs-2 col-md-3">
                <input class="form-control" group="data" name="search_name_more" type="text" autocomplete="off" spellcheck="false" placeholder="Tiêu đề">
            </div>
            <div class="col-xs-2 col-md-3">
                <select class="form-control select-status select2-news__more" group="data" name="search_type">
                </select>
            </div>
            <div class="col-xs-2 col-md-3">
                <select class="form-control select-status" group="data" name="search_status">
                    <option value="">--Trạng thái--</option>
                    <option value="1">Hoạt động</option>
                    <option value="2">Ngừng hoạt động</option>
                </select>
            </div>
            <div class="col-xs-2 col-md-3">
                <button class="btn btn-outline-primary btn-custom" id="btnSearchNewsMore">
                    <i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
                </button>
                <button class="btn btn-outline-success btn-custom" id="btnResetNewsMore">
                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <div class="card-header-actions">
                <button class="btn btn-outline-primary btn-custom add-modal-new-more" data-toggle="modal" data-target="#modal-form-news-more">
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                </button>
        </div>
    </div>
    <div id="idTable_news_more">
        <div class="scroll-table" id="scroll-table-css">
            <table class="table table-striped border table-hover datatable dataTable no-footer"
                   role="grid"
                   aria-describedby="table-users_info">
                <thead>
                <tr role="row" class="header-tableData">
                    <th title="STT" class=" column-key-username sorting_desc" style="width: 50px;">STT</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Tiêu đề</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 150px;">Thể loại</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 100px;">Hình ảnh</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 100px;">Nổi bật</th>
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 100px;">Ưu tiên</th>
                    <th title="Trạng thái" class="column-key-created_at " style="width: 110px;">Trạng thái</th>
                    <th title="Thao tác" class="column-key-status " style="width: 125px;">Thao tác</th>
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
            <div class="paging_simple_numbers pull-right" id="table_paginate_news_more"></div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const config = {
            urlGetNewsMore: "/admin/news_more/list",
            urlGetCategoryMore: "/admin/news_more/category",
        };

        let pageIndex = 1;
        let lastPage = 0;

        $('#modal-lookup-tab').on('click', '#nav-more-tab', function () {
            pageIndex = 1;
            window.loadCategoryMore();
            window.loadDataTableNewsMore();
        });

        // load data thông tin
        window.loadDataTableNewsMore = function() {
            $('#idTable_news_more tbody tr').remove();

            let lookup_id = $("input[name='id-intro']").val();
            let data = {
                id: lookup_id,
                title: $("#searchFormNewsMore input[name='search_name_more']").val(),
                type: $("#searchFormNewsMore select[name='search_type']").val(),
                status: $("#searchFormNewsMore select[name='search_status']").val(),
                page: pageIndex
            }

            let result = ajaxQuery(config.urlGetNewsMore, data, 'GET');
            let lstData = result.data.data;
            lastPage = result.data.last_page;

            let perPage = 20;
            let order = (pageIndex - 1) * perPage;

            $.each(lstData, function(index, item){
                //STATUS
                let status = '<span class="label badge badge-success sucsess-status">Hoạt động</span>';
                if(item.status != 1) status = '<span class="label badge badge-warning">Ngừng hoạt động</span>';


                let hot_txt = item.is_hot == 1 ? 'Có' : 'Không';
                let priority_txt = item.priority != null ? item.priority : '';

                order += 1;
                let newRow = "<tr id='"  + item.id + "'>" +
                    "<td>" + order + "</td>" +
                    "<td>" + item.title + "</td>" +
                    "<td>" + item.category_name + "</td>" +
                    "<td><img width='80' src='" + item.image + "'></td>" +
                    "<td>" + hot_txt + "</td>" +
                    "<td>" + priority_txt + "</td>" +
                    "<td>" + status + "</td>" +
                    "<td>";
                newRow += '<a title="Chỉnh sửa" class="btn btn-sm active edit-news-more" href="" name="id" style="color: #4B49AC" data-toggle="modal" data-target="#modal-edit-news-more" data-id="' + item.id + '"><i class="mdi mdi-pencil"></i></a>' +
                    '<a title="Xóa" class="btn btn-sm active delete-news-more" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-delete-news-more" data-id="' + item.id + '"><i class="mdi mdi-delete"></i></a>' +
                    "</td>" +
                    "</tr>";
                $('#idTable_news_more tbody').append(newRow);
            });

            paginationNews(result);

        }

        window.loadCategoryMore = function() {
            let lookup_id = $("input[name='id-intro']").val();
            let data = {
                id: lookup_id,
            };

            let result = ajaxQuery(config.urlGetCategoryMore, data, 'GET');

            // Tạo một hàm để append các option vào select element
            function appendOptionsToSelect(select, options) {
                select.empty();
                select.append($('<option>', {
                    value: "",
                    text: "--Chọn--",
                }));

                // Sắp xếp mảng options dựa trên parent_id và id
                options.sort(function (a, b) {
                    if (a.parent_id === b.parent_id) {
                        return a.id - b.id;
                    } else {
                        return a.parent_id - b.parent_id;
                    }
                });

                options.forEach(function (option) {
                    var $option = $('<option>', {
                        value: option.id,
                        text: (option.parent_id !== null ? '- ' : '') + option.name,
                    });
                    select.append($option);
                });
            }

            // Gọi hàm để append các option vào cả hai select element
            appendOptionsToSelect($('#searchFormNewsMore select[name="search_type"]'), result.data);
            appendOptionsToSelect($("#modal-form-news-more select[name='type']"), result.data);
            appendOptionsToSelect($("#modal-edit-news-more select[name='type']"), result.data);
        }

        $('.add-modal-new-more').click(function () {
            clearData();
        })

        $('#btnResetNewsMore').click(function () {
            $("#searchFormNewsMore input[name='search_name_more']").val('');
            $("#searchFormNewsMore select[name='search_type']").val('');
            $("#searchFormNewsMore select[name='search_status']").val('');
            pageIndex = 1;

            window.loadDataTableNewsMore();
        })

        $('#btnSearchNewsMore').click(function () {
            pageIndex = 1;
            window.loadDataTableNewsMore();
        })

        function clearData() {
            $("#modal-form-news-more input[name='title']").val('');
            $("#modal-form-news-more select[name='type']").val("");
            $("#modal-form-news-more textarea[name='description']").val('');
            $("#modal-form-news-more select[name='status']").val(1);
            $("#modal-form-news-more img[name='image']").attr('src', '/admin/img/placeholder.png');
            $("#modal-form-news-more input[name='is_hot']").prop('checked', false);
            $("#modal-form-news-more input[name='priority']").val('');

            let fncCallback = function(){
                CKEDITOR.instances['content'].setData('');
            };
            CKEDITOR.instances['content'].setData("", fncCallback);

            let fncCallback_des = function(){
                CKEDITOR.instances['news_more_description_edit'].setData('');
            };
            CKEDITOR.instances['news_more_description_edit'].setData("", fncCallback_des);

            $("#modal-form-news-more .show-invalid").remove();
        }

        function calculateTableHeight() {
            let $scrollTable = $('#idTable_news').find('.scroll-table');
            let tableHeight = $scrollTable.prop('scrollHeight');
            let windowHeight = $scrollTable.outerHeight();
            console.log(tableHeight)
            console.log(windowHeight)

            $scrollTable.on('scroll', function() {
                var scrollTop = $(this).scrollTop();

                // Kiểm tra nếu đã cuộn đến cuối phần table
                if (scrollTop + windowHeight >= tableHeight) {
                    pageIndex += 1;

                    if(pageIndex > lastPage) return;
                    window.loadDataTableNewsMore();
                }
            });
        }

        function paginationNews(data) {
            let htmlPanigation =
                "<nav>" +
                "<ul class=\"pagination\">" +
                "<li class=\"page-item disabled\">" +
                "<span class=\"page-link\" aria-hidden=\"true\">‹</span>" +
                "</li>" +
                "<li class=\"page-item active\" aria-current=\"page\"><span class=\"page-link\">1</span></li>" +
                "<li class=\"page-item disabled\">" +
                "<span class=\"page-link\" aria-hidden=\"true\">›</span>" +
                "</li>" +
                "</ul>" +
                "</nav>";

            if(data.data.last_page == 1){
                $('#table_paginate_news_more').html(htmlPanigation);
            } else {
                let pagination = data.data;

                //btn more left
                htmlPanigation = "<nav><ul class=\"pagination\">";
                if (pagination.current_page == 1) {
                    htmlPanigation += "<li class=\"page-item disabled\">" +
                        "<span class=\"page-link\" aria-hidden=\"true\">‹</span>" +
                        "</li>";
                } else {
                    htmlPanigation += "<li class=\"page-item\">" +
                        "<a class=\"page-link\" aria-hidden=\"true\">‹</a>" +
                        "</li>";
                }

                if(pagination.current_page > 2) {
                    htmlPanigation += "<li class=\"page-item\" aria-current=\"page\"><a class=\"page-link\">1</a></li>";
                }
                if(pagination.current_page > 3) {
                    htmlPanigation += "<li class=\"page-item disabled\"><span class=\"page-link p-custom\">...</span></li>";
                }

                //page
                let page_from = 1;
                let page_to = pagination.last_page;
                for(let i=page_from; i<=page_to; i++) {
                    if(i>=pagination.current_page-1 && i<=pagination.current_page+1) {
                        if (i == pagination.current_page) {
                            htmlPanigation += "<li class=\"page-item active\" aria-current=\"page\"><span class=\"page-link\">" + i + "</span></li>";
                        } else {
                            htmlPanigation += "<li class=\"page-item\" aria-current=\"page\"><a class=\"page-link\">" + i + "</a></li>";
                        }
                    }
                }

                if (pagination.current_page < pagination.last_page - 2) {
                    htmlPanigation += "<li class=\"page-item disabled\"><span class=\"page-link p-custom\">...</span></li>";
                }
                if (pagination.current_page < pagination.last_page - 1) {
                    htmlPanigation += "<li class=\"page-item\" aria-current=\"page\"><a class=\"page-link\">" + pagination.last_page + "</a></li>";
                }
                // }

                //btn more right
                if(pagination.current_page==pagination.last_page) {
                    htmlPanigation += "<li class=\"page-item disabled\">" +
                        "<span class=\"page-link\" aria-hidden=\"true\">›</span>" +
                        "</li>";
                } else {
                    htmlPanigation += "<li class=\"page-item\">" +
                        "<a class=\"page-link\" aria-hidden=\"true\">›</a>" +
                        "</li>";
                }
                $('#table_paginate_news_more').html(htmlPanigation);
            }

            $("#table_paginate_news_more nav ul li a").click(function (e) {
                let strPage = $(this).text().trim();
                let iPage;
                if (strPage == '‹' && parseInt(pageIndex) > 0) {
                    iPage = parseInt(pageIndex) - 1;
                } else if (strPage == '›') {
                    iPage = parseInt(pageIndex) + 1;
                } else {
                    iPage = parseInt(strPage);
                }
                pageIndex = iPage;

                window.loadDataTableNewsMore();
            })
        }

        $('.select2-news__more').select2();
    });
</script>
