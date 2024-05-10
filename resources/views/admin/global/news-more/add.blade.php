<div id="modal-form-news-more" class="modal" data-backdrop="static">
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
                                        <label class="btn btnChoose" onclick="setImage('image-news-more');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="image-news-more"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="image-news-more">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tiêu đề<span>*</span></label>
                        <textarea class="form-control"  group="data" name="titleNewMore" type="text" autocomplete="off"
                                  spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Thể loại</label>
                        <select class="form-control select-status" group="data" name="type" id="new_more__add">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Mô tả ngắn</label>
                        <textarea id="news_more_description" class="form-control" group="data" name="description" type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea id="news_more" class="form-control" group="data" name="content" type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nổi bật</label>
                        <input group="data" name="is_hot" type="checkbox" autocomplete="off" spellcheck="false"></input>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Ưu tiên</label>
                        <input class="form-control" group="data" name="priority" type="text" autocomplete="off" spellcheck="false" placeholder="Ưu tiên">
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
                <button type="button" class="btn btn-success active btn-custom" id="btnAddNewsMore">
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
            urlAddNewsMore: "/admin/news_more/add",
        };

        $('#modal-form-news-more').on('click', '#btnAddNewsMore', function () {
            let data = {
                'lookup_id': $("input[name='id-intro']").val(),
                // 'title': $("#modal-form-news-more input[name='title']").val(),
                'title': CKEDITOR.instances['titleNewMore'].getData(),
                'description': CKEDITOR.instances['news_more_description'].getData(),
                'content': CKEDITOR.instances['news_more'].getData(),
                'type': $("#modal-form-news-more select[name='type']").val(),
                'status': $("#modal-form-news-more select[name='status']").val(),
                'is_hot': $("#modal-form-news-more input[name='is_hot']").is(":checked") ? 1 : 0,
                'image': $("#modal-form-news-more img[name='image']").attr('src'),
                'priority': $("#modal-form-news-more input[name='priority']").val(),
            }
            let result = ajaxQuery(config.urlAddNewsMore, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableNewsMore()
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-news-more [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-news-more [name='" + key + "']").parent();
                        $("#modal-form-news-more [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        $('#new_more__add').select2();

    });
</script>
