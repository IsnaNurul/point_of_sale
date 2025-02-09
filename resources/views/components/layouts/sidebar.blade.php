@if (Auth::user()->role == 'cashier')
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Transaction</h6>
                        <ul>
                            <li class="{{ Request::is('pos*') ? 'active' : '' }}">
                                <a href="{{ route('pos') }}"><i data-feather="shopping-cart"></i><span>POS</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@else
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Main</h6>
                        <ul>
                            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                                <a href="{{ route('dashboard') }}"><i
                                        data-feather="grid"></i><span>Dashboard</span></span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">User Management</h6>
                        <ul>
                            <li class="{{ Request::is('cashier*') ? 'active' : '' }}">
                                <a href="{{ route('cashier') }}"><i
                                        data-feather="user-check"></i><span>Cashier</span></a>
                            </li>
                            <li class="{{ Request::is('customers*') ? 'active' : '' }}">
                                <a href="{{ route('customers') }}"><i data-feather="user"></i><span>Customers</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Inventory</h6>
                        <ul>
                            <li class="{{ Request::is('category*') ? 'active' : '' }}">
                                <a href="{{ route('category') }}"><i
                                        data-feather="codepen"></i><span>Category</span></a>
                            </li>
                            <li class="{{ Request::is('units*') ? 'active' : '' }}">
                                <a href="{{ route('units') }}"><i data-feather="speaker"></i><span>Units</span></a>
                            </li>
                            <li class="{{ Request::is('products*') ? 'active' : '' }}">
                                <a href="{{ route('products') }}"><i data-feather="box"></i><span>Products</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Promo</h6>
                        <ul>
                            <li class="{{ Request::is('discount*') ? 'active' : '' }}">
                                <a href="{{ route('discount') }}"><i
                                        data-feather="shopping-cart"></i><span>Voucher</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Transaction</h6>
                        <ul>
                            <li class="{{ Request::is('pos*') ? 'active' : '' }}">
                                <a href="{{ route('pos') }}"><i
                                        data-feather="shopping-cart"></i><span>Sales</span></a>
                            </li>
                            <li class="{{ Request::is('payment_method*') ? 'active' : '' }}">
                                <a href="{{ route('payment_method') }}"><i data-feather="dollar-sign"></i><span>Payment
                                        Method</span></a>
                            </li>
                            {{-- <li class="{{ Request::is('purchases*') ? 'active' : '' }}">
                            <a href="{{ route('purchases') }}"><i
                                    data-feather="shopping-bag"></i><span>Purchases</span></a>
                        </li> --}}
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif
