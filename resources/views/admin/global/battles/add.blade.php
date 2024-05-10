<div id="modal-form-battles-add" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 1500px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Thêm mới thông tin khác</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-body">
                    <input group="data" type="hidden" name="id">
                    <input group="data" type="hidden" name="news_id">
                    <div class="form-group text-center">
                        <label class="control-label required">Hình ảnh</label>
                        <div class="widget-body">
                            <div class="fileupload-preview fileupload-exists">
                                <div class="preview-image-wrapper-white">
                                    <div class="field-news-image">
                                        <label class="btn btnChoose" onclick="setImage('battles-add-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="battles-add-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="battles-add-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tên<span>*</span></label>
                        <textarea class="form-control" group="data" name="nameBattles" type="text" autocomplete="off"
                                  spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content_battles" type="text"
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
                <button type="button" class="btn btn-success active btn-custom" id="btnAddBattles">
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
            urlAddBattles: "/admin/battles/add",
        };

        $('#modal-form-battles-add').on('click', '#btnAddBattles', function () {
            let data = {
                'news_id': $('#modal-form-battles-add input[name="news_id"]').val(),
                'name': CKEDITOR.instances['nameBattles'].getData(),
                'content': CKEDITOR.instances['content_battles'].getData(),
                'status': $("#modal-form-battles-add select[name='status']").val(),
                'priority': $("#modal-form-battles-add input[name='priority']").val(),
                'image': $("#modal-form-battles-add img[name='image']").attr('src'),
            };
            let result = ajaxQuery(config.urlAddBattles, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableBattles();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-battles-add [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-battles-add [name='" + key + "']").parent();
                        $("#mmodal-form-battles-add [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
