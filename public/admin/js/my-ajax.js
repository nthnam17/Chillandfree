
$('#search').on('keyup',function(){
    $value = $(this).val();
    $.ajax({
        type: "POST",
        url: '/admin/news/search',
        data: {
            'search': $value
        },
        success:function(data){
            $('tbody').html(data);
        }
    });
})

function ajaxQuery(url, data, strType) {
    var arrResults = new Array();
    $.ajax({
        dataType: 'json',
        async: false,
        url: url,
        type: strType,
        cache: false,
        data: data,
        success: function(response) {
            arrResults = response;
        },
        error: function (response) {
            if( response.status === 422 ) {
                arrResults = $.parseJSON(response.responseText);
            }
            //arrResults = response.responseJSON;
        }
    });

    return arrResults;
}

$(document).on({
    ajaxStart: function () {
        $("#iconLoading").show();
    },
    ajaxStop: function () {
        $("#iconLoading").hide();
    }
});





