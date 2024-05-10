<div id="modal-form-news" class="modal" data-backdrop="static">
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
                    <div class="form-group text-center">
                        <label class="control-label required">Hình ảnh</label>
                        <div class="widget-body">
                            <div class="fileupload-preview fileupload-exists">
                                <div class="preview-image-wrapper-white">
                                    <div class="field-news-image">
                                        <label class="btn btnChoose" onclick="setImage('intro-news-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="intro-news-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="intro-news-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label class="control-label required">Tiêu đề<span>*</span></label>--}}
{{--                        <input class="form-control" group="data" name="title" type="text" autocomplete="off"--}}
{{--                               spellcheck="false" placeholder="Tiêu đề">--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label class="control-label required">Tiêu đề<span>*</span></label>
                        <textarea id="news_title" class="form-control" group="data" name="title" type="text"
                                  autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Thể loại</label>
                        <select class="form-control select-status" group="data" name="type" id="sel_add">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Mô tả ngắn</label>
                        <textarea id="news_description" class="form-control" group="data" name="description" type="text"
                                  autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content" type="text" autocomplete="off"
                                  spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nổi bật</label>
                        <input group="data" name="is_hot" type="checkbox" autocomplete="off" spellcheck="false">
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Trang chủ</label>
                        <input group="data" name="show_home" type="checkbox" autocomplete="off" spellcheck="false">
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
                <button type="button" class="btn btn-success active btn-custom" id="btnAddNews">
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
            urlAddNews: "/admin/news/add",
        };

        $('#modal-form-news').on('click', '#btnAddNews', function () {
            let data = {
                'lookup_id': $("input[name='id-intro']").val(),
                // 'title': $("#modal-form-news input[name='title']").val(),
                'title': CKEDITOR.instances['news_title'].getData(),
                'description': CKEDITOR.instances['news_description'].getData(),
                'content': CKEDITOR.instances['content'].getData(),
                'type': $("#modal-form-news select[name='type']").val(),
                'status': $("#modal-form-news select[name='status']").val(),
                'is_hot': $("#modal-form-news input[name='is_hot']").is(":checked") ? 1 : 0,
                'show_home': $("#modal-form-news input[name='show_home']").is(":checked") ? 1 : 0,
                'image': $("#modal-form-news img[name='image']").attr('src'),
                'priority': $("#modal-form-news input[name='priority']").val(),
            };
            let result = ajaxQuery(config.urlAddNews, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableNews();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-news [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-news [name='" + key + "']").parent();
                        $("#modal-form-news [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });
        $("#sel_add").select2();
    });
</script>
