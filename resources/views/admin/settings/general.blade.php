<?php
use App\Models\Menus;
?>
@extends('admin.layouts.index')
@section('pageTitle', 'Cài đặt chung')
@section('content')

    <style>
        .preview-image-wrapper img {
            height: auto;
            max-width: 150px;
        }
        .save-data {
            color: #FFFFFF !important;
            background-color: #20a8d8 !important;
        }
        .scrollbar
        {
            height: 850px;
            overflow-y: scroll;
        }
        #style-3::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar
        {
            width: 6px;
            background-color: #F5F5F5;
        }

        #style-3::-webkit-scrollbar-thumb
        {
            background-color: #000000;
        }



        .item-box-info{
            position: relative
        }
        .btn_remove_box_info{
            position: absolute;
            top: 0;
            right: 5px;
            color: red !important;
            cursor: pointer;
        }

    </style>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-body scrollbar" id="style-3">
                    <form class="form-body">
                        <input type="hidden" name="id" group="data" value="{!! isset($data) ? $data['id'] : null !!}">
                        <div class="row">
                            <div class="col-md-3">
                                <h4>Thông tin chung</h4>
                                <p>Cài đặt thông tin website</p>
                            </div>
                        </div>
                        <div class="row box-general">
                            <div class="col-md-3">
                                <h4>Logo</h4>
                            </div>
                            <div class="col-md-9">
                                <div class="wrapper-content pd-all-20">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-title-field" for="admin-logo">Logo</label>
                                                <div class="admin-logo-image-setting">
                                                    <div class="image-box">
                                                        <div class="preview-image-wrapper">
                                                            <img
                                                                src="{!! isset($data) && !is_null($data->logo) ?  $data->logo : '/admin/img/placeholder.png' !!}"
                                                                alt="img-logo" id="img-logo" name="logo" group="data">
                                                           
                                                        </div>
                                                        <div class="image-box-actions">
                                                            <label class="btn btnBrowse"
                                                                   onclick="setImage('img-logo');">
                                                                <i class="fas fa-image" aria-hidden="true"></i>
                                                                <span>Chọn ảnh</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-title-field" for="admin-logo">Favicon</label>
                                                <div class="admin-logo-image-setting">
                                                    <div class="image-box">
                                                        <div class="preview-image-wrapper">
                                                            <img src="{!! isset($data) && !is_null($data->favicon) ?  $data->favicon : '/admin/img/placeholder.png' !!}" alt="img-logo"
                                                                 id="img-favicon" name="favicon" group="data">
                                                        </div>
                                                        <div class="image-box-actions">
                                                            <label class="btn btnBrowse"
                                                                   onclick="setImage('img-favicon');">
                                                                <i class="fas fa-image" aria-hidden="true"></i>
                                                                <span>Chọn ảnh</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            {{-- <div class="form-group">
                                                <label class="text-title-field" for="admin-typical_customers">Khách hàng tiêu biểu</label>
                                                <div class="admin-logo-image-setting">
                                                    <div class="image-box">
                                                        <div class="preview-image-wrapper">
                                                            <img src="{!! isset($data) && !is_null($data->typical_customers) ?  $data->typical_customers : '/admin/img/placeholder.png' !!}" alt="img-typical_customers"
                                                                 id="img-typical_customers" name="typical_customers" group="data">
                                                        </div>
                                                        <div class="image-box-actions">
                                                            <label class="btn btnBrowse"
                                                                   onclick="setImage('img-typical_customers');">
                                                                <i class="fas fa-image" aria-hidden="true"></i>
                                                                <span>Chọn ảnh</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row box-general">
                            <div class="col-md-3">
                                <h4>Thông tin chung</h4>
                            </div>
                            <div class="col-md-9">
                                <div class="row box-general">
                                    <div class="col-md-6">
                                        <div class="wrapper-content">
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Tên website</label>
                                                <input class="form-control" group="data" placeholder="Nội dung"name="website" type="text"value="{!! isset($data) ? $data->website : null !!}"></input>
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Số điện thoại</label>
                                                <input class="form-control" group="data" placeholder="Nhập số điện thoại"name="phone" type="text"value="{!! isset($data) ? $data->phone : null !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Email quản trị</label>
                                                <input class="form-control" group="data" placeholder="Nhập email quản trị"name="email_admin" type="text"value="{!! isset($data) ? $data->email_admin : null !!}">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wrapper-content">
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Hotline liên hệ</label>
                                                <input class="form-control" group="data" placeholder="Nhập hotline"name="hotline" type="text"value="{!! isset($data) ? $data->hotline : null !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Địa chỉ</label>
                                                <input class="form-control" group="data" placeholder="Nhập link gg map địa chỉ"name="gg_maps" type="text"value="{!! isset($data) ? $data->gg_maps : null !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Email liên hệ</label>
                                                <input class="form-control" group="data" placeholder="Nhập email liên hệ"name="email_contact" type="text"value="{!! isset($data) ? $data->email_contact : null !!}"></input>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="row box-general">
                            <div class="col-md-3">
                                <h4>Thông tin truyền thông</h4>
                            </div>
                            <div class="col-md-9">
                                <div class="row box-general">
                                    <div class="col-md-6">
                                        <div class="wrapper-content">
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Facebook</label>
                                                <input class="form-control" group="data" placeholder="Nhập link facebook"name="link_fb" type="text"value="{!! isset($data) ? $data->content_banner : null !!}"></input>
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Youtube</label>
                                                <input class="form-control" group="data" placeholder="Nhập link youtube"name="youtube" type="text"value="{!! isset($data) ? $data->phone : null !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Instagram</label>
                                                <input class="form-control" group="data" placeholder="Nhập link ins"name="link_ins" type="text"value="{!! isset($data) ? $data->description_banner : null !!}">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wrapper-content">
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Linked</label>
                                                <input class="form-control" group="data" placeholder="Nhập link linked"name="link_linked" type="text"value="{!! isset($data) ? $data->phone : null !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Twitter</label>
                                                <input class="form-control" group="data" placeholder="Nhập link twitter"name="twitter" type="text"value="{!! isset($data) ? $data->description_banner : null !!}">
                                            </div>
                                            <div class="form-group">
                                                <label for="Name" class="control-label">Kênh khác</label>
                                                <input class="form-control" group="data" placeholder="Nhập link kênh"name="link_other" type="text"value="{!! isset($data) ? $data->content_banner : null !!}"></input>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>


                        <div class="row box-general text-center">
                            <div class="col-md-12">
                                <button class="btn btn-info save-data" type="submit"><i class="fa fa-save mr-1"></i>Lưu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            const urlEdit = '/admin/settings/editGeneral';


            let imageCounter = 1;
            // thêm box mục tiêu
            $('#addBoxInfo').on('click', function() {
                var divParentTarget = $('#parent_box_info .row');
                var newBox1 = $('<div>').addClass('col-md-3 mt-3 item-box-info text-center');
                var imageName = 'image_info_' + imageCounter;
                newBox1.html(`
                                <div class="form-group">
                                    <div class="widget-body">
                                        <div class="fileupload-preview fileupload-exists ">
                                            <div class="preview-image-wrapper-white">
                                                <div class="field-news-image">
                                                    <label class="btn btnChoose" onclick="setImage('${imageName}');">
                                                        <i class="fas fa-image" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                                <img class="image_info" src="/admin/img/placeholder.png" width="150" alt="" id="${imageName}"  name="${imageName}" group="data">
                                                <a class="btn_remove_image" title="Remove image" img-remove="${imageName}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control title_info_item" group="data" placeholder="Tiêu đề item"name="title_info_item" type="text"value="{!! isset($data) ? $data->title_info_item : null !!}">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control description_info_item" group="data" placeholder="Mô tả item"name="description_info_item" type="text"value="{!! isset($data) ? $data->description_info_item : null !!}"></textarea>
                                </div>
                                <a class="btn_remove_box_info"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        `);
                divParentTarget.append(newBox1);
                imageCounter++;
            });
            $('body').on('click', '.btn_remove_box_info', function() {
                $(this).closest('.item-box-info').remove();
            });



            $(".save-data").click(function (e) {
                e.preventDefault();

                // thông tin
                let lst_info = [];
                $('#parent_box_info .item-box-info').each(function(index) {
                    var image = $(this).find('.image_info').attr('src');
                    var lst_info_item = {
                        image: image,
                        title: $(this).find('.title_info_item').val(),
                        description : $(this).find('.description_info_item').val(),
                    };
                    lst_info.push(lst_info_item);
                });

                let data = getDataView('form.form-body');
                data['lst_info'] = lst_info;
                //add token
                data["_token"] = $('meta[name="csrf-token"]').attr('content');
                //query edi general
                let result = ajaxQuery(urlEdit, data, 'POST');
                if (result == undefined || result.length == 0) {
                    //noti
                    showAlert("@Lang('global.msg_error')", "danger", 5000);
                } else if (result.code == 200) {
                    // $("#scheme").attr("selected","selected");
                    //noti
                    showAlert(result.message, result.notify, 5000);
                } else if (result.code == 401) {
                    //noti
                    showAlert(result.message, result.notify, 5000);
                }
            });

            $('.js-example-basic-single').select2();
            $('.js-example-basic-multiple').select2();
        });
        // ckeditor("title");

    </script>
@endsection

