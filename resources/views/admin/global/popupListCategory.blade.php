<?php
// use \App\Models\Role_has_permissions;
use \App\Models\LookUp;
use \App\Models\Category;
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
<div id="modal-category-tab" class="modal fade" role="dialog">
    <div class="modal-dialog " style="max-width: 1200px;">
        <!-- Modal content-->
        <div class="modal-content modal-content-progress">
            <div class="modal-header bg-modal my-modal modal-skill-cus">
                <h4 class="modal-title text-left">
                    <i class="til_img"></i>
                    <strong>Danh sách chức năng thể loại</strong>
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
                                <a title="Cập nhật thông tin thể loại" class="btn btn-sm active" href=""
                                   id="eventUpdate"
                                   name="id" style="color: #4B49AC"
                                   group="data" convertToAttr="data-id" data-toggle="modal"><i
                                        class="mdi mdi-pencil"></i> </a>
                                <span>
                                    <a title="Xóa" class="btn btn-sm"
                                       style="color: red" data-toggle="modal"
                                       data-target="#modal-delete-category" data-id="" data-url="">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </div>
                            <form class="form-body form-disabled">
                                <input group="data" type="hidden" name="id">
                                <div class="form-group">
                                    <label class="control-label required">Tên thể loại <span>*</span> </label>
                                    <input class="form-control nameCategory" group="data" name="name" type="text"
                                           autocomplete="off"
                                           disabled="true"
                                           spellcheck="false" placeholder="Tên thể loại">
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Tra cứu <span>*</span></label>
                                    <select class="form-control select-status js-example-basic-single typeLook_id" disabled="true"
                                            group="data"
                                            name="lookup_id">
                                        <?php $data = LookUp::selectAll() ?>
                                        <option value="">--Chọn--</option>
                                        @foreach($data as $item)
                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Loại cha</label>
                                    <select class="form-control select-status js-example-basic-single" group="data" disabled="true"
                                            id="select_parent"
                                            name="parent_id">
                                        <?php $data = Category::getAll() ?>
                                        <option value="">--Chọn--</option>
                                        @foreach($data as $item)
                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label required">Nội dung</label>
                                    <textarea class="form-control" group="data" name="content_edit" type="text"
                                              autocomplete="off"
                                              spellcheck="false"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label required">Ưu tiên</label>
                                    <input class="form-control" group="data" name="order" type="text"
                                           autocomplete="off" disabled="true"
                                           spellcheck="false" placeholder="Ưu tiên">
                                </div>
                                <div class="form-group">
                                    <label for="upload_file" class="control-label">Upload File</label>
                                    <div class="row">
                                        <div class="col-sm-1" id="d-none-files">
                                            <label class="btn btn-primary action-item"
                                                   onclick="chooseFile('xFile');">
                                                <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                        <div class="col-sm-11">
                                            <input id="xFile" class="form-control" type="text" group="data"
                                                   style="padding-right: 35px;"
                                                   name="file"
                                                   readonly>
                                            <a class="btn_remove_image" title="Remove image" onclick="removeFile()"
                                               style="position: absolute;right: 15px;">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <select class="form-control select-status" group="data" name="status"
                                            id="statusCategory"
                                            disabled="true">
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Ngừng hoạt động</option>
                                    </select>
                                </div>
                            </form>
                            <div class="d-flex justify-content-end">
                                <button type="button"
                                        class="btn btn-success active btn-custom hiden-cus showHidenCus mr-2"
                                        id="btnUpdateCategory">
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

<!-- MODAL DELETE -->
<div id="modal-delete-category" class="modal fade" role="dialog">
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
                <button type="button" class="btn btn-dagerdel my-btn-default" id="delete-category">
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
            urlGetModelFromDb: "/admin/category/get-data",
            urlUpdateModelToDb: "/admin/category/edit",
            urlDeleteModelCategoryToDb: "/admin/category/delete",
        };

        let idUser = '';
        $('#idTable tbody').on('click', '.list-category-modal', function () {
            self = this;
            idUser = $(self).data("id");
            loadDataByidPopUp(idUser)
        });

        function loadDataByidPopUp($id) {
            data['id'] = $id;
            let result = ajaxQuery(config.urlGetModelFromDb, data, 'GET');
            if (result.code == 200) {
                $(".nameCategory").val(result.data.name);
                $(".typeLook_id").val(result.data.lookup_id).trigger("change");
                $.ajax({
                    type: "GET",
                    url: "/admin/category/get-categories",
                    data: {lookup_id: result.data.lookup_id},
                    cache: false,
                    success: function(parentsData) {
                        var options = '<option value="">--Chọn--</option>';
                        $.each(parentsData, function(index, parent) {
                            options += '<option value="' + parent.id + '">' + parent.name + '</option>';
                        });
                        $("select[name='parent_id']").html(options).val(result.data.parent_id).trigger("change");
                    }
                });

                $('.typeLook_id').change(function() {
                    var lookup_id = $(this).val();

                    $.ajax({
                        type: "GET",
                        url: "/admin/category/get-categories",
                        data: {lookup_id: lookup_id},
                        cache: false,
                        success: function(parentsData) {
                            var options = '<option value="">--Chọn--</option>';
                            $.each(parentsData, function(index, parent) {
                                options += '<option value="' + parent.id + '">' + parent.name + '</option>';
                            });

                            $("select[name='parent_id']").html(options);
                        }
                    });
                });

                let fncCallback = function () {
                    CKEDITOR.instances['content_edit'].setData(result.data.content);
                };
                CKEDITOR.instances['content_edit'].setData("", fncCallback);
                $("input[name='order']").val(result.data.order);
                $("#statusCategory").val(result.data.status);
                $("input[name='file']").val(result.data.file);
            }
        }


        // update
        $(document).on("click", "#btnUpdateCategory", function () {
            let data = {
                'id': idUser,
                'name': $(".nameCategory").val(),
                'lookup_id': $(".typeLook_id").val(),
                'parent_id': $("select[name='parent_id']").val(),
                'order': $("input[name='order']").val(),
                'content': CKEDITOR.instances['content_edit'].getData(),
                'file': $("input[name='file']").val(),
                'status': $("#statusCategory").val(),

            };
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
        $('#modal-delete-category').on('click', '#delete-category', function () {
            let data = {
                'id': idUser,
            };
            let result = ajaxQuery(config.urlDeleteModelCategoryToDb, data, 'POST');
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
        ckeditor('content_edit');
    });
</script>

