<?php
use App\Models\SkillType;
?>


<div id="modal-menu-tab" class="modal fade" role="dialog">
    <div class="modal-dialog " style="max-width: 1200px;">
        <!-- Modal content-->
        <div class="modal-content modal-content-progress">
            <div class="modal-header bg-modal my-modal modal-skill-cus">
                <h4 class="modal-title text-left">
                    <i class="til_img"></i>
                    <strong>Danh sách chức năng menu</strong>
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
                                <div class="form-group">
                                    <label class="control-label required">Tên<span>*</span></label>
                                    <input class="form-control" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Tên"  disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Đường dẫn<span>*</span></label>
                                    <input class="form-control" group="data" name="slug_menu" type="text" autocomplete="off" spellcheck="false" placeholder="Đường dẫn"  disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Loại cha</label>
                                    <select id="parent_id" class="form-control select-status" group="data" name="parent_id"  disabled="true">
                                        <option value="">Lựa chọn</option>
                                        <?php use App\Models\Menu; $data = Menu::getParentMenu()?>
                                        @foreach($data as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>  
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <select id="status_menu" class="form-control select-status" group="data" name="status"  disabled="true">
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Ngừng hoạt động</option>
                                    </select>
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
            urlGetModelFromDb: "/admin/system/menu/getMenu",
            urlUpdateModelToDb: "/admin/system/menu/edit",
            urlDeleteModelToDb: "/admin/system/menu/delete",
        }

        let idUser = '';
        $('#idTable tbody').on('click', '.list-menu-modal', function () {
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
            $("input[name='slug_menu']").val(lstData.slug_menu);
            $("#parent_id").val(lstData.parent_id);
            $("#status_menu").val(lstData.status);
            $('.idDelete').attr('data-id',idUser);
            $('.idDelete').attr('data-url',config.urlDeleteModelToDb);
        }

        //envent update
        $(document).on("click", "#btnUpdateEvent", function () {
            let data = {
                'id': idUser,
                'name': $("input[name='name']").val(),
                'slug_menu': $("input[name='slug_menu']").val(),
                'status': $("#status_menu").val(),
                'parent_id':$("#parent_id").val(),
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

