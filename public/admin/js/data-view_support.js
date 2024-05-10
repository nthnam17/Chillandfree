function getDataView(cssSelectorRootElement) {
    // Description: auto get data from tag have group contains 'data', result key is attr name of tag
    data = {};
    $(cssSelectorRootElement).find("[group~='data']").each(function() {
        let name = $(this).attr('name');
        let tagName = $(this).prop("tagName");
        let type = $(this).prop("type");
        //let eleShow = $(this).is(":visible");
        //if(name == 'id' || eleShow) {


        if(tagName=='IMG') {
            let src = $(this).attr("src");
            if(src != undefined) {
                data[name] = $(this).attr('src');
            }
        } else if (type=='checkbox') {
            data[name] = $(this).is(":checked") ? 1 : 0;
        } else if(CKEDITOR.instances[name] != undefined) {
            //ckeditor
            data[name] = CKEDITOR.instances[name].getData();
        } else if (name != null && name != '') {
            let value = $(this).val();
            data[name] = value;
        }
        else if(tagName=='SELECT') {
            data[name] = $(this).select2("val")
        }
    });

    //tags
    if($(".select-tags").length) {
        data['tags'] = $(".select-tags").select2("val").toString();
    }

    return data;
};

function updateDataView(cssSelectorRootElement, data) {
    // Description: auto update data to tag have group contains 'data', result key is attr name of tag
    $(cssSelectorRootElement).find("[group~='data']").each(function() {
        const thisElement = $(this);
        const tagName = thisElement.prop("tagName");
        const group = thisElement.attr('group');
        const convertToAttr = thisElement.attr("convertToAttr");
        const name = thisElement.attr('name');
        const flag = thisElement.attr("dataNotFill");
        const setValue = thisElement.attr("setValue");
        const type = $(this).prop("type");
        if (flag == "true") return true;

        if (name != null && name != '') {
            $.each(data, function(key, value) {
                if (key == name) {
                    if (group.includes("daterangepicker")) {
                        thisElement.data('daterangepicker').setStartDate(formatDatetime(value));
                        thisElement.data('daterangepicker').setEndDate(formatDatetime(value));
                    } else if (convertToAttr != null && convertToAttr != "") {
                        let arrAttr = convertToAttr.split(',');
                        $.each(arrAttr, function(key, value) {
                            let field = value.split('-');
                            thisElement.attr(value.trim(), data[field[1]]);
                        });
                        if(setValue) thisElement.text(value);
                    } else if (tagName == "SELECT" || tagName == "INPUT") {
                        if(type == 'checkbox') {
                            if(value==1) thisElement.prop('checked', true);
                        } else if(type == 'date') {
                            thisElement.val(value==null ? null : value.split(' ')[0]);
                        } else {
                            thisElement.val(value).change();
                        }
                    } else if (tagName == "IMG") {
                        thisElement.attr("src", value);
                    } else if (tagName == "A") {
                         if(group.includes("setHrefKeyword")) {
                                const _slug = thisElement.attr("data-slug");
                                const _id = thisElement.parent().parent().attr('id');
                                const slug = _slug+'?keywordId='+_id;

                                thisElement.attr("href", slug);
                        }
                         else if(group.includes("setHref")) {
                            const _slug = thisElement.attr("data-slug");
                            const _id = thisElement.parent().parent().attr('id');
                            const slug = _slug+'?fieldId='+_id;

                            thisElement.attr("href", slug);
                        }
                        else if(group.includes("setText")) {
                            thisElement.html(value);
                        } else {
                            thisElement.attr("href", value);
                        }
                    } else if (CKEDITOR.instances[name]) {
                        let fncCallback = function(){
                            CKEDITOR.instances[name].focus();
                            CKEDITOR.instances[name].setData(value);
                        };
                        CKEDITOR.instances[name].setData("", fncCallback);
                    } else {
                        if (group.includes("autoConvertTime")) {
                            value = value == null ? "" : changeTimezone(value);
                        }else if(group.includes("autoConvertDateTime")){
                            value = value == null ? "" : changeDateTime(value);
                        }else if (group.includes("autoConvertPrice")) {
                            value = value == null ? "" : formatPrice(value) + ' đ';
                        } else if (group.includes("autoConvertDate")) {
                            value = value == null ? "" : changeDate(value);
                        }
                        if (group.includes("autoConvertHtml")) {
                            thisElement.text(value);
                            thisElement.html(thisElement.text());
                        } else {
                            tagName=='TEXTAREA' ? thisElement.val(value) : thisElement.text(value);
                        }
                    }
                }
            })
        }
    });

    // loadfunctionTask(data, cssSelectorRootElement);

    //tags
    if($(".select-tags").length) {
        $('.select-tags').val(data['tags']!=null ? data['tags'].split(',') : null).change();
    }

};

function loadfunctionTask(data, cssSelectorRootElement) {
    $(cssSelectorRootElement).find('.list-action-mictask').children().remove();

    // //duyệt hoàn thành
    if(data.show_aprove_complete) {
        create_operation(cssSelectorRootElement, 'modal-approve-complete', 'Duyệt hoàn thành', '#popup-complete-browser', 'icon_duyet_hoan_thanh.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-approve-complete').remove();
    }

    //cập nhật tiến độ
    if(data.show_processing) {
        create_operation(cssSelectorRootElement, 'modal-process', 'Cập nhật tiến độ', '#popup-progress-update', 'icon_cap_nhat_tien_do.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-process').remove();
    }
    //giao theo dõi
    if(data.show_follow) {
        create_operation(cssSelectorRootElement, 'modal-follow', 'Giao theo dõi', '#popup-follow', 'icon_giao_theo_doi.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-follow').remove();
    }
    //giao xử lý
    if(data.show_handing_processing) {
        create_operation(cssSelectorRootElement, 'modal-handing-processing', 'Giao xử lý', '#handing-processing', 'icon_giao_xu_ly.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-handing-processing').remove();
    }

    //giao xử lý cấp đơn vị
    if(data.show_handing_processing_group) {
        create_operation(cssSelectorRootElement, 'modal-handing-processing-group', 'Giao chuyên viên xử lý', '#handing-processing-group', 'icon_giao_xu_ly.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-handing-processing-group').remove();
    }

    //giao xử phòng ban
    if(data.show_department_group) {
        create_operation(cssSelectorRootElement, 'modal-department-group', 'Giao phòng ban xử lý', '#department-group', 'icon_giao_xu_ly.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-department-group').remove();
    }

    //xin gian hạn
    if(data.show_renewed) {
        create_operation(cssSelectorRootElement, 'modal-renewed', 'Xin gia hạn', '#popup-renewed', 'icon_xin_gia_han.png', data.id);
    }else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.modal-renewed').remove();
    }

    //trả lại
    if(data.show_returned) {
        create_operation(cssSelectorRootElement, 'return-mictask-modal', 'Trả lại', '#popup-return-mictask', 'icon_tra_lai.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.return-mictask-modal').remove();
    }

    //gửi mail
    if(data.show_send_mail) {
        create_operation(cssSelectorRootElement, 'popup-send-mail', 'Gửi mail', '#popup-send-mail', 'icon_send_email.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.popup-send-mail').remove();
    }

    //chỉnh sửa
    if(data.show_edit) {
        create_operation(cssSelectorRootElement, 'update-modal-custom', 'Chỉnh sửa', '#modal-form', 'icon_sua.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.update-modal-custom').remove();
    }

    //xóa
    if(data.show_delete) {
        $(cssSelectorRootElement).find('.deleteDialog').show();
        create_operation(cssSelectorRootElement, 'deleteDialog', 'Xóa', '#popup-delete', 'icon_xoa.png', data.id);
    } else {
        $(cssSelectorRootElement + ' .list-action-mictask').find('.deleteDialog').remove();
    }

}

function create_operation(cssSelectorRootElement, cls_modal, title, id_modal, src, id_data) {
    let a = document.createElement('a');
    a.setAttribute("class", "dropdown-item " + cls_modal);
    a.setAttribute("title", title);
    a.setAttribute("data-toggle", "modal");
    a.setAttribute("data-target", id_modal);
    a.setAttribute("data-id", id_data);
    a.setAttribute("href", "");
    a.setAttribute("data-backdrop", "static");
    a.setAttribute("data-keyboard", "false");
    // a.createTextNode(title);

    // let i = document.createElement('i');
    // i.setAttribute("class", "fas " + icon);
    // a.appendChild(i);

    let img = document.createElement('img');
    img.setAttribute("src", "/admin/image/icon_menu_left/" + src);
    img.setAttribute("class", "icon_mictask" );
    a.appendChild(img);

    let span = document.createElement("span");
    span.innerHTML = title;
    a.appendChild(span);

    $(cssSelectorRootElement).find('.list-action-mictask').append(a);


}
