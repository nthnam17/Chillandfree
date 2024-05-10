<div id="modal-form-video" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 800px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Thêm mới </strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-body">
                    <input group="data" type="hidden" name="id">
                    <div class="form-group">
                        <label class="control-label required">Tiêu đề<span>*</span></label>
                        <input class="form-control" group="data" name="title" type="text" autocomplete="off"
                               spellcheck="false" placeholder="Tiêu đề">
                    </div>
                    <div class="form-group">
                        <label class="control-label required">Ưu tiên</label>
                        <input class="form-control" group="data" name="priority" type="text" autocomplete="off"
                               spellcheck="false" placeholder="Ưu tiên">
                    </div>
                    <div class="form-group">
                        <label for="upload_file" class="control-label">Upload video</label>
                        <div class="row">
                            <div class="col-sm-1" id="d-none-files">
                                <label class="btn btn-primary action-item"
                                       onclick="chooseFile('xFileVideo');">
                                    <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                                </label>
                            </div>
                            <div class="col-sm-11">
                                <input id="xFileVideo" class="form-control" type="text" group="data"
                                       style="padding-right: 35px;"
                                       name="source"
                                       readonly>
                                <a class="btn_remove_image" title="Remove image" onclick="removeFile()"
                                   style="position: absolute;right: 15px;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Trạng thái</label>
                        <select class="form-control select-status" group="data" name="status">
                            <option value="1">Hoạt động</option>
                            <option value="2">Ngừng hoạt động</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success active btn-custom" id="btnAddVideo">
                    Thêm mới
                </button>
                <button type="button" class="btn btn-danger btn-canel active btn-custom btn-close" data-dismiss="modal">
                    Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const config = {
            urlAddVideo: "/admin/videos/add",
        };

        $('#modal-form-video').on('click', '#btnAddVideo', function () {
            let data = {
                'lookup_id': $("input[name='id-intro']").val(),
                'title': $("#modal-form-video input[name='title']").val(),
                'status': $("#modal-form-video select[name='status']").val(),
                'source': $("#modal-form-video input[name='source']").val(),
                'priority': $("#modal-form-video input[name='priority']").val(),
            };
            let result = ajaxQuery(config.urlAddVideo, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableVideo();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-video [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-video [name='" + key + "']").parent();
                        $("#modal-form-video [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
<script>
    function removeFile() {
        var fileInput = document.getElementById('xFileVideo');

        fileInput.value = '';
    }
</script>

