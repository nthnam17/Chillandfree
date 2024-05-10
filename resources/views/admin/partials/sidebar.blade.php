<style>
    .nav-link {
        white-space: pre-line !important;
        line-height: 1rem !important;
    }
    .nav-title {
        color: #20a8d8;
        padding: 0.8125rem 1.937rem 0.8125rem 1rem;
        font-weight: 600;
    }
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                <i class="fa fa-home" aria-hidden="true"></i>
                <span class="menu-title pl-3">Trang chủ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-topic" aria-expanded="false" aria-controls="ui-topic">
                <i class="fa fa-book" aria-hidden="true"></i>
                <span class="menu-title pl-3">Quản lý chủ đề</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-topic">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item items-small-menu">
                        <a class="nav-link nav-item-drop" href="{{ url('/admin/topic/list') }}">Danh sách chủ đề</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-lookup" aria-expanded="false" aria-controls="ui-lookup">
                <i class="fa fa-university" aria-hidden="true"></i>
                <span class="menu-title pl-3">Quản lý tra cứu</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-lookup">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item items-small-menu">
                        <a class="nav-link nav-item-drop" href="{{ url('admin/category/list') }}">Danh sách thể loại</a>
                    </li>
                    <li class="nav-item items-small-menu">
                        <a class="nav-link nav-item-drop" href="{{ url('admin/look_up/list') }}">Danh sách tra cứu</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-statistical" aria-expanded="false" aria-controls="ui-statistical">
                <i class="mdi mdi-chart-bar" aria-hidden="true"></i>
                <span class="menu-title pl-3">Thống kê</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-statistical">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item items-small-menu">
                        <a class="nav-link nav-item-drop" href="{{ url('admin/statistical/list') }}">Danh sách thống kê</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-system" aria-expanded="false" aria-controls="ui-system">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                <span class="menu-title pl-3">Cấu hình hệ thống</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-system">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/system/users/list') }}">Quản lý người dùng</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/system/role/list') }}">Quản lý nhóm quyền</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('admin/system/permission/list') }}">Quản lý quyền</a></li>
                    <li class="nav-item items-small-menu">
                        <a class="nav-link nav-item-drop" href="{{ url('admin/settings/general') }}">Cài đặt chung</a>
                    </li>
                </ul>

            </div>
        </li>
    </ul>
</nav>


