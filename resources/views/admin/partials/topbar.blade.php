@inject('setting', 'App\CustomClasses\Setting')
<style>
    #profileDropdown {
        line-height: 0 !important;
    }


    .iconNotificion,.customer-Notification {
        position: relative;
    }
    .iconNotificion1 {
        position: relative;
    }
    .iconNotificion i  {
        font-size: 30px;
        color: #5156be;
        cursor: pointer;
        padding-top: 17px;
        animation: ring 1.5s infinite ease-in-out
    }
    .customer-Notification i {
        font-size: 30px;
        color: #5156be;
        cursor: pointer;
        padding-top: 17px;
    }
    .iconNotificion1 i {
        font-size: 30px;
        color: #5156be;
        cursor: pointer;
        padding-top: 17px;
    }


    @keyframes ring {
        0% { transform: rotate(-30deg) }
        50% { transform: rotate(30deg) }
        100% { transform: rotate(-30deg) }
    }

    @keyframes ring-clapper {
        0% { transform: rotate(0deg) }
        20% { transform: rotate(20deg) }
        70% { transform: rotate(-20deg) }
        100% { transform: rotate(0deg) }
    }
    .notifi_ring {
        position: relative;
        padding-right: 15px;
        top: -7px;
    }
    .count_number_task span {
        display: flex;
        background: red;
        position: absolute;
        top: 6px;
        right: 20px;
        z-index: 2;
        border-radius: 50%;
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 82, 82, 1);
        animation: pulse-red 2s infinite;
        color: #fff;
        width: 18px;
        height: 18px;
        align-items: center;
        justify-content: center;
    }
    .cus-count{
        font-size: 10px
    }
    
</style>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div
        class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center"
    >
        <a class="navbar-brand brand-logo mr-5" href="/"
        ><img src="{{ url('/admin/image/logo-mini.svg') }}" class="mr-2" alt="logo"
            /><b style="font-size: 20px">Chill And Free</b></a>
        <a class="navbar-brand brand-logo-mini" href="/"
        ><img src="{{ url('/admin/image/logo-mini.svg') }}" alt="logo"
            /></a>
    </div>
    <div
        class="navbar-menu-wrapper d-flex align-items-center justify-content-end"
    >
        <button
            class="navbar-toggler navbar-toggler align-self-center"
            type="button"
            data-toggle="minimize"
        >
            <span class="icon-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <div>
                    @if(auth()->user()->name)
                        <span class="name-login" style="font-weight: bold">
                            {{ auth()->user()->name }}
                        </span>
                    @else
                        <span class="name-login" style="font-weight: bold">
                            {{ auth()->user()->username }}
                        </span>
                    @endif
                </div>
                <a
                    class="nav-link dropdown-toggle ml-2"
                    href="#"
                    data-toggle="dropdown"
                    id="profileDropdown"
                >
                    @php
                        if(auth()->user()->image !== null) {
                           $img = auth()->user()->image;
                        }else {
                            $img = '/admin/image/boy.png';
                        }
                    @endphp
                    <img src="{{ url($img) }}" alt="profile" />
                </a>
                
                <div
                    class="dropdown-menu dropdown-menu-right navbar-dropdown"
                    aria-labelledby="profileDropdown"
                 
                >
                    <a id="profile" class="dropdown-item" href="/admin/settings/profile">
                        <i class="ti-settings text-primary"></i>
                        Tài khoản
                    </a>
                    <a class="dropdown-item" href="{{ url('logout') }}">
                        <i class="ti-power-off text-primary"></i>
                        Đăng xuất
                    </a>
                </div>
            </li>
        </ul>
        <button
            class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
            type="button"
            data-toggle="offcanvas"
        >
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>




