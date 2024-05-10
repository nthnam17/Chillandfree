var config = {};

function setupCRUD(_config) {
    config = _config;
    config['page'] = 0;

    // ### setup csrf-token ajax
    setupCsrfTokenAjax();

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

    // ### Event show dialog update one row data
    setupEventShowDialogViewOneRowData();

    // ### Event show dialog delete one row
    setupEventShowDialogDeleteOne();

    // ### Event delete one row
    setupEventDeleteOneRowToDb();

    // ### Event reload table
    setupEventReloadTable();

    // setup daterangepicker
    setupDaterangepicker();

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
                    if (!currentText.includes(strSearch)) continue;

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
    console.log("Call loadDataTable()")
    removeAllRowsDataTable(config.idTableElement);

    let urlList = config.urlList + '?page=' + config.page;

    let queryParamsData = getDataView('#frm-export');
    if (queryParamsData == null) {
        queryParamsData = {};
    }
    queryParamsData['anyField'] = $("input[name='anyField']").val();
    if ($('#searchForm').length > 0) {
        queryParamsData = getDataView("#searchForm");
    }

    var dataSearchInContainer = getDataView("#dataSearchContainer");
    $.each(dataSearchInContainer, function (key, value) {
        queryParamsData[key] = value;
    })
    for (var i = 0; i < dataSearchInContainer.length; i++) {

    }

    let result = ajaxQuery(urlList, queryParamsData, 'GET');
    let listData = result.data.data.data;
    if (listData == undefined || listData.length == 0) {
        generatePagination(result.data);
        return;
    }
    let totalData = listData.length;

    for (let i = totalData - 1; i >= 0; i--) {
        let data = listData[i];
        let firstRowElement = $(config.idTableElement + " tbody tr").first();

        $(config.idTableElement + " tbody").prepend("<tr id='new'>" + firstRowElement.html() + "</tr>");
        let id = data.id;
        $("tr[id='new']").attr("id", id);
        $("tr[id='" + id + "'] td:first-child").text(totalData);
        setCfgEventHtmlModified("tr[id='" + id + "']", config.autoConvertData);
        updateDataView("tr[id='" + id + "']", data);
        if(config.roleId !== '' || config.roleId !== undefined) {
            reChangeTable(config.roleId)
        }
        totalData--;
    }
    generatePagination(result.data);


}

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
    $(".btn-search").click(function () {
        config.page = 0;
        loadDataTable();
    });

    $("#btn-reset").click(function () {

        config.page = 0;
        resetFormSearch();

        loadDataTable();
    });

    // $("[group~='keyupEvent']").on('input',function(e){
    //     config.page = 0;
    //     loadDataTable();
    // });
}

function resetFormSearch() {
    //clear data form
    $("#searchForm").find("[group~='data']").each(function () {
        let tagName = $(this).prop("tagName");
        let name = $(this).attr('name');
        let type = $(this).attr("type");
        if (tagName == 'SELECT') {
            $(this).prop("selectedIndex", 0);
            if ($(this).data('select2')) {
                $(this).select2({
                    minimumResultsForSearch: -1
                });
                $(this).select2("val", "");
            } else {
                $(this).val('')
            }
        } else if (tagName == 'IMG') {
            $(this).prop("src", "/admin/img/placeholder.png");
        } else if (type == 'checkbox') {
            $(this).prop("checked", false);
        } else if (tagName == 'TEXTAREA') {
            if (CKEDITOR.instances[name] !== undefined) {
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
        clearModalData();
        setUpModal(config.titleModalAdd);
    });
}

function clearModalData() {
    $('#modal-form input[name="file_getData"]').val('');
}


function setupEventAddNewOneRowDataToDb() {


    $("#btnAdd").click(function (e) {
        let lst__file = [];
        let lst__phase_name_vi = [];
        let lst__phase_name_en = [];
        if ($(".list-gallery__phase .col-md-3").length) {
            $('.list-gallery__phase .col-md-3').each(function (i, e) {
                let input = $(this).find('input[type="text"][name="file"]');
                let phaseInputVi = $(this).find('input[type="text"][name="name_phase_vi"]');
                let phaseInputEn = $(this).find('input[type="text"][name="name_phase_en"]');
                lst__file.push(input.val());
                lst__phase_name_vi.push(phaseInputVi.val());
                lst__phase_name_en.push(phaseInputEn.val());
            });
        }
        var data = getDataView('form.form-body');
        data['lst__file'] = lst__file.toString();
        data['lst__phase_name_vi'] = lst__phase_name_vi.toString();
        data['lst__phase_name_en'] = lst__phase_name_en.toString();
        let result = ajaxQuery(data.id == '' || data.id == undefined ? config.urlAddModelToDb : config.urlUpdateModelToDb, data, 'POST');
        if (result.code == 200) {
            //notify success
            showAlert(result.message, result.notify, 5000);

            loadDataTable();

            //close modal
            $("[data-dismiss=modal]").trigger({type: "click"});
            window.location.reload();
        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
        } else {
            if (result.errors == null) {
                showAlert(result.message, result.notify, 5000);
            } else {
                Object.keys(result.errors).forEach(function (key) {
                    //noti
                    showAlert(result.errors[key], result.notify, 5000);
                });
            }
        }

    });
}

function firstLoadDataTable() {
    console.log("##### init data table #####")
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
    $(config.idTableElement + ' tbody').on('click', '.update-modal', function () {
        
        setUpModal(config.titleModalEdit);
        self = this;
        let data = {
            "id": $(self).data("id")
        }
        let result = ajaxQuery(config.urlGetModelFromDb, data, 'POST');
        if (result.code == 200) {
            if ($(".list-gallery__phase").length) {
                let namePhase_vi =  result.data['name_page_vi']
                let namePhase_en =  result.data['name_page_en']
                let lst__file = result.data['lst_file'];
                if (lst__file != null && lst__file !== "" ) {
                    let arrayFile = lst__file.split(',')
                    let lst_namePhase_vi = namePhase_vi.split(',')
                    let lst_namePhase_en = namePhase_en.split(',')
                    for (let i = 0; i < arrayFile.length; i++) {
                        appendFileToList('eleImage',arrayFile[i],lst_namePhase_vi[i],lst_namePhase_en[i]);
                    }
                }
            }
            updateDataView("#modal-form", result.data);
        } else if (result.code == 401) {
            // notify error
            showAlert(result.message, result.notify, 5000);
        }

    });
}

function setupEventShowDialogViewOneRowData() {
    $(config.idTableElement + ' tbody').on('click', '.view_detail', function () {
        setUpModal('Chi tiết');
        self = this;
        let data = {
            "id": $(self).data("id")
        };
        let result = ajaxQuery(config.urlGetModelFromDb, data, 'POST');
        if (result.code == 200) {
            $('#modal-form').find("[group*='data']").attr('disabled', true);
            $('.btnChoose').css('display', 'none');
            $('.btn_remove_image').css('display', 'none');
            $('#btnAdd').hide();
            updateDataView("#modal-form", result.data);
            $('.btn.btn-danger.my-btn-default[data-dismiss="modal"], .close[data-dismiss="modal"]').on('click', function () {
                reverseStyles();
            });

        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
        }
    });
}
function reverseStyles() {
    // Enable elements
    $('#modal-form').find("[group*='data']").attr('disabled', false);

    // Show elements
    $('.btnChoose').css('display', 'block');
    $('.btn_remove_image').css('display', 'block');
    $('#btnAdd').show();
}

function setupEventShowDialogDeleteOne() {
    $(config.idTableElement + ' tbody').on('click', '.deleteDialog', function () {
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
            $("[data-dismiss=modal]").trigger({type: "click"});

            //notify success
            showAlert(result.message, result.notify, 5000);

            loadDataTable();

        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
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

        if (strPage == '‹' && config.page > 0) {
            iPage = config.page - 1;
        } else if (strPage == '›') {
            iPage = config.page + 1;
        } else {
            iPage = parseInt(strPage);
        }
        config.page = iPage;
        console.log(iPage)
        loadDataTable();
    })
}

function generatePagination(data) {

    var panigation_cus = `<nav>
        <ul class="pagination">
            <li class="page-item disabled" aria-disabled="true" aria-label="pagination.previous">
                 <span class="page-link">‹</span>
             </li>
                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <li class="page-item">
                 <span class="page-link">›</span>
            </li>
        </ul>
    </nav>`
    //set current total
    let total = 'Tổng ' + data.data.total + ' đối tượng/ ' + data.data.last_page + ' trang';
    $(config.idTableElement + ' .dt-length-records').html(total);
    if (data.pagination == '') {
        $(config.idTableElement + ' #table_paginate').html(panigation_cus);
    } else {
        $(config.idTableElement + ' #table_paginate').html(data.pagination);
    }
    // $(config.idTableElement + ' #table_paginate').html(data.pagination);
    $(config.idTableElement + " #table_paginate nav ul li a").removeAttr("href");
    setupEventClickPageNumber();
}

function setUpModal(title) {
    if ($('.nav-tabs').length > 0) {
        setActiveTab('.tabbable-custom');
    }
    //edit title form
    $('#modal-form .modal-title strong').html(title);
    //edit button form
    if ($("#btnAdd").contents().length <= 0) return;
    $("#btnAdd").contents().last()[0].textContent = title;

    //clear data form
    $(".form-body").find("[group~='data']").each(function () {
        let tagName = $(this).prop("tagName");
        let name = $(this).attr('name');
        let type = $(this).attr("type");
        if (tagName == 'SELECT') {
            $(this).prop("selectedIndex", 0);
            if ($(this).data('select2')) {
                $(this).select2({
                    minimumResultsForSearch: -1
                });
                $(this).select2("val", "");
            }
        } else if (tagName == 'IMG') {
            $(this).prop("src", "/admin/img/placeholder.png");
        } else if (type == 'checkbox') {
            $(this).prop("checked", false);
        } else if (tagName == 'TEXTAREA') {
            if (CKEDITOR.instances[name] !== undefined) {
                CKEDITOR.instances[name].setData("");
            } else {
                $(this).val("");
            }
        } else {
            $(this).val("");
        }
    });

    //clear photo gallery if exist
    $(".photo-gallery-vi div").remove();
    $(".photo-gallery-en div").remove();
    $(".reset-gallery-vi").addClass("hidden");
    $(".reset-gallery-en").addClass("hidden");

    if($(".list-gallery .col-md-3").length) {
        $('.list-gallery').children().remove();

    }
    // if($(".list-gallery__phase .col-md-3").length) {
    //     $('.list-gallery__phase').children().remove();
    // }
}

function removeAllRowsDataTable(cssSelectorTable) {
    $(cssSelectorTable + " tbody tr").not("[id='templateRow']").remove();
}

function getDataForm() {
    return $('.form-body').serializeArray().reduce(function (obj, item) {
        if ($('select[name="' + item.name + '"]:visible').length > 0) {
            obj[item.name] = item.value;
            return obj;
        }

    }, {});
}
