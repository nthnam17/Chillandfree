<div id="modal-edit-related" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 1500px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Cập nhật thông tin liên quan</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-body">
                    <input group="data" type="hidden" name="id">
                    <div class="form-group text-center">
                        <label class="control-label required">Hình ảnh</label>
                        <div class="widget-body">
                            <div class="fileupload-preview fileupload-exists">
                                <div class="preview-image-wrapper-white">
                                    <div class="field-news-image">
                                        <label class="btn btnChoose" onclick="setImage('related-edit-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="related-edit-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="related-edit-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tên<span>*</span></label>
                        <textarea class="form-control" group="data" name="nameRelatedUpdate" type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content_edit_related" type="text"
                                  autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Ưu tiên</label>
                        <input class="form-control" group="data" name="priority" type="text" autocomplete="off"
                               spellcheck="false" placeholder="Ưu tiên">
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditRelated">
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
            urlEditRelated: "/admin/related/edit",
            urlAGetOneRelated: "/admin/related/getOne",
        };

        $('#idTable_related tbody').on('click', '.edit-related', function () {
            self = this;
            loadDataByidPopUp($(self).data("id"))
        });

        // load data thông tin
        function loadDataByidPopUp($id) {
            clearData();

            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneRelated, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-related input[name='id']").val(lstData.id);
            $("#modal-edit-related input[name='priority']").val(lstData.priority);
            $("#modal-edit-related select[name='status']").val(lstData.status);
            $("#modal-edit-related img[name='image']").attr('src', lstData.image);

            let fncCallbackName = function () {
                CKEDITOR.instances['nameRelatedUpdate'].focus();
                CKEDITOR.instances['nameRelatedUpdate'].setData(lstData.name);
            };

            let fncCallback = function () {
                CKEDITOR.instances['content_edit_related'].focus();
                CKEDITOR.instances['content_edit_related'].setData(lstData.content);
            };

            CKEDITOR.instances['content_edit_related'].setData("", fncCallback);
            CKEDITOR.instances['nameRelatedUpdate'].setData("", fncCallbackName);
        }

        $('#modal-edit-related').on('click', '#btnEditRelated', function () {
            let data = {
                'id': $("#modal-edit-related input[name='id']").val(),
                'name': CKEDITOR.instances['nameRelatedUpdate'].getData(),
                'priority': $("#modal-edit-related input[name='priority']").val(),
                'status': $("#modal-edit-related select[name='status']").val(),
                'image': $("#modal-edit-related img[name='image']").attr('src'),
                'content': CKEDITOR.instances['content_edit_related'].getData(),
            };
            let result = ajaxQuery(config.urlEditRelated, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableRelated();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-related [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-related [name='" + key + "']").parent();
                        $("#modal-edit-related [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        function clearData() {
            $("#modal-edit-related input[name='priority']").val('');
            $("#modal-edit-related select[name='status']").val(1);
            $("#modal-edit-related img[name='image']").attr('src', '/admin/img/placeholder.png');

            CKEDITOR.instances['nameRelatedUpdate'].setData("");
            CKEDITOR.instances['content_edit_related'].setData("");

            $("#modal-edit-related .show-invalid").remove();
        }

    });
</script>
