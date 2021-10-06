@if (hasAnyPermission(['production.index', 'production.create', 'manufactured.index', 'manufactured.create', 'materials-assign.index', 'materials-assign.create',
'factories.index', 'factories.create', 'ledger-report.index', 'product-ledger.index'], $slugs) && hasModulePermission('Production', $active_modules))
<li class="{{ request()->segment(1) == 'production' ? 'open' : '' }}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-desktop"></i>
        <span class="menu-text">Production</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">

        <!-- Requsition Start -->
        <li class="{{ request()->segment(2) == 'requsition' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Requsition</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                <li class="{{ request()->segment(3) == 'purchase' | request()->segment(3) == 'grn' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                        <span class="menu-text">Purchase</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="{{ request()->is('production/requsition/grn/purchase') ? 'active' : '' }}">
                            <a href="{{ route('purchase.grnIndex') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                GRN List
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="{{ request()->is('production/requsition/purchase') ? 'active' : '' }}">
                            <a href="{{ route('purchase.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="{{ request()->is('production/requsition/purchase/create') ? 'active' : '' }}">
                            <a href="{{ route('purchase.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Create
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->segment(2) == 'sales-order' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                        <span class="menu-text">Requsition</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="{{ request()->is('production/sales-order') ? 'active' : '' }}">
                            <a href="">
                                <i class="menu-icon fa fa-caret-right"></i>
                                GRN List
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="{{ request()->is('production/sales-order') ? 'active' : '' }}">
                            <a href="">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="{{ request()->is('production/sales-order/create') ? 'active' : '' }}">
                            <a href="">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Create
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->segment(2) == 'sales-order' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                        <span class="menu-text">Report</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="{{ request()->is('production/sales-order') ? 'active' : '' }}">
                            <a href="">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Stock In Hand
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="{{ request()->is('production/sales-order/create') ? 'active' : '' }}">
                            <a href="">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Item Ledger
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="{{ request()->is('production/sales-order/create') ? 'active' : '' }}">
                            <a href="">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Weekly Movements
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <!-- Requsition End -->

        <!-- Production Start -->
        @if (hasAnyPermission(["production.index", "production.create"], $slugs))
        <li class="{{ request()->segment(2) == 'production' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Production</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasAnyPermission(['production.index'], $slugs))
                <li class="{{ request()->is('production/production') ? 'active' : '' }}">
                    <a href="{{ route('production.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        List
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif

                @if (hasAnyPermission(['production.create'], $slugs))
                <li class="{{ request()->is('production/production/create') ? 'active' : '' }}">
                    <a href="{{ route('production.create') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Create
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Production End -->

        <!-- Sales Start -->
        @if (hasAnyPermission(["production.index", "production.create"], $slugs))
        <li class="{{ request()->segment(2) == 'sales' | request()->segment(2) == 'sales-order' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Sales</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasAnyPermission(['production.index'], $slugs))
                <li class="{{ request()->segment(2) == 'sales' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                        <span class="menu-text">Sales</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        @if (hasAnyPermission(['production.index'], $slugs))
                        <li class="{{ request()->is('production/sales') | request()->is('production/sales/*/edit') ? 'active' : '' }}">
                            <a href="{{ route('sales.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endif

                        @if (hasAnyPermission(['production.create'], $slugs))
                        <li class="{{ request()->is('production/sales/create') ? 'active' : '' }}">
                            <a href="{{ route('sales.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Sales Create
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if (hasAnyPermission(['production.create'], $slugs))
                <li class="{{ request()->segment(2) == 'sales-order' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                        <span class="menu-text">Sales Order</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        @if (hasAnyPermission(['production.index'], $slugs))
                        <li class="{{ request()->is('production/sales-order') ? 'active' : '' }}">
                            <a href="{{ route('sales.order.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Order List
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endif

                        @if (hasAnyPermission(['production.create'], $slugs))
                        <li class="{{ request()->is('production/sales-order/create') ? 'active' : '' }}">
                            <a href="{{ route('sales.order.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Order Create
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Sales End -->

        <!-- Manufacture Start -->
        @if (hasAnyPermission(["manufactured.index", "manufactured.create"], $slugs))
        <li class="{{ request()->segment(2) == 'manufactured' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Manufactured</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasAnyPermission(['manufactured.create'], $slugs))
                <li class="{{ request()->is('production/manufactured') ? 'active' : '' }}">
                    <a href="{{ route('manufactured.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        List
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif

                @if (hasAnyPermission(['manufactured.create'], $slugs))
                <li class="{{ request()->is('production/manufactured/create') ? 'active' : '' }}">
                    <a href="{{ route('manufactured.create') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Create
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Manufacture End -->

        <!-- Materials Start -->
        @if (hasAnyPermission(["materials-assign.index", "materials-assign.create"], $slugs))
        <li class="{{ request()->segment(2) == 'materials-assign' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Materials Assign</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasAnyPermission(['materials-assign.create'], $slugs))
                <li class="{{ request()->is('production/materials-assign') ? 'active' : '' }}">
                    <a href="{{ route('materials-assign.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        List
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif

                @if (hasAnyPermission(['materials-assign.create'], $slugs))
                <li class="{{ request()->is('production/materials-assign/create') ? 'active' : '' }}">
                    <a href="{{ route('materials-assign.create') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Create
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Manufacture End -->

        <!-- Factories Start -->
        @if (hasAnyPermission(["factories.index"], $slugs))
        <li class="{{ request()->segment(2) == 'factories' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Factories</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                <li class="{{ request()->is('production/factories') ? 'active' : '' }}">
                    <a href="{{ route('factories.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Factory List
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        @endif
        <!-- Factories End -->

        <!-- Report Start -->
        @if (hasAnyPermission(["ledger-report.index", "product-ledger.index"], $slugs))
        <li class="{{ request()->segment(2) == 'report' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-caret-right" style=" transform: rotate(45deg); color:gold; font-weight:bolder"></i>
                <span class="menu-text">Report</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasAnyPermission(['ledger-report.index'], $slugs))
                <li class="{{ request()->is('production/report/leger-report') ? 'active' : '' }}">
                    <a href="{{ route('leger-report.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Ledger Report
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif

                @if (hasAnyPermission(['product-ledger.index'], $slugs))
                <li class="{{ request()->is('production/report/leger-report/create') ? 'active' : '' }}">
                    <a href="{{ route('product-ledger.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Product Ledger
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <!-- Report End -->

    </ul>
</li>
@endif