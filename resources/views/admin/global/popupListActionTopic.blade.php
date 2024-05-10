<?php
use App\Models\Topic;
// use \App\Models\Role_has_permissions;

?>
<style>
    .modal-delete {
        background-color: #ff5252 !important;
        border-color: #ff5252 !important;
        color: #fff !important;
        text-align: center !important;
        display: inline-block;
        padding: 10px;
        /* position: relative; */
    }

    .close {
        position: absolute;
        top: 5px;
        right: 10px;
    }

    .btn-dagerdel {
        background-color: #ff5252 !important;
        border-color: #ff5252 !important;
        color: #fff;

    }

    .btn {
        padding: 0.375rem 0.75rem;
        border-radius: 5px;
    }

    .btn:hover {
        color: #FFF;
        text-decoration: none;
    }

    .btn-black {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #fff;
    }

    .modal-footer-delete {
        border-top: none !important;
        display: inline-block;
        text-align: center;
    }

    .modal-body-delete {
        padding: 0 !important;
    }

    .title-del {
        font-size: 16px;
    }

    button:focus {
        outline: none !important;
        border: none !important;
    }

    .modal-dialog {
        min-width: 500px;
    }
</style>
<div id="modal-topic-tab" class="modal fade" role="dialog">
    <div class="modal-dialog " style="max-width: 1300px;">
        <!-- Modal content-->
        <div class="modal-content modal-content-progress">
            <div class="modal-header bg-modal my-modal modal-skill-cus">
                <h4 class="modal-title text-left">
                    <i class="til_img"></i>
                    <strong>Danh sách chức năng chủ đề </strong>
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
                                {{-- @if(Role_has_permissions::hasPermissionByName('Cập nhật tra cứu')) --}}
                                <a title="Cập nhật thông tin loại kỹ năng" class="btn btn-sm active" href=""
                                   id="eventUpdate"
                                   name="id" style="color: #4B49AC"
                                   group="data" convertToAttr="data-id" data-toggle="modal"><i
                                        class="mdi mdi-pencil"></i> </a>
                                {{-- @endif --}}
                                {{-- @if(Role_has_permissions::hasPermissionByName('Xóa tra cứu')) --}}
                                <span>
                                    <a title="Xóa" class="btn btn-sm "
                                       style="color: red"  data-toggle="modal"
                                       data-target="#modal-delete-topic">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </span>
                                {{-- @endif --}}
                            </div>
                            <form class="form-body form-disabled" id="data-one">
                                <input group="data" type="hidden" name="id-intro">
                                <div class="row">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Tên chủ đề<span>*</span></label>
                                    <input class="form-control" id="nameTopic" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Tên chủ đề"  disabled="true">
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <select class="form-control select-status" group="data" name="status" disabled="true" id="statusTopic">
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
                        <div class="tab-pane fade" id="nav-intro" role="tabpanel" aria-labelledby="nav-intro-tab">
                            @include('admin.global.intro.list')
                        </div>

                        <div class="tab-pane fade" id="nav-news" role="tabpanel" aria-labelledby="nav-news-tab">
                            @include('admin.global.news.list')
                        </div>
                        <div class="tab-pane fade" id="nav-keyword" role="tabpanel" aria-labelledby="nav-keyword-tab">
                            @include('admin.global.keyword.list')
                        </div>
                        <div class="tab-pane fade" id="nav-more" role="tabpanel" aria-labelledby="nav-more-tab">
                            @include('admin.global.news-more.list')
                        </div>
                        <div class="tab-pane fade" id="nav-video" role="tabpanel" aria-labelledby="nav-video-tab">
                            @include('admin.global.video.list')
                        </div>
                        <div class="tab-pane fade" id="nav-document" role="tabpanel" aria-labelledby="nav-document-tab">
                            @include('admin.global.document.list')
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
<!-- MODAL DELETE -->
<div id="modal-delete-topic" class="modal fade" role="dialog">
    <div class="modal-dialog " style="width: 500px; margin-top:15%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title text-center">
                    <i class="til_img"></i>
                    <strong>Thông báo</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center modal-body-delete">
                <p class="title-del pt-5">Bạn có xác nhận xóa bản ghi ?</p>
            </div>
            <div class="modal-footer modal-footer-delete">
                <button type="button" class="btn btn-dagerdel my-btn-default" id="delete-topic">
                    <span class="pr-2"><i class="fa fa-check-circle"></i></span>Xác nhận
                </button>
                <button type="button" class="btn btn-black my-btn-default" data-dismiss="modal">
                    <i class="fa fa-times-circle"></i>Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const config = {
            urlGetModelFromDb: "/admin/topic/getOne",
            urlUpdateModelToDb: "/admin/topic/edit",
            urlDeleteModelToDb: "/admin/topic/delete",
        }

        let idUser = '';
        $('#idTable tbody').on('click', '.list-topic-modal', function () {
            self = this;
            idUser = $(self).data("id");
            loadDataByidPopUp(idUser)
        });
        // load data thông tin
        function loadDataByidPopUp($id) {
            data['id'] = $id;
            let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
            if (result.code == 200) {
                $("#nameTopic").val(result.data.name);
                $("#statusTopic").val(result.data.status);
            }
        }

        //envent update
        $(document).on("click", "#btnUpdateEvent", function () {
            let data = {
                'id': idUser,
                'name': $("#nameTopic").val(),
                'status': $("#statusTopic").val(),
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

        // delete category
        $('#modal-delete-topic').on('click', '#delete-topic', function () {
            let data = {
                'id': idUser,
            };
            let result = ajaxQuery(config.urlDeleteModelToDb, data, 'POST');
            if (result.code == 200) {
                swalSuccess(result.message);

                loadDataTable();
                $("[data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            }
        });

        $('.js-example-basic-single').select2();
    });
</script>

