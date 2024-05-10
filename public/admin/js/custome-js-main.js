$(document).ready(function () {

    // disable filter khi click show modal
    $(".disable-modal-notification").on("click", function () {
        $(".form-disabled .form-control").attr("disabled", true);
        $('select[name=selValue]').selectpicker('refresh');
            $(".showHidenCus").removeClass('show-cus');
            $(".showHidenCus").addClass('hiden-cus');
    });

    //setup disable form
    $("#eventUpdate").on("click", function () {
        $(".form-disabled .form-control").prop("disabled", false);
        $('select[name=selValue]').selectpicker('refresh');
        $(".showHidenCus").removeClass('hiden-cus');
        $(".showHidenCus").addClass('show-cus');
    });

    // setup sự kiện of update
    $(".EnventOffUpdate").on("click", function () {
        $(".form-disabled .form-control").attr("disabled", true);
        $('select[name=selValue]').selectpicker('refresh');
        $(".showHidenCus").removeClass('show-cus');
        $(".showHidenCus").addClass('hiden-cus');
    });

    // $(".btn-custom").on("click", function () {
    //     $(".form-disabled .form-control").attr("disabled", true);
    //     $('select[name=selValue]').selectpicker('refresh');
    //     $(".showHidenCus").removeClass('show-cus');
    //     $(".showHidenCus").addClass('hiden-cus');
    // });

    $(".btn-canel").on("click", function () {
        $(".form-disabled .form-control").attr("disabled", true);
        showErrorMessage("name", "");
        $(".showHidenCus").removeClass('show-cus');
        $(".showHidenCus").addClass('hiden-cus');
        $(':radio').prop('checked',false);
    });

    $(".modal-header .close").on("click", function () {
        $(':radio').prop('checked',false);
    });

    $(".my-btn-default").on("click", function () {
        $(':radio').prop('checked',false);
    });
});
