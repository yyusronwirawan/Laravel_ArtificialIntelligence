<div class="flex items-center justify-center px-3 h-12 absolute inset-x-0 top-0 z-50 bg-[#343C57] text-center text-white text-sm bg-cover bg-blend-luminosity opacity-0 transition-all duration-500 group-[.page-loaded]/body:opacity-100" style="background-image: url(/assets/img/site/conffetti.png);">
	<p>
		<span class="mr-3 text-xs font-semibold tracking-wide uppercase">{{__($fSetting->header_title)}}</span>
		<span class="opacity-70">{{__($fSetting->header_text)}}</span>
	</p>
</div>
<header class="site-header absolute inset-x-0 top-12 z-50 text-white transition-[background,shadow] group/header [&.lqd-is-sticky]:bg-white [&.lqd-is-sticky]:shadow-[0_4px_20px_rgba(0,0,0,0.03)] [&.lqd-is-sticky]:text-black">
	<nav id="frontend-local-navbar" class="flex items-center justify-between py-4 border-b border-white px-7 border-opacity-10 relative text-[14px] opacity-0 max-sm:px-2 transition-all duration-500 group-[.page-loaded]/body:opacity-100 group-[.lqd-is-sticky]/header:border-black group-[.lqd-is-sticky]/header:border-opacity-5">
		<a href="{{route('index')}}" class="site-logo basis-1/3 relative max-lg:basis-1/3">
			@if(isset($setting->logo_sticky))
			<img class="absolute top-1/2 start-0 opacity-0 -translate-y-1/2 translate-x-3 transition-all group-[.lqd-is-sticky]/header:opacity-100 group-[.lqd-is-sticky]/header:translate-x-0 peer" src="/{{$setting->logo_sticky_path}}" @if ( isset($setting->logo_sticky_2x_path) ) srcset="/{{$setting->logo_sticky_2x_path}} 2x" @endif alt="{{$setting->site_name}} logo">
			@endif
			<img class="transition-all group-[.lqd-is-sticky]/header:peer-first:opacity-0 group-[.lqd-is-sticky]/header:peer-first:translate-x-2" src="/{{$setting->logo_path}}" @if ( isset($setting->logo_2x_path) ) srcset="/{{$setting->logo_2x_path}} 2x" @endif alt="{{$setting->site_name}} logo">
		</a>
		<div class="site-nav-container basis-1/3 max-lg:w-full max-lg:absolute max-lg:top-full max-lg:right-0 max-lg:bg-[#343C57] max-lg:text-white max-lg:overflow-hidden max-lg:max-h-0 [&.lqd-is-active]:max-lg:max-h-screen">
			<ul class="flex items-center justify-center text-center gap-14 whitespace-nowrap max-xl:gap-10 max-lg:flex-col max-lg:items-start max-lg:gap-5 max-lg:p-10">
				@php
					$setting->menu_options = $setting->menu_options ? $setting->menu_options : '[{"title": "Home","url": "#banner","target": false},{"title": "Features","url": "#features","target": false},{"title": "How it Works","url": "#how-it-works","target": false},{"title": "Testimonials","url": "#testimonials","target": false},{"title": "Pricing","url": "#pricing","target": false},{"title": "FAQ","url": "#faq","target": false}]';
					$menu_options = json_decode($setting->menu_options, true);
					foreach( $menu_options as $menu_item ) {
						printf(
							'
							<li>
								<a href="%1$s" target="%3$s" class="relative before:absolute before:-inset-x-4 before:-inset-y-2 before:rounded-lg before:bg-current before:transition-all before:opacity-0 before:scale-75 hover:before:opacity-10 hover:before:scale-100 [&.active]:before:opacity-10 [&.active]:before:scale-100">
									%2$s
								</a>
							</li>
							',
							Route::currentRouteName() != 'index' ? url('/') . $menu_item['url'] : $menu_item['url'],
							__($menu_item['title']),
							($menu_item['target'] === false ? '_self' : '_blank')
						);
					}
				@endphp
			</ul>
		</div>
		<div class="flex justify-end gap-2 basis-1/3 max-lg:basis-2/3">
			<div class="hidden md:block relative group">
				<button class="inline-flex items-center justify-center w-10 h-10 border-2 border-solid border-white !border-opacity-20 rounded-full transition-colors group-hover:bg-white group-hover:!border-opacity-100 group-hover:text-black group-[.lqd-is-sticky]/header:border-black group-[.lqd-is-sticky]/header:group-hover:bg-black group-[.lqd-is-sticky]/header:group-hover:text-white before:absolute before:w-full before:h-4 before:top-full before:end-0">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
						<path d="M3.6 9h16.8"></path>
						<path d="M3.6 15h16.8"></path>
						<path d="M11.5 3a17 17 0 0 0 0 18"></path>
						<path d="M12.5 3a17 17 0 0 1 0 18"></path>
					</svg>
				</button>
				<div class="min-w-[145px] bg-white shadow-lg opacity-0 translate-y-2 pointer-events-none absolute top-[calc(100%+1rem)] end-0 rounded-md text-black transition-all group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" rel="alternate" hreflang="{{ $localeCode }}" class="block px-3 py-3 border-b border-black border-opacity-5 last:border-none transition-colors hover:bg-black hover:bg-opacity-5">{{ country2flag(substr($properties['regional'], strrpos($properties['regional'], '_') + 1)) }} {{$properties['native']}}</a>
                    @endforeach
				</div>
			</div>
			<x-button link="{{ LaravelLocalization::localizeUrl( route('login') ) }}" label="{!! __($fSetting->sign_in) !!}" type="outline" border="border-[2px] border-white !border-opacity-10 group-[.lqd-is-sticky]/header:border-black" text="text-white group-[.lqd-is-sticky]/header:text-black group-[.lqd-is-sticky]/header:hover:text-white" />
			<x-button link="{{ LaravelLocalization::localizeUrl( route('register') ) }}" label="{!! __($fSetting->join_hub) !!}" border="border-[2px] border-white !border-opacity-0" bg="bg-white !bg-opacity-10 hover:!bg-opacity-100 group-[.lqd-is-sticky]/header:bg-black group-[.lqd-is-sticky]/header:hover:!bg-opacity-100" text="text-white group-[.lqd-is-sticky]/header:text-black group-[.lqd-is-sticky]/header:hover:text-white" />
			<button class="flex items-center justify-center w-10 h-10 bg-white rounded-full mobile-nav-trigger shrink-0 !bg-opacity-10 group lg:hidden group-[.lqd-is-sticky]/header:bg-black">
				<span class="flex flex-col w-4 gap-1">
					@for ($i = 0; $i <= 1; $i++)
					<span class="inline-flex w-full h-[2px] bg-white transition-transform first:origin-left last:origin-right group-[&.lqd-is-active]:first:rotate-45 group-[&.lqd-is-active]:first:translate-x-[3px] group-[&.lqd-is-active]:first:-translate-y-[2px] group-[&.lqd-is-active]:last:-rotate-45 group-[&.lqd-is-active]:last:-translate-x-[2px] group-[&.lqd-is-active]:last:-translate-y-[8px] group-[.lqd-is-sticky]/header:bg-black"></span>
					@endfor
				</span>
			</button>
		</div>
	</nav>
</header>
@if(env('APP_STATUS') == 'Demo')
<div class="fixed bottom-8 start-8 z-50">
	<a class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#262626] transition-all duration-300 hover:shadow-md hover:scale-110 hover:-translate-y-1" href="https://codecanyon.net/item/magicai-openai-content-text-image-chat-code-generator-as-saas/45408109" target="_blank" title="{{__('Buy on Envato')}}">
		<svg fill="#0ac994" xmlns="http://www.w3.org/2000/svg" width="19.824" height="22.629" viewBox="0 0 19.824 22.629">
			<path d="M17.217,9.263c-.663-.368-2.564-.14-4.848.566-4,2.731-7.369,6.756-7.6,13.218-.043.155-.437-.021-.515-.069a9.2,9.2,0,0,1-.606-7.388c.168-.28-.381-.624-.48-.525A11.283,11.283,0,0,0,1.6,17.091a9.84,9.84,0,0,0,17.2,9.571c3.058-5.481.219-16.4-1.574-17.4Z" transform="translate(-0.32 -9.089)"/>
		</svg>
	</a>
</div>
@endif
