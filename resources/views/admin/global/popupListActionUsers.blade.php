<?php
use \App\Models\Role_has_permissions;
?>


<div id="modal-users-tab" class="modal fade" role="dialog">
    <div class="modal-dialog " style="max-width: 1200px;">
        <!-- Modal content-->
        <div class="modal-content modal-content-progress">
            <div class="modal-header bg-modal my-modal modal-skill-cus">
                <h4 class="modal-title text-left">
                    <i class="til_img"></i>
                    <strong>Danh sách chức năng người dùng</strong>
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
                                @if(Role_has_permissions::hasPermissionByName('Cập nhập người dùng'))
                                <a title="Cập nhật thông tin loại kỹ năng" class="btn btn-sm active" href=""
                                   id="eventUpdate"
                                   name="id" style="color: #4B49AC"
                                   group="data" convertToAttr="data-id" data-toggle="modal"><i
                                        class="mdi mdi-pencil"></i> </a>
                                @endif
                                @if(Role_has_permissions::hasPermissionByName('Xóa người dùng'))
                                <span>
                                    <a title="Xóa" class="btn btn-sm idDelete"
                                       style="color: red"  data-toggle="modal"
                                       data-target="#popup-delete" data-id="" data-url="">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </span>
                                @endif
                            </div>
                            <form class="form-body form-disabled">
                                <input group="data" type="hidden" name="id">
                                <div class="form-group">
                                    <label class="control-label required">Tên đầy đủ<span>*</span></label>
                                    <input class="form-control" group="data" name="name-popup" type="text" autocomplete="off" spellcheck="false" placeholder="Tên đầy đủ"  disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Số điện thoại</label>
                                    <input class="form-control" group="data" name="phone" type="text" autocomplete="off" spellcheck="false" placeholder="Số điện thoại"  disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Email <span>*</span></label>
                                    <input class="form-control" group="data" name="email" type="text"autocomplete="off" spellcheck="false" placeholder="Email" disabled="true">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required ">Tài khoản đăng nhập <span>*</span></label>
                                    <input class="form-control" group="data" name="username_popup" type="text" id="dvct" autocomplete="off" spellcheck="false" placeholder="Tài khoản đăng nhập" disabled="true">
                                </div>
                                <div class="form-group position-relative">
                                    <label class="control-label label-password required">Mật khẩu <span>*</span></label>
                                    <input class="form-control" group="data" name="password" id="password" type="password" autocomplete="off" placeholder="Mật khẩu" disabled="true">
                                    <span class="btn-show-pass">
                                        <i class="mdi mdi-eye"></i>
                                    </span>
                                </div>
                                <div class="form-group position-relative">
                                    <label class="control-label label-password required">Nhập lại mật khẩu <span>*</span></label>
                                    <input class="form-control" group="data" name="re_password" id="password" type="password" autocomplete="off" placeholder="Nhập lại mật khẩu" disabled="true">
                                    <span class="btn-show-pass">
                                        <i class="mdi mdi-eye"></i>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Quyền truy cập</label>
                                    <select id="select_status_permision" class="form-control select-status" group="data" name="role_id"  disabled="true">
                                        <?php use App\Models\Role;$data_roles = Role::allRolesActive(); ?>
                                        @foreach($data_roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <select id="select_status" class="form-control select-status" group="data" name="status"  disabled="true">
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
            urlGetModelFromDb: "/admin/system/users/get",
            urlUpdateModelToDb: "/admin/system/users/edit",
            urlDeleteModelToDb: "/admin/system/users/delete",
        }

        let idUser = '';
        $('#idTable tbody').on('click', '.list-users-modal', function () {
            self = this;
            idUser = $(self).data("id");
            loadDataByidPopUp(idUser)
        });
        // load data thông tin
        function loadDataByidPopUp($id) {
            data['id'] = $id;
            let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
            let lstData = result.data;
            $("input[name='name-popup']").val(lstData.name);
            $("input[name='phone']").val(lstData.phone);
            $("input[name='email']").val(lstData.email);
            $("input[name='username_popup']").val(lstData.username);
            $("input[name='role_id']").val(lstData.role_id);
            // $("input[name='password']").val(lstData.password);
            // $("input[name='re_password']").val(lstData.username);
            $("#select_status").val(lstData.status);
            $("#select_status_permision").val(lstData.role_id);


            $('.idDelete').attr('data-id',idUser);
            $('.idDelete').attr('data-url',config.urlDeleteModelToDb);
        }

        //envent update
        $(document).on("click", "#btnUpdateEvent", function () {
            let data = {
                'id': idUser,
                'name': $("input[name='name-popup']").val(),
                'phone': $("input[name='phone']").val(),
                'email': $("input[name='email']").val(),
                'username': $("input[name='username_popup']").val(),
                'status': $("#select_status").val(),
                'role_id':$("#select_status_permision").val(),
                'password':$("input[name='password']").val(),
            }
            let result = ajaxQuery(config.urlUpdateModelToDb, data, 'POST');
            if (result.code == 200) {
                //notify success
                swalSuccess(result.message);
                loadDataTable();
                //close modal
                $("[data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
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

