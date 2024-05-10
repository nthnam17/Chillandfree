<div id="modal-form-keyword" class="modal" data-backdrop="static">
    <div class="modal-dialog" style="min-width: 800px; ">
        <div class="modal-content" >
            <div class="modal-header bg-modal my-modal">
                <h4 class="modal-title">
                    <i class="til_img"></i>
                    <strong>Thêm mới </strong>
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
                <button type="button" class="btn btn-success active btn-custom" id="btnAddKeyword">
                    Thêm mới
                </button>
                <button type="button" class="btn btn-danger btn-canel active btn-custom btn-close" data-dismiss="modal">
                    Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const config = {
            urlAddToDb: "/admin/keyword/add",
        }

        $('#modal-form-keyword').on('click', '#btnAddKeyword', function () {
            let data = {
                'lookup_id': $("input[name='id-intro']").val(),
                'name': $("#modal-form-keyword input[name='name']").val(),
                'count': $("#modal-form-keyword input[name='count']").val(),
                'status': $("#modal-form-keyword select[name='status']").val(),
            }
            let result = ajaxQuery(config.urlAddToDb, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableKeyword()
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-form-keyword [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            } else {
                if (result.errors == null) {
                    notifyError(result.message);
                } else {
                    Object.keys(result.errors).forEach(function (key) {
                        let locationAddValidate = $("#modal-form-keyword-form [name='" + key + "']").parent();
                        $("#modal-form-keyword-form [name='" + key + "']").addClass('invalid');
                        createdInvalid(locationAddValidate, result.errors[key]);
                    });
                }
            }
        });

    });
</script>
