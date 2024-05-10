<!-- Modal Reset Password -->
<div id="popup-reset-password" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Thay đổi mật khẩu</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="title-reset">Bạn có chắc chắn muốn thay đổi mật khẩu ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success my-btn-default btnReset">
                    <i class="fa fa-check-circle"></i>Đồng ý
                </button>
                <button type="button" class="btn btn-danger my-btn-default" data-dismiss="modal">
                    <i class="fa fa-times-circle"></i>Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete -->

<script>
//show dialog delete
$('#table tbody').on('click', '.reset-password', function() {
    var txtAlert = 'Bạn có chắc chắn muốn thay đổi mật khẩu cho ' + $(this).data("name") + ' ?';
    $('.title-reset').html(txtAlert);
    self = this;
    // $('#delPer').modal('show');
});
</script>
