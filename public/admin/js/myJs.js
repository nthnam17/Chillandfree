function ckeditor(name) {
    // var editor = CKEDITOR.replace(name,{
    //     uiColor: '#518ca3',
    //     language: 'vi',
    // });
    var editor = CKEDITOR.replace(name);
}

function comConfirm(msg){
    if (window.confirm(msg)) {
        return true;
    }
    return false;
}


//choose avatar image
function BrowseServer() {
    CKFinder.popup({
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
//remove image
const samplePhoto = '/admin/img/placeholder.png';
// $(".btn_remove_image").click(function () {
$(document).on('click', '.btn_remove_image', function(e) {
    e.preventDefault();
    let img_remove = $(this).attr('img-remove');
    $("#"+img_remove).attr("src", samplePhoto);
});

function chooseFile(eleImage) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                let file = evt.data.files.first();
                let idEle = '#' + eleImage;
                $(idEle).val(file.getUrl());
                updateRemoveFileLink(file.changed.url);
            });
        }
    });
}

function updateRemoveFileLink(url) {
    $('.url-data-file').attr('href', url);
}

//choose Gallery images
function appendFileToList(eleImage, path,namePhaseVi,namePhaseEn) {
    if (!path) {
        return;
    }
    let div = document.createElement("div");
    div.setAttribute("class", "col-md-3 mb-5");

    let inputDivVI = document.createElement("input");
    inputDivVI.setAttribute("class", "form-control mb-2");
    inputDivVI.setAttribute("type", "text");
    inputDivVI.setAttribute("placeholder", "Giai đoạn VI");
    inputDivVI.setAttribute("group", "data");
    inputDivVI.setAttribute("name", "name_phase_vi");
    if(namePhaseVi !== null || namePhaseVi !== ''){
        inputDivVI.value = namePhaseVi
    }
    div.appendChild(inputDivVI);

    let inputDivEN = document.createElement("input");
    inputDivEN.setAttribute("class", "form-control mb-2");
    inputDivEN.setAttribute("type", "text");
    inputDivEN.setAttribute("placeholder", "Giai đoạn EN");
    inputDivEN.setAttribute("group", "data");
    inputDivEN.setAttribute("name", "name_phase_en");
    if(namePhaseEn !== null || namePhaseEn !== ''){
        inputDivEN.value = namePhaseEn
    }
    div.appendChild(inputDivEN);

    let aRemove = document.createElement("a");
    aRemove.setAttribute("class", "btn_remove_col");
    aRemove.setAttribute("style", "top: -15px;");
    aRemove.addEventListener("click", function() {
        div.remove();
    });
    aRemove.innerHTML = '<i class="fa fa-times"></i>';
    div.appendChild(aRemove);

    let a = document.createElement("a");
    a.setAttribute("href", path);
    a.setAttribute("class", "url-data-file");
    a.setAttribute("group", "data");
    a.setAttribute("name", "file");
    a.setAttribute("target", "_blank");

    let inputAnchor = document.createElement("input");
    inputAnchor.setAttribute("id", eleImage);
    inputAnchor.setAttribute("class", "form-control");
    inputAnchor.setAttribute("type", "text");
    inputAnchor.setAttribute("group", "data");
    inputAnchor.setAttribute("style", "cursor: pointer");
    inputAnchor.setAttribute("name", "file");
    inputAnchor.setAttribute("readonly", "");
    inputAnchor.value = path;

    a.appendChild(inputAnchor);

    div.appendChild(a);
    $('.list-gallery__phase').append(div);

}

function galleryFiles() {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                var url = file.getUrl();
                var namePhaseVi = ''
                var namePhaseEn = ''
                appendFileToList('eleImage', url,namePhaseVi,namePhaseEn);
            });
        }
    });
}

//choose Gallery images
function galleryImages() {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();

                genLstImg(file.getUrl());

            });
        }
    });
}

function genLstImg(pathImg) {
    if (!pathImg) {
        return;
    }
    let div = document.createElement("div");
    div.setAttribute("class", "col-md-3 mb-2");

    let div1 = document.createElement("div");
    div1.setAttribute("class", "fileupload-preview");
    div.appendChild(div1);

    let div2 = document.createElement("div");
    div2.setAttribute("class", "preview-image-wrapper-white");
    div1.appendChild(div2);

    let div3 = document.createElement("div");
    div3.setAttribute("class", "field-news-image");
    div2.appendChild(div3);

    let length = $('.list-gallery .col-md-3').length;
    let idFile = 'xFile'+length++;

    let label = document.createElement("label");
    label.setAttribute("class", "btn btnChoose btnChoose1");
    label.setAttribute("idFile", idFile);
    div3.appendChild(label);

    let i = document.createElement("i");
    i.setAttribute("class", "fas fa-image");
    label.appendChild(i);

    let img = document.createElement("img");
    img.setAttribute("src", pathImg);
    img.setAttribute("id", idFile);
    img.setAttribute("class", "imgChange");
    div2.appendChild(img);

    let i1 = document.createElement("i");
    i1.setAttribute("class", "fa fa-times");

    let a = document.createElement("a");
    a.setAttribute("class", "btn_remove_col");
    a.appendChild(i1);
    div1.appendChild(a);

    div2.appendChild(a);
    $('.list-gallery').append(div);
}

$(document).on('click', '.btn_remove_col', function(e) {
    e.preventDefault();
    $(this).parent().parent().parent().remove();
});

$(document).on("click", ".btnChoose1", function(e) {
    let id = $(this).attr('idFile');
    setImage(id);

});

$(document).on('blur', '.item-name, .item-description', function() {
    let cls = $(this).attr('locale');
    setValGallery(cls);
});

//remove image
$(document).on('click', '.btn_remove_col', function(e) {
    e.preventDefault();
    $(this).parent().parent().remove();
    let cls = $(this).attr('locale');
    setValGallery(cls);

});

function setValGallery(cls) {
    //array value image
    let lstImg = [];
    $(".gallery_image_wrapper-"+cls).each(function () {
        let item = {};
        item["img"] = $(this).find('img').attr('src');
        item["name"] = $(this).parent().find('input').val();
        item["description"] = $(this).parent().find('textarea').val();
        lstImg.push(item);
    });
    $('#gallery-data-'+cls).val(JSON.stringify(lstImg));

    if(lstImg.length==0) $(".reset-gallery-"+cls).addClass("hidden");

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
        if(index==0) {
            el.classList.add("active");
        }
    });

    for(name in CKEDITOR.instances)
    {
        let data = CKEDITOR.instances[name].getData()
        CKEDITOR.instances[name].destroy(true);

        CKEDITOR.replace(name);
        CKEDITOR.instances[name].setData( data, function()
        {
            this.checkDirty();  // true
        });
    }
}

//remove all images
function resetImages(cls) {
    $(".photo-gallery-"+cls+" div").remove();

    $('#gallery-data-'+cls).val(null);

    //hidden reset class
    $(".reset-gallery-"+cls).addClass("hidden");

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
    let h = (parseInt(timePieces[0])+7) < 10 ? '0'+(parseInt(timePieces[0])+7) : (parseInt(timePieces[0])+7);
    // return datePieces[0]+'-'+datePieces[1]+'-'+datePieces[2]+' '+h+':'+timePieces[1]+':'+timePieces[2].substring(0, 2);

    return datePieces[2]+'-'+datePieces[1]+'-'+datePieces[0]+' '+h+':'+timePieces[1]+':'+timePieces[2].substring(0, 2);
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
                ,bottom: "0"
                ,"z-index": "99999"
            })
            .appendTo($("body"));
    }

    // default to alert-info; other options include success, warning, danger
    type = type || "info";

    // create the alert div
    var alert = $('<div>')
        .addClass("fade in show alert alert-" + type)
        .append(
            $('<button type="button" class="close" data-dismiss="alert">')
                .append("&times;")
        )
        .append('<i class="mdi mdi-alert" aria-hidden="true"></i>')
        .append(message);

    // add the alert div to top of alerts-container, use append() to add to bottom
    $cont.prepend(alert);

    // if closeDelay was passed - set a timeout to close the alert
    if (closeDelay)
        window.setTimeout(function() { alert.alert("close") }, closeDelay);
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
    return url.searchParams.get("page");
}

function formatPrice(price) {
    return price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

// ### date dd/mm/yyyy
function changeDate(responseDate) {
    if(responseDate=='' || responseDate==null) return '';
    let dateComponents = responseDate.split(' ');
    let datePieces = dateComponents[0].split("-");
    return datePieces[2]+'/'+datePieces[1]+'/'+datePieces[0];
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

    //change tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        for(name in CKEDITOR.instances)
        {
            let data = CKEDITOR.instances[name].getData()
            CKEDITOR.instances[name].destroy(true);

            CKEDITOR.replace(name);
            CKEDITOR.instances[name].setData( data, function()
            {
                this.checkDirty();  // true
            });
        }
    });

});

$.fn.charCounter = function(e, t) {
    var a, n;
    e = e || 100,
        t = $.extend({
            container: "<span></span>",
            classname: "charcounter",
            format: "(%1 character(s) remain)",
            pulse: !0,
            delay: 0
        }, t);
    var o = function(o, r) {
        (o = $(o)).val().length > e && (o.val(o.val().substring(0, e)),
        t.pulse && !a && i(r, !0)),
            t.delay > 0 ? (n && window.clearTimeout(n),
                n = window.setTimeout(function() {
                    r.html(t.format.replace(/%1/, e - o.val().length))
                }, t.delay)) : r.html(t.format.replace(/%1/, e - o.val().length))
    }
        , i = function e(t, n) {
        a && (window.clearTimeout(a),
            a = null),
            t.animate({
                opacity: .1
            }, 100, function() {
                $(t).animate({
                    opacity: 1
                }, 100)
            }),
        n && (a = window.setTimeout(function() {
            e(t)
        }, 200))
    };
    return this.each(function(e, a) {
        var n;
        t.container.match(/^<.+>$/) ? ($(a).next("." + t.classname).remove(),
            n = $(t.container).insertAfter(a).addClass(t.classname)) : n = $(t.container),
            $(a).unbind(".charCounter").bind("keydown.charCounter", function() {
                o(a, n)
            }).bind("keypress.charCounter", function() {
                o(a, n)
            }).bind("keyup.charCounter", function() {
                o(a, n)
            }).bind("focus.charCounter", function() {
                o(a, n)
            }).bind("mouseover.charCounter", function() {
                o(a, n)
            }).bind("mouseout.charCounter", function() {
                o(a, n)
            }).bind("paste.charCounter", function() {
                setTimeout(function() {
                    o(a, n)
                }, 10)
            }),
        a.addEventListener && a.addEventListener("input", function() {
            o(a, n)
        }, !1),
            o(a, n)
    })
}
$(document).on("click", "input[data-counter], textarea[data-counter]", function(e) {
    $(e.currentTarget).charCounter($(e.currentTarget).data("counter"), {
        container: "<small></small>"
    })
});

$(document).on("click", ".btnChoose1", function(e) {
    let id = $(this).attr('idFile');
    setImage(id);

});

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
                $(idEle).attr("src", file.getUrl());

                if($(idEle).hasClass("imgChange")) {
                    setValGallery($(idEle).attr('locale'));
                }
            });
        }
    });
}

function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = seconds / 31536000;

    if (interval > 1) {
        return Math.floor(interval) + " years";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
        return Math.floor(interval) + " months";
    }
    interval = seconds / 86400;
    if (interval > 1) {
        return Math.floor(interval) + " days";
    }
    interval = seconds / 3600;
    if (interval > 1) {
        return Math.floor(interval) + " hours";
    }
    interval = seconds / 60;
    if (interval > 1) {
        return Math.floor(interval) + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}

function reChangeTable(roleId) {
    if ($('#idTable tbody tr').length <= 0) return;

    $('#idTable tbody tr').each(function () {
        let status = $(this).find('td:nth-child(5)').text();

        if(roleId == 24) {
            $(this).find('td:nth-child(9) a:nth-child(7)').hide();
            if (status == 'Chờ duyệt') {
                $(this).find('td:nth-child(9) a:nth-child(3)').show();
                $(this).find('td:nth-child(9) a:nth-child(4)').hide();
            } else if (status === 'Đã duyệt') {
                $(this).find('td:nth-child(9) a:nth-child(3)').hide();
                $(this).find('td:nth-child(9) a:nth-child(4)').show();
            } else if (status === 'Từ chối duyệt') {
                $(this).find('td:nth-child(9 a:nth-child(3)').hide();
                $(this).find('td:nth-child(9) a:nth-child(4)').hide();
            }
        }

        if (roleId == 68) {
            if (status == 'Chờ duyệt') {
                $(this).find('td:nth-child(9) a:nth-child(3)').show();
                $(this).find('td:nth-child(9) a:nth-child(4)').hide();
            } else if (status === 'Đã duyệt') {
                $(this).find('td:nth-child(9) a:nth-child(3)').hide();
                $(this).find('td:nth-child(9) a:nth-child(4)').show();
            } else if (status === 'Từ chối duyệt') {
                $(this).find('td:nth-child(9) a:nth-child(3)').hide();
                $(this).find('td:nth-child(9) a:nth-child(4)').hide();
            }
        }

            if (roleId == 89) {
                if (status == 'Đã duyệt') {
                    $(this).find('td:nth-child(9) a:nth-child(3), td:nth-child(9) a:nth-child(4), td:nth-child(9) a:nth-child(5)').hide();
                } else if (status === 'Chờ duyệt') {
                    $(this).find('td:nth-child(9) a:nth-child(3), td:nth-child(9) a:nth-child(4)').show();
                    $(this).find('td:nth-child(9) a:nth-child(5)').hide();
                } else if (status === 'Từ chối duyệt') {
                    $(this).find('td:nth-child(9) a:nth-child(5)').show();
                }
            }
    });
}



