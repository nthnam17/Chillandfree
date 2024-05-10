<div
    class="vertical-menu fixed left-0 bottom-0 top-16 h-screen border-r bg-slate-50 border-gray-50 print:hidden dark:bg-zinc-800 dark:border-neutral-700 z-10">

    <div data-simplebar class="h-full">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="/admin/dashboard"
                       class=" pl-6 pr-4 py-3 block text-sm font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false"
                       class="nav-menu pl-6 pr-4 py-3 block text-sm font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span data-key="t-HR">Quản lý Danh mục</span>
                    </a>
                    <ul>
                        {{-- @if(Auth::user()->hasAnyRole('Admin')) --}}
                            <li>
                                <a href=""
                                   class="pl-14 pr-4 py-2 block text-[13.5px] font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Danh sách danh mục</a>
                            </li>
                        {{-- @endif --}}
                    </ul>
                </li>
                {{-- @if(Auth::user()->hasAnyRole('Admin')) --}}
                    <li>
                        <a href="javascript: void(0);" aria-expanded="false"
                           class="nav-menu pl-6 pr-4 py-3 block text-sm font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                            <span data-key="t-HR">Hệ thống</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/admin/system/users/list"
                                   class="pl-14 pr-4 py-2 block text-[13.5px] font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Quản
                                    lý người dùng</a>
                            </li>
                            <li>
                                <a href="/admin/system/role/list"
                                   class="pl-14 pr-4 py-2 block text-[13.5px] font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Quản
                                    lý nhóm quyền</a>
                            </li>
                            <li>
                                <a href="/admin/system/permission/list"
                                   class="pl-14 pr-4 py-2 block text-[13.5px] font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">Quản
                                    lý quyền</a>
                            </li>
                        </ul>
                    </li>
                {{-- @endif --}}
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
