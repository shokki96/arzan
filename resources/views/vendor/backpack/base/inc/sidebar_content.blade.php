<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

@if(backpack_user()->hasPermissionTo('locations'))
<li><a href='{{ backpack_url("location") }}'><i class='fa fa-globe'></i> <span>Locations</span></a></li>
@endif
@if(backpack_user()->hasPermissionTo('customers'))
<li><a href='{{ backpack_url("client") }}'><i class='fa fa-users'></i> <span>Customers</span></a></li>
@endif
@if(backpack_user()->hasPermissionTo('categories'))
<li><a href='{{ backpack_url("category") }}'><i class='fa fa-cubes'></i> <span>Categories</span></a></li>
@endif
@if(backpack_user()->hasPermissionTo('products'))
<li><a href='{{ backpack_url("product") }}'><i class="fa fa-shopping-bag"></i> <span>Products</span></a></li>
@endif
@if(backpack_user()->hasPermissionTo('contacts'))
<li><a href='{{ backpack_url("contact") }}'><i class="fa fa-envelope"></i> <span>Contacts</span></a></li>
@endif
@if(backpack_user()->hasPermissionTo('orders'))
<li><a href='{{ backpack_url('order') }}'><i class='fa fa-tag'></i> <span>Orders</span></a></li>
@endif
<!-- Users, Roles Permissions -->
@if(backpack_user()->hasPermissionTo('users'))
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
        <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
        <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endif