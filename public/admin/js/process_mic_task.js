const TITLE_MODAL_EDIT = "Chỉnh sửa nhiệm vụ";
const TITLE_MODAL_ADD = "Gửi duyệt";
const URL_GET_MODEL_FROM_DB = "/admin/mic_task/get";
const URL_ADD_MODEL_DB = "/admin/mic_task/add";
const URL_UPDATE_MODEL_DB = "/admin/mic_task/edit";
const URL_UPDATE_MODEL_HANDING_PROCESSING = "/admin/mic_task/handing_processing";
const URL_UPDATE_MODEL_HANDING_PROCESSING_GROUP = "/admin/mic_task/handing_processing_group";
const URL_UPDATE_MODEL_DEPARTMENT_GROUP = "/admin/mic_task/department_group";
const URL_PROCESS_TASK_ADD = "/admin/mic_task/add_process_task";
const URL_APPROVE_COMPLETE = "/admin/mic_task/approve_complete";
const URL_APPROVE_PROCESSING = "/admin/mic_task/approve_processing";
const URL_SEND_REPORT = "/admin/mic_task/send_report";
const URL_APPROVE_COMPLETE_GROUP = "/admin/mic_task/approve_complete_group";
const URL_RETURN_TASK_GROUP = "/admin/mic_task/return_task_group";
const URL_PLEASE_EXTEND = "/admin/mic_task/please_extend";
const URL_RENEWAL_APPROVAL = "/admin/mic_task/renewal_approval";
const VAL_OPTION_MANUALLY = 'manually';
const VAL_POST_DRAFT = 'Đăng dự thảo VBQPPL lên website để xin ý kiến nhân dân';
const VAL_APPRAISAL = 'Thẩm định dự thảo VBQPPL';



//add mic task
$("#btnAddCustom").click(function () {
    if($('#modal-form').find('.invald').length > 0) return;
    // validate type_task
    if( $("select[name='type_task']").val() == 0){
        $('#err-type-task').show();
    }else {
        $('#err-type-task').hide();
    }
    //validate asigner_id
    if( $("select[name='asigner_id']").val() == 0){
        $('#asigner-err').show();
    }else {
        $('#asigner-err').hide();
    }
    //validate group_id
    if( $("select[name='asigner_id']").val() == 0){
        $('#err-group_id').show();
    }else {
        $('#err-group_id').hide();
    }

    //validate task_department_id
    if( $("select[name='task_department_id']").val() == 0){
        $('#err-department_id').show();
    }else {
        $('#task_department_id').hide();
    }
    var data = getDataView('form.form-body');
    data['check_deadline'] = $('input[name="check_deadline"]:checked').val();
    data['lst_attach'] = arrFile;
    //data landmark
    let tr_landmark = $("#table_landmark tbody tr").not("[id='templateRowLandmark']").length;
    let data_landmark = [];
    if(tr_landmark > 0) {
        $("#table_landmark tbody tr").not("[id='templateRowLandmark']").each(function() {
            let obj_landmark = {};
            $(this).find("[group~='data']").each(function () {
                let name = $(this).attr('name');
                obj_landmark[name] = $(this).html().trim();
            });
            data_landmark.push(obj_landmark);
        });
    }
    console.log(data_landmark);
    data['data_landmark'] = data_landmark;
    //data file
    let tr_file = $("#table_file tbody tr").not("[id='templateRowFile']").length;
    let data_file = [];
    if(tr_file > 0) {{
        $("#table_file tbody tr").not("[id='templateRowFile']").each(function() {
            let obj_file = {};
            let name = $(this).find("td:nth-child(2) a").text();
            let file = $(this).find("td:nth-child(2) a").attr('href');
            obj_file['name'] = name;
            obj_file['name_response'] = file;
            console.log(name);
            data_file.push(obj_file);
        });
    }}
    data['lst_attach'] = data_file;
    let result = ajaxQuery(data.id=='' || data.id==undefined ? URL_ADD_MODEL_DB : URL_UPDATE_MODEL_DB, data, 'POST');

    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);
        loadDataTable();
        console.log(result);
        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });
        // $( ".close" ).click(function() {
        //     alert( "Handler for .click() called." );
        // });


        $(this).attr('disabled', true);
    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    } else {
        if(result.errors==null) {
            showAlert(result.message, result.notify, 5000);
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
// group by setor
function groupBySector(){
    $("#asigner_idBySector").change(function () {
        var id = this.value;
        data['id'] = id;
        let result = ajaxQuery('/admin/groups/groups_by_user_leader', data, 'POST');
        if (result.code == 200) {
            $("select[name='group_id']").html("<option value=''>" + '--Chọn--' + "</option>");
            $.each(result.data, function(key, value){
                $("select[name='group_id']").append(
                    "<option value=" + value.id + ">" + value.name + "</option>"
                );
            });
        } else if (result.code == 401) {
            showAlert(result.message, result.notify, 5000);
        }
    });
}
//check tồn tại đơn vị chủ trì
function group_combinationByGroup(){
    $("select[name='group_id']").change(function () {
        var id = this.value;
        data['id'] = id;
        let result = ajaxQuery('/admin/groups/groups_exist', data, 'POST');
        if (result.code == 200) {
            $("select[name='group_combination']").html('');
            $.each(result.data, function(key, value){
                $("select[name='group_combination']").append(
                    "<option value=" + value.id + ">" + value.name + "</option>"
                );
            });
        } else if (result.code == 401) {
            showAlert(result.message, result.notify, 5000);
        }
    });
}
// check tồn tại phòng ban chủ trì
function department_group(){
    $("select[name='department_id']").change(function () {
        var id = this.value;
        data['id'] = id;
        let result = ajaxQuery('/admin/groups/department_exist', data, 'POST');
        if (result.code == 200) {
            $("select[name='department_combination_id']").html('');
            $.each(result.data, function(key, value){
                $("select[name='department_combination_id']").append(
                    "<option value=" + value.id + ">" + value.name + "</option>"
                );
            });
        } else if (result.code == 401) {
            showAlert(result.message, result.notify, 5000);
        }
    });
}

// check tồn tại phòng ban chủ trì giao xử lý
function department_group_g(){
    $("select[name='department_group_id']").change(function () {
        var id = this.value;
        data['id'] = id;
        let result = ajaxQuery('/admin/groups/department_exist', data, 'POST');
        if (result.code == 200) {
            $("select[name='department_group_combination_id']").html('');
            $.each(result.data, function(key, value){
                $("select[name='department_group_combination_id']").append(
                    "<option value=" + value.id + ">" + value.name + "</option>"
                );
            });
        } else if (result.code == 401) {
            showAlert(result.message, result.notify, 5000);
        }
    });
}

// check phòng ban phối hợp theo phòng ban chủ trì
function department_Bydepartment(){
    $("select[name='task_department_id']").change(function () {
        var id = this.value;
        data['id'] = id;
        let result = ajaxQuery('/admin/groups/department_exist', data, 'POST');
        if (result.code == 200) {
            $("select[name='group_combination']").html('');
            $.each(result.data, function(key, value){
                $("select[name='group_combination']").append(
                    "<option value=" + value.id + ">" + value.name + "</option>"
                );
            });
        } else if (result.code == 401) {
            showAlert(result.message, result.notify, 5000);
        }
    });
}




//show popup add
$( "#addBtnCl" ).click(function() {

    setUpModal("Thêm mới nhiệm vụ");
    $("#btnAddCustom").contents().last()[0].textContent = TITLE_MODAL_ADD;
    $("#btnAddCustom").attr('disabled', false);

    $(".select-combination").select2({});
    $(".select-combination").val(null).trigger("change");
    clearFormLandmark();
    $('.box-add-landmark').hide();
    $("#table_landmark tbody tr").not("[id='templateRowLandmark']").remove();
    $("#sector_id").val("");
    $("#asigner_id").val("");
    $("#group_id").val("");
    groupBySector();
    group_combinationByGroup();
    department_Bydepartment();
    department_group();

    clearTableFile();
    $('.input_file').val("");
});


//show popup edit
$('#idTable tbody').on('click', '.update-modal-custom', function () {
    self = this;
    department_group();
    load_data_edit(self);
});
// show popup giao phòng ban xử lý
$(document).on('click', '#idTable tbody .modal-department-group', function(e){
    self = this;
    department_group_g();
    $('#department_group_id').val("");
    // $('.department_group_combination_id').val("");
    $('.department_group_combination_id').val("").trigger("change")
    $('.leading_idea_department').val("");


    $('.err-department_group_id').hide();
});

function load_data_edit(self) {
    $(".select-combination").select2({});
    $(".select-combination").val(null).trigger("change");
    clearFormLandmark();
    setUpModal(TITLE_MODAL_EDIT);
    $("#btnAddCustom").contents().last()[0].textContent = TITLE_MODAL_EDIT;
    $("#btnAddCustom").attr('disabled', false);

    $("#table_landmark tbody tr").not("[id='templateRowLandmark']").remove();

    clearTableFile();
    $('.input_file').val("");

    let data = {
        "id": $(self).data("id")
    }
    console.log(data);
    let result = ajaxQuery(URL_GET_MODEL_FROM_DB, data, 'POST');
    if (result.code == 200) {
        updateDataView("#modal-form", result.data);
        $("select[name='group_id']").val(result.data.group_id);
        console.log('11111');
        console.log(result.data.task_department_id);
        console.log('11111');
        $("select[name='task_department_id']").val(result.data.task_department_id);
        if(result.data.deadline_process == 'deadline') {
            $('input[value="deadline"]').prop('checked', true);

            $('#div1').show();
        } else {
            $('input[value="nodeadline"]').prop('checked', true);
            $('input[name="deadline"]').val("");
            $('#div1').hide();
        }

        //load data lankmark
        if(result.data.data_landmark.length > 0 ) {
            let data_landmark = result.data.data_landmark;

            $.each(data_landmark, function(idx, data){
                //set data to table
                let firstRowElement = $("#table_landmark tbody tr").first();

                $("#table_landmark tbody").append("<tr id='new'>" + firstRowElement.html() + "</tr>");
                let count = $("#table_landmark tbody tr").length - 1;
                data.landmark_id = count;
                $("#table_landmark tr[id='new']").attr("id", data.landmark_id);

                let id = data.landmark_id;
                $("tr[id='"+id+"'] td:first-child").text();
                $("#table_landmark tr[id='" + id + "']").find("[group~='data']").each(function() {
                    const thisElement = $(this);
                    const group = thisElement.attr('group');
                    const name = thisElement.attr('name');

                    // let value = data[name];
                    // if (group.includes("autoConvertDate")) {
                    //     value = value == null ? "" : changeDate(value);
                    // }
                    thisElement.html(data[name]);
                });
                $("#table_landmark tr[id='" + id + "']").find("[name='data-id']").attr('data-id', id);
            });
        }

        //load data attach
        if(result.data.data_attach.length > 0) {
            let data_attach = result.data.data_attach;

            $.each(data_attach, function(idx, data){
                let firstRowElement = $('#table_file tbody tr').first();
                let num_row = $('#table_file tbody tr').not("[id='templateRowFile']").length;
                let id = num_row + 1;

                $('#table_file tbody').append("<tr id='"+id+"'>" + firstRowElement.html() + "</tr>");
                $("#table_file tr[id='" + id + "'] td:first-child").text(id);
                $("#table_file tr[id='" + id + "'] td:nth-child(2) a").text(data.file_name);
                $("#table_file tr[id='" + id + "'] td:nth-child(2) a").attr('href', '/file/' + data.file_name);
                $("#table_file tr[id='" + id + "']").find(".delete-file").attr('data-id', id);
            });
        }
    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
}

//show popup approve-modal (duyệt chính thức)
$('#idTable tbody').on('click', '.approve-modal', function () {
    $("#table_landmark tbody tr").not("[id='templateRowLandmark']").remove();
    self = this;
    let data = {
        "id": $(self).data("id")
    }
    let result = ajaxQuery(URL_GET_MODEL_FROM_DB, data, 'POST');
    if (result.code == 200) {
        updateDataView("#modal-approve", result.data);
        $('select[name="approve_nature"]').val(result.data.nature);
        $('#btnApprove').attr('data-id', $(this).data("id"));
    } else if (result.code == 401) {
        showAlert(result.message, result.notify, 5000);
    }
});

//show popup return pending renewed (Trả lại gia hạn)
$('#idTable tbody').on('click', '.return-modal-pending-approved', function () {
    $("#table_landmark tbody tr").not("[id='templateRowLandmark']").remove();
    self = this;
    let data = {
        "id": $(self).data("id")
    }
    let result = ajaxQuery(URL_GET_MODEL_FROM_DB, data, 'POST');
    if (result.code == 200) {
        updateDataView("#popup-return-pending-approved", result.data);
        $('textarea[name="reason_returned"]').val(result.data.reason_renewed);
    } else if (result.code == 401) {
        showAlert(result.message, result.notify, 5000);
    }
});


//### event process task
$('#btnProcess').click(function () {
    var data = {};
    data['id'] = $(self).data("id");
    data['state'] = $('#form-process [name="state"]').val();
    data['completed_date'] = $('#form-process [name="completed_date"]').val();
    data['leading_idea'] = $('#form-process [name="leading_idea"]').val();
    data['result'] = $('#form-process [name="result"]').val();
    data['out_date_reason'] = $('#form-process [name="out_date_reason"]').val();
    data['out_date_checkbox'] = $('#form-process [name="out_date_checkbox"]').val();
    if($('#table-landmark tbody tr').not("[id='templateRow']").length > 0) {
        data['landmark'] = $('#popup-progress-update .num_landmark').text();
    }

    let tr_file = $("#table_file2 tbody tr").not("[id='templateRowFile2']").length;

    if(tr_file > 0) {
        let data_file = [];
        $("#table_file2 tbody tr").not("[id='templateRowFile2']").each(function() {
            let obj_file = {};
            let name = $(this).find("td:nth-child(2) a").text();
            let file = $(this).find("td:nth-child(2) a").attr('href');
            obj_file['name'] = name;
            obj_file['name_response'] = file;
            console.log(name);
            data_file.push(obj_file);
        });
        data['lst_attach'] = data_file;
    }

    if($("#completed_date_up").val() == ""){
        $("#error-required").show();
        return;
    }
    else {
        $("#error-required").hide();
    }

    let result = ajaxQuery(URL_PROCESS_TASK_ADD, data, 'POST');

    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });


    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }

});

//### duyệt hoàn thành
$('.btnApproveComplete').click(function () {
    var data = {};
    data['id'] = $(self).data("id");
    let result = ajaxQuery(URL_APPROVE_COMPLETE, data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
});

//### duyệt xử lý
$('.btnApproveProcessing').click(function () {

    var data = {};
    data['id'] = $(self).data("id");
    data['department_id'] = $(self).data("department");
    let result = ajaxQuery(URL_APPROVE_PROCESSING, data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
});

//### duyệt gửi báo cáo nhiệm vụ đơn vị
$('#btnSendReport').click(function () {

    var leading_idea = $("#leading_idea").val();
    var result_form = $("#result").val();
    var completed_date = $("#completed_date_group").val();
    var state = $("#state_group").val();

    var data = {
        "leading_idea": leading_idea,
        "result": result_form,
        "completed_date": completed_date,
        "state": state,
    };
    data['id'] = $(self).data("id");
    data['department_id'] = $(self).data("department");
    let result = ajaxQuery(URL_SEND_REPORT, data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
});




//### Trả lại nhiệm vụ cấp đơn vị
$('.btnReturnTaskGroup').click(function () {
    if($('.reason_return_gr').val() == ""){
        $('.error_reason_group').show();
    }else {
        $('.error_reason_group').hide();
        var  reason_return = $('.reason_return_gr').val();
        var data = {
            "reason_return":reason_return,
        };
        data['id'] = $(self).data("id");
        let result = ajaxQuery(URL_RETURN_TASK_GROUP, data, 'POST');
        if (result.code == 200) {
            //notify success
            showAlert(result.message, result.notify, 5000);

            loadDataTable();

            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });

        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
        }
    }
})


//### Xin gia hạn

$('.btnExtend').click(function () {
    var date = $("input[name='date']").val();
    var reason = $("#reason-renewed").val();

    var data = {
        "date": date,
        "reason": reason,
    };
    data['id'] = $(self).data("id");

    let tr_file = $("#table_file3 tbody tr").not("[id='templateRowFile3']").length;

    if(tr_file > 0) {
        let data_file = [];
        $("#table_file3 tbody tr").not("[id='templateRowFile3']").each(function() {
            let obj_file = {};
            let name = $(this).find("td:nth-child(2) a").text();
            let file = $(this).find("td:nth-child(2) a").attr('href');
            obj_file['name'] = name;
            obj_file['name_response'] = file;
            console.log(name);
            data_file.push(obj_file);
        });
        data['lst_attach'] = data_file;
    }

    let result = ajaxQuery(URL_PLEASE_EXTEND, data, 'POST');

    if($("textarea[name='reason']").val()==""){
        $('#error_reason').show();
    }
    else {
        if (result.code == 200) {
            //notify success
            showAlert(result.message, result.notify, 5000);

            $("textarea[name='reason']").val("");
            loadDataTable();

            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });

        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
        }
    }

});

// Duyệt gia hạn

$('.btnRenewalApproval').click(function () {
    var data = {};
    data['id'] = $(self).data("id");
    let result = ajaxQuery(URL_RENEWAL_APPROVAL, data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
});
// ### clearFormLandmark
function clearFormLandmark() {
    $('.form-add-landmark input[name="landmark_deadline"]').val("");
    $('.form-add-landmark input[name="id"]').val("");
    $('.form-add-landmark input[type=checkbox]').each(function () {
        $(this).prop('checked', false);
    });
    $('.ckb_manually').prop('checked', true);
    $('textarea[name="landmark_result_txt"]').val("");
    $('textarea[name="landmark_content"]').val("");
    $('.txt_manually').show();

    //clear invalid
    $('.form-add-landmark .show-invalid').remove();
    $('.form-add-landmark').find(".invalid").removeClass('invalid');
}

// ### clear Table file
function clearTableFile() {
    $('#table_file tbody tr').not("[id='templateRowFile']").remove();
}


// ### event show add landmark
$('.add-landmark').click(function () {
    clearFormLandmark();
    $('.box-add-landmark').toggle();
});

// ### event save landmark
$(".save-landmark").click(function () {
    let landmark_id = $('.form-add-landmark input[name="landmark_id"]').val();
    let landmark_deadline = $('input[name="landmark_deadline"]').val();
    let landmark_result = $("input[name='landmark_result']:checked").val();
    let landmark_result_txt = $('textarea[name="landmark_result_txt"]').val();
    let landmark_content = $('textarea[name="landmark_content"]').val();

    if(!validateLandmark(landmark_deadline, landmark_result, landmark_result_txt, landmark_content)) return;

    let data = {};
    data['landmark_deadline'] = landmark_deadline;
    data['landmark_result'] = landmark_result==VAL_OPTION_MANUALLY ? landmark_result_txt : $("input[name='landmark_result']:checked").parent().text();
    data['landmark_content'] = landmark_content;

    data['landmark_id'] = landmark_id;
    if(landmark_id == '' || landmark_id == undefined) {
        //set data to table
        let firstRowElement = $("#table_landmark tbody tr").first();

        $("#table_landmark tbody").append("<tr id='new'>" + firstRowElement.html() + "</tr>");
        let count = $("#table_landmark tbody tr").length - 1;
        data['landmark_id'] = count;
        $("#table_landmark tr[id='new']").attr("id", data['landmark_id']);

    }

    let id = data.landmark_id;
    $("tr[id='"+id+"'] td:first-child").text();
    $("#table_landmark tr[id='" + id + "']").find("[group~='data']").each(function() {
        const thisElement = $(this);
        const name = thisElement.attr('name');
        // const group = thisElement.attr('group');

        // let value = data[name];
        // if (group.includes("autoConvertDate")) {
        //     value = value == null ? "" : changeDate(value);
        // }
        thisElement.html(data[name]);
    });
    $("#table_landmark tr[id='" + id + "']").find("[name='data-id']").attr('data-id', id);
    $("#table_landmark tr[id='" + id + "']").find("[name='data-id']").attr('landmark_result', landmark_result);

    //close form and clear data
    clearFormLandmark();
    $('.box-add-landmark').toggle();
});

// ### event show edit landmark
$('#table_landmark tbody').on('click', '.update-landmark', function (e) {
    e.preventDefault();

    $('.box-add-landmark').show();

    let id = $(this).attr('data-id');
    let landmark_result = $(this).attr('landmark_result');
    $("#table_landmark tr[id='" + id + "']").find("[group~='data']").each(function() {
        let val = $(this).html();
        const name = $(this).attr('name');

        if(name == 'landmark_result') {
            $('.form-add-landmark input[type=checkbox]').each(function () {
                $(this).prop('checked', false);
            });

            if(landmark_result != undefined) {
                $('.box-add-landmark [value="' + landmark_result + '"]').prop('checked', true);
                if(landmark_result != VAL_OPTION_MANUALLY) {
                    $('.txt_manually').hide();
                } else {
                    $('.txt_manually').show();
                    $('.box-add-landmark [name="landmark_result_txt"]').val(val);
                }
            } else {
                if(val == VAL_POST_DRAFT) {
                    $('.box-add-landmark [value="post-draft"]').prop('checked', true);
                    $('.txt_manually').hide();
                } else if(val == VAL_APPRAISAL) {
                    $('.box-add-landmark [value="appraisal"]').prop('checked', true);
                    $('.txt_manually').hide();
                } else {
                    $('.txt_manually').show();
                    $('.box-add-landmark [value="' + VAL_OPTION_MANUALLY + '"]').prop('checked', true);
                    $('.box-add-landmark [name="landmark_result_txt"]').val(val);
                }
            }

        } else {
            $('.box-add-landmark [name="' + name + '"]').val(val);
        }


        // if(name==)
    });
});

// ### event delete landmark
$('#table_landmark tbody').on('click', '.delete-landmark', function (e) {
    e.preventDefault();
    let id = $(this).attr('data-id');
    $("#table_landmark tr[id='" + id + "']").remove();

    let order = 1;
    $("#table_landmark tbody tr").not("[id='templateRowLandmark']").each(function() {
        $(this).find('td:first-child').html(order);
        order ++;
    });
});

// ### validateLandmark
function validateLandmark(landmark_deadline, landmark_result, landmark_result_txt, landmark_content) {
    let flag = true;
    let check_deadline = $('input[name="check_deadline"]:checked').val();
    let deadline = $('input[name="deadline"]').val();
    let newdeadline = deadline.split("/").reverse().join("/");
    let newlandmark_deadline = landmark_deadline.split("/").reverse().join("/");



    // console.log((deadline));
    // console.log((newdeadline));
    // console.log((newlandmark_deadline));

    if(landmark_deadline=='') {
        flag = false;
        createInvalid('landmark_deadline', 'Nhập thời hạn!');
    }
    else if(check_deadline == 'deadline' && newlandmark_deadline > newdeadline) {
        flag = false;
        createInvalid('landmark_deadline', 'Thời hạn các mốc không lớn hơn thời hạn!');
    }
    if(landmark_result==VAL_OPTION_MANUALLY && landmark_result_txt=='') {
        flag = false;
        createInvalid('landmark_result_txt', 'Nhập kết quả dự kiến!');
    }
    if(landmark_content=='') {
        flag = false;
        createInvalid('landmark_content', 'Nhập nội dung!');
    }

    return flag;
}

function createInvalid(key, msg) {
    let locationAddValidate = $(".box-add-landmark [name='" + key + "']").parent();
    $(".box-add-landmark [name='" + key + "']").addClass('invalid');
    createdInvalid(locationAddValidate, msg);
}

// ### event change checkbox option landmark
$('.form-add-landmark input[type=checkbox]').change(function () {
    $('.form-add-landmark input[type=checkbox]').each(function () {
        $(this).prop('checked', false);
    });
    $(this).prop('checked', true);

    $(this).val() == VAL_OPTION_MANUALLY ? $('.txt_manually').show() : $('.txt_manually').hide();
});


// ### return
$( ".btnReturnPendingApproved" ).click(function() {
    var data = {};
    data['id'] = $(self).data("id");

    let result = ajaxQuery('/admin/mic_task/return_renewal_approval', data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });


    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
});


// ### return pending delete
$( ".btnReturnPendingDelete" ).click(function() {
    var data = {};
    data['id'] = $(self).data("id");

    let result = ajaxQuery('/admin/mic_task/return_pending_delete', data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }
});


// ### return mic-task
$( ".btnReturnMictask" ).click(function() {

    var reason_returned = $("textarea[name='reason_return']").val();
    var landmark_deadline = $(".landmark_deadline").val();
    var data = {
        "reason_returned": reason_returned,
        "landmark_deadline": landmark_deadline,
    };
    data['id'] = $(self).data("id");
    console.log($('.permission_data').val());
    let url = $('.permission_data').val()==3 ? "/admin/mic_task/return_mic_task_group" : "/admin/mic_task/return_mic_task";
    let result = ajaxQuery(url, data, 'POST');
    if($("textarea[name='reason_return']").val()==""){
        // alert('111');
        $('#error-reason').show();
    }
    else {
        if (result.code == 200) {
            //notify success
            showAlert(result.message, result.notify, 5000);
            loadDataTable();
            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });

        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
        }
    }
});

$("#popup-return-mictask").click(function () {
    $('#reason_return').val('');
});

//show popup handing_processing
$('#idTable tbody').on('click', '.modal-handing-processing', function () {
    $("#table_landmark tbody tr").not("[id='templateRowLandmark']").remove();
    self = this;
    let data = {
        "id": $(self).data("id")
    }
    let result = ajaxQuery(URL_GET_MODEL_FROM_DB, data, 'POST');
    // console.log(111111);
    // console.log(result.data.asigner_id);
    // console.log(111111);
    if (result.code == 200) {

        var asigner = result.data.asigner_id;
        let data1 = {
            "id": asigner
        }
        let result1 = ajaxQuery('/admin/groups/groups_by_user_leader', data1, 'POST');
        if (result1.code == 200) {
            $("select[name='group_id']").html("<option value=''>" + '--Chọn--' + "</option>");
            $.each(result1.data, function(key, value){
                $("select[name='group_id']").append('<option value="' + value.id + '">' + value.name + '</option>');
            });
        }

        $("select[name='asigner_id']").change(function () {
            var asigner1 = this.value;
            let data2 = {
                "id": asigner1
            }
            let result2 = ajaxQuery('/admin/groups/groups_by_user_leader', data2, 'POST');
            if (result2.code == 200) {
                $("select[name='group_id']").html("<option value=''>" + '--Chọn--' + "</option>");
                $.each(result2.data, function(key, value){
                    $("select[name='group_id']").append(
                        "<option value=" + value.id + ">" + value.name + "</option>"
                    );
                });
            } else if (result.code == 401) {
                showAlert(result.message, result.notify, 5000);
            }
        });
        updateDataView("#handing-processing", result.data);


    } else if (result.code == 401) {
        showAlert(result.message, result.notify, 5000);
    }
})

//### event handing_processing
$('#btnProcessHanding').click(function () {
    var group_id = $(".group_id").val();
    var asigner_id = $(".asigner_id").val();
    var group_combination = $(".group_combination").val();
    var leader_responsible = $("#leader_responsible").val();
    var leading_idea = $("#leading_idea").val();



    var data = {
        "leader_responsible": leader_responsible,
        "leading_idea": leading_idea,
        "group_id": group_id,
        "asigner_id": asigner_id,
        "group_combination": group_combination,
    };
    data['id'] = $(self).data("id");
    let result = ajaxQuery(URL_UPDATE_MODEL_HANDING_PROCESSING, data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }

});


//### Giao xử lý cấp đơn vị
$('#btnProcessHandingGroup').click(function () {
    var group_expert_id = $(".group_expert").val();
    var leading_idea = $("#leading_idea").val();

    var data = {
        "group_expert_id": group_expert_id,
        "leading_idea": leading_idea,
    };
    data['id'] = $(self).data("id");
    let result = ajaxQuery(URL_UPDATE_MODEL_HANDING_PROCESSING_GROUP, data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        loadDataTable();

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }

});

//### Giao xử lý phòng ban đơn vị
$('#btnDepartmentGroup').click(function () {

    //validate group_id
    if( $("select[name='department_group_id']").val() == 0){
        $('.err-department_group_id').show();
    }else {
        $('.err-department_group_id').hide();

        var department_group_id = $(".department_group_id").val();
        var department_group_combination_id = $(".department_group_combination_id").val();
        var leading_idea = $(".leading_idea_department").val();

        var data = {
            "department_group_id": department_group_id,
            "department_group_combination_id": department_group_combination_id,
            "leading_idea": leading_idea,
        };
        data['id'] = $(self).data("id");
        let result = ajaxQuery(URL_UPDATE_MODEL_DEPARTMENT_GROUP, data, 'POST');
        if (result.code == 200) {
            //notify success
            showAlert(result.message, result.notify, 5000);

            loadDataTable();

            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });

        } else if (result.code == 401) {
            //notify error
            showAlert(result.message, result.notify, 5000);
        }
    }


});




//### Giao theo dõi
$('#btnTracking').click(function () {
    var tracker_uid = $(".tracker_uid").val();
    var data = {
        "tracker_uid":tracker_uid
    };
    data['id'] = $(self).data("id");

    let result = ajaxQuery('/admin/mic_task/tracking_assignment', data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);
        loadDataTable();
        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });
    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }

})

//### Đánh giá chất lượng
$('.btnQuality').click(function () {
    // alert('111');
    // var radio_quality = $(".radio_quality").val();
    var radio_quality = $('input[name=radio_quality]:checked').val()
    var data = {
        "radio_quality":radio_quality
    };
    data['id'] = $(self).data("id");

    let result = ajaxQuery('/admin/mic_task/evaluate-quality', data, 'POST');
    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);
        loadDataTable();
        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });
    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);
    }

})

//export excel task
$(".action-export").click(function () {
    let dataSearchInContainer = getDataView("#searchForm");
    let url = window.location.href;

    let split = url.split("/");
    let pathName = split[split.length-1];

    if(url.indexOf('official-list') >= 0) {
        dataSearchInContainer['status_list'] = 'assign_new';
    }
    else if(url.indexOf('completed-out-date-list') >= 0) {
        dataSearchInContainer['status_list'] = 'completed_out_date';
    }
    else {
        dataSearchInContainer['status_list'] = pathName.replaceAll("-", "_");
    }

    let result = ajaxQuery('/admin/report/list_task', dataSearchInContainer, 'GET');
    if(result.code==200) {
        var $a = $("<a>");
        $a.attr("href",result.file);
        $("body").append($a);
        $a.attr("download",result.file_name);
        $a[0].click();
        $a.remove();
    }
})
//export excel task group
$(".action-export-group").click(function () {
    let dataSearchInContainer = getDataView("#searchForm");
    let url = window.location.href;

    let split = url.split("/");
    let pathName = split[split.length-1];

    if(url.indexOf('official-list') >= 0) {
        dataSearchInContainer['status_list'] = 'assign_new';
    }
    else if(url.indexOf('completed-out-date-list') >= 0) {
        dataSearchInContainer['status_list'] = 'completed_out_date';
    }
    else {
        dataSearchInContainer['status_list'] = pathName.replaceAll("-", "_");
    }

    let result = ajaxQuery('/admin/report/list_task_group', dataSearchInContainer, 'GET');
    if(result.code==200) {
        var $a = $("<a>");
        $a.attr("href",result.file);
        $("body").append($a);
        $a.attr("download",result.file_name);
        $a[0].click();
        $a.remove();
    }
})

//export word task
//### export work task
$(".action-word").click(function () {
    let dataSearchInContainer = getDataView("#searchForm");
    let url = window.location.href;

    let split = url.split("/");
    let pathName = split[split.length-1];

    if(url.indexOf('official-list') >= 0) {
        dataSearchInContainer['status_list'] = 'assign_new';
    }
    else if(url.indexOf('completed-out-date-list') >= 0) {
        dataSearchInContainer['status_list'] = 'completed_out_date';
    }
    else {
        dataSearchInContainer['status_list'] = pathName.replaceAll("-", "_");
    }

    let result = ajaxQuery('/admin/report/word', dataSearchInContainer, 'GET');
    if(result.code==200) {
        var $a = $("<a>");
        $a.attr("href",result.file);
        $("body").append($a);
        $a.attr("download",result.file_name);
        $a[0].click();
        $a.remove();
    }
})


//### export work task group
$(".action-word-group").click(function () {
    let dataSearchInContainer = getDataView("#searchForm");
    let url = window.location.href;

    let split = url.split("/");
    let pathName = split[split.length-1];

    if(url.indexOf('official-list') >= 0) {
        dataSearchInContainer['status_list'] = 'assign_new';
    }
    else if(url.indexOf('completed-out-date-list') >= 0) {
        dataSearchInContainer['status_list'] = 'completed_out_date';
    }
    else {
        dataSearchInContainer['status_list'] = pathName.replaceAll("-", "_");
    }

    let result = ajaxQuery('/admin/report/word_group', dataSearchInContainer, 'GET');
    if(result.code==200) {
        var $a = $("<a>");
        $a.attr("href",result.file);
        $("body").append($a);
        $a.attr("download",result.file_name);
        $a[0].click();
        $a.remove();
    }
})

//show more
$('#idTable tbody').on('click', '.show-more', function (e) {
    e.preventDefault();
    $(this).parent().find('p').attr("style", "display:block; max-height:100%");
    $(this).attr("style", "display:none;");
    $(this).parent().find('.show-less').attr("style", "display:block;");
});

//show less
$('#idTable tbody').on('click', '.show-less', function (e) {
    e.preventDefault();
    $(this).parent().find('p').attr("style", "display:-webkit-box; max-height:60px");
    $(this).attr("style", "display:none;");
    $(this).parent().find('.show-more').attr("style", "display:block;");
});

//sendmail
$(".sendmail").click(function () {
    let data = {
        "mail_to": $('.form_mail [name="mail_to"]').val(),
        "mail_body": CKEDITOR.instances["mail_body"].getData(),
        "mail_title": $('.form_mail [name="mail_title"]').val(),
        "task_id":  $(self).data("id")
    }
    console.log(data);
    let result = ajaxQuery('/admin/mic_task/send_mail', data, 'POST');

    if (result.code == 200) {
        //notify success
        showAlert(result.message, result.notify, 5000);

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });

    } else if (result.code == 401) {
        //notify error
        showAlert(result.message, result.notify, 5000);

        //close modal
        $("[data-dismiss=modal]").trigger({ type: "click" });
    } else {
        if(result.errors==null) {
            showAlert(result.message, result.notify, 5000);

            //close modal
            $("[data-dismiss=modal]").trigger({ type: "click" });
        } else {
            Object.keys(result.errors).forEach(function(key) {
                let locationAddValidate = $(".form_mail [name='" + key + "']").parent();
                $(".form_mail [name='" + key + "']").addClass('invalid');
                createdInvalid(locationAddValidate, result.errors[key]);
            });
        }
    }
})

$(document).on('change', '.form_mail input, .form_mail select, .form_mail textarea', function(e) {
    e.preventDefault();
    $(this).removeClass('invalid');
    $(this).parent().find('.show-invalid').remove();
});

$(document).ready(function() {
    if(CKEDITOR.instances.mail_body != undefined) {
        CKEDITOR.instances.mail_body.on('change', function () {
            $('.form_mail [name="mail_body"]').removeClass('invalid');
            $('.form_mail [name="mail_body"]').parent().find('.show-invalid').remove();
        });
    }
});
