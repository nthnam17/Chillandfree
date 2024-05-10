// var touchStartTimeStamp = 0;
// var touchEndTimeStamp   = 0;
// var timer;
// window.addEventListener('touchstart', onTouchStart,false);
// window.addEventListener('touchend', onTouchEnd,false);

// console.log(11111)

// document.addEventListener('touchstart', function(e) {
//     if (e.touches.length == 2) {
//         e.preventDefault();
//     }
// }, { passive: false });

// function onTouchStart(e) {
//     touchStartTimeStamp = e.timeStamp;
// }

// function onTouchEnd(e) {
//     touchEndTimeStamp = e.timeStamp;
//     var touchHold = touchEndTimeStamp - touchStartTimeStamp;
//     if(touchHold >= 500){
//         e.preventDefault();
//     }
// }



// //menu

// const { includes } = require("lodash");

//   $(window).scroll(function() {
//     var a = $(window).scrollTop();
//     if (a > 100) {
//         $('.scroll-menu').slideDown();

//     } else {
//         $('.scroll-menu').slideUp();
//     }
//     console.log(a);
//   });

//owl-slider
$(".owl-banner").owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
        },
    },
});

$(".owl-estate").owlCarousel({
    loop: false,
    // margin: 10,
    nav: false,
    dots: true,
    // autoplay: true,
    // autoplayTimeout: 5000,
    // autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 1,
        },
    },
});

$(".owl-project").owlCarousel({
    loop: true,
    // margin: 10,
    nav: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 1,
        },
        1000: {
            items: 3,
        },
    },
});

function showAlert(message, type, closeDelay) {
    var $cont = $("#alerts-container");

    if ($cont.length == 0) {
        // alerts-container does not exist, create it
        $cont = $('<div id="alerts-container">')
            .css({
                position: "fixed",
                width: "17%",
                right: "40px",
                top: "100px",
                "z-index": "99999",
            })
            .appendTo($("body"));
    }

    // default to alert-info; other options include success, warning, danger
    type = type || "info";

    // create the alert div
    var alert = $("<div>")
        .addClass("fade in show alert alert-" + type)
        .append(
            $(
                '<button type="button" class="close" data-dismiss="alert">'
            ).append("&times;")
        )
        .append('<i class="mdi mdi-alert" aria-hidden="true"></i>')
        .append(message);

    // add the alert div to top of alerts-container, use append() to add to bottom
    $cont.prepend(alert);

    // if closeDelay was passed - set a timeout to close the alert
    if (closeDelay)
        window.setTimeout(function () {
            alert.remove();
        }, closeDelay);
}

//button-contact
function register_feedbackCt() {
    let _token = $('meta[name="csrf-token"]').attr("content");
    let email = $("input[name='email']").val();
    let name = $("input[name='name']").val();
    let address = $("input[name='address']").val();
    let phone = $("input[name='phone']").val();
    let content = $("#exampleFormControlTextarea5").val();

    if (name == "") {
        showAlert("Vui lòng nhập họ và tên  của bạn  !!!", "danger", 3000);
        return true;
    }
    if (email == "") {
        showAlert("Vui lòng nhập email của bạn  !!!", "danger", 3000);
        return true;
    }
    if (phone == "") {
        showAlert("Vui lòng nhập số điện thoại của bạn  !!!", "danger", 3000);
        return true;
    }
    if (!validatePhone(phone)) {
        showAlert("sai định dạng số diện thoại  !!!", "danger", 3000);
        return true;
    }
    if (!validateEmail(email)) {
        showAlert("sai định dạng số email  !!!", "danger", 3000);
        return true;
    }

    function validateEmail(email) {
        const re =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(email) {
        const re = /^([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})$/;
        return re.test(String(email).toLowerCase());
    }

    let data = {
        _token: _token,
        email: email,
        name: name,
        address: address,
        phone: phone,
        content: content,
    };

    $.ajax({
        dataType: "json",
        async: false,
        url: "/ajaxFeedback",
        type: "POST",
        cache: false,
        data: data,
        success: function (response) {
            if (response.code == 200) alert(response.message);
        },
        error: function (response) {
            alert("Có lỗi vui lòng thử lại!");
        },
    });
}

// Intro

// const INTERACTIVE_EVENTS = ["mousedown", "mousemove", "touchstart", "keydown"];

// const SCREENSAVER_TIMEOUT = 100;

// window.onload = () => {
// let lastEventTime = new Date();

// function screenSaver() {
//     let elapsed = new Date() - lastEventTime;
//     document.body.classList.toggle(
//         "has-screensaver",
//         elapsed > SCREENSAVER_TIMEOUT
//     );
//     setTimeout(screenSaver, 100);
// }

// INTERACTIVE_EVENTS.forEach((e) =>
//     window.addEventListener(e, () => (lastEventTime = new Date()))
// );

// screenSaver();
// };



// HOVER NO LINK
$(document).ready(function () {
    setTimeout(function () {

        $('a[href].no-link').each(function () {
            var href = this.href;

            $(this).removeAttr('href').css('cursor', 'pointer').click(function () {
                if (href.toLowerCase().indexOf("#") >= 0) {

                } else {
                    window.open(href, '_self');
                }
            });
        });

    }, 500);
});
