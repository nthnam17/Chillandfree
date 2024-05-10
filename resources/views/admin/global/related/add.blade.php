<div id="modal-form-related-add" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 1500px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Thêm mới thông tin liên quan</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-body">
                    <input group="data" type="hidden" name="id">
                    <input group="data" type="hidden" name="news_battles_id">
                    <div class="form-group text-center">
                        <label class="control-label required">Hình ảnh</label>
                        <div class="widget-body">
                            <div class="fileupload-preview fileupload-exists">
                                <div class="preview-image-wrapper-white">
                                    <div class="field-news-image">
                                        <label class="btn btnChoose" onclick="setImage('related-add-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="related-add-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="related-add-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tên<span>*</span></label>
                        <textarea class="form-control" group="data" name="nameRelated" type="text" autocomplete="off"
                                  spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content_related" type="text"
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
                <button type="button" class="btn btn-success active btn-custom" id="btnAddRelated">
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
            urlAddRelated: "/admin/related/add",
        };

        $('#modal-form-related-add').on('click', '#btnAddRelated', function () {
            console.log($("#modal-form-related-add input[name='name']").val())
            let data = {
                'news_battles_id': $('#modal-form-related-add input[name="news_battles_id"]').val(),
                'name': CKEDITOR.instances['nameRelated'].getData(),
                'content': CKEDITOR.instances['content_related'].getData(),
                'status': $("#modal-form-related-add select[name='status']").val(),
                'priority': $("#modal-form-related-add input[name='priority']").val(),
                'image': $("#modal-form-related-add img[name='image']").attr('src'),
            };
            let result = ajaxQuery(config.urlAddRelated, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableRelated();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-related-add [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-related-add [name='" + key + "']").parent();
                        $("#modal-form-battles-add [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
