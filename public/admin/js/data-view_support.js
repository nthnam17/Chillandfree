function getDataView(cssSelectorRootElement) {
    // Description: auto get data from tag have group contains 'data', result key is attr name of tag
    var strLog = "------------------ get data view ------------------\n";
    strLog += "     cssSelectorRootElement: " + cssSelectorRootElement + "\n";
    data = {};
    $(cssSelectorRootElement).find("[group~='data']").each(function () {
        let name = $(this).attr('name');
        let tagName = $(this).prop("tagName");
        let type = $(this).prop("type");
        //let eleShow = $(this).is(":visible");
        //if(name == 'id' || eleShow) {

        if (tagName == 'IMG') {
            let src = $(this).attr("src");
            if (src != undefined) {
                data[name] = $(this).attr('src');
            }
        } else if (type == 'checkbox') {
            data[name] = $(this).is(":checked") ? 1 : 0;
        } else if (CKEDITOR.instances[name] != undefined) {
            //ckeditor
            data[name] = CKEDITOR.instances[name].getData();
        } else if (name != null && name != '') {
            let value = $(this).val();
            data[name] = value;
            strLog += name + " : " + value + "\n";
        }
    });

    //image
    if ($(".list-gallery .col-md-3").length) {
        let lst_img = [];
        $('.list-gallery .col-md-3').each(function (i, e) {
            lst_img.push($(this).find('img').attr('src'));
        });
        data['lst_img'] = lst_img.toString();
    }


   


    strLog += "---------------------------------------------------\n";
    console.log(strLog);
    return data;
}
function updateDataView(cssSelectorRootElement, data) {
    // Description: auto update data to tag have group contains 'data', result key is attr name of tag
    let strLog = "--------------- update data view ------------------\n";
    strLog += "     cssSelectorRootElement: " + cssSelectorRootElement;
    $(cssSelectorRootElement).find("[group~='data']").each(function () {
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
            strLog += "\n" + name + " -->  ";
            $.each(data, function (key, value) {
                if (key == name) {
                    strLog += value;
                    if (group.includes("daterangepicker")) {
                        thisElement.data('daterangepicker').setStartDate(formatDatetime(value));
                        thisElement.data('daterangepicker').setEndDate(formatDatetime(value));
                    } else if (convertToAttr != null && convertToAttr != "") {
                        let arrAttr = convertToAttr.split(',');
                        $.each(arrAttr, function (key, value) {
                            let field = value.split('-');
                            thisElement.attr(value.trim(), data[field[1]]);
                        });
                        if (setValue) thisElement.text(value);
                    } else if (tagName == "SELECT" || tagName == "INPUT") {
                        if (type == 'checkbox') {
                            if (value == 1) thisElement.prop('checked', true);
                        } else if (type == 'date') {
                            thisElement.val(value == null ? null : value.split(' ')[0]);
                        } else {
                            thisElement.val(value).change();
                        }
                    } else if (tagName == "IMG") {
                        thisElement.attr("src", value);
                    } else if (tagName == "A") {
                        thisElement.attr("href", value);
                    } else if (CKEDITOR.instances[name]) {
                        let fncCallback = function () {
                            CKEDITOR.instances[name].focus();
                            CKEDITOR.instances[name].setData(value);
                        };
                        CKEDITOR.instances[name].setData("", fncCallback);
                    } else {
                        if (group.includes("autoConvertTime")) {
                            value = value == null ? "" : changeTimezone(value);
                        } else if (group.includes("autoConvertPrice")) {
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

    if ($(".list-gallery").length) {
        let lst_img = data['lst_img'];
        if (lst_img != null && lst_img !== "") {
            let array = lst_img.split(',');
            for (let i = 0; i < array.length; i++) {
                genLstImg(array[i]);
            }
        }
    }

    
    



    strLog += "\n---------------------------------------------------";
    console.log(strLog);
}

