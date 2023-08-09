<!DOCTYPE html>
<html lang="en" class="max-sm:overflow-x-hidden">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	@if(isset($setting->meta_description))
        <meta name="description" content="{{$setting->meta_description}}">
    @endif
	@if(isset($setting->meta_keywords))
        <meta name="keywords" content="{{$setting->meta_keywords}}">
    @endif
    <link rel="icon" href="/{{$setting->favicon_path}}">
    <title>@if(isset($setting->meta_title)) {{$setting->meta_title}} @else {{$setting->site_name}} | {{__('Home')}} @endif</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="/assets/css/frontend/fonts.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/frontend/flickity.min.css">

	@vite('resources/css/frontend.scss')

    @if($setting->frontend_custom_css != null)
        <link rel="stylesheet" href="{{$setting->frontend_custom_css}}" />
    @endif
  
	@if($setting->frontend_code_before_head != null)
        {!!$setting->frontend_code_before_head!!}
    @endif

	<script>
		window.liquid = {
			isLandingPage: true
		};
	</script>
</head>
<body class="font-golos bg-body-bg text-body group/body">
	<script src="/assets/js/tabler-theme.min.js"></script>
	<script src="/assets/js/navbar-shrink.js"></script>

	<div id="app-loading-indicator" class="fixed top-0 left-0 right-0 z-[99] opacity-0 transition-opacity">
		<div class="progress [--tblr-progress-height:3px]">
			<div class="progress-bar progress-bar-indeterminate bg-[--tblr-primary] before:[animation-timing-function:ease-in-out] dark:bg-white"></div>
		</div>
	</div>

	@include('layout.header')

	@yield('content')

	@include('layout.footer')

	@if($setting->frontend_custom_js != null)
		<script src="{{$setting->frontend_custom_js}}"></script>
	@endif

	@if($setting->frontend_code_before_body != null)
        {!!$setting->frontend_code_before_body!!}
    @endif

	<script src="/assets/libs/vanillajs-scrollspy.min.js"></script>
	<script src="/assets/libs/flickity.pkgd.min.js"></script>
	<script src="/assets/js/frontend.js"></script>
	<script src="/assets/js/frontend/frontend-animations.js"></script>
	@if($setting->gdpr_status == 1)
	<script src="/assets/js/gdpr.js"></script>
	@endif

</body>
</html>
