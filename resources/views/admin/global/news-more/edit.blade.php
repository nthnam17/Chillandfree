<div id="modal-edit-news-more" class="modal" data-backdrop="static">
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
                    <div class="form-group text-center">
                        <label class="control-label required">Hình ảnh</label>
                        <div class="widget-body">
                            <div class="fileupload-preview fileupload-exists">
                                <div class="preview-image-wrapper-white">
                                    <div class="field-news-image">
                                        <label class="btn btnChoose" onclick="setImage('image-news-more-edit');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="image-news-more-edit"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="image-news-more-edit">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tiêu đề<span>*</span></label>
                        <textarea class="form-control" group="data" name="titleNewMoreUpdate" type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Thể loại</label>
                        <select class="form-control select-status" group="data" name="type" id="new_more__update">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Mô tả ngắn</label>
                        <textarea id="news_more_description_edit" class="form-control" group="data" name="description" type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content_more_edit" type="text" autocomplete="off" spellcheck="false"></textarea>
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditNewsMore">
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
            urlEditNewsMore: "/admin/news_more/edit",
            urlAGetOneNewsMore: "/admin/news_more/get-data",
        }

        $('#idTable_news_more tbody').on('click', '.edit-news-more', function () {

            self = this;
            loadDataByIdNewsMore($(self).data("id"))
        });

        // load data thông tin
        function loadDataByIdNewsMore($id) {
            clearData();

            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneNewsMore, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-news-more input[name='id']").val(lstData.id);
            $("#modal-edit-news-more select[name='status']").val(lstData.status);
            $("#modal-edit-news-more select[name='type']").val(lstData.type).trigger("change");
            $("#modal-edit-news-more img[name='image']").attr('src', lstData.image);
            $("#modal-edit-news-more input[name='priority']").val(lstData.priority);
            if(lstData.is_hot==1) $("#modal-edit-news-more input[name='is_hot']").prop('checked', true);

            let fncCallbackTitle = function(){
                CKEDITOR.instances['titleNewMoreUpdate'].setData(lstData.title);
            };
            CKEDITOR.instances['titleNewMoreUpdate'].setData("", fncCallbackTitle);

            let fncCallback = function(){
                CKEDITOR.instances['content_more_edit'].setData(lstData.content);
            };
            CKEDITOR.instances['content_more_edit'].setData("", fncCallback);

            let fncCallback_des = function(){
                CKEDITOR.instances['news_more_description_edit'].setData(lstData.description);
            };
            CKEDITOR.instances['news_more_description_edit'].setData("", fncCallback_des);
            $(".select2-results__option[data-val='" + lstData.type + "']").addClass("showme");
        }

        $('#modal-edit-news-more').on('click', '#btnEditNewsMore', function () {
            let data = {
                'id': $("#modal-edit-news-more input[name='id']").val(),
                // 'description': $("#modal-edit-news textarea[name='description']").val(),
                'status': $("#modal-edit-news-more select[name='status']").val(),
                'image': $("#modal-edit-news-more img[name='image']").attr('src'),
                'type': $("#modal-edit-news-more select[name='type']").val(),
                'is_hot': $("#modal-edit-news-more input[name='is_hot']").is(":checked") ? 1 : 0,
                'title': CKEDITOR.instances['titleNewMoreUpdate'].getData(),
                'content': CKEDITOR.instances['content_more_edit'].getData(),
                'description': CKEDITOR.instances['news_more_description_edit'].getData(),
                'priority': $("#modal-edit-news-more input[name='priority']").val(),

            }
            let result = ajaxQuery(config.urlEditNewsMore, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableNewsMore();
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-news-more [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-news-more [name='" + key + "']").parent();
                        $("#modal-edit-news-more [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        function clearData() {
            $("#modal-edit-news-more select[name='type']").val("")
            $("#modal-edit-news-more textarea[name='description']").val('');
            $("#modal-edit-news-more select[name='status']").val(1);
            $("#modal-edit-news-more img[name='image']").attr('src', '/admin/img/placeholder.png');
            $("#modal-edit-news-more input[name='is_hot']").prop('checked', false);
            $("#modal-edit-news-more input[name='priority']").val('')

            CKEDITOR.instances['titleNewMoreUpdate'].setData("");
            CKEDITOR.instances['content_more_edit'].setData("");
            CKEDITOR.instances['news_more_description_edit'].setData("");

            $("#modal-edit-news-more .show-invalid").remove();

        }

        $('#new_more__update').select2();

    });
</script>
