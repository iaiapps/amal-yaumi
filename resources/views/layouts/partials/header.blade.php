<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item header-mobile-collapse">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-search"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search here. . ." />
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="header-search">
                        <i data-feather="search" class="icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search here. . ." />
                        <button class="btn btn-light-secondary btn-search"><i
                                class="ti ti-adjustments-horizontal"></i></button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-send"></i>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">
                            <div class="list-group list-group-flush w-100">
                                <a href="http://wa.me/6285232213939" class="fs-4 link-offset-3" target="_blank">
                                    <div class="list-group-item list-group-item-action px-1 py-1">
                                        <div class="avtar bg-light-success">
                                            <i class="ti ti-brand-whatsapp"></i>
                                        </div>
                                        <span class="ms-2"> kirim pesan ke admin </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="pc-h-item">
                    <div class="float-end d-flex">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="ms-2 btn btn-danger">logout</button>
                        </form>
                    </div>

                </li>
            </ul>
        </div>
    </div>
</header>
