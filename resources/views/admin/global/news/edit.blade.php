<div id="modal-edit-news" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 800px; ">
        <div class="modal-content">
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
                                        <label class="btn btnChoose" onclick="setImage('intro-news-image-edit');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="intro-news-image-edit"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="intro-news-image-edit">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tiêu đề<span>*</span></label>
                        <textarea id="news_title_edit" class="form-control" group="data" name="title"
                                  type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Thể loại</label>
                        <select class="form-control select-status" group="data" name="type" id="sel_update">
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Mô tả ngắn</label>
                        <textarea id="news_description_edit" class="form-control" group="data" name="description"
                                  type="text" autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content_edit" type="text" autocomplete="off"
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditNews">
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
            urlEditNews: "/admin/news/edit",
            urlAGetOneNews: "/admin/news/getOne",
        };

        $('#idTable_news tbody').on('click', '.edit-news', function () {
            self = this;
            loadDataByidPopUp($(self).data("id"))
        });

        // load data thông tin
        function loadDataByidPopUp($id) {
            clearData();

            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneNews, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-news input[name='id']").val(lstData.id);
            // $("#modal-edit-news input[name='title']").val(lstData.title);
            // $("#modal-edit-news textarea[name='description']").val(lstData.description);
            $("#modal-edit-news select[name='status']").val(lstData.status);
            $("#modal-edit-news select[name='type']").val(lstData.type).trigger("change");
            $("#modal-edit-news img[name='image']").attr('src', lstData.image);
            $("#modal-edit-news input[name='priority']").val(lstData.priority);
            if (lstData.is_hot == 1) $("#modal-edit-news input[name='is_hot']").prop('checked', true);
            if (lstData.show_home == 1) $("#modal-edit-news input[name='show_home']").prop('checked', true);

            let fncCallbackTitle = function () {
                CKEDITOR.instances['news_title_edit'].setData(lstData.title);
            };
            CKEDITOR.instances['news_title_edit'].setData("", fncCallbackTitle);

            let fncCallback = function () {
                CKEDITOR.instances['content_edit'].setData(lstData.content);
            };
            CKEDITOR.instances['content_edit'].setData("", fncCallback);

            let fncCallback_des = function () {
                CKEDITOR.instances['news_description_edit'].setData(lstData.description);
            };
            CKEDITOR.instances['news_description_edit'].setData("", fncCallback_des);

            $(".select2-results__option[data-val='" + lstData.type + "']").addClass("showme");
        }

        $('#modal-edit-news').on('click', '#btnEditNews', function () {
            let data = {
                'id': $("#modal-edit-news input[name='id']").val(),
                'title': CKEDITOR.instances['news_title_edit'].getData(),
                'status': $("#modal-edit-news select[name='status']").val(),
                'image': $("#modal-edit-news img[name='image']").attr('src'),
                'type': $("#modal-edit-news select[name='type']").val(),
                'is_hot': $("#modal-edit-news input[name='is_hot']").is(":checked") ? 1 : 0,
                'show_home': $("#modal-edit-news input[name='show_home']").is(":checked") ? 1 : 0,
                'content': CKEDITOR.instances['content_edit'].getData(),
                'description': CKEDITOR.instances['news_description_edit'].getData(),
                'priority': $("#modal-edit-news input[name='priority']").val(),
            };
            let result = ajaxQuery(config.urlEditNews, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableNews();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-news [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-news [name='" + key + "']").parent();
                        $("#modal-edit-news [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        function clearData() {
            // $("#modal-edit-news textarea[name='title']").val('');
            $("#modal-edit-news select[name='type']").val("");
            $("#modal-edit-news textarea[name='description']").val('');
            $("#modal-edit-news select[name='status']").val(1);
            $("#modal-edit-news img[name='image']").attr('src', '/admin/img/placeholder.png');
            $("#modal-edit-news input[name='is_hot']").prop('checked', false);
            $("#modal-edit-news input[name='priority']").val('');
            $("#modal-edit-news input[name='show_home']").val('');

            CKEDITOR.instances['news_title_edit'].setData("");
            CKEDITOR.instances['content_edit'].setData("");
            CKEDITOR.instances['news_description_edit'].setData("");

            $("#modal-edit-news .show-invalid").remove();

        }

        $("#sel_update").select2();

    });
</script>


