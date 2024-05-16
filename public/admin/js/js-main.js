function ckeditor(name) {
    var editor = CKEDITOR.replace(name,{
        // uiColor: '#518ca3',
        language: 'vi',
    });
}


// replace special characters
// function check(event){
//     var regex = new RegExp("^[a-zA-Z0-9]+$");
//     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//     if (!regex.test(key)) {
//         event.preventDefault();
//         return false;
//     }
// }


// a white space in the beginning of a input
function validate(input){
    if(/^\s/.test(input.value))
        input.value = '';

}

function comConfirm(msg){
    if (window.confirm(msg)) {
        return true;
    }
    return false;}


function isVietnamesePhoneNumber(number) {
    return /([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/.test(number);
}



//remove image
const samplePhoto = '/admin/img/placeholder.png';
// $(".btn_remove_image").click(function () {
$(document).on('click', '.btn_remove_image', function(e) {
    e.preventDefault();
    let img_remove = $(this).attr('img-remove');
    $("#"+img_remove).attr("src", samplePhoto);
});

//choose avatar image
function BrowseServer() {
    CKFinder.popup({
        language: 'vi',
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                let file = evt.data.files.first();
                let value_image = document.getElementById('Image');
                let value_file = document.getElementById('xFile');
                value_image.value = file.getUrl();
                value_file.src = file.getUrl();
            });
        }
    });
}

function chooseFile(eleImage) {

    CKFinder.popup({
        language: 'vi',
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                let file = evt.data.files.first();
                let idEle = '#'+eleImage;
                $(idEle).val(file.getUrl());
            });
        }
    });
}

function setImage(eleImage) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                let file = evt.data.files.first();
                // let value_file = document.getElementById(eleImage);
                // value_file.src = file.getUrl();
                let idEle = '#'+eleImage;
                console.log(idEle,'idEle');
                $(idEle).attr("src", file.getUrl());

                if($(idEle).hasClass("imgChange")) {
                    setValGallery($(idEle).attr('locale'));
                }
            });
        }
    });
}

//remove image
$('#list-photos-items').on('click', '.btn_remove_image', function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();

    //array value image
    let images = [];
    $(".gallery_image_wrapper img").each(function () {
        images.push($(this).attr('src'))
    });
    $('#gallery-data').val(images);
    if(images.length==0) $(".reset-gallery").addClass("hidden");
});

//choose Gallery images
function galleryImages() {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                if (file !== null){
                    let fName = file.attributes.name;
                    let folder = file.attributes.folder.attributes.name;
                    const arrFolder = [];
                    let fFile = file.attributes.folder.attributes.parent;

                    while (fFile != null) {
                        if(fFile.attributes.parent!= null) {
                            arrFolder.push(fFile.attributes.name);
                        }
                        fFile = fFile.attributes.parent;
                    }
                    let src = '/uploads/images/' + arrFolder.reverse().join("/") + '/' + folder + '/' + fName;

                    $("#list-photos-items").append("<div class='col-md-2 col-sm-3 col-4 photo-gallery-item'>" +
                                                   "<div class='gallery_image_wrapper'>" +
                                                   "<img src='" + src + "'>" +
                                                    "<a class='btn_remove_image' title='Remove image'><i class='fa fa-times'></i></a>" +
                                                   "</div></div>");
                    //show reset class
                    $(".reset-gallery").removeClass("hidden");

                    //array value image
                    var images = [];
                    $(".gallery_image_wrapper img").each(function () {
                        images.push($(this).attr('src'))
                    })
                    console.log(images);
                    $('#gallery-data').val(images);
                }
            });
        }
    });
}

function register_feedback() {
    let _token = $('meta[name="csrf-token"]').attr('content');
    let name = $("input[name='name']").val();
    let add_email = $("input[name='add_email']").val();
    let title = $("input[name='title']").val();
    let type = $("input[name='type']").val();
    let file = $("input[name='file']").val();
    let content = $('#exampleFormControlTextarea5').val();

    if(title == '' ){
        showAlert("Thông tin Tiêu đề cần được nhập !", 'danger', 5000);
        return true;

    }
    else if (content == '') {
        showAlert("Thông tin Thông điệp cần được nhập !", 'danger', 5000);
        return true;
    }

    let data = {
        "_token": _token,
        "name": name,
        "add_email": add_email,
        "title": title,
        "content": content,
        "type": type,
        "file": file,
    };

    $.ajax({
        dataType: 'json',
        async: false,
        url: "/ajaxFeedback",
        type: "POST",
        cache: false,
        data: data,
        success: function(response) {
            if (response.code == 200) {
                setTimeout(
                    function () {
                        showAlert("Cảm ơn bạn đã đóng góp ý kiến!", 'success', 5000);
                        location.reload();
                    }, 4000
                );
            }
        },
        error: function(response) {
            showAlert("Có lỗi vui lòng thử lại!", 'danger', 5000);
        }
    });
}


function setActiveTab(tab_name) {
    const elements = document.querySelectorAll(tab_name+' .nav-item');

    elements.forEach((el, index) => {
        el.children[0].classList.remove("active");
        if(index==0) {
            el.children[0].classList.add("active");
        }
    });

    const tab_pane = document.querySelectorAll(tab_name+' .tab-pane');

    tab_pane.forEach((el, index) => {
        el.classList.remove("active");
        el.classList.remove("show");
        if(index==0) {
            el.classList.add("active");
            el.classList.add("show");
        }
    });
}

//remove all images
function resetImages() {
    $("#list-photos-items div").remove();

    //hidden reset class
    $(".reset-gallery").addClass("hidden");

}

//show notification success
function showNotiSuccess(message) {
    $('.toast-title').html("Success");
    $('.toast-message').html(message);
    $("#toast-container .toast").addClass("toast-success");

    $('#delUser').modal('toggle');
    $('#toast-container').show().delay(5000).slideUp();
}

//show notification error
function showNotiError(message) {
    $('.toast-title').html("Error");
    $('.toast-message').html(message);
    $("#toast-container .toast").addClass("toast-error");

    $('#delUser').modal('toggle');
    $('#toast-container').show().delay(5000).slideUp();
}

//load page
function locationPage(url) {
    if (!!!url) {
        window.location.reload();
    } else {
        window.location.href = url;
    }
}

function formatDatetime(datetime) {
    return datetime.replace("T", " ").substring(0, 19);
}

function changeTimezone(responseDate) {
    let dateComponents;
    if(responseDate.indexOf('T') != -1) {
        dateComponents = responseDate.split('T');
    } else {
        dateComponents = responseDate.split(' ');
    }

    let datePieces = dateComponents[0].split("-");
    let timePieces = dateComponents[1].split(":");
    return datePieces[2]+'-'+datePieces[1]+'-'+datePieces[0]+' '+(parseInt(timePieces[0])+7)+':'+timePieces[1]+':'+timePieces[2].substring(0, 2);
}


// ### date dd/mm/yyyy
function changeDate(responseDate) {
    if(responseDate=='' || responseDate==null) return '';
    let dateComponents = responseDate.split(' ');
    let datePieces = dateComponents[0].split("-");
    return datePieces[2]+'/'+datePieces[1]+'/'+datePieces[0];
}

// value = datetime
function changeDateTime(responseDate) {
    let dateComponents;
    if(responseDate.indexOf('T') != -1) {
        dateComponents = responseDate.split('T');
    } else {
        dateComponents = responseDate.split(' ');
    }

    let datePieces = dateComponents[0].split("-");
    let timePieces = dateComponents[1].split(":");
    return datePieces[2]+'-'+datePieces[1]+'-'+datePieces[0]+' '+(parseInt(timePieces[0]))+':'+timePieces[1]+':'+timePieces[2].substring(0, 2);
}

function changeTime(responseDate) {
    let dateComponents;
    if(responseDate.indexOf('T') != -1) {
        dateComponents = responseDate.split('T');
    } else {
        dateComponents = responseDate.split(' ');
    }

    let datePieces = dateComponents[0].split("-");
    let timePieces = dateComponents[1].split(":");
    return datePieces[0]+'-'+datePieces[1]+'-'+datePieces[2]+' '+timePieces[0]+':'+timePieces[1];
}

function showAlert(message, type, closeDelay) {

    var $cont = $("#alerts-container");

    if ($cont.length == 0) {
        // alerts-container does not exist, create it
        $cont = $('<div id="alerts-container">')
            .css({
                position: "fixed"
                ,width: "16%"
                ,right: "40px"
                ,top: "10%"
                ,"z-index": "99999"
            })
            .appendTo($("body"));
    }

    let status = 'Lỗi!';
    if(type=='success') status = 'Thành công!';

    // default to alert-info; other options include success, warning, danger
    type = type || "danger";

    // create the alert div
    var alert = $('<div>')
        .addClass("fade in show alert alert-" + type)
        // .append(
        //     $('<button type="button" class="close" data-dismiss="alert">')
        //         .append("&times;")
        // )
        // .append('<i class="mdi mdi-alert" aria-hidden="true"></i>')
        // .append('<div><b>'+status+'</b></div>')
        .append(message);

    // add the alert div to top of alerts-container, use append() to add to bottom
    $cont.prepend(alert);

    // if closeDelay was passed - set a timeout to close the alert
    if (closeDelay)
        window.setTimeout(function() { alert.alert("close") }, closeDelay);

}

function notifyError(message) {
    new Notify({
        status: 'error',
        text:  `${message}`,
        effect: 'slide',
        speed: 300,
        customClass: null,
        customIcon: null,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 3000,
        gap: 20,
        distance: 20,
        type: 1,
        position: 'right top'
    })
}

function swalSuccess(message) {
    Swal.fire({
        text: `${message}`,
        icon: 'success',
        confirmButtonColor: '#5156be',
        autotimeout: 3000,
        autoclose: true,
    })

}


function toSlug(str) {
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();

    // xóa dấu
    str = str
        .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
        .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

    // Thay ký tự đĐ
    str = str.replace(/[đĐ]/g, 'd');

    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');

    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');

    // Xóa ký tự - liên tiếp
    str = str.replace(/-+/g, '-');

    // xóa phần dư - ở đầu & cuối
    str = str.replace(/^-+|-+$/g, '');

    // return
    return str;
}

$(document).on('click', '.btn-show-table-options', function(e){
    e.preventDefault(),
    $(e.currentTarget).closest(".table-wrapper").find(".table-configuration-wrap").slideToggle(500)
});

function getPageCurrent() {
    const url = new URL(window.location.href);
    return url.searchParams.get("status");
}

function formatPrice(price) {
    return price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

$(document).ready(function(){
    let screen_Height = $(window).height();
    let h = screen_Height - 50;
    $('.page-content').css("min-height", h);

    // js clear value input search
    Array.prototype.forEach.call(document.querySelectorAll('.clearable-input'), function(el) {
        var input = el.querySelector('input');

        conditionallyHideClearIcon();
        input.addEventListener('input', conditionallyHideClearIcon);
        el.querySelector('[data-clear-input]').addEventListener('click', function(e) {
            input.value = '';
            conditionallyHideClearIcon();

            loadDataTable();
        });

        function conditionallyHideClearIcon(e) {
            var target = (e && e.target) || input;
            target.nextElementSibling.style.display = target.value ? 'block' : 'none';
        }
    });

    //cal height table
    $('.tableFixHead').css('height', '583px');

});

var ExcelToJSON = function() {

    this.parseExcel = function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            workbook.SheetNames.forEach(function(sheetName) {
                // Here is your object
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var json_object = JSON.stringify(XL_row_object);
                countData(json_object, true);
            })

        };

        reader.onerror = function(ex) {
            console.log(ex);
        };

        reader.readAsBinaryString(file);
    };

    this.parseExcelDynamic = function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });

            workbook.SheetNames.forEach(function(sheetName) {
                // Here is your object
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var json_object = JSON.stringify(XL_row_object);
                countData(json_object, false);
            })

        };

        reader.onerror = function(ex) {
            console.log(ex);
        };

        reader.readAsBinaryString(file);
    };


};

let arrData = [], arrPhone = [], mapNetwork = new Map();
function countData(jsonObj, flagStatic) {
    let arrObj = $.parseJSON(jsonObj);

    for(let i=0; i<arrObj.length; i++) {
        let obj = arrObj[i];
        let phone = obj['phone'];

        //check format phone
        if (!isPhoneNumber(phone)) {
            setMap(mapNetwork, 'Unsupport');
        }
        else {
            //check exist
            let exist = arrPhone.includes(phone);
            if(exist) {
                setMap(mapNetwork, 'Unsupport');
            } else {
                arrPhone.push(phone);
                arrData.push(obj);
                setMap(mapNetwork, carriersNumber(phone));
                setMap(mapNetwork, 'Valid');
            }
        }
    }

    if(arrData.length > 0) {
        if(flagStatic) {
            setDataToTable(arrData);
        } else{
            setDataToTableDynamic(arrData);
        }
    }

    if(mapNetwork.size > 0) {
        $('#countVTL').text(mapNetwork.get('Viettel'));
        $('#countMobi').text(mapNetwork.get('Mobifone'));
        $('#countVina').text(mapNetwork.get('Vinaphone'));
        $('#countVNM').text(mapNetwork.get('VNM'));
        $('#countGmobile').text(mapNetwork.get('Gmobile'));
        $('#countItel').text(mapNetwork.get('Itelecom'));
        $('#countReddi').text(mapNetwork.get('Reddi'));
        $('#countUnsupport').text(mapNetwork.get('Unsupport'));
        $('#countValidateData').text(mapNetwork.get('Valid'));
    }
}

function isPhoneNumber(number) {
    return /([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/.test(number);
}

function setMap(map, key) {
    let num = map.get(key)==undefined ? 0 : map.get(key);
    num+=1;
    map.set(key, num);
}

function setDataToTable(data) {
    let html='', stt=1;
    for(let i=0; i<data.length; i++) {
        let obj = data[i];
        console.log(obj['phone']);
        html += '<tr>';
        html += '<td>' + stt + '</td>';
        html += '<td>' + obj['phone'] + '</td>';
        html += '</tr>';
        stt++;
    }
    $('#table-phone tbody tr').remove();
    $('#table-phone tbody').append(html);
}

function setDataToTableDynamic(data) {
    let html='', stt=1;

    var replaceArray = Object.keys(data[0]);

    for(let i=0; i<data.length; i++) {
        let sms = $(".templatesms_id option:selected").text();
        let obj = data[i];
        var replaceWith = [];
        for(let j=0; j<replaceArray.length; j++) {
            replaceWith.push(obj[replaceArray[j]]);
        }

        sms = mappingDataSms(sms, replaceArray, replaceWith);

        console.log(sms);
        console.log(obj['phone']);
        html += '<tr>';
        html += '<td>' + stt + '</td>';
        html += '<td>' + obj['phone'] + '</td>';
        html += '<td>' + sms + '</td>';
        html += '</tr>';
        stt++;
    }
    $('#table-phone tbody tr').remove();
    $('#table-phone tbody').append(html);
}

function mappingDataSms(sms, replaceArray, replaceWith) {
    var mapping = {replaceArray};
    replaceArray.forEach((e,i) => mapping[`{${e}}`] = replaceWith[i]);
    return sms.replace(/\{\w+\}/ig, n => mapping[n]);
}

function carriersNumber(phone) {
    let start_phone = phone.length==11 ? '0'+phone.substring(2, 4) : phone.substring(0, 3);
    switch (start_phone) {
        case '096':
        case '097':
        case '098':
        case '033':
        case '034':
        case '035':
        case '036':
        case '037':
        case '038':
        case '039':
            return 'Viettel';
        case '090':
        case '093':
        case '070':
        case '071':
        case '072':
        case '076':
        case '078':
            return 'Mobifone';
        case '091':
        case '094':
        case '084':
        case '085':
        case '085':
        case '089':
            return 'Vinaphone';
        case '099':
            return 'Gmobile';
        case '092':
        case '056':
        case '058':
            return 'VNM';
        case '055':
            return 'Reddi';
        case '087':
            return 'Itelecom';
    }
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

function spinnerShow(ele) {
    $(ele).prop("disabled", true);
    // add spinner to button
    $(ele).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
    );
}
function spinnerHide(ele, txt) {
    $(ele).prop("disabled", false);
    $(ele).text(txt);
}

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function run_waitMe(el, num, effect){
    text = '';
    fontSize = '';
    switch (num) {
        case 1:
            maxSize = '';
            textPos = 'vertical';
            break;
        case 2:
            text = '';
            maxSize = 30;
            textPos = 'vertical';
            break;
        case 3:
            maxSize = 30;
            textPos = 'horizontal';
            fontSize = '18px';
            break;
    }
    el.waitMe({
        effect: effect,
        text: text,
        bg: 'rgba(255,255,255,0.7)',
        color: '#6F57F1',
        maxSize: maxSize,
        waitTime: -1,
        source: 'img.svg',
        textPos: textPos,
        fontSize: fontSize,
        onClose: function(el) {}
    });
}

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1.$2");
    return x;
}


function convertViToEn(str) {
    str = str.toLowerCase()
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, "a");
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, "e");
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, "i");
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, "o");
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, "u");
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, "y");
    str = str.replace(/(đ)/g, "d");
    str = str.replace(/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/g, "a");
    str = str.replace(/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/g, "e");
    str = str.replace(/(Ì|Í|Ị|Ỉ|Ĩ)/g, "i");
    str = str.replace(/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/g, "o");
    str = str.replace(/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/g, "u");
    str = str.replace(/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/g, "y");
    str = str.replace(/(Đ)/g, "d");
    str = str.replace(/ /g, "-");
    return str;
}





