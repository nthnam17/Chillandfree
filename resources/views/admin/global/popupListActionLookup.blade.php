<?php
use App\Models\Topic;
use \App\Models\Role_has_permissions;

?>
<style>
    .main-progress-update .container {
        max-width: 100%;
    }
</style>
<div id="modal-lookup-tab" class="modal fade" role="dialog">
    <div class="modal-dialog " style="max-width: 1500px;">
        <!-- Modal content-->
        <div class="modal-content modal-content-progress">
            <div class="modal-header bg-modal my-modal modal-skill-cus">
                <h4 class="modal-title text-left">
                    <i class="til_img"></i>
                    <strong>Danh sách chức năng tra cứu</strong>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-body-delete main-progress-update">
                <div class="container scrollbar pt-3" id="form-skill">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                               role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                            @if(Role_has_permissions::hasPermissionByName('Danh sách giới thiệu'))
                            <a class="nav-item nav-link" id="nav-intro-tab" data-toggle="tab" href="#nav-intro"
                               role="tab" aria-controls="nav-intro" aria-selected="true">Giới thiệu</a>
                            @endif
                            @if(Role_has_permissions::hasPermissionByName('Xem danh sách nội dung'))
                            <a class="nav-item nav-link" id="nav-news-tab" data-toggle="tab" href="#nav-news"
                               role="tab" aria-controls="nav-news" aria-selected="true">Nội dung</a>
                            @endif
                            <a class="nav-item nav-link" id="nav-keyword-tab" data-toggle="tab" href="#nav-keyword"
                               role="tab" aria-controls="nav-keyword" aria-selected="true">Từ khóa</a>
                            <a class="nav-item nav-link" id="nav-more-tab" data-toggle="tab" href="#nav-more"
                               role="tab" aria-controls="nav-more" aria-selected="true">Tin xem thêm</a>
                            <a class="nav-item nav-link" id="nav-video-tab" data-toggle="tab" href="#nav-video"
                               role="tab" aria-controls="nav-video" aria-selected="true">Video</a>
                            <a class="nav-item nav-link" id="nav-document-tab" data-toggle="tab" href="#nav-document"
                               role="tab" aria-controls="nav-document" aria-selected="true">Tài liệu</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                             aria-labelledby="nav-home-tab">
                            <div class="d-flex justify-content-end">
                                @if(Role_has_permissions::hasPermissionByName('Cập nhật tra cứu'))
                                <a title="Cập nhật thông tin loại kỹ năng" class="btn btn-sm active" href=""
                                   id="eventUpdate"
                                   name="id" style="color: #4B49AC"
                                   group="data" convertToAttr="data-id" data-toggle="modal"><i
                                        class="mdi mdi-pencil"></i> </a>
                                @endif
                                @if(Role_has_permissions::hasPermissionByName('Xóa tra cứu'))
                                <span>
                                    <a title="Xóa" class="btn btn-sm idDelete"
                                       style="color: red"  data-toggle="modal"
                                       data-target="#modal-delete-lookup" data-id="" data-url="">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </span>
                                @endif
                            </div>
                            <form class="form-body form-disabled" id="data-one">
                                <input group="data" type="hidden" name="id-intro">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group text-center">
                                            <label class="control-label required">Hình ảnh</label>
                                            <div class="widget-body">
                                                <div class="fileupload-preview fileupload-exists">
                                                    <div class="preview-image-wrapper-white">
                                                        <div class="field-news-image">
                                                            <label class="btn btnChoose" onclick="setImage('edit-image');">
                                                                <i class="fas fa-image" aria-hidden="true"></i>
                                                            </label>
                                                        </div>
                                                        <img src="/admin/img/placeholder.png" width="150" alt="" id="edit-image"
                                                             name="image"
                                                             group="data">
                                                        <a class="btn_remove_image" title="Remove image" img-remove="edit-image">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-center">
                                            <label class="control-label required">Banner</label>
                                            <div class="widget-body">
                                                <div class="fileupload-preview fileupload-exists">
                                                    <div class="preview-image-wrapper-white">
                                                        <div class="field-news-image">
                                                            <label class="btn btnChoose" onclick="setImage('edit-banner');">
                                                                <i class="fas fa-image" aria-hidden="true"></i>
                                                            </label>
                                                        </div>
                                                        <img src="/admin/img/placeholder.png" width="150" alt="" id="edit-banner"
                                                             name="banner"
                                                             group="data">
                                                        <a class="btn_remove_image" title="Remove image" img-remove="edit-banner">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Tên tra cứu<span>*</span></label>
                                    <textarea class="form-control" group="data" name="nameLookupUpdate" type="text" autocomplete="off" spellcheck="false"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Chủ để</label>
                                    <select class="form-control select-status" group="data" name="topic_id" disabled="true">
                                        <?php $data =  Topic::selectAll() ?>
                                        <option value="">--Chọn--</option>
                                        @foreach($data as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Nội dung</label>
                                    <textarea class="form-control" group="data" name="contentLookup" type="text" autocomplete="off" spellcheck="false"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label required">Màu sắc</label>
                                    <input class="form-control" group="data" name="color" type="text" autocomplete="off" spellcheck="false" placeholder="Màu sắc" disabled="true">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <select class="form-control select-status" group="data" name="status" disabled="true">
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
<div id="modal-delete-lookup" class="modal fade" role="dialog">
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
                <button type="button" class="btn btn-dagerdel my-btn-default" id="delete-lookup">
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
            urlGetModelFromDb: "/admin/look_up/getOne",
            urlUpdateModelToDb: "/admin/look_up/edit",
            urlDeleteModelLookupToDb: "/admin/look_up/delete",
        }

        let idUser = '';
        $('#idTable tbody').on('click', '.list-lookup-modal', function () {
            self = this;
            idUser = $(self).data("id");
            loadDataByidPopUp(idUser)
        });
        // load data thông tin
        function loadDataByidPopUp($id) {
            data['id'] = $id;
            let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
            let lstData = result.data;
            // $("#data-one input[name='name']").val(lstData.name);
            $("#data-one input[name='id-intro']").val(lstData.id);
            $("#data-one select[name='topic_id']").val(lstData.topic_id);
            $("#data-one input[name='color']").val(lstData.color);
            $("#data-one select[name='status']").val(lstData.status);
            $("#data-one img[name='image']").attr('src', lstData.image);
            $("#data-one img[name='banner']").attr('src', lstData.banner);

            let fncCallbackName = function(){
                CKEDITOR.instances['nameLookupUpdate'].setData(lstData.name);
            };
            CKEDITOR.instances['nameLookupUpdate'].setData("", fncCallbackName);

            let fncCallback = function(){
                CKEDITOR.instances['contentLookup'].setData(lstData.content_lookup);
            };
            CKEDITOR.instances['contentLookup'].setData("", fncCallback);
        }

        //envent update
        $(document).on("click", "#btnUpdateEvent", function () {
            let data = {
                'id': idUser,
                'nameLookup': CKEDITOR.instances['nameLookupUpdate'].getData(),
                'topic_id': $("#data-one select[name='topic_id']").val(),
                'color': $("#data-one input[name='color']").val(),
                'content_lookup': CKEDITOR.instances['contentLookup'].getData(),
                'status': $("#data-one select[name='status']").val(),
                'image': $("#data-one img[name='image']").attr('src'),
                'banner': $("#data-one img[name='banner']").attr('src'),
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
        $('#modal-delete-lookup').on('click', '#delete-lookup', function () {
            let data = {
                'id': idUser,
            };
            let result = ajaxQuery(config.urlDeleteModelLookupToDb, data, 'POST');
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

