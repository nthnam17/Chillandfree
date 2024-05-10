<div id="modal-edit-intro" class="modal" data-backdrop="static">
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
                                        <label class="btn btnChoose" onclick="setImage('intro-edit-image');">
                                            <i class="fas fa-image" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                    <img src="/admin/img/placeholder.png" width="150" alt="" id="intro-edit-image"
                                         name="image"
                                         group="data">
                                    <a class="btn_remove_image" title="Remove image" img-remove="intro-edit-image">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Tên giới thiệu<span>*</span></label>
                        <textarea class="form-control" group="data" name="nameIntroUpdate" type="text" autocomplete="off" spellcheck="false"></textarea>
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditIntro">
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
            urlEditIntro: "/admin/intro/edit",
            urlAGetOneIntro: "/admin/intro/getOne",
        }

        $('#idTable_intro tbody').on('click', '.edit-intro', function () {
            console.log('12345')
            self = this;
            loadDataByidPopUp($(self).data("id"))
        });

        // load data thông tin
        function loadDataByidPopUp($id) {
            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneIntro, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-intro input[name='id']").val(lstData.id);
            // $("#modal-edit-intro input[name='name']").val(lstData.name);
            $("#modal-edit-intro textarea[name='description']").val(lstData.description);
            $("#modal-edit-intro select[name='status']").val(lstData.status);
            $("#modal-edit-intro img[name='image']").attr('src', lstData.image);


            let fncCallback = function () {
                CKEDITOR.instances['nameIntroUpdate'].setData(lstData.name);
            };
            CKEDITOR.instances['nameIntroUpdate'].setData("", fncCallback);
        }

        $('#modal-edit-intro').on('click', '#btnEditIntro', function () {
            let data = {
                'id': $("#modal-edit-intro input[name='id']").val(),
                'name': CKEDITOR.instances['nameIntroUpdate'].getData(),
                'description': $("#modal-edit-intro textarea[name='description']").val(),
                'status': $("#modal-edit-intro select[name='status']").val(),
                'image': $("#modal-edit-intro img[name='image']").attr('src'),
            }
            let result = ajaxQuery(config.urlEditIntro, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableIntro()
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-intro [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-intro [name='" + key + "']").parent();
                        $("#modal-edit-intro [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
