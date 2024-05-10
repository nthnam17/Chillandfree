<div id="modal-form-intro" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 800px; ">
        <div class="modal-content" >
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
                    <div class="form-group text-center">
                        <label class="control-label required">Hình ảnh</label>
                        <div class="widget-body">
                            <div class="fileupload-preview fileupload-exists">
                                <div class="preview-image-wrapper-white">
                                    <div class="field-news-image">
                                        <label class="btn btnChoose" onclick="setImage('intro-add-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="intro-add-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="intro-add-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tên giới thiệu<span>*</span></label>
                        <textarea class="form-control"  group="data" name="nameIntro" type="text" autocomplete="off"
                                  spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Mô tả ngắn</label>
                        <textarea class="form-control" group="data" name="description" type="text" autocomplete="off" spellcheck="false"></textarea>
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
                <button type="button" class="btn btn-success active btn-custom" id="btnAddIntro">
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
            urlAddIntro: "/admin/intro/add",
        }

        $('#modal-form-intro').on('click', '#btnAddIntro', function () {
            let data = {
                'lookup_id': $("input[name='id-intro']").val(),
                'name': CKEDITOR.instances['nameIntro'].getData(),
                'description': $("#modal-form-intro textarea[name='description']").val(),
                'status': $("#modal-form-intro select[name='status']").val(),
                'image': $("#modal-form-intro img[name='image']").attr('src'),
            }
            let result = ajaxQuery(config.urlAddIntro, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableIntro()
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-intro [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-intro-form [name='" + key + "']").parent();
                        $("#modal-form-intro-form [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
