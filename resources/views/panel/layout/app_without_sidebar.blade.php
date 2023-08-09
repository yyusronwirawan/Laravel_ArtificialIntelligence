<!doctype html>
<html lang="en">
<head>
@include('panel.layout.head')
</head>
<body class="group/body">
<script src="/assets/js/tabler-theme.min.js"></script>
<script src="/assets/js/navbar-shrink.js"></script>

<div id="app-loading-indicator" class="fixed top-0 left-0 right-0 z-[99] opacity-0 transition-opacity">
	<div class="progress [--tblr-progress-height:3px]">
		<div class="progress-bar progress-bar-indeterminate bg-[--tblr-primary] before:[animation-timing-function:ease-in-out] dark:bg-white"></div>
	</div>
</div>

@yield('content')

@include('panel.layout.scripts')

@yield('script')
<script src="/assets/js/frontend.js"></script>
</body>
</html>
