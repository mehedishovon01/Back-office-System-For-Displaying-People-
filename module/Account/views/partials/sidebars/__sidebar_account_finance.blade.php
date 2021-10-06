@if ((hasAnyPermission(["account.setups.index", "account.groups.index", "account.controls.index", "account.subsidiaries.index", "accounts.index", "fund.transfers.index", "account.reports.index"], $slugs)) && hasModulePermission('Account & Finance', $active_modules))

<li class="{{ request()->segment(1) == 'account' | request()->segment(2) == 'vouchers' | request()->segment(1) == 'reports'
    | request()->segment(1) == 'product' | request()->segment(1) == 'purchase' | request()->segment(1) == 'setup' ? 'open' : '' }}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-bank" style=" font-weight:bolder"></i>
        <span class="menu-text">Account</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">

        @if ((hasAnyPermission(["account.setups.index", "account.groups.index", "account.controls.index", "account.subsidiaries.index", "accounts.index"], $slugs)))
        <li class="{{ request()->segment(1) == "setup" ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-circle"></i>
                Setup
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if ((hasPermission("account.setups.index", $slugs)))
                    <li class="{{ request()->is('setup/account-setup*') ? 'active' : '' }}" hidden>
                        <a href="{{ route('account-setups.index') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Account Setup
                        </a>
                    </li>
                @endif

                @if ((hasPermission("account.groups.index", $slugs)))
                <li class="{{ request()->is('setup/account-group*') ? 'active' : '' }}">
                    <a href="{{ route('account-groups.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Account Group
                    </a>
                </li>
                @endif

                @if ((hasPermission("account.controls.index", $slugs)))
                <li class="{{ request()->is('setup/account-control*') ? 'active' : '' }}">
                    <a href="{{ route('account-controls.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Account Control
                    </a>
                </li>
                @endif

                @if ((hasPermission("account.subsidiaries.index", $slugs)))
                <li class="{{ request()->is('setup/account-subsidiari*') ? 'active' : '' }}">
                    <a href="{{ route('account-subsidiaries.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Account Subsidiary
                    </a>
                </li>
                @endif

                @if ((hasPermission("accounts.index", $slugs)))
                <li class="{{ request()->is('setup/accounts') || request()->is('account/setup/accounts/*') ? 'active' : '' }}">
                    <a href="{{ route('accounts.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Chart Of Accounts
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        <!-- Voucher -->
        <li class="{{ request()->segment(1) == 'payment' | request()->segment(1) == 'receive' | request()->segment(1) == 'journal' | request()->segment(1) == 'contra' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-circle"></i>
                Voucher
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="{{ request()->is('payment/vouchers') | request()->is('payment/vouchers/create') | request()->is('payment/vouchers/*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Payment
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('payment/vouchers') ? 'active' : '' }}">
                            <a href="{{ route('vouchers.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                        </li>
                        <li class="{{ request()->is('payment/vouchers/create') ? 'active' : '' }}">
                            <a href="{{ route('vouchers.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Create
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="submenu">
                <li class="{{ request()->is('receive/vouchers') | request()->is('receive/vouchers/create') | request()->is('receive/vouchers/*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Receive
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('receive/vouchers') ? 'active' : '' }}">
                            <a href="{{ route('receive.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                        </li>
                        <li class="{{ request()->is('receive/vouchers/create') ? 'active' : '' }}">
                            <a href="{{ route('receive.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Create
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="submenu">
                <li class="{{ request()->is('journal/vouchers') | request()->is('journal/vouchers/create') | request()->is('journal/vouchers/*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Journal
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('journal/vouchers') ? 'active' : '' }}">
                            <a href="{{ route('journal.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                        </li>
                        <li class="{{ request()->is('journal/vouchers/create') ? 'active' : '' }}">
                            <a href="{{ route('journal.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Create
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="submenu">
                <li class="{{ request()->is('contra/vouchers') | request()->is('contra/vouchers/create') | request()->is('contra/vouchers/*') ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Contra
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('contra/vouchers') ? 'active' : '' }}">
                            <a href="{{ route('contra.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                List
                            </a>
                        </li>
                        <li class="{{ request()->is('contra/vouchers/create') ? 'active' : '' }}">
                            <a href="{{ route('contra.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Create
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

        <!-- Reports -->
        @if ((hasPermission("account.reports.index", $slugs)))
        <li class="{{ request()->segment(1) == "reports" ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-circle"></i>
                Report
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if ((hasPermission("account.chart.of.account.reports", $slugs)))
                <li class="{{ request()->is('reports/chart-of-account') ? 'active' : '' }}">
                    <a href="{{ route('report.chart-of-account') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Chart Of Account
                    </a>
                </li>
                @endif

                @if ((hasPermission("account.ledger.journal.reports", $slugs)))
                <li class="{{ request()->is('reports/ledger-journal') ? 'active' : '' }}">
                    <a href="{{ route('report.ledger-journal') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Ledger Journal
                    </a>
                </li>
                @endif

                @if ((hasPermission("account.transaction.ledger.reports", $slugs)))
                <li class="{{ request()->is('reports/transaction-ledger') ? 'active' : '' }}">
                    <a href="{{ route('report.transaction-ledger') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Transaction Ledger
                    </a>
                </li>
                @endif

                @if ((hasPermission("account.account.ledger.reports", $slugs)))
                <li class="{{ request()->is('reports/account-ledger') ? 'active' : '' }}">
                    <a href="{{ route('report.account-ledger') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Account Ledger
                    </a>
                </li>
                @endif


                @if ((hasPermission("account.subsidiary.ledger.reports", $slugs)))
                <li class="{{ request()->is('reports/subsidiary-wise-ledger') ? 'active' : '' }}">
                    <a href="{{ route('report.subsidiary-wise-ledger') }}" title="Subsidiary Wise Ledger">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Subsidiary Ledger
                    </a>
                </li>
                @endif

                {{-- @if ((hasPermission("account.reports.index", $slugs)))--}}
                {{-- <li class="hidden {{ request()->is('reports/nominal-account-ledger') ? 'active' : '' }}">--}}
                {{-- <a href="{{ route('report.nominal-account-ledger') }}" title="Nominal Account Ledger">--}}
                {{-- <i class="menu-icon fa fa-caret-right"></i>--}}
                {{-- Nominal Ledger--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- @endif--}}

                {{-- @if ((hasPermission("account.reports.index", $slugs)))--}}
                {{-- <li class="hidden {{ request()->is('reports/revenue-analysis') ? 'active' : '' }}">--}}
                {{-- <a href="{{ route('report.revenue-analysis') }}">--}}
                {{-- <i class="menu-icon fa fa-caret-right"></i>--}}
                {{-- Revenue Analysis--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- @endif--}}

                @if ((hasPermission("account.expense.analysis.reports", $slugs)))
                <li class="{{ request()->is('reports/expense-analysis') ? 'active' : '' }}">
                    <a href="{{ route('report.expense-analysis') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Expense Analysis
                    </a>
                </li>
                @endif

                {{-- @if ((hasPermission("account.reports.index", $slugs)))--}}
                {{-- <li class="hidden {{ request()->is('reports/ratio-analysis') ? 'active' : '' }}">--}}
                {{-- <a href="{{ route('report.ratio-analysis') }}">--}}
                {{-- <i class="menu-icon fa fa-caret-right"></i>--}}
                {{-- Ratio Analysis--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- @endif--}}

                {{-- @if ((hasPermission("account.reports.index", $slugs)))--}}
                {{-- <li class="hidden {{ request()->is('reports/received-payment-statement') ? 'active' : '' }}">--}}
                {{-- <a href="{{ route('report.received-payment-statement') }}" title="Received Payment Statement">--}}
                {{-- <i class="menu-icon fa fa-caret-right"></i>--}}
                {{-- Received Payment--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- @endif--}}

                <!-- financial report -->
                @if ((hasAnyPermission(["account.trial.balance.reports", "account.balance.sheet.reports", "account.profit.and.loss.reports"], $slugs)))
                <li class="{{ request()->segment(2) == 'financial-statements' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="tooltip" title="Financial Statements">
                        <i class="menu-icon fa fa-circle"></i>
                        Financial
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        @if ((hasPermission("account.trial.balance.reports", $slugs)))
                        <li class="{{ request()->is('reports/financial-statements/trial-balance') ? 'active' : '' }}">
                            <a href="{{ route('report.trial-balance') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Trial Balance
                            </a>
                        </li>
                        @endif

                        @if ((hasPermission("account.balance.sheet.reports", $slugs)))
                        <li class="{{ request()->is('reports/financial-statements/balance-sheet') ? 'active' : '' }}">
                            <a href="{{ route('report.balance-sheet') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Balance Sheet
                            </a>
                        </li>
                        @endif

                        @if ((hasPermission("account.profit.and.loss.reports", $slugs)))
                        <li class="{{ request()->is('reports/financial-statements/profit-and-loss') ? 'active' : '' }}">
                            <a href="{{ route('report.profit-and-loss') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Profit And Loss
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </li>
        @endif


        <!-- Products -->
        @if ((hasAnyPermission(["products.index", "units.index", "categories.index"], $slugs)))
        <li class="{{ request()->segment(2) == 'units' | request()->segment(2) == 'categories' | request()->segment(2) == 'products' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-circle"></i>
                Product
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if ((hasPermission("units.index", $slugs)))
                <li class="{{ request()->is('product/units') ? 'active' : '' }}">
                    <a href="{{ route('units.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Units
                    </a>
                </li>
                @endif

                @if ((hasPermission("categories.index", $slugs)))
                <li class="{{ request()->is('product/categories') || request()->is('product/categories/*/edit') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Category
                    </a>
                </li>
                @endif

                @if ((hasPermission("products", $slugs)))
                <li class="{{ request()->segment(2) == 'products' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Product
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('product/products/create') ? 'active' : '' }}">
                            <a href="{{ route('products.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Product Create
                            </a>
                        </li>
                        <li class="{{ request()->is('product/products') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Product List
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </li>
        @endif


        <!-- Purchase -->
        @if ((hasAnyPermission(["acc_purchases.index", "acc_payments.index"], $slugs)))
        <li class="{{ request()->segment(2) == 'acc_payments' | request()->segment(2) == 'acc_purchases' | request()->segment(2) == 'acc_suppliers' ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-circle"></i>
                Purchase
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if ((hasPermission("acc_payments.index", $slugs)))
                <li class="{{ request()->is('purchase/acc_payments') ? 'active' : '' }}">
                    <a href="{{ route('acc_payments.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Payments
                    </a>
                </li>
                @endif

                @if ((hasPermission("acc_purchases.index", $slugs)))
                <li class="{{ request()->segment(2) == 'acc_purchases' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Purchase
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('purchase/acc_purchases/create') ? 'active' : '' }}">
                            <a href="{{ route('acc_purchases.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Purchase Create
                            </a>
                        </li>
                        <li class="{{ request()->is('purchase/acc_purchases') ? 'active' : '' }}">
                            <a href="{{ route('acc_purchases.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Purchase List
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if ((hasPermission("acc_suppliers.index", $slugs)))
                <li class="{{ request()->segment(2) == 'acc_suppliers' ? 'open' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Supplier
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="{{ request()->is('purchase/acc_suppliers/create') ? 'active' : '' }}">
                            <a href="{{ route('acc_suppliers.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Supplier Create
                            </a>
                        </li>
                        <li class="{{ request()->is('purchase/acc_suppliers') ? 'active' : '' }}">
                            <a href="{{ route('acc_suppliers.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Supplier List
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </li>
        @endif


        <!-- Sale -->
        @if ((hasAnyPermission(["acc_sales.index", "acc_collections.index"], $slugs)))
        <li class="{{ request()->segment(2) == "sale" ? 'open' : '' }}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-circle"></i>
                Sale
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if ((hasPermission("acc_collections.index", $slugs)))
                <li class="{{ request()->is('account/sale/acc_collections') ? 'active' : '' }}">
                    <a href="{{ route('acc_collections.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Collections
                    </a>
                </li>
                @endif

                @if ((hasPermission("acc_sales.index", $slugs)))
                <li class="{{ request()->segment(3) == 'acc_sales' ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Sale
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="{{ request()->is('account/sale/acc_sales/create') ? 'active' : '' }}">
                            <a href="{{ route('acc_sales.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Sale Create
                            </a>
                        </li>
                        <li class="{{ request()->is('account/sale/acc_sales') ? 'active' : '' }}">
                            <a href="{{ route('acc_sales.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Sale List
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if ((hasPermission("acc_customers.index", $slugs)))
                <li class="{{ request()->segment(3) == 'acc_customers' ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-circle"></i>
                        Customer
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="{{ request()->is('account/customer/acc_customers/create') ? 'active' : '' }}">
                            <a href="{{ route('acc_customers.create') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Customer Create
                            </a>
                        </li>
                        <li class="{{ request()->is('account/customer/acc_customers') ? 'active' : '' }}">
                            <a href="{{ route('acc_customers.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Customer List
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </li>
        @endif

    </ul>
</li>
@endif