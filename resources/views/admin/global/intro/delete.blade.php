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
<!-- Modal Delete -->
<div id="modal-delete-intro" class="modal fade" role="dialog">
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
                <button type="button" class="btn btn-dagerdel my-btn-default" id="delete-intro">
                    <span class="pr-2"><i class="fa fa-check-circle"></i></span>Xác nhận
                </button>
                <button type="button" class="btn btn-black my-btn-default" data-dismiss="modal">
                    <i class="fa fa-times-circle"></i>Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete -->

<script>
    $(document).ready(function () {
        const config = {
            urlDeleteIntro: "/admin/intro/delete",
        }
        let idIntro = null;

        // event xoa
        $('#idTable_intro tbody').on("click", ".delete-intro", function () {
            console.log($(this).data("id"))
            idIntro = $(this).data("id");
        })

        $('#modal-delete-intro').on('click', '#delete-intro', function () {
            let data = {
                'id': idIntro,
            }
            let result = ajaxQuery(config.urlDeleteIntro, data, 'POST');
            if (result.code == 200) {
                window.loadDataTableIntro()
                //notify success
                swalSuccess(result.message);
                //close modal
                $("#modal-delete-intro [data-dismiss=modal]").trigger({type: "click"});
            } else if (result.code == 401) {
                //notify error
                notifyError(result.message);
            }
        });
    });

</script>
