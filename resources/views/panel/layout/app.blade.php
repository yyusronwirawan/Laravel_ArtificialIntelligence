<!doctype html>
<html lang="en">
@include('panel.layout.head')
<body class="group/body">
	<script src="/assets/js/tabler-theme.min.js"></script>
	<script src="/assets/js/navbar-shrink.js"></script>

	<div id="app-loading-indicator" class="fixed top-0 left-0 right-0 z-[99] opacity-0 transition-opacity">
		<div class="progress [--tblr-progress-height:3px]">
			<div class="progress-bar progress-bar-indeterminate bg-[--tblr-primary] before:[animation-timing-function:ease-in-out] dark:bg-white"></div>
		</div>
	</div>

	<div class="page">
		<!-- Navbar -->
		@include('panel.layout.header')

		<div class="page-wrapper overflow-hidden">
			<!-- Updater -->
            @if($good_for_now)
			@yield('content')
            @elseif(!$good_for_now and Route::currentRouteName()!= 'dashboard.admin.settings.general')
                @include('vendor.installer.magicai_c4st_Act')
            @else
                @yield('content')
            @endif
			@include('panel.layout.footer')
		</div>
	</div>

	@include('panel.layout.scripts')

	@if(\Session::has('message'))
	<script>
		toastr.{{\Session::get('type')}}('{{\Session::get('message')}}')
	</script>
	@endif

	@yield('script')
	<script src="/assets/js/frontend.js"></script>

	@if($setting->dashboard_code_before_body != null)
        {!!$setting->dashboard_code_before_body!!}
    @endif

	@auth()
		@if(\Illuminate\Support\Facades\Auth::user()->type == 'admin')
			<script src="/assets/js/panel/update-check.js"></script>
		@endif
	@endauth


</body>
</html>
