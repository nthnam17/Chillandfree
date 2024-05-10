{{--<!-- CoreUI and necessary plugins-->--}}
{{--<script src="{{ url('admin/js/coreui.bundle.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/js/simplebar.min.js') }}"></script>--}}
{{--<!-- Bootstrap and necessary plugins-->--}}
{{--<script src="{{ url('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/node_modules/pace-progress/pace.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>--}}
{{--<script src="{{ url('admin/node_modules/@coreui/coreui-pro/dist/js/coreui.min.js') }}"></script>--}}
{{--<script src="{{url('admin/node_modules/jquery.maskedinput/src/jquery.maskedinput.js')}}"></script>--}}
{{--<script src="{{url('admin/node_modules/moment/min/moment.min.js')}}"></script>--}}
{{--<script src="{{url('admin/node_modules/select2/dist/js/select2.min.js')}}"></script>--}}
{{--<script src="{{url('admin/node_modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/bootstrap.datepicker/0.1/js/bootstrap-datepicker.js"></script>--}}

{{--<script src="{{ url('admin/js/data-view_support.js') }}"></script>--}}
{{--<script src="{{ url('admin/js/CRUD_support.js') }}"></script>--}}
{{--<script src="{{ url('admin/js/ajax-main.js') }}"></script>--}}
{{--<script src="{{ url('admin/js/js-main.js') }}"></script>--}}
{{--<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>--}}

{{--<!-- Plugins and scripts required by this view-->--}}
{{--<script src="{{ url('admin/js/coreui-utils.js') }}"></script>--}}

{{--<script type="text/javascript" src="/admin/js/dropzone.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>--}}


{{--<!-- Plugins ckeditor ckfinder-->--}}

{{--<script src="{{ url('admin/ckeditor_4/ckeditor.js') }}"></script>--}}
{{--<script src="{{ url('admin/js/bootstrap-multiselect1.js') }}"></script>--}}
{{--<script src="{{ url('admin/js/echarts-en.min.js') }}"></script>--}}

{{-- Dashboard new--}}
<script src="{{ asset('admin/assets/libs/%40popperjs/core/umd/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/metismenujs/metismenujs.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>


{{--<script src="../../../code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>--}}


<script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>

<!-- Plugins ckfinder-->
<script src="{{ url('admin/ckfinder/ckfinder.js') }}"></script>
<script src="{{ url('admin/ckeditor_4/ckeditor.js') }}"></script>
<!-- apexcharts -->
{{-- <script src="{{ asset('admin/js/jquery-1.11.3.min.js') }}"></script> --}}
<!-- Plugins js-->
{{-- <script src="{{ asset('admin/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script> --}}
{{-- <script src="{{ asset('admin/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
<!-- dashboard init -->
{{--<script src="{{ asset('admin/assets/js/pages/dashboard.init.js')  }}"></script>--}}
<!-- Sweet Alerts js -->
<script src="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Sweet alert init js-->
<script src="{{ asset('admin/assets/js/pages/sweetalert.init.js') }}"></script>

<script src="{{ asset('admin/assets/js/pages/nav%26tabs.js') }}"></script>

<script src="{{ asset('admin/assets/js/app.js') }}"></script>
{{-- <script src="{{ asset('admin/js/js-main.js') }}"></script> --}}
{{-- <script src="{{ asset('admin/js/ajax-main.js') }}"></script> --}}
<script src="{{ asset('admin/js/CRUD_support.js') }}"></script>
<script src="{{ asset('admin/js/data-view_support.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>


<!-- custorm tab -->
<script>
    var tab;
    var tabContent;
    window.onload=function() {
        tabContent=document.getElementsByClassName('tabContent');
        tab=document.getElementsByClassName('tab');
        hideTabsContent(1);
    }

    if(document.getElementById('tabs')){
        document.getElementById('tabs').onclick= function (event) {
        var target=event.target;
        if (target.className=='tab') {
        for (var i=0; i<tab.length; i++) {
            if (target == tab[i]) {
                showTabsContent(i);
                break;
            }
        }
        }
    }
    }
    function hideTabsContent(a) {
        for (var i=a; i<tabContent.length; i++) {
            tabContent[i].classList.remove('show');
            tabContent[i].classList.add("hide");
            tab[i].classList.remove('whiteborder');
        }
    }
    function showTabsContent(b){
        if (tabContent[b].classList.contains('hide')) {
            hideTabsContent(0);
            tab[b].classList.add('whiteborder');
            tabContent[b].classList.remove('hide');
            tabContent[b].classList.add('show');
        }
    }
</script>




