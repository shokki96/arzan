<div class="user-panel" style="background-color: #1b2427;text-align: center">
  {{-- <a class="pull-left image" href="{{ route('backpack.account.info') }}">
    <img src="{{ backpack_avatar_url(backpack_auth()->user()) }}" class="img-circle" alt="User Image">
  </a> --}}
  <div class="pull-left" style="width: 100%">
    <p style="margin-bottom: 0"><a href="{{ route('backpack.account.info') }}" style="color: #fff; font-weight: 500;font-size: 17px;">{{ backpack_auth()->user()->name }}</a></p>
    <small><small><a href="{{ route('backpack.account.info') }}"><span><i class="fa fa-user-circle-o"></i> {{ trans('backpack::base.my_account') }}</span></a> &nbsp;  &nbsp; <a href="{{ backpack_url('logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></small></small>
  </div>
</div>