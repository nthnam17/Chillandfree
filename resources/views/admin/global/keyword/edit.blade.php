<div id="modal-edit-keyword" class="modal" data-backdrop="static">
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

                    <div class="form-group">
                        <label class="control-label required">Từ khóa<span>*</span></label>
                        <input class="form-control" group="data" name="name" type="text" autocomplete="off" spellcheck="false" placeholder="Từ khóa">
                    </div>

                    <div class="form-group">
                        <label class="control-label required">Số lượt tra cứu</label>
                        <input class="form-control" group="data" name="count" type="text" autocomplete="off" spellcheck="false" placeholder="Số lượt tra cứu">
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
                <button type="button" class="btn btn-success active btn-custom" id="btnEditKeyword">
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
            urlEditOneModelToDb: "/admin/keyword/edit",
            urlAGetOneModelFromDb: "/admin/keyword/getOne",
        }

        $('#idTable_keyword tbody').on('click', '.edit-keyword', function () {
            self = this;
            loadDataByidPopUp($(self).data("id"))
        });

        // load data thông tin
        function loadDataByidPopUp($id) {
            let data = {
                id: $id
            };
            let result = ajaxQuery(config.urlAGetOneModelFromDb, data, 'GET');
            let lstData = result.data;
            $("#modal-edit-keyword input[name='id']").val(lstData.id);
            $("#modal-edit-keyword input[name='name']").val(lstData.name);
            $("#modal-edit-keyword input[name='count']").val(lstData.count);
            $("#modal-edit-keyword select[name='status']").val(lstData.status);
        }

        $('#modal-edit-keyword').on('click', '#btnEditKeyword', function () {
            let data = {
                'id': $("#modal-edit-keyword input[name='id']").val(),
                'name': $("#modal-edit-keyword input[name='name']").val(),
                'count': $("#modal-edit-keyword input[name='count']").val(),
                'status': $("#modal-edit-keyword select[name='status']").val(),
            }
            let result = ajaxQuery(config.urlEditOneModelToDb, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableKeyword()
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-edit-keyword [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-edit-keyword [name='" + key + "']").parent();
                        $("#modal-edit-keyword [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
