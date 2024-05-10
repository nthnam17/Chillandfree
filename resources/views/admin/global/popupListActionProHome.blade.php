<?php
use App\Models\SkillType;
?>


<div id="modal-product-home-tab" class="modal fade" role="dialog">
    <div class="modal-dialog " style="max-width: 1200px;">
        <!-- Modal content-->
        <div class="modal-content modal-content-progress">
            <div class="modal-header bg-modal my-modal modal-skill-cus">
                <h4 class="modal-title text-left">
                    <i class="til_img"></i>
                    <strong>Danh sách chức năng </strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-body-delete main-progress-update">
                <div class="container scrollbar pt-3" id="form-skill">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                               role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <div class="d-flex justify-content-end">
                                <a title="Cập nhật thông tin loại kỹ năng" class="btn btn-sm active" href=""
                                   id="eventUpdate"
                                   name="id" style="color: #4B49AC"
                                   group="data" convertToAttr="data-id" data-toggle="modal"><i
                                        class="mdi mdi-pencil"></i> </a>
                                <span>
                                    <a title="Xóa" class="btn btn-sm idDelete"
                                       style="color: red"  data-toggle="modal"
                                       data-target="#popup-delete" data-id="" data-url="">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </div>
                            <form class="form-body form-disabled">
                                <input group="data" type="hidden" name="id">
                                <div class="form-group text-center">
                                    <div class="widget-body">
                                        <div class="fileupload-preview fileupload-exists">
                                            <div class="preview-image-wrapper-white">
                                                <div class="field-news-image">
                                                    <label class="btn btnChoose" onclick="setImage('image_edit');">
                                                        <i class="fas fa-image" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                                <img src="/admin/img/placeholder.png" width="150" alt="" id="image_edit" name="image_edit" class="image_edit"
                                                     group="data">
                                                <a class="btn_remove_image" title="Remove image" img-remove="image_edit">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Link_video</label>
                                    <input class="form-control" group="data" name="link_video" type="text" autocomplete="off" spellcheck="false" placeholder="Đường dẫn"  disabled="true">
                                </div>
                            </form>
                            <div class="d-flex justify-content-end">
                                <button type="button"
                                        class="btn btn-success active btn-custom hiden-cus showHidenCus mr-2"
                                        id="btnUpdateEvent">
                                    Cập nhật
                                </button>
                                <button type="button"
                                        class="btn btn-danger btn-canel active btn-custom hiden-cus showHidenCus EnventOffUpdate">
                                    Hủy bỏ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-footer-delete text-right">
                <button type="button" class="btn btn-danger btn-canel active btn-custom" data-dismiss="modal">
                    <i class="fa fa-times-circle"></i>Đóng
                </button>
            </div>
        </div>
    </div>
</div>
@include('admin.global.popupDelete')
<script>
    $(document).ready(function () {
        const config = {
            urlGetModelFromDb: "/admin/woay_product_created/getId",
            urlUpdateModelToDb: "/admin/woay_product_created/edit",
            urlDeleteModelToDb: "/admin/woay_product_created/delete",
        }

        let idUser = '';
        $('#idTable tbody').on('click', '.list-product-home-modal', function () {
            self = this;
            idUser = $(self).data("id");
            loadDataByidPopUp(idUser)
        });
        // load data thông tin
        function loadDataByidPopUp($id) {
            data['id'] = $id;
            let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
            let lstData = result.data;
            $("input[name='link_video']").val(lstData.link_video);
            $("#image_edit").attr(lstData.iamge),
            $('.idDelete').attr('data-url',config.urlDeleteModelToDb);
        }

        //envent update
        $(document).on("click", "#btnUpdateEvent", function () {
            let data = {
                'id': idUser,
                'link_video': $("input[name='link_video']").val(),
                'image': $("#image_edit").attr('src'),
            }
            let result = ajaxQuery(config.urlUpdateModelToDb, data, 'POST');
            if (result.code == 200) {
                swalSuccess(result.message);
                loadDataTable();
                $("[data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form [name='" + key + "']").parent();
                        $("#modal-form [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

        $('.js-example-basic-single').select2();
    });
</script>

