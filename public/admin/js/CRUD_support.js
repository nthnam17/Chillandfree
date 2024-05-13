var config = {};

function setupCRUD(_config) {
    config = _config;
    config['page'] = 0;

    // ### setup csrf-token ajax
    setupCsrfTokenAjax();

    setupSortTable();

    // ### Load data table first
    firstLoadDataTable();

    // ### Event click page number
    setupEventClickPageNumber();

    // #### Event search
    setupEventSearch();

    // ### Event show dialog add new one row data
    setupEventShowDialogAddNew();

    // ### Event add new one row to DB
    setupEventAddNewOneRowDataToDb();

    // ### Event show dialog update one row data
    setupEventShowDialogUpdateOneRowData();

    // ### Event show dialog delete one row
    setupEventShowDialogDeleteOne();

    // ### Event delete one row
    setupEventDeleteOneRowToDb();

    // ### Event reload table
    setupEventReloadTable();

    // setup daterangepicker
    setupDaterangepicker();

    //deleteSetup Popup
    // deleteSetup();

}

function setupTable(_config) {
    config = _config;
    config['page'] = 0;
    // ### Load data table first
    firstLoadDataTable();
}

// ### Auto convert data after update data to view
function setCfgEventHtmlModified(cssSelectorRootElement, convertDataConfig) {
    if (convertDataConfig == null) return;

    var elementsAutoConvertData = $(cssSelectorRootElement + " [group~='autoConvertData']");

    // var selectorElement = $(cssSelectorRootElement);
    // console.log("cssSelectorRootElement ", cssSelectorRootElement)
    // console.log("test show selectorElement ", selectorElement.html())
    // var attrGroup = selectorElement.attr("group");
    // console.log("test show group ", attrGroup)
    // if (attrGroup != null && attrGroup.includes(autoConvertData)) {
    //     console.log("this element is autoConvertData")
    //     console.log("elementsAutoConvertData ", elementsAutoConvertData)
    //     if (elementsAutoConvertData == null) {
    //         elementsAutoConvertData = selectorElement;
    //     } else {
    //         elementsAutoConvertData.push($(cssSelectorRootElement));
    //     }
    // }

    elementsAutoConvertData.on('DOMSubtreeModified', function () {
        var name = $(this).attr("name");
        for (var i = 0; i < convertDataConfig.length; i++) {
            var cfg = convertDataConfig[i];
            if (cfg.name == name) {
                var convertCfg = cfg.convert;
                for (var j = 0; j < convertCfg.length; j++) {
                    var rowConvertCfg = convertCfg[j];
                    var arrSplit = rowConvertCfg.split("->");
                    var strSearch = arrSplit[0];
                    var currentText = $(this).text();
                    if (!strSearch.includes(currentText)) continue;

                    var strReplace = arrSplit[1];
                    // if (strReplace == null || strReplace == '') {
                    //     console.log("ERROR: config not match strSeach->strReplace,class on: '" + rowConvertCfg + "'");
                    // }
                    currentText = currentText.replaceAll(strSearch, strReplace);
                    $(this).text(currentText);

                    if (arrSplit.length > 2) {
                        var strClass = arrSplit[2];
                        if (strClass != null && strClass != '') {
                            $(this).attr("class", strClass);
                        }
                    }
                }
            }

        }
    })
}

function loadDataTable() {
    removeAllRowsDataTable(config.idTableElement);

    let urlList = config.urlList;

    let str_split = config.urlList.split('?');
    if (str_split.length>1) {
        urlList += '&page=' + config.page;

    } else {
        urlList += '?page=' + config.page;
    }

    let queryParamsData = getDataView('#frm-export');
    if (queryParamsData == null) {
        queryParamsData = {};
    }
    queryParamsData['anyField'] = $("input[name='anyField']").val();

    if($('#searchForm').length > 0) {
        queryParamsData = getDataView("#searchForm");
    }

    var dataSearchInContainer = getDataView("#dataSearchContainer");
    $.each(dataSearchInContainer, function(key, value) {
        queryParamsData[key] = value;
    })

    if(getUrlParameter('status')) {
        queryParamsData['status'] = getUrlParameter('status');
    }

    let sort_data = []
    $('#idTable th').each(function() {
        let el = $(this);
        let field = el.attr('name');
        let order = el.attr('order');
        if(!order) return;

        sort_data = [...sort_data, field+'-'+order]
    })
    if(sort_data.length>0) queryParamsData['sort'] = sort_data.toString();
    //page size
    queryParamsData['page_size'] = $("[name='page_size']").val();

    console.log("queryParamsData ", queryParamsData);
    let result = ajaxQuery(urlList, queryParamsData, 'GET');
    console.log("result, ", result)
    let listData = result.data.data.data;

    let stt;
    let totalData = 0;
    let genPagination = true;
    if(listData==undefined) {
        listData = result.data.data;
        totalData = listData.length;
        stt = listData.length;
        genPagination = false;
    } else {
        listData = Object.keys(listData).map(function (key) { return listData[key]; });

        totalData = listData.length;
        stt = result.data.data.to;
    }
    if(listData.length == 0){
        let no_data_html = `<p>Không có kết quả phù hợp !</p>`
        $("#no_data").html(no_data_html);
    }else {
        $("#no_data").empty();
    }



    for (let i = totalData - 1; i >= 0; i--) {
        let data = listData[i];
        let firstRowElement = $(config.idTableElement+" tbody tr").first();
        $(config.idTableElement+" tbody").prepend("<tr id='new' class='state'>" + firstRowElement.html() + "</tr>");
        let id = data.id;
        let state= data.state;
        $("tr[id='new']").attr("id", id);
        $("tr[class='state']").attr("class", state);

        $("tr[id='"+id+"'] td:first-child").text(stt);
        setCfgEventHtmlModified("tr[id='" + id + "']", config.autoConvertData);
        updateDataView("tr[id='" + id + "']", data);
        stt--;
        totalData--;
    }



    //tota task
    if($('#total-task').length > 0) $('#total-task').text(result.data.data.total);

    if(genPagination) generatePagination(result.data);

    if(result.data[0]) {
        $('.card-header').css('display','block');
        $('.card-header').text(result.data[0]);
    }
    $('[data-toggle="tooltip"]').tooltip();

    // setHeightTable();
}

// function setHeightTable() {
//     console.log('setHeightTable');
//     if($('#scroll-table-css').length > 0) {
//         let height_screen = $(document).height();
//         let height_title = $('.content .title').length>0 ? $('.content .title')[0].offsetHeight : 0;
//         let height_topbar = $('.app-header').length>0 ? $('.app-header')[0].offsetHeight : 0;
//         let height_pagination = $('.datatables__info_wrap').length>0 ? $('.datatables__info_wrap')[0].offsetHeight : 0;
//         let height_search_container = $('#dataSearchContainer').length>0 ? $('#dataSearchContainer')[0].offsetHeight + 15 : 0;
//         let searchForm = $('#searchForm').length>0 ? $('#searchForm')[0].offsetHeight : 0;
//         let clearable_input = $('.clearable-input').length>0 ? $('.clearable-input')[0].offsetHeight+16 : 0;
//         let card_header = $('.card .card-header').length>0 ? $('.card .card-header')[0].offsetHeight+16 : 0;
//         let height_table = height_screen - height_title - height_topbar - height_padding
//             - height_pagination - height_search_container - searchForm - clearable_input - card_header - 45;
//         console.log('height_table: ' + height_table);
//         $('#scroll-table-css').css('max-height', height_table+'px');
//     }
// }
function setupEventSearch() {
    $("#btnSearch").click(function (e) {
        console.log("##### Search event #####");
        config.page = 0;
        loadDataTable();

    });
    $("[group~='keyupEvent']").bind('keyup', function (e) {
        if (e.keyCode === 13) {
            console.log("##### Search event #####");
            config.page = 0;
            loadDataTable();
        }
    });

    $("#btn-reset").click(function () {

        config.page = 0;
        resetFormSearch();

        loadDataTable();
    });


    $(".btn-search").click(function () {
        config.page = 0;
        loadDataTable();
    });

    $("#mic_task_search").click(function (e) {
        e.preventDefault();
        $('#showForm').toggle();
        config.page = 0;
        loadDataTable();

    });

    var wto;

    $("[group~='inputChange']").on('change keyup paste', function(e) {
        clearTimeout(wto);
        wto = setTimeout(function() {
            config.page = 0;
            loadDataTable();
        }, 2000);
    });

    $("[group~='selectChange']").on('change', function() {
        config.page = 0;
        loadDataTable();
    });
}

function resetFormSearch() {
    //clear data form
    $("#searchForm").find("[group~='data']").each(function() {
        let tagName = $(this).prop("tagName");
        let name = $(this).attr('name');
        let type = $(this).attr("type");
        if(tagName=='SELECT') {
            $(this).prop("selectedIndex", 0);
            if ($(this).data('select2')) {
                $(this).select2({
                    minimumResultsForSearch: -1
                });
                $(this).select2("val", "");
            } else {
                $(this).val('')
            }
        } else if(tagName=='IMG') {
            $(this).prop("src", "/admin/img/placeholder.png");
        } else if(type=='checkbox') {
            $(this).prop("checked", false);
        } else if(tagName=='TEXTAREA') {
            if(CKEDITOR.instances[name] !== undefined) {
                CKEDITOR.instances[name].setData("");
            } else {
                $(this).val("");
            }
        } else {
            $(this).val("");
        }
    });
}


function setupEventShowDialogAddNew() {
    $(".add-modal").click(function () {
        setUpModal(config.titleModalAdd, 'Thêm mới');
        $('.times_cus_only').prop('disabled', false);
    });
}



function setupEventAddNewOneRowDataToDb() {
    $("#btnAdd").click(function (e) {
        var data = getDataView('form.form-body');
        let result = ajaxQuery(data.id=='' || data.id==undefined ? config.urlAddModelToDb : config.urlUpdateModelToDb, data, 'POST');
        if (result.code == 200) {
            //notify success
            // showAlert(result.message, result.notify, 5000);
            swalSuccess(result.message);

            loadDataTable();

            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });

        } else if (result.code == 401) {
            //notify error
            notifyError(result.message);
        } else {
            if(result.errors==null) {
                notifyError(result.message);
            } else {
                Object.keys(result.errors).forEach(function(key) {
                    //noti
                    //showAlert(result.errors[key], result.notify, 5000);
                    let locationAddValidate = $("#modal-form [name='" + key + "']").parent();
                    $("#modal-form [name='" + key + "']").addClass('invalid');
                    createdInvalid(locationAddValidate, result.errors[key]);
                });
            }
        }
    });
}

// $(document).on('change', '#modal-form input, #modal-form select, #modal-form textarea', function(e) {
//     e.preventDefault();
//     $(this).removeClass('invalid');
//     $(this).parent().find('.show-invalid').remove();

// });

// removeValid();
// function removeValid() {
//     $('#modal-form input').change(function() {
//         $(this).removeClass('invalid');
//     });
//
//     $('input').change(function() {
//         $(this).removeClass('invalid');
//     });
// }

function createdInvalid(locationAppend, text) {
    if($(locationAppend).find('.show-invalid').length > 0) return true;
    let div = document.createElement("div");
    div.className = 'show-invalid';
    div.textContent = text;
    $(locationAppend).append(div);

}


function setupSortTable() {
    const $sortable = $('.sort');

    $sortable.on('click', function(){
        const $this = $(this);
        var asc = $this.hasClass('asc');
        var desc = $this.hasClass('desc');
        $this.removeClass('asc').removeClass('desc');
        if (desc || (!asc && !desc)) {
            $this.addClass('asc');
            $this.attr('order', 'asc');
        } else {
            $this.addClass('desc');
            $this.attr('order', 'desc')
        }
        loadDataTable();

    });
}

function firstLoadDataTable() {
    loadDataTable();
}

function setupCsrfTokenAjax() {
    var csrftoken = $("meta[name='csrf-token']").attr("content");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrftoken
        }
    });
}

function setupEventShowDialogUpdateOneRowData() {
    $(config.idTableElement+' tbody').on('click', '.update-modal', function () {
        setUpModal(config.titleModalEdit, 'Cập nhật');

        $('.times_cus_only').prop('disabled', true);

        self = this;
        let data = {
            "id": $(self).data("id")
        }
        let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
        if (result.code == 200) {
            updateDataView("#modal-form", result.data);
        } else if (result.code == 401) {
            //notify error
            // showAlert(result.message, result.notify, 5000);
            notifyError(result.message);
        }
    });
}

function setupEventShowDialogDeleteOne() {
    $(config.idTableElement+' tbody').on('click', '.deleteDialog', function () {
        // $(".deleteDialog").click(function() {
        self = this;
        $('#delPer').modal('show');
    });
}

function setupEventDeleteOneRowToDb() {
    $(".btnDel").click(function (e) {
        let id = $(self).data("id");

        // call api for delete row in DB
        let data = {
            "id": id,
            "_token": $('meta[name="csrf-token"]').attr('content'),
        };
        let result = ajaxQuery(config.urlDeleteModelToDb, data, 'POST');

        if (result.code == 200) {
            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });
            //notify success
            // showAlert(result.message, result.notify, 5000);
            swalSuccess(result.message);

            loadDataTable();

        } else if (result.code == 401) {
            //notify error
            // showAlert(result.message, result.notify, 5000);
            notifyError(result.message)
        }
    });
}

function setupEventReloadTable() {
    $("#btnReload").click(function (e) {
        loadDataTable();
    });
}

function setupDaterangepicker() {
    $("[group~='daterangepicker']").daterangepicker({
        "timePicker": true,
        "format": 'YYYY-MM-DD HH:mm:ss',
        "drops": "auto",
        singleDatePicker: true,
        showDropdowns: true,
        "timePicker24Hour": true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss',
            "applyLabel": "Áp dụng",
            "cancelLabel": "Hủy",
            "daysOfWeek": ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            "monthNames": ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
            "firstDay": 1
        }
    });
}

function setupEventClickPageNumber() {
    $(config.idTableElement + " #table_paginate nav ul li a").click(function (e) {
        var strPage = $(this).text().trim();
        var iPage;
        if (strPage == '‹' && parseInt(config.page) > 0) {
            iPage = parseInt(config.page) - 1;
        } else if (strPage == '›') {
            iPage = parseInt(config.page) + 1;
        } else {
            iPage = parseInt(strPage);
        }
        config.page = iPage;

        loadDataTable();

    })
}

function generatePagination(data) {
    //set current total
    // let total = 'Tổng ' + data.data.total + ' bản ghi/ ' + data.data.last_page + ' trang';
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


    // $(config.idTableElement + ' .dt-length-records').html(total);
    if(data.data.last_page == 1){
        $(config.idTableElement + ' #table_paginate').html(htmlPanigation);
    }
    else {
        let pagination = data.data;
        if(pagination.last_page <= 5) {
            $(config.idTableElement + ' #table_paginate').html(data.pagination);
        } else {
            //btn more left
            htmlPanigation = "<nav><ul class=\"pagination\">";
            if(pagination.current_page==1) {
                htmlPanigation += "<li class=\"page-item disabled\">" +
                    "<span class=\"page-link\" aria-hidden=\"true\">‹</span>" +
                    "</li>";
            } else {
                htmlPanigation += "<li class=\"page-item\">" +
                    "<a class=\"page-link\" aria-hidden=\"true\">‹</a>" +
                    "</li>";
            }

            // if(pagination.last_page>5) {
            if(pagination.current_page > 2) {
                htmlPanigation += "<li class=\"page-item\" aria-current=\"page\"><a class=\"page-link\">1</a></li>";
            }
            if(pagination.current_page > 3) {
                htmlPanigation += "<li class=\"page-item disabled\"><span class=\"page-link p-custom\">...</span></li>";
            }
            // }

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

            // if(pagination.last_page>5) {

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
            $(config.idTableElement + ' #table_paginate').html(htmlPanigation);
        }

        $(config.idTableElement + " #table_paginate nav ul li a").removeAttr("href");
    }

    setupEventClickPageNumber();
    generateChooseRecord(data.data.current_page, data.data.per_page);

}

function generateChooseRecord(page_index, page_size) {
    let htmlPanigation = "<button class='btn btn-sm btn-primary active my-btn-default pd815 btn_go_page'>Đi</button>"
        + "<div class='box-slot'><fieldset aria-hidden=\"true\"><legend style=\"width: 30.75px;\"><span>​</span></legend></fieldset>"
        + "<div class='slot'><label class='v-label'>Trang</label><input class='goto_page' value='"+page_index+"' name='page_index'></div></div>"
        + "<div class='box-slot mr-3'><fieldset aria-hidden=\"true\"><legend style=\"width: 42.75px;\"><span>​</span></legend></fieldset>"
        + "<div class='slot'><label class='v-label'>Bản ghi</label>"
        + "<select class=\"select_cus\" name=\"page_size\">";
    let arr = [10, 20, 50, 100, 150, 200, 300, 500, 1000, 2000, 3000, 5000, 1000];
    for(let i=0; i<arr.length; i++) {
        let selected = arr[i]==page_size ? 'selected' : '';
        htmlPanigation += "<option "+selected+" value='"+arr[i]+"'>"+arr[i]+"</option>";
    }
    htmlPanigation += "</select></div></div>";

    $(config.idTableElement + ' #table_paginate').append(htmlPanigation);
    $('.select_cus').select2();

    //add event
    $(config.idTableElement + " .btn_go_page").click(function (e) {
        let page_index = $("[name='page_index']").val();
        config.page = page_index;
        loadDataTable();
    })
}

function setUpModal(title, titleBtn) {
    if($('.nav-pills').length > 0) {
        setActiveTab('.tabbable-custom');
    }
    //edit title form
    $('#modal-form .modal-title strong').html(title);
    //edit button form
    if($("#btnAdd").contents().length > 0) {
        $("#btnAdd").contents().last()[0].textContent = titleBtn;
    }

    //clear data form
    $(".form-body").find("[group~='data']").each(function() {
        let tagName = $(this).prop("tagName");
        let name = $(this).attr('name');
        let type = $(this).attr("type");
        if(tagName=='SELECT') {
            $(this).prop("selectedIndex", 0);
            if ($(this).data('select2')) {
                $(this).select2({
                    minimumResultsForSearch: -1
                });
                $(this).select2("val", "");
            }
        } else if(tagName=='IMG') {
            $(this).prop("src", "/admin/img/placeholder.png");
        } else if(type=='checkbox') {
            $(this).prop("checked", false);
        } else if(tagName=='TEXTAREA') {
            if(CKEDITOR.instances[name] !== undefined) {
                CKEDITOR.instances[name].setData("");
            } else {
                $(this).val("");
            }
        } else {
            $(this).val("");
        }
    });

    $(".form-body .show-invalid").remove();
    $(".form-body").find(".invalid").removeClass('invalid');

    if($('.dropzone').length > 0) {
        Dropzone.forElement('.dropzone').removeAllFiles(true)
    }

    //clear photo gallery if exist
    $(".photo-gallery-vi div").remove();
    $(".photo-gallery-en div").remove();
    $(".reset-gallery-vi").addClass("hidden");
    $(".reset-gallery-en").addClass("hidden");

    if($(".select-tags").length) {
        $(".select-tags").val(new Array()).trigger("change");
    }
    if($(".list-gallery .col-md-4").length) {
        $('.list-gallery').children().remove();
    }
}

// function setUpModal(title) {
//     if($('.nav-tabs').length > 0) {
//         setActiveTab('.tabbable-custom');
//     }
//     //edit title form
//     $('#modal-form .modal-title strong').html(title);
//     //edit button form
//     var elementExists = document.getElementById("btnAdd");
//     if(elementExists != null) {
//         $("#btnAdd").contents().last()[0].textContent = title;
//     }
//     var elementExists1 = document.getElementById("btnAddPackage");
//     if(elementExists1 != null) {
//         $("#btnAddPackage").contents().last()[0].textContent = title;
//     }
//
//     $(".form-body").find("[group~='data']").each(function() {
//         $(this).val("");
//     });
// }

function removeAllRowsDataTable(cssSelectorTable) {
    $(cssSelectorTable + " tbody tr").not("[id='templateRow']").remove();
}

function getDataForm() {
    return $('.form-body').serializeArray().reduce(function(obj, item) {
        if($('select[name="'+ item.name +'"]:visible').length > 0) {
            obj[item.name] = item.value;
            return obj;
        }

    }, {});
}


// load data skill
function loadDataViewSkill(lstData) {
    $("#table-skill tbody tr").not("[id='templateRow']").remove();
    let count = 1;
    $.each(lstData, function(idx, data) {
        let firstRowElement = $("#table-skill tbody tr").first();
        let newRow = $("<tr>" + firstRowElement.html() + "</tr>");
        let _id = count;
        count++;
        newRow.attr("id", _id);
        newRow.find("[group~='data']").each(function() {
            let tagName = $(this).prop("tagName");
            let name = $(this).attr('name');
            if (name === 'stt') {
                $(this).html(_id);
            } else {
                if (tagName == 'IMG') {
                    let src = $(this).attr("src");
                    $(this).attr("src", data[name]);
                } else {
                    $(this).html(data[name]);
                }
            }
        });

        newRow.find("[name='data-id']").attr('data-id', data.id);

        $("#table-skill tbody").append(newRow);
    });
}


// load data nhân viên theo phòng ban
function loadDataViewEmployment(lstData){
    let count = 1;
    $.each(lstData, function(idx, data) {
        let firstRowElement = $("#table-empt-derpartment tbody tr").first();
        let newRow = $("<tr>" + firstRowElement.html() + "</tr>");
        let _id = count;
        count++;
        newRow.attr("id", _id);
        newRow.find("[group~='data']").each(function() {
            let tagName = $(this).prop("tagName");
            let name = $(this).attr('name');
            if (name === 'stt') {
                $(this).html(_id);
            } else {
                if (tagName == 'IMG') {
                    let src = $(this).attr("src");
                    $(this).attr("src", data[name]);
                } else {
                    $(this).html(data[name]);
                }
            }
        });

        newRow.find("[name='data-id']").attr('data-id', data.emp_id);

        $("#table-empt-derpartment tbody").append(newRow);
    });
}



function panigationViewDetail(dataPanigation,id){
    // Tạo phân trang
    let pagination = dataPanigation;
    let totalPages = pagination.last_page;
    let currentPage = pagination.current_page;
    let total = pagination.total

    let paginationHtml = '<ul class="pagination pagination-cus">';
    paginationHtml += '<span class="totla-record">Tổng số bản ghi:' + total + '</span>';
    for (let i = 1; i <= totalPages; i++) {
        if (i == currentPage) {
            paginationHtml += '<li class="page-item active"><a class="page-link page-number" data-id="' + id + '">' + i + '</a></li>';
        } else {
            paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '">' + i + '</a></li>';
        }
    }
    paginationHtml += '</ul>';

    $("#pagination-container").html(paginationHtml);
}


//Event delete record popup
function deleteSetup($id,$url){
    data['id'] = $id;
    let result = ajaxQuery(config.urlDeleteModelToDb, data, 'POST');
    if (result.code == 200) {
        swalSuccess(result.message);
        loadDataTable();
        $("[data-dismiss=modal]").trigger({type: "click"});
    } else {
        notifyError(result.message);
    }
}



function showErrorMessage(field, message) {
    const $errorElement = $(`.error-message[data-field="${field}"]`);
    if (message) {
        $errorElement.show().html(`<span>${message}</span>`);
    } else {
        $errorElement.hide();
    }
}

function validateUpdatePopup(errors) {
    for (const field in errors) {
        showErrorMessage(field, errors[field][0]);
    }
}



// loadata table task của Ano khi được phân công nhiệm vụ
function loadDataListTaskEmploe(dataLoad) {
    let data = {
        'name':dataLoad.name,
        'status':dataLoad.status,
        'page':dataLoad.page,
    }
    let result = ajaxQuery("/admin/project/getListTaskProjectEmploy",data, 'GET');
    if (result.code == 200) {
        let rowsPerPage = result.data.data.per_page;
        let currentPage = dataLoad.page ? dataLoad.page : 1;
        let count = (currentPage - 1) * rowsPerPage + 1;
        $("#table-listTask tbody tr").not("[id='templateRow']").remove();
        $.each(result.data.data.data, function (idx, data) {
            let firstRowElement = $("#table-listTask tbody tr").first();
            let newRow = $("<tr>" + firstRowElement.html() + "</tr>");
            let _id = count;
            count++;
            newRow.attr("id", _id);
            newRow.find("[group~='data']").each(function () {
                let tagName = $(this).prop("tagName");
                let name = $(this).attr('name');
                if (name === 'stt') {
                    $(this).html(_id);
                } else {
                    if (tagName == 'IMG') {
                        let src = $(this).attr("src");
                        $(this).attr("src", data[name]);
                    } else {
                        $(this).html(data[name]);
                    }
                }
            });
            newRow.find("[name='data-id']").attr('data-id', data.id);
            newRow.find("[name='data-id']").attr('data-kpi', data.image_remaining);
            newRow.find("[name='data-id']").attr('data-pass-kpi', data.image_pass_task);
            newRow.find("[name='data-id']").attr('data-reason-reword', data.reson_reword);
            newRow.find("[name='data-id']").attr('data-emp-id', data.emp_id);
            newRow.find("[name='data-id']").attr('data-task', data.task_id);
            newRow.find("[name='data-id']").attr('data-date-assign', data.date_assign);
            newRow.find("[name='data-id']").attr('data-deadline-emp', data.deadline_emp);
            newRow.find("[name='data-id']").attr('data-im-employ-transimit', data.count_img_employ_transimit);
            newRow.find("[name='data-id']").attr('data-count-img-task-emp', data.count_img_task_emp);
            newRow.find("[name='data-id']").attr('data-review-id', data.review_user_id);
            newRow.find("[name='data-id']").attr('data-status-value', data.status);


            $("#table-listTask tbody").append(newRow);
        });
        panigationCustomerOnly(result.data.data)
        $("#table-listTask tbody tr").each(function() {
            const statusValue = $(this).find("[name='status']").text();
            $(this).find("td .action_cus").hide();
            $(this).find("td .show-reason-reword").hide();
            //set color status
            if(statusValue == 1){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-primary');
                $(this).find("td span[name='status']").text('Working');
                $(this).find("td .action_cus").show();
            }else if(statusValue == 2 || statusValue == 6 || statusValue == 9){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-warning');
                $(this).find("td span[name='status']").text('Reviewing');
            }else if(statusValue == 3 || statusValue == 8){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-success');
                $(this).find("td span[name='status']").text('Complete');
            }else if(statusValue == 5){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-danger');
                $(this).find("td span[name='status']").text('Close');
            }else{
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-danger');
                $(this).find("td span[name='status']").text('Rework');

                $(this).find("td .action_cus").show();
                $(this).find("td .show-reason-reword").show();
            }
        });
    } else{
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
}


// loadata table task của review khi được phân công nhiệm vụ
function loadDataListTaskEmploeReview(dataLoad) {
    let data = {
        'name':dataLoad.name,
        'status':dataLoad.status,
        'page':dataLoad.page,
    }
    console.log(data);
    let result = ajaxQuery("/admin/project/getListTaskProjectReview",data, 'GET');
    if (result.code == 200) {
        let rowsPerPage = result.data.data.per_page;
        let currentPage = dataLoad.page ? dataLoad.page : 1;
        let count = (currentPage - 1) * rowsPerPage + 1;
        $("#table-listTask-review tbody tr").not("[id='templateRow']").remove();
        $.each(result.data.data.data, function (idx, data) {
            let firstRowElement = $("#table-listTask-review tbody tr").first();
            let newRow = $("<tr>" + firstRowElement.html() + "</tr>");
            let _id = count;
            count++;
            newRow.attr("id", _id);
            newRow.find("[group~='data']").each(function () {
                let tagName = $(this).prop("tagName");
                let name = $(this).attr('name');
                if (name === 'stt') {
                    $(this).html(_id);
                } else {
                    if (tagName == 'IMG') {
                        let src = $(this).attr("src");
                        $(this).attr("src", data[name]);
                    } else {
                        $(this).html(data[name]);
                    }
                }
            });
            newRow.find("[name='data-id']").attr('data-id', data.id);
            newRow.find("[name='data-id']").attr('data-kpi', data.image_remaining);
            newRow.find("[name='data-id']").attr('data-pass-kpi', data.image_pass_task);
            newRow.find("[name='data-id']").attr('data-reason-reword', data.reson_reword);
            newRow.find("[name='data-id']").attr('data-emp-id', data.emp_id);
            newRow.find("[name='data-id']").attr('data-task', data.task_id);
            newRow.find("[name='data-id']").attr('data-date-assign', data.date_assign);
            newRow.find("[name='data-id']").attr('data-deadline-emp', data.deadline_emp);
            newRow.find("[name='data-id']").attr('data-im-employ-transimit', data.count_img_employ_transimit);
            newRow.find("[name='data-id']").attr('data-count-img-task-emp', data.count_img_employ_complete);
            newRow.find("[name='data-id']").attr('data-review-id', data.review_user_id);
            newRow.find("[name='data-id']").attr('data-status-value', data.status);
            newRow.find("[name='data-id']").attr('data-projetc_id', data.project_id);


            $("#table-listTask-review tbody").append(newRow);
        });
        panigationCustomerOnly(result.data.data)
        $("#table-listTask-review tbody tr").each(function() {
            const statusValue = $(this).find("[name='status']").text();
            $(this).find("td .action_review").hide();
            $(this).find("td .show-reason-reword").hide();
            //set color status
            if(statusValue == 1){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-primary');
                $(this).find("td span[name='status']").text('Working');
            }else if(statusValue == 2 || statusValue == 6 || statusValue == 9){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-warning');
                $(this).find("td span[name='status']").text('Reviewing');
                $(this).find("td .action_review").show();
            }else if(statusValue == 3 || statusValue == 8){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-success');
                $(this).find("td span[name='status']").text('Complete');
            }else if(statusValue == 5){
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-danger');
                $(this).find("td span[name='status']").text('Close');
            }else{
                $(this).find("td span[name='status']").removeClass();
                $(this).find("td span[name='status']").addClass('badge badge-danger');
                $(this).find("td span[name='status']").text('Rework');
            }
        });
    } else{
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
}


// loadData điểm danh
// function loadDataListAttendance(data) {
//     let fillter = {
//         'name_att': data.emp_id,
//         'team_id': data.team_id,
//         'type_att': data.type_att,
//         'date_att': data.date,
//     }
//     let result = ajaxQuery("/admin/attendance/list", fillter, 'GET');
//     console.log(result, 'resultresultresultresult');
//     if (result.code == 200) {
//         let _id = 1;
//         $("#example tbody tr").not("[id='templateRow']").remove();
//         $.each(result.data, function (idx, data) {
//             let firstRowElement = $("#example tbody tr").first();
//             let newRow = $("<tr>" + firstRowElement.html() + "</tr>");
//             newRow.attr("id", _id);
//             newRow.find("[group~='data']").each(function () {
//                 let tagName = $(this).prop("tagName");
//                 let name = $(this).attr('name');
//                 if (name === 'stt') {
//                     $(this).html(_id);
//                 } else {
//                     if (tagName == 'IMG') {
//                         let src = $(this).attr("src");
//                         $(this).attr("src", data[name]);
//                     } else {
//                         $(this).html(data[name]);
//                     }
//                 }
//             });
//             newRow.find("[name='id']").attr('data-id', data.id);
//             $("#example tbody").append(newRow);
//             _id++;
//         });
//     } else {
//         showAlert(result.message, result.notify, 5000);
//     }
// }
function loadDataListAttendance(data) {
    console.log(1111);
    let field_data = {
        'name_att': data.emp_id,
        'team_id': data.team_id,
        'type_att': data.type_att,
        'date_att': data.date,
    };
    let result = ajaxQuery("/admin/attendance/list", field_data, 'GET');
    if (result.code == 200) {
        let table = $("#attendance-table").DataTable({
            destroy: true,
            searching: false,
            lengthChange: false,
            info: false,
            language: {
                emptyTable: "Không có kết quả phù hợp",
                paginate: {
                    previous: '<span class="page-link" aria-hidden="true">‹</span>',
                    next: '<a class="page-link" aria-hidden="true">›</a>'
                }
            }
        });
        table.clear();
        let _id = 1;

        $.each(result.data, function (idx, data) {
            let action =  ` <a title="Chỉnh sửa" class="btn btn-sm  active list-tab-attendens-modal list-tab-attendens-modal" href=""
                                           style="color: #57B657" data-id = ${data.id}
                                           data-toggle="modal"
                                           data-target="#modal-customer-tab"><i class="fa fa-bars"aria-hidden="true"></i>
                           </a>`;
            table.row.add([
                _id,
                data.emp_name,
                data.team_name,
                data.type_convert,
                data.date,
                action,
            ]);
            _id++;
        });

        table.draw();
    } else {
        showAlert(result.message, result.notify, 5000);
    }
}




function panigationCustomerOnly(dataPanigation, id) {
    // Tạo phân trang
    let pagination = dataPanigation;
    let totalPages = pagination.last_page;
    let currentPage = pagination.current_page;
    let total = pagination.total;

    let paginationHtml = '<ul class="pagination pagination-cus">';

    if (totalPages <= 5) {
        // Hiển thị tất cả các trang nếu tổng số trang nhỏ hơn hoặc bằng 5
        for (let i = 1; i <= totalPages; i++) {
            if (i == currentPage) {
                paginationHtml += '<li class="page-item active"><a class="page-link page-number" data-id="' + id + '" data-page="' + i + '">' + i + '</a></li>';
            } else {
                paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '" data-page="' + i + '">' + i + '</a></li>';
            }
        }
    } else {
        if (currentPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '" data-page="' + (currentPage - 1) + '"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
        }
        // Hiển thị 5 trang và dấu ba chấm
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);

        if (startPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '" data-page="1">1</a></li>';
            if (startPage > 2) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i == currentPage) {
                paginationHtml += '<li class="page-item active"><a class="page-link page-number" data-id="' + id + '" data-page="' + i + '">' + i + '</a></li>';
            } else {
                paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '" data-page="' + i + '">' + i + '</a></li>';
            }
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '" data-page="' + totalPages + '">' + totalPages + '</a></li>';
        }
    }



    if (currentPage < totalPages) {
        paginationHtml += '<li class="page-item"><a class="page-link page-number" data-id="' + id + '" data-page="' + (currentPage + 1) + '"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
    }

    paginationHtml += '</ul>';
    $("#pagination-container").html(paginationHtml);
}







