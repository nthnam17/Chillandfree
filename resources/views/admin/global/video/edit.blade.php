<div id="modal-edit-video" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 800px; ">
        <div class="modal-content" >
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Cập nhật </strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-body">
                    <input group="data" type="hidden" name="id">
                    <div class="form-group">
                        <label class="control-label required">Tiêu đề<span>*</span></label>
                        <input class="form-control" group="data" name="title" type="text" autocomplete="off" spellcheck="false" placeholder="Tiêu đề">
                    </div>
                    <div class="form-group">
                        <label class="control-label required">Ưu tiên</label>
                        <input class="form-control" group="data" name="priority" type="text" autocomplete="off" spellcheck="false" placeholder="Ưu tiên">
                    </div>
                    <div class="form-group">
                        <label for="upload_file" class="control-label">Upload video</label>
                        <div class="row">
                            <div class="col-sm-1" id="d-none-files">
                                <label class="btn btn-primary action-item"
                                       onclick="chooseFile('xFileVideoId');">
                                    <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                                </label>
                            </div>
                            <div class="col-sm-11">
                                <input id="xFileVideoId" class="form-control" type="text" group="data"
                                       style="padding-right: 35px;"
                                       name="source"
                                       readonly>
                                <a class="btn_remove_image" title="Remove image" onclick="removeFileVideo()"
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditVideo">
                    Cập nhật
                </button>
                <button type="button" class="btn btn-danger btn-canel active btn-custom " data-dismiss="modal">
                    Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const config = {
            urlEditVideo: "/admin/videos/edit",
            urlAGetOneVideo: "/admin/videos/get-data",
        }

        $('#idTable_video tbody').on('click', '.edit-video', function () {
            self = this;
            loadDataByIdVideo($(self).data("id"))
        });

        // load data thông tin
        function loadDataByIdVideo($id) {
            clearData();

            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneVideo, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-video input[name='id']").val(lstData.id);
            $("#modal-edit-video input[name='title']").val(lstData.title);
            $("#modal-edit-video input[name='source']").val(lstData.source);
            $("#modal-edit-video select[name='status']").val(lstData.status);
            $("#modal-edit-video input[name='priority']").val(lstData.priority);
        }

        $('#modal-edit-video').on('click', '#btnEditVideo', function () {
            let data = {
                'id': $("#modal-edit-video input[name='id']").val(),
                'title': $("#modal-edit-video input[name='title']").val(),
                'source': $("#modal-edit-video input[name='source']").val(),
                'status': $("#modal-edit-video select[name='status']").val(),
                'priority': $("#modal-edit-video input[name='priority']").val(),
            }
            let result = ajaxQuery(config.urlEditVideo, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableVideo();
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-video [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-video [name='" + key + "']").parent();
                        $("#modal-edit-video [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        function clearData() {
            $("#modal-edit-video input[name='title']").val('')
            $("#modal-edit-video input[name='source']").val("")
            $("#modal-edit-video select[name='status']").val(1);
            $("#modal-edit-video input[name='priority']").val('')
            $("#modal-edit-video .show-invalid").remove();
        }

    });
</script>

<script>
    function removeFileVideo() {
        var fileInput = document.getElementById('xFileVideoId');

        fileInput.value = '';
    }
</script>
