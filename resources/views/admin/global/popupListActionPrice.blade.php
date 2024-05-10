<?php
use App\Models\SkillType;
?>
<style>
    .toggle-switch {
  margin-top: 20px;
  position: relative;
}
.toggle-switch label {
  padding: 0;
}
input#cb-switch-edit {
  display: none;
}
.toggle-switch label input + span {
      position: relative;
    display: inline-block;
    margin-right: 10px;
    width: 3rem;
    height: 1.5rem;
    background: #bdc1c8;
    border: 1px solid #eee;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
    box-shadow: inset 0 0 5px #828282;
}
.toggle-switch label input + span small {
    position: absolute;
    display: block;
    width: 1rem;
    height: 1rem;
    border-radius: 1.875rem;
    background: #fff;
    transition: all 0.3s ease-in-out;
    top: 0.2rem;
    left: 0.2rem;
}
.toggle-switch label input:checked + span {
  background-color: #ff8800;
}
.toggle-switch label input:checked + span small{
    left: 1.7rem;
    transition: left .25s;
}
.toggle-switch span:after {
    top: -9px;
    content: "Best Sale";
    line-height: 2.5rem;
    width: 8rem;
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 2px;
    position: absolute;
    bottom: 0;
    transition: opacity .25s;
    left: 2.5rem;
    opacity: 0.5;
    color: #6b7381;
}
.toggle-switch label input:checked + span:after {
  opacity: 1;
}
</style>



<div id="modal-price-tab" class="modal fade" role="dialog">
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
                            {{-- <form class="form-body form-disabled">
                                <input group="data" type="hidden" name="id">
                                <div class="form-group text-center">
                                    <div class="widget-body">
                                        <div class="fileupload-preview fileupload-exists">
                                            <div class="preview-image-wrapper-white">
                                                <div class="field-news-image">
                                                    <label class="btn btnChoose" onclick="setImage('image');">
                                                        <i class="fas fa-image" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                                <img src="/admin/img/placeholder.png" width="150" alt="" id="icon" name="image" class="project-image"
                                                     group="data">
                                                <a class="btn_remove_image" title="Remove image" img-remove="image">
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
                            </form> --}}
                            <form class="form-body form-disabled">
                                <input group="data" type="hidden" name="id">
                                <div class="form-group text-center">
                                    <label class="control-label required">Hình ảnh</label>
                                    <div class="widget-body">
                                        <div class="fileupload-preview fileupload-exists">
                                            <div class="preview-image-wrapper-white">
                                                <div class="field-news-image">
                                                    <label class="btn btnChoose" onclick="setImage('image_edit');">
                                                        <i class="fas fa-image" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                                <img src="/admin/img/placeholder.png" width="150" alt="" id="image_edit"
                                                        name="image_edit"
                                                        group="data">
                                                <a class="btn_remove_image" title="Remove image_edit" img-remove="image_edit">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Tên<span>*</span></label>
                                    <input class="form-control" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Tên bảng giá" disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mô tả ngắn</label>
                                    <textarea class="form-control description" group="data" name="description" type="text" autocomplete="off" spellcheck="false" placeholder="Mô tả ngắn" disabled="true"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Giá</label>
                                    <input class="form-control" group="data" name="price" type="text" autocomplete="off" spellcheck="false" placeholder="Giá" disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nội dung </label>
                                    <textarea class="form-control content_edit" group="data" name="content_edit" type="text" autocomplete="off" spellcheck="false" placeholder="Nội dung" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Ghi chú </label>
                                    <textarea class="form-control note" group="data" name="note" type="text" autocomplete="off" spellcheck="false" placeholder="Ghi chú" disabled="true"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="toggle-switch">
                                        <label for="cb-switch">
                                        <input type="checkbox" id="cb-switch-edit" value="">
                                        <span>
                                            <small></small>
                                        </span>
                                        </label>
                                    </div>
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
            urlGetModelFromDb: "/admin/price_table/getPrice",
            urlUpdateModelToDb: "/admin/price_table/edit",
            urlDeleteModelToDb: "/admin/price_table/delete",
        }

        let idUser = '';
        $('#idTable tbody').on('click', '.list-price-modal', function () {
            self = this;
            idUser = $(self).data("id");
            loadDataByidPopUp(idUser)
        });
        // load data thông tin
        function loadDataByidPopUp($id) {
            data['id'] = $id;
            let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
            let lstData = result.data;
            $("input[name='name']").val(lstData.name);
            $("input[name='price']").val(lstData.price);
            $(".description").val(lstData.description);
            $("input[name='is_best_sale']").prop("checked", lstData.is_best_sale == 1 ? true : false);  
            CKEDITOR.instances['content_edit'].setData(lstData.content);
            $(".note").val(lstData.note);
            $("#image_edit").attr('src', lstData.image);
            $('.idDelete').attr('data-url',config.urlDeleteModelToDb);
        }

        //envent update
        $(document).on("click", "#btnUpdateEvent", function () {
            var best_sale = $('#cb-switcht-edit').is(':checked');
            let data = {
                'id': idUser,
                'name': $("input[name='name']").val(),
                'price': $("input[name='price']").val(),
                'image': $("#image_edit").attr('src'),
                'description': $(".description").val(),
                'note': $(".note").val(),
                'best_sale':best_sale == true ? 1 : 0,
                'content':CKEDITOR.instances['content_edit'].getData()
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
        ckeditor('content_edit');
        $('.js-example-basic-single').select2();
    });
</script>

