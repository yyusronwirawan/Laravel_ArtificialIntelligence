<?php
	$wrapper_classnames = ['mx-auto', 'text-center'];

	if ( empty( $width ) ) {
		$wrapper_classnames[] = 'w-2/5';
	} else {
		$wrapper_classnames[] = $width;
	}
	if ( empty( $mb ) ) {
		$wrapper_classnames[] = 'mb-14';
	} else {
		$wrapper_classnames[] = 'mb-' . $mb;
	}
?>

<header class="{{join( ' ', $wrapper_classnames )}} max-xl:w-8/12 max-lg:w-10/12 max-md:w-full">
	{{$slot}}
	<h2 class="mb-[0.45em]">{{$title}}</h2>
	<p class="text-[18px] leading-[1.444em]">{{$subtitle}}</p>
</header>