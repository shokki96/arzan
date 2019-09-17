<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

@if(backpack_user()->can('locations'))
<li><a href='{{ backpack_url("location") }}'><i class='fa fa-globe'></i> <span>Ýerler</span></a></li>
@endif
@if(backpack_user()->can('customers'))
<li><a href='{{ backpack_url("customer") }}'><i class='fa fa-users'></i> <span>Ulanyjylar</span></a></li>
@endif
@if(backpack_user()->can('categories'))
<li><a href='{{ backpack_url("category") }}'><i class='fa fa-cubes'></i> <span>Kategoriýalar</span></a></li>
@endif
@if(backpack_user()->can('users'))
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>ARZAN panel</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Ulanyjylar</span></a></li>
        <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
        <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Rugsatlar</span></a></li>
    </ul>
</li>
<li><a href='{{ backpack_url("contact") }}'><i class="fa fa-envelope"></i> <span>Habarlaşmak üçin</span></a></li>
@endif
@if(backpack_user()->can('products'))
<li><a href='{{ backpack_url("product") }}'><i class="fa fa-shopping-bag"></i> <span>Harytlar</span></a></li>

@endif

@if(backpack_user()->can('orders'))
<li><a href='{{ backpack_url("order") }}'><i class='fa fa-tag'></i> <span>Zakazlar</span></a></li>
@endif

@if(backpack_user()->can('sliders'))
<li><a href='{{ backpack_url("slider") }}'><i class='fa fa-image'></i> <span>Slaýderler</span></a></li>
@endif

@if(backpack_user()->can('deliverman'))
<li><a href='{{ backpack_url("delivermen") }}'><i class='fa fa-car'></i> <span>Dostawşiklar</span></a></li>
@endif