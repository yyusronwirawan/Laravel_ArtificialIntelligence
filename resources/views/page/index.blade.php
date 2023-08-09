@extends('layout.app')

@section('content')

<section class="site-section flex items-center justify-center min-h-[200px] text-center text-white relative py-52 max-md:pb-16 max-md:pt-48 overflow-hidden bg-[#4384ea]" id="banner">
	<canvas id="banner-bg" class="absolute top-0 start-0 w-full-h-full"></canvas>
	<div class="container relative">
		<div class="max-lg:w-2/3 max-md:w-full flex flex-col items-center w-1/2 mx-auto">
			<div class="banner-title-wrap relative">
				<h1
					class="
					banner-title
				    font-golos -tracking-wide font-bold text-white
					opacity-0 transition-all ease-out translate-y-7
					group-[.page-loaded]/body:opacity-100 group-[.page-loaded]/body:translate-y-0">
					{{$page->title}}
				</h1>
			</div>
		</div>
	</div>
</section>

<section class="page-content">
    <div class="container py-20">
        {!! $page->content !!}
    </div>
</section>

@endsection
