<!-- CoreUI and necessary plugins-->
<script src="{{ url('admin/js/coreui.bundle.min.js') }}"></script>
<script src="{{ url('admin/js/simplebar.min.js') }}"></script>
<!-- Bootstrap and necessary plugins-->
<script src="{{ url('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ url('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('admin/node_modules/pace-progress/pace.min.js') }}"></script>
{{--<script src="{{ url('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>--}}
<script src="{{ url('admin/node_modules/@coreui/coreui-pro/dist/js/coreui.min.js') }}"></script>
<script src="{{url('admin/node_modules/jquery.maskedinput/src/jquery.maskedinput.js')}}"></script>
<script src="{{url('admin/node_modules/moment/min/moment.min.js')}}"></script>
<script src="{{url('admin/node_modules/select2/dist/js/select2.min.js')}}"></script>
<script src="{{url('admin/node_modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/bootstrap.datepicker/0.1/js/bootstrap-datepicker.js"></script>--}}
<script src="/admin/js/simple-notify.min.js"></script>
<script src="https://cms.games.tektra.vn/admin/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cms.games.tektra.vn/admin/assets/js/pages/sweetalert.init.js"></script>
<script src="/admin/js/waitMe.js"></script>
<script src="{{ url('admin/js/data-view_support.js') }}"></script>
<script src="{{ url('admin/js/CRUD_support.js') }}"></script>
<script src="{{ url('admin/js/ajax-main.js') }}"></script>
<script src="{{ url('admin/js/js-main.js') }}"></script>
<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

<!-- Plugins and scripts required by this view-->
<script src="{{ url('admin/js/coreui-utils.js') }}"></script>

<script type="text/javascript" src="/admin/js/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>

<!-- Plugins ckeditor ckfinder-->
<script src="{{ url('admin/ckfinder/ckfinder.js') }}"></script>
<script src="{{ url('admin/ckeditor_4/ckeditor.js') }}"></script>
<script src="{{ url('admin/js/bootstrap-multiselect1.js') }}"></script>
<script src="{{ url('admin/js/echarts-en.min.js') }}"></script>
<script src="{{ url('admin/js/chart.min.js') }}"></script>
<!-- CoreUI and necessary plugins-->

{{--<script src="{{ url('admin/js/vendor.bundle.base.js') }}"></script>--}}
<script src="{{ url('admin/js/off-canvas.js') }}"></script>
<script src="{{ url('admin/js/hoverable-collapse.js') }}"></script>
<script src="{{ url('admin/js/template.js') }}"></script>
<script src="{{ url('admin/js/settings.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="/admin/js/bootstrap.bundle.min.js"></script>
<script src="{{ url('admin/js/loading.js') }}"></script>
<script src="/admin/js/bootstrap-select.min.js"></script>
<script src="{{ url('admin/js/custome-js-main.js') }}"></script>

{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}


<script>
    $(document).ready(function () {
        $("#myModalBtn").click(function () {
            $("#myModal").modal("show");
        });
    });
</script>


<script type="text/javascript">
    //<![CDATA[

       // This call can be placed at any point after the
       // <textarea>, or inside a <head><script> in a
       // window.onload event handler.

       // Replace the <textarea id="editor"> with an CKEditor
       // instance, using default configurations.
       CKEDITOR.replace( 'editor1',
{
 filebrowserBrowseUrl : '/plugin/ckfinder/ckfinder.html',
 filebrowserImageBrowseUrl : '/plugin/ckfinder/ckfinder.html?Type=Images',
 filebrowserFlashBrowseUrl : '/plugin/ckfinder/ckfinder.html?Type=Flash',
 filebrowserUploadUrl : '/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
 filebrowserImageUploadUrl : '/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
 filebrowserFlashUploadUrl : '/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
} 
);

    //]]>
    </script>

