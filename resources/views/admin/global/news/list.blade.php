<?php

use \App\Models\Role_has_permissions;

?>
<style>
    #table_paginate_news {
        margin-top: 15px;
    }
</style>
<div class="card mb-0">
    <div class="main-search-news">
        <div class="row" id="searchFormNews">
            <div class="col-xs-2 col-md-3">
                <input class="form-control" group="data" name="search_name" type="text" autocomplete="off"
                       spellcheck="false" placeholder="Tiêu đề">
            </div>
            <div class="col-xs-2 col-md-3">
                <select class="form-control select-status" group="data" name="search_type" id="sel_2">
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
                <button class="btn btn-outline-primary btn-custom" id="btnSearchNews">
                    <i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm
                </button>
                <button class="btn btn-outline-success btn-custom" id="btnResetNews">
                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                </button>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <div class="card-header-actions">
            @if(Role_has_permissions::hasPermissionByName('Thêm nội dung'))
                <button class="btn btn-outline-primary btn-custom add-modal-new" data-toggle="modal"
                        data-target="#modal-form-news">
                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                </button>
            @endif
        </div>
    </div>
    <div id="idTable_news">
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
                    <th title="Tên đăng nhập" class=" column-key-email " style="width: 100px;">Trang chủ</th>
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
            <div class="paging_simple_numbers pull-right" id="table_paginate_news"></div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const config = {
            urlGetNews: "/admin/news/list",
            urlUpdateModelToDb: "/admin/look_up/edit",
            urlDeleteModelToDb: "/admin/look_up/delete",
            urlGetCategory: "/admin/news/category",
        }

        let pageIndex = 1;
        let lastPage = 0;

        $('#modal-lookup-tab').on('click', '#nav-news-tab', function () {
            pageIndex = 1;
            window.loadCategory();
            window.loadDataTableNews();
        });

        // load data thông tin
        window.loadDataTableNews = function () {
            $('#idTable_news tbody tr').remove();

            let lookup_id = $("input[name='id-intro']").val();
            let data = {
                id: lookup_id,
                title: $("#searchFormNews input[name='search_name']").val(),
                type: $("#searchFormNews select[name='search_type']").val(),
                status: $("#searchFormNews select[name='search_status']").val(),
                page: pageIndex
            }

            let result = ajaxQuery(config.urlGetNews, data, 'GET');
            let lstData = result.data.data;
            lastPage = result.data.last_page;

            let perPage = 20;
            let order = (pageIndex - 1) * perPage;

            $.each(lstData, function (index, item) {
                //STATUS
                let status = '<span class="label badge badge-success sucsess-status">Hoạt động</span>';
                if (item.status != 1) status = '<span class="label badge badge-warning">Ngừng hoạt động</span>';


                let hot_txt = item.is_hot == 1 ? 'Có' : 'Không';
                let showHome_txt = item.show_home == 1 ? 'Hiện' : 'Không hiện';
                let priority_txt = item.priority != null ? item.priority : '';

                order += 1;
                let newRow = "<tr id='" + item.id + "'>" +
                    "<td>" + order + "</td>" +
                    "<td>" + item.title + "</td>" +
                    "<td>" + item.category_name + "</td>" +
                    "<td><img width='80' src='" + item.image + "'></td>" +
                    "<td>" + hot_txt + "</td>" +
                    "<td>" + showHome_txt + "</td>" +
                    "<td>" + priority_txt + "</td>" +
                    "<td>" + status + "</td>" +
                    "<td>";
                newRow += '<a title="Các trận đánh tham gia" class="btn btn-sm active figure-battles" href="" name="id" style="color: #57B657" data-toggle="modal" data-target="#modal-form-battles" data-id="' + item.id + '"><i class="mdi mdi-set-center"></i></a>';
                newRow += '<a title="Chỉnh sửa" class="btn btn-sm active edit-news" href="" name="id" style="color: #4B49AC" data-toggle="modal" data-target="#modal-edit-news" data-id="' + item.id + '"><i class="mdi mdi-pencil"></i></a>' +
                    '<a title="Xóa" class="btn btn-sm active delete-news" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-delete-news" data-id="' + item.id + '"><i class="mdi mdi-delete"></i></a>' +
                    '<a title="Lịch sử" class="btn btn-sm active his-news" href="" name="id" style="color: #f5302e" data-toggle="modal" data-target="#modal-his-news" data-id="' + item.id + '"><i class="mdi mdi-history"></i></a>' +
                    "</td>" +
                    "</tr>";
                $('#idTable_news tbody').append(newRow);
            });

            // setTimeout(calculateTableHeight, 100);
            paginationNews(result);

        }

        window.loadCategory = function () {
            let lookup_id = $("input[name='id-intro']").val();
            let data = {
                id: lookup_id,
            };

            let result = ajaxQuery(config.urlGetCategory, data, 'GET');


            // Tạo một hàm để append các option vào select element
            function appendOptionsToSelect(select, options) {
                // Kiểm tra xem select đã chứa phần tử "-- Chọn --" chưa
                if (select.find('option[value=""]').length === 0) {
                    select.empty();
                    // Thêm phần tử "-- Chọn --" nếu chưa tồn tại
                    select.append($('<option>', {
                        value: "",
                        text: "-- Chọn --",
                    }));
                }

                function sortOptions(options) {
                    var tempArray = JSON.parse(JSON.stringify(options)); // Tạo một bản sao hoàn toàn độc lập của mảng options
                    var map = {};
                    tempArray.forEach(function(option) {
                        map[option.id] = option;
                    });

                    var roots = [];
                    tempArray.forEach(function(option) {
                        if (option.parent_id === null) {
                            roots.push(option);
                        } else {
                            var parent = map[option.parent_id];
                            if (!parent.children) {
                                parent.children = [];
                            }
                            parent.children.push(option);
                        }
                    });

                    function sortChildren(node) {
                        if (node.children) {
                            node.children.sort(function(a, b) {
                                return a.id - b.id;
                            });
                            node.children.forEach(sortChildren);
                        }
                    }
                    roots.forEach(sortChildren);

                    return roots;
                }


                var sortedOptions = sortOptions(options);

                function createOptions(options, select, prefix) {
                    options.forEach(function(option) {
                        var $option = $('<option>', {
                            value: option.id,
                            text: (prefix || '') + option.name,
                        });
                        select.append($option);
                        if (option.children) {
                            createOptions(option.children, select, (prefix || '') + '- ');
                        }
                    });
                }

                // Xóa tất cả các option cũ trừ phần tử "-- Chọn --" nếu có
                select.find('option[value!=""]').remove();

                // Tạo lại các option
                createOptions(sortedOptions, select);
            }


            // Gọi hàm để append các option vào cả hai select element
            appendOptionsToSelect($('#searchFormNews select[name="search_type"]'), result.data);
            appendOptionsToSelect($("#modal-form-news select[name='type']"), result.data);
            appendOptionsToSelect($("#modal-edit-news select[name='type']"), result.data);
        }

        $('.add-modal-new').click(function () {
            clearData();
        })

        $('#btnResetNews').click(function () {
            $("#searchFormNews input[name='search_name']").val('');
            $("#searchFormNews select[name='search_type']").val('').trigger("change");
            $("#searchFormNews select[name='search_status']").val('');
            pageIndex = 1;

            window.loadDataTableNews();
        })

        $('#btnSearchNews').click(function () {
            pageIndex = 1;
            window.loadDataTableNews();
        })

        $('#idTable_news').on('click', '.figure-battles', function () {
            $('#modal-form-battles-add input[name="news_id"]').val($(this).attr('data-id'));
            window.loadDataTableBattles();
        });

        function clearData() {
            $("#modal-form-news input[name='title']").val('');
            $("#modal-form-news select[name='type']").val("");
            $("#modal-form-news textarea[name='description']").val('');
            $("#modal-form-news select[name='status']").val(1);
            $("#modal-form-news img[name='image']").attr('src', '/admin/img/placeholder.png');
            $("#modal-form-news input[name='is_hot']").prop('checked', false);
            $("#modal-form-news input[name='priority']").val('');

            let fncCallback = function () {
                CKEDITOR.instances['content'].setData('');
            };
            CKEDITOR.instances['content'].setData("", fncCallback);

            let fncCallback_des = function () {
                CKEDITOR.instances['news_description_edit'].setData('');
            };
            CKEDITOR.instances['news_description_edit'].setData("", fncCallback_des);

            $("#modal-form-news .show-invalid").remove();
        }


        // $('#idTable_news').find('.scroll-table').on('scroll', function() {
        //     console.log('3453453453')
        //     var tableHeight = $(this).outerHeight(); // Lấy chiều cao của phần table
        //     var scrollTop = $(this).scrollTop(); // Lấy vị trí scroll hiện tại của phần tử
        //     var windowHeight = $(this).outerHeight(); // Lấy chiều cao của cửa sổ hiển thị
        //
        //     // Kiểm tra nếu đã cuộn đến cuối phần table
        //     if (scrollTop + windowHeight >= tableHeight) {
        //         alert('Cuộn đến cuối bảng');
        //     }
        // });

        function calculateTableHeight() {
            let $scrollTable = $('#idTable_news').find('.scroll-table');
            let tableHeight = $scrollTable.prop('scrollHeight');
            let windowHeight = $scrollTable.outerHeight();
            console.log(tableHeight)
            console.log(windowHeight)

            $scrollTable.on('scroll', function () {
                var scrollTop = $(this).scrollTop();

                // Kiểm tra nếu đã cuộn đến cuối phần table
                if (scrollTop + windowHeight >= tableHeight) {
                    pageIndex += 1;

                    if (pageIndex > lastPage) return;
                    window.loadDataTableNews();
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

            if (data.data.last_page == 1) {
                $('#table_paginate_news').html(htmlPanigation);
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

                if (pagination.current_page > 2) {
                    htmlPanigation += "<li class=\"page-item\" aria-current=\"page\"><a class=\"page-link\">1</a></li>";
                }
                if (pagination.current_page > 3) {
                    htmlPanigation += "<li class=\"page-item disabled\"><span class=\"page-link p-custom\">...</span></li>";
                }

                //page
                let page_from = 1;
                let page_to = pagination.last_page;
                for (let i = page_from; i <= page_to; i++) {
                    if (i >= pagination.current_page - 1 && i <= pagination.current_page + 1) {
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
                if (pagination.current_page == pagination.last_page) {
                    htmlPanigation += "<li class=\"page-item disabled\">" +
                        "<span class=\"page-link\" aria-hidden=\"true\">›</span>" +
                        "</li>";
                } else {
                    htmlPanigation += "<li class=\"page-item\">" +
                        "<a class=\"page-link\" aria-hidden=\"true\">›</a>" +
                        "</li>";
                }
                $('#table_paginate_news').html(htmlPanigation);
            }

            $("#table_paginate_news nav ul li a").click(function (e) {
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

                window.loadDataTableNews();
            })
        }
        $("#sel_2").select2();
    });
</script>
