<div id="modal-edit-battles" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 1500px; ">
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Cập nhật thông tin khác</strong>
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
                                        <label class="btn btnChoose" onclick="setImage('battles-edit-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="battles-edit-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="battles-edit-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tên<span>*</span></label>
                        <textarea class="form-control" group="data" name="nameBattlesUpdate" type="text"
                                  autocomplete="off" spellcheck="false"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Nội dung</label>
                        <textarea class="form-control" group="data" name="content_edit_battles" type="text"
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditBattles">
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
            urlEditBattles: "/admin/battles/edit",
            urlAGetOneBattles: "/admin/battles/getOne",
        };

        $('#idTable_battles tbody').on('click', '.edit-battles', function () {
            console.log('123456');
            self = this;
            loadDataByidPopUp($(self).data("id"))
        });

        // load data thông tin
        function loadDataByidPopUp($id) {
            clearData();

            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneBattles, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-battles input[name='id']").val(lstData.id);
            $("#modal-edit-battles input[name='priority']").val(lstData.priority);
            $("#modal-edit-battles select[name='status']").val(lstData.status);
            $("#modal-edit-battles img[name='image']").attr('src', lstData.image);

            let fncCallback = function () {
                CKEDITOR.instances['content_edit_battles'].focus();
                CKEDITOR.instances['content_edit_battles'].setData(lstData.content);
            };

            CKEDITOR.instances['content_edit_battles'].setData("", fncCallback);

            let fncCallbackName = function () {
                CKEDITOR.instances['nameBattlesUpdate'].focus();
                CKEDITOR.instances['nameBattlesUpdate'].setData(lstData.name);
            };

            CKEDITOR.instances['nameBattlesUpdate'].setData("", fncCallbackName);
        }

        $('#modal-edit-battles').on('click', '#btnEditBattles', function () {
            let data = {
                'id': $("#modal-edit-battles input[name='id']").val(),
                'name': CKEDITOR.instances['nameBattlesUpdate'].getData(),
                'priority': $("#modal-edit-battles input[name='priority']").val(),
                'status': $("#modal-edit-battles select[name='status']").val(),
                'image': $("#modal-edit-battles img[name='image']").attr('src'),
                'content': CKEDITOR.instances['content_edit_battles'].getData(),
            };
            let result = ajaxQuery(config.urlEditBattles, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableBattles();
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-battles [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-battles [name='" + key + "']").parent();
                        $("#modal-edit-battles [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        function clearData() {
            $("#modal-edit-battles input[name='priority']").val('');
            $("#modal-edit-battles select[name='status']").val(1);
            $("#modal-edit-battles img[name='image']").attr('src', '/admin/img/placeholder.png');

            CKEDITOR.instances['nameBattlesUpdate'].setData("");
            CKEDITOR.instances['content_edit_battles'].setData("");

            $("#modal-edit-battles .show-invalid").remove();

        }

    });
</script>
