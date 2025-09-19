<!-- partial:partials/_sidebar.html -->

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
              Pur<span>Sys</span>
        </a>

        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            @if (Auth::user()->can('permission.menu'))
                <li class="nav-item nav-category">Role & Permission</li>
                <li class="nav-item {{ request()->is('*/permission') || request()->is('*/roles') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button"
                        aria-expanded="false" aria-controls="uiComponents">
                        <i class="link-icon" data-feather="feather"></i>
                        <span class="link-title">Role & Permission</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>

                    </a>
                    <div class="{{ request()->is('edit/permission/*') || request()->is('all/permission') || request()->is('add/permission') || request()->is('add/roles/permission') || request()->is('all/roles/permission') || request()->is('*/roles') || request()->is('admin/edit/roles/*') || request()->is('edit/roles/*') ? 'show' : 'collapse' }}"
                        id="uiComponents">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.permission') }}"
                                    class="nav-link {{ request()->is('all/permission') || request()->is('edit/permission/*') ? 'active' : '' }}">
                                    Permission</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.roles') }}"
                                    class="nav-link {{ request()->is('*/roles') || request()->is('edit/roles/*') ? 'active' : '' }}">
                                    Roles</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('add.roles.permission') }}"
                                    class="nav-link {{ request()->is('add/roles/permission') ? 'active' : '' }}">Add
                                    Role in Permission</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.roles.permission') }}"
                                    class="nav-link {{ request()->is('all/roles/permission') || request()->is('admin/edit/roles/*') ? 'active' : '' }}">
                                    Role in Permission</a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if (Auth::user()->can('admin.menu'))
                <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">

                    <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="false"
                        aria-controls="forms">
                        <i class="link-icon" data-feather="inbox"></i>
                        <span class="link-title">Manage Admin</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>

                    <div class="{{ request()->is('*/admin') | request()->is('*/admin/*') ? 'show' : 'collapse' }}"
                        id="forms">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('all.admin') }}"
                                    class="nav-link {{ request()->is('*/admin') || 'edit/admin/*' ? 'active' : '' }}">
                                    Admin</a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if (Auth::user()->can('employee.menu'))
                <li class="nav-item nav-category">Master</li>
            @endif

            @if (Auth::user()->can('category.menu'))
                @php
                    // Definisikan array URL
                    $urls = [
                        '*/category',
                        '*/category/*',
                        'all/category',
                        'edit/category/*',
                        'all/cbd',
                        'edit/cbd/*',
                        'import/cbds',
                        'all/color',
                        'edit/color/*',
                        'all/consumption',
                        'add/consumption',
                        'edit/consumption/*',
                        'all/employee',
                        'edit/employee/*',
                        '*/employee',
                        'all/item',
                        'edit/item/*',
                        'all/itemvariant',
                        'edit/itemvariant/*',
                        'all/qr_code',
                        'edit/qr_code/*',
                        '*/qr_code',
                        'all/size',
                        'edit/size/*',
                        'all/supplier',
                        'edit/supplier/*',
                        'all/unit',
                        'edit/unit/*',
                        'all/rak',
                        'edit/rak/*',
                        '*/rak',
                        'all/bom',
                        'edit/bom/*',
                        '*/bom',
                    ];

                    // Fungsi untuk memeriksa apakah rute saat ini ada dalam array URL
                    $isActive = function ($urls) {
                        foreach ($urls as $url) {
                            if (request()->is($url)) {
                                return true;
                            }
                        }
                        return false;
                    };
                @endphp

                <li class="nav-item {{ $isActive($urls) ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#emailszeo" role="button" aria-expanded="false"
                        aria-controls="emailsze">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Master</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>

                    <div class="{{ $isActive($urls) ? 'show' : 'collapse' }}" id="emailszeo">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('all.bom'))
                            <li class="nav-item">
                                <a href="{{ route('all.bom') }}"
                                    class="nav-link {{ request()->is('all/bom') || request()->is('edit/bom/*') || request()->is('import/boms') ? 'active' : '' }}">
                                    BOM</a>
                            </li>
                             @endif

                            @if (Auth::user()->can('all.category'))
                                <li class="nav-item">
                                    <a href="{{ route('all.category') }}"
                                        class="nav-link {{ request()->is('all/category') || request()->is('edit/category/*') ? 'active' : '' }}">
                                        Category</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.cbd'))
                                <li class="nav-item">
                                    <a href="{{ route('all.cbd') }}"
                                        class="nav-link {{ request()->is('all/cbd') || request()->is('edit/cbd/*') || request()->is('import/cbds') ? 'active' : '' }}">
                                        CBD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.color'))
                                <li class="nav-item">
                                    <a href="{{ route('all.color') }}"
                                        class="nav-link {{ request()->is('all/color') || request()->is('edit/color/*') ? 'active' : '' }}">
                                        Color</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.consumption'))
                                <li class="nav-item">
                                    <a href="{{ route('all.consumption') }}"
                                        class="nav-link {{ request()->is('*/consumption') || request()->is('edit/consumption/*') ? 'active' : '' }}">
                                        Consumption</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.employee'))
                                <li class="nav-item">
                                    <a href="{{ route('all.employee') }}"
                                        class="nav-link {{ request()->is('*/employee') || request()->is('edit/employee/*') ? 'active' : '' }}">
                                        Employee</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.item'))
                                <li class="nav-item">
                                    <a href="{{ route('all.item') }}"
                                        class="nav-link {{ request()->is('all/item') || request()->is('edit/item/*') ? 'active' : '' }}">
                                        Item</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.qr_code'))
                                <li class="nav-item">
                                    <a href="{{ route('all.qr_code') }}"
                                        class="nav-link {{ request()->is('all/qr_code') || request()->is('import/qr_codes') ? 'active' : '' }}">
                                        QR Code Fabric</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.rak'))
                                <li class="nav-item">
                                    <a href="{{ route('all.rak') }}"
                                        class="nav-link {{ request()->is('all/rak') || request()->is('*/rak') ? 'active' : '' }}">
                                        Rak</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.size'))
                                <li class="nav-item">
                                    <a href="{{ route('all.size') }}"
                                        class="nav-link {{ request()->is('all/size') || request()->is('edit/size/*') ? 'active' : '' }}">
                                        Size</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.supplier'))
                                <li class="nav-item">
                                    <a href="{{ route('all.supplier') }}"
                                        class="nav-link {{ request()->is('all/supplier') || request()->is('edit/supplier/*') ? 'active' : '' }}">
                                        Supplier</a>
                                </li>
                            @endif
                            @if (Auth::user()->can('all.unit'))
                                <li class="nav-item">
                                    <a href="{{ route('all.unit') }}"
                                        class="nav-link {{ request()->is('all/unit') || request()->is('edit/unit/*') ? 'active' : '' }}">
                                        Unit</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            <li class="nav-item nav-category">PO Transaction</li>
            @if (Auth::user()->can('transaction.menu'))

                <li class="nav-item {{ request()->is('*/transaction') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.transaction'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout" role="button"
                            aria-expanded="false" aria-controls="emailsyout">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">Transaction</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/transaction') || request()->is('*/transaction/*') || request()->is('*/transaction') ? 'show' : 'collapse' }}"
                        id="emailsyout">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('all.transaction'))
                                <li class="nav-item">
                                    <a href="{{ route('add.transaction') }}"
                                        class="nav-link {{ request()->is('add/transaction') ? 'active' : '' }}">Add
                                        Trasaction IN</a>
                                </li>
                            @endif
                            @if (Auth::user()->can('all.transaction'))
                                <li class="nav-item">
                                    <a href="{{ route('add.transactionout') }}"
                                        class="nav-link {{ request()->is('add/transactionout') ? 'active' : '' }}">Add
                                        Trasaction OUT</a>
                                </li>
                            @endif
                            @if (Auth::user()->can('all.transaction'))
                                <li class="nav-item">
                                    <a href="{{ route('all.transaction') }}"
                                        class="nav-link {{ request()->is('all/transaction') ? 'active' : '' }}">
                                        Transaction</a>
                                </li>
                            @endif

                        </ul>
                    </div>

                </li>

                <li
                    class="nav-item {{ request()->is('*/purchaserequest') || request()->is('edit/purchaserequest/*') || request()->is('*/purchaserequest/*') || request()->is('*/purchaserequestid/*') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.purchaserequest'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout1" role="button"
                            aria-expanded="false" aria-controls="emailsyout1">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">Purchase Request</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/purchaserequest') || request()->is('*/purchaserequest/*') || request()->is('*/purchaserequest') || request()->is('*/photoreturn') || request()->is('*/purchaserequestwaiting') ? 'show' : 'collapse' }}"
                        id="emailsyout1">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('purchaserequest.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.purchaserequest') }}"
                                        class="nav-link {{ request()->is('all/purchaserequest') ? 'active' : '' }}">
                                        Purchase Request (PR)</a>
                                </li>
                            @endif
                
               			  @if (Auth::user()->can('purchaserequest.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.purchaserequestwaiting') }}"
                                        class="nav-link {{ request()->is('all/purchaserequestwaiting') ? 'active' : '' }}">
                                        Purchase Request (Waiting)</a>
                                </li>
                            @endif


                        </ul>
                    </div>

                </li>
              <li
                    class="nav-item {{ request()->is('*/purchaseorder') || request()->is('edit/purchaseorder/*') || request()->is('*/purchaseorder/*') || request()->is('*/purchaseorderid/*') || request()->is('all/purchaseordersend') || request()->is('add/purchaseordersend') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.purchaseorder'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout1x" role="button"
                            aria-expanded="false" aria-controls="emailsyout1x">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">Purchase Order</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/purchaseorder') || request()->is('*/purchaseorder/*') || request()->is('*/purchaseorderid/*') || request()->is('*/purchaseordersend') ? 'show' : 'collapse' }}"
                        id="emailsyout1x">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('purchaseorder.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.purchaseorder') }}"
                                        class="nav-link {{ request()->is('all/purchaseorder') ? 'active' : '' }}">
                                        Purchase Order (PO)</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('purchaseordersend.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.purchaseordersend') }}"
                                        class="nav-link {{ request()->is('all/purchaseordersend') || request()->is('add/purchaseordersend') ? 'active' : '' }}">
                                        Purchase Order (Send Email)</a>
                                </li>
                            @endif

                        </ul>

                    </div>

                </li>

            @endif

            <li class="nav-item nav-category">WAREHOUSE</li>
            @if (Auth::user()->can('transaction.menu'))

                <li
                    class="nav-item {{ request()->is('*/materialin') || request()->is('edit/materialin/*') || request()->is('*/materialin/*') || request()->is('*/materialinid/*') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.materialin'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout10" role="button"
                            aria-expanded="false" aria-controls="emailsyout10">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">MATERIAL RAW</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/materialin') || request()->is('*/materialin/*') || request()->is('*/materialin') || request()->is('*/materialinsp') || request()->is('all/materialindetail') || request()->is('add/materialout') || request()->is('all/materialout') || request()->is('all/materialreturn') || request()->is('add/materialreturn') ? 'show' : 'collapse' }}"
                        id="emailsyout10">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('materialin.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialin') }}"
                                        class="nav-link {{ request()->is('all/materialin') ? 'active' : '' }}">
                                        Material IN</a>
                                </li>
                            @endif

                            {{-- @if (Auth::user()->can('materialin.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialindetail') }}"
                                        class="nav-link {{ request()->is('all/materialindetail') || request()->is('*/materialindetailsp') ? 'active' : '' }}">
                                        Material IN DETAIL</a>
                                </li>
                            @endif --}}

                            @if (Auth::user()->can('materialin.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('add.materialinsp') }}"
                                        class="nav-link {{ request()->is('add/materialinsp') ? 'active' : '' }}">
                                        Material IN ADD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('materialout.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialout') }}"
                                        class="nav-link {{ request()->is('all/materialout') ? 'active' : '' }}">
                                        Material OUT</a>
                                </li>
                            @endif
                            {{-- 
                            @if (Auth::user()->can('materialout.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialoutdetail') }}"
                                        class="nav-link {{ request()->is('all/materialoutdetail') || request()->is('*/materialoutdetail') ? 'active' : '' }}">
                                        Material OUT DETAIL</a>
                                </li>
                            @endif --}}

                            @if (Auth::user()->can('materialout.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('add.materialout') }}"
                                        class="nav-link {{ request()->is('add/materialout') ? 'active' : '' }}">
                                        Material OUT ADD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('materialreturn.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialreturn') }}"
                                        class="nav-link {{ request()->is('all/materialreturn') ? 'active' : '' }}">
                                        Material RETURN</a>
                                </li>
                            @endif

                            {{-- @if (Auth::user()->can('materialreturn.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialreturndetail') }}"
                                        class="nav-link {{ request()->is('all/materialreturndetail') || request()->is('*/materialreturndetail') ? 'active' : '' }}">
                                        Material RETURN DETAIL</a>
                                </li>
                            @endif --}}

                            @if (Auth::user()->can('materialreturn.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('add.materialreturn') }}"
                                        class="nav-link {{ request()->is('add/materialreturn') ? 'active' : '' }}">
                                        Material RETURN ADD</a>
                                </li>
                            @endif

                        </ul>
                    </div>

                </li>

                {{-- <li
                    class="nav-item {{ request()->is('*/accessoriesin') || request()->is('edit/accessoriesin/*') || request()->is('*/accessoriesin/*') || request()->is('*/accessoriesinid/*') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.accessoriesin'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout101" role="button"
                            aria-expanded="false" aria-controls="emailsyout101">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">Accessories</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/accessoriesin') || request()->is('*/accessoriesin/*') || request()->is('*/accessoriesin') || request()->is('*/accessoriesinsp') || request()->is('all/accessoriesindetail') ? 'show' : 'collapse' }}"
                        id="emailsyout101">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('accessoriesin.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.accessoriesin') }}"
                                        class="nav-link {{ request()->is('all/accessoriesin') || request()->is('*/accessoriesinsp') ? 'active' : '' }}">
                                        Accessories IN</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesin.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.accessoriesindetail') }}"
                                        class="nav-link {{ request()->is('all/accessoriesindetail') || request()->is('*/accessoriesindetailsp') ? 'active' : '' }}">
                                        Accessories IN DETAIL</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesin.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('add.accessoriesinsp') }}"
                                        class="nav-link {{ request()->is('add/accessoriesinsp') ? 'active' : '' }}">
                                        Accessories IN ADD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('materialout.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.materialout') }}"
                                        class="nav-link {{ request()->is('all/materialout') ? 'active' : '' }}">
                                        Accessories OUT</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesout.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.accessoriesoutdetail') }}"
                                        class="nav-link {{ request()->is('all/accessoriesoutdetail') || request()->is('*/accessoriesoutdetail') ? 'active' : '' }}">
                                        Accessories OUT DETAIL</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesout.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('add.accessoriesout') }}"
                                        class="nav-link {{ request()->is('add/accessoriesout') ? 'active' : '' }}">
                                        Accessories OUT ADD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesreturn.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.accessoriesreturn') }}"
                                        class="nav-link {{ request()->is('all/accessoriesreturn') ? 'active' : '' }}">
                                        Accessories RETURN</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesreturn.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.accessoriesreturndetail') }}"
                                        class="nav-link {{ request()->is('all/accessoriesreturndetail') || request()->is('*/accessoriesreturndetail') ? 'active' : '' }}">
                                        Accessories RETURN DETAIL</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('accessoriesreturn.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('add.accessoriesreturn') }}"
                                        class="nav-link {{ request()->is('add/accessoriesreturn') ? 'active' : '' }}">
                                        Accessories RETURN ADD</a>
                                </li>
                            @endif

                        </ul>
                    </div>

                </li> --}}

                <li class="nav-item {{ request()->is('*/stock') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.stock'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout11x" role="button"
                            aria-expanded="false" aria-controls="emailsyout11x">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">STOCK</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/stock') || request()->is('all/stockdetail') || request()->is('all/stockmutation') || request()->is('all/stockmutationori') ? 'show' : 'collapse' }}"
                        id="emailsyout11x">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('stock.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stock') }}"
                                        class="nav-link {{ request()->is('all/stock') ? 'active' : '' }}">
                                        STOCK BY CODE</a>
                                </li>
                            @endif

                            {{-- @if (Auth::user()->can('stock.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockdetail') }}"
                                        class="nav-link {{ request()->is('all/stockdetail') || request()->is('*/stockdetail') ? 'active' : '' }}">
                                        STOCK BY ORIGINAL NO</a>
                                </li>
                            @endif --}}

                            @if (Auth::user()->can('stock.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockmutation') }}"
                                        class="nav-link {{ request()->is('all/stockmutation') ? 'active' : '' }}">
                                        MUTATION BY CODE</a>
                                </li>
                            @endif

                            {{-- @if (Auth::user()->can('stock.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockmutationori') }}"
                                        class="nav-link {{ request()->is('all/stockmutationori') ? 'active' : '' }}">
                                        MUTATION BY ORIGINAL NO</a>
                                </li>
                            @endif --}}

                        </ul>
                    </div>

                </li>

            @endif

            {{-- <li class="nav-item nav-category">RELAX</li> --}}
            @if (Auth::user()->can('transaction.menu'))
                {{-- <li
                    class="nav-item {{ request()->is('*/relaxin') || request()->is('edit/relaxin/*') || request()->is('*/relaxin/*') || request()->is('*/relaxinid/*') || request()->is('*/relaxout') || request()->is('all/relaxreturn') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.relaxin'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout1nmx" role="button"
                            aria-expanded="false" aria-controls="emailsyout1nmx">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">RELAX</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/relaxin') || request()->is('*/relaxin/*') || request()->is('*/relaxindetail') || request()->is('*/relaxout') || request()->is('*/relaxreturn') ? 'show' : 'collapse' }}"
                        id="emailsyout1nmx">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('all.relaxin'))
                                <li class="nav-item">
                                    <a href="{{ route('all.relaxin') }}"
                                        class="nav-link {{ request()->is('all/relaxin') ? 'active' : '' }}">
                                        RELAX IN</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all/relaxindetail'))
                                <li class="nav-item">
                                    <a href="{{ route('all.relaxindetail') }}"
                                        class="nav-link {{ request()->is('all/relaxindetail') ? 'active' : '' }}">
                                        RELAX IN DETAIL</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('add.relaxin'))
                                <li class="nav-item">
                                    <a href="{{ route('add.relaxin') }}"
                                        class="nav-link {{ request()->is('add/relaxin') ? 'active' : '' }}">
                                        RELAX IN ADD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.relaxout'))
                                <li class="nav-item">
                                    <a href="{{ route('all.relaxout') }}"
                                        class="nav-link {{ request()->is('all/relaxout') ? 'active' : '' }}">
                                        RELAX OUT</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all/relaxoutdetail'))
                                <li class="nav-item">
                                    <a href="{{ route('all.relaxoutdetail') }}"
                                        class="nav-link {{ request()->is('all/relaxoutdetail') ? 'active' : '' }}">
                                        RELAX OUT DETAIL</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('add.relaxout'))
                                <li class="nav-item">
                                    <a href="{{ route('add.relaxout') }}"
                                        class="nav-link {{ request()->is('add/relaxout') ? 'active' : '' }}">
                                        RELAX OUT ADD</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all.relaxreturn'))
                                <li class="nav-item">
                                    <a href="{{ route('all.relaxreturn') }}"
                                        class="nav-link {{ request()->is('all/relaxreturn') ? 'active' : '' }}">
                                        RELAX RETURN</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('all/relaxreturndetail'))
                                <li class="nav-item">
                                    <a href="{{ route('all.relaxreturndetail') }}"
                                        class="nav-link {{ request()->is('all/relaxreturndetail') ? 'active' : '' }}">
                                        RELAX RETURN DETAIL</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('add.relaxreturn'))
                                <li class="nav-item">
                                    <a href="{{ route('add.relaxreturn') }}"
                                        class="nav-link {{ request()->is('add/relaxreturn') ? 'active' : '' }}">
                                        RELAX RETURN ADD</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ request()->is('*/stockrelax') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.stockrelax'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout11x1" role="button"
                            aria-expanded="false" aria-controls="emailsyout11x1">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">STOCK RELAX</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/stockrelax') || request()->is('all/stockrelaxdetail') || request()->is('all/stockrelaxmutation') || request()->is('all/stockrelaxmutationori') ? 'show' : 'collapse' }}"
                        id="emailsyout11x1">
                        <ul class="nav sub-menu">

                            @if (Auth::user()->can('stockrelax.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockrelax') }}"
                                        class="nav-link {{ request()->is('all/stockrelax') ? 'active' : '' }}">
                                        STOCK RELAX BY CODE</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('stockrelax.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockrelaxdetail') }}"
                                        class="nav-link {{ request()->is('all/stockrelaxdetail') || request()->is('*/stockrelaxdetail') ? 'active' : '' }}">
                                        STOCK RELAX BY ORIGINAL NO</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('stockrelax.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockrelaxmutation') }}"
                                        class="nav-link {{ request()->is('all/stockrelaxmutation') ? 'active' : '' }}">
                                        RELAX MUTATION BY CODE</a>
                                </li>
                            @endif

                            @if (Auth::user()->can('stockrelax.menu'))
                                <li class="nav-item">
                                    <a href="{{ route('all.stockrelaxmutationori') }}"
                                        class="nav-link {{ request()->is('all/stockrelaxmutationori') ? 'active' : '' }}">
                                        RELAX MUTATION BY ORIGINAL NO</a>
                                </li>
                            @endif

                        </ul>
                    </div>

                </li> --}}

                {{-- <li
                    class="nav-item {{ request()->is('*/relaxout') || request()->is('edit/relaxout/*') || request()->is('*/relaxout/*') || request()->is('*/relaxoutid/*') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.relaxout'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout1nmx1" role="button"
                            aria-expanded="false" aria-controls="emailsyout1nmx1">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">RELAX OUT</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/relaxout') || request()->is('*/relaxout/*') || request()->is('*/relaxout') || request()->is('*/photoreturn') || request()->is('*/serahterima') ? 'show' : 'collapse' }}"
                        id="emailsyout1nmx1">
                        <ul class="nav sub-menu">

                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ request()->is('*/relaxreturn') || request()->is('edit/relaxreturn/*') || request()->is('*/relaxreturn/*') || request()->is('*/relaxreturnid/*') ? 'active' : '' }}">
                    @if (Auth::user()->can('all.relaxreturn'))
                        <a class="nav-link" data-bs-toggle="collapse" href="#emailsyout1nmx2" role="button"
                            aria-expanded="false" aria-controls="emailsyout1nmx2">
                            <i class="link-icon" data-feather="check-circle"></i>
                            <span class="link-title">RELAX RETURN</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                    @endif
                    <div class="{{ request()->is('*/relaxreturn') || request()->is('*/relaxreturn/*') || request()->is('*/relaxreturn') || request()->is('*/photoreturn') || request()->is('*/serahterima') ? 'show' : 'collapse' }}"
                        id="emailsyout1nmx2">
                        <ul class="nav sub-menu">

                        </ul>
                    </div>
                </li> --}}
            @endif

        </ul>
    </div>
</nav>
