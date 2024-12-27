<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}"><i data-feather="grid"></i><span>Dashboard</span></span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Inventory</h6>
                    <ul>
                        <li class="{{ Request::is('products*') ? 'active' : '' }}">
                            <a href="{{ route('products') }}" ><i data-feather="box"></i><span>Products</span></a>
                        </li>
                        <li class="{{ Request::is('category*') ? 'active' : '' }}">
                            <a href="{{ route('category') }}"><i data-feather="codepen"></i><span>Category</span></a>
                        </li>
                        <li class="{{ Request::is('units*') ? 'active' : '' }}">
                            <a href="{{ route('units') }}"><i data-feather="speaker"></i><span>Units</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Sales</h6>
                    <ul>
                        <li>
                            <a href="sales-list.html"><i data-feather="shopping-cart"></i><span>Sales</span></a>
                        </li>
                        <li>
                            <a href="{{ route('pos') }}"><i data-feather="hard-drive"></i><span>POS</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Promo</h6>
                    <ul>
                        <li>
                            <a href="coupons.html"><i data-feather="shopping-cart"></i><span>Discount</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Purchases</h6>
                    <ul>
                        <li>
                            <a href="purchase-list.html"><i data-feather="shopping-bag"></i><span>Purchases</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Reports</h6>
                    <ul>
                        <li>
                            <a href="sales-report.html"><i data-feather="bar-chart-2"></i><span>Sales
                                    Report</span></a>
                        </li>
                        <li>
                            <a href="purchase-report.html"><i data-feather="pie-chart"></i><span>Purchase
                                    report</span></a>
                        </li>
                        <li>
                            <a href="customer-report.html"><i data-feather="user"></i><span>Customer
                                    Report</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li>
                            <a href="users.html"><i data-feather="user-check"></i><span>Cashier</span></a>
                        </li>
                        <li>
                            <a href="customers.html"><i data-feather="user"></i><span>Customers</span></a>
                        </li>
                        <li>
                            <a href="suppliers.html"><i data-feather="users"></i><span>Suppliers</span></a>
                        </li>
                        <li>
                            <a href="delete-account.html"><i data-feather="lock"></i><span>Delete Account
                                    Request</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
