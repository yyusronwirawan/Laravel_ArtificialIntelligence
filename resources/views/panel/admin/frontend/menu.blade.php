@extends('panel.layout.app')
@section('title', 'Menu Settings')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
                    <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to dashboard')}}
                    </a>
                    <h2 class="page-title mb-2">
                        {{__('Menu Settings')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            <div class="row col-md-5 mx-auto">
                <form id="settings_form" onsubmit="return menuSettingsSave();" enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <button type="button" class="btn btn-default add-menu">
                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    {{__('Add Menu')}}
                                </button>
                            </div>
                            <div id="menu-items" class="flex flex-col space-y-1">

                            @php
                                $setting->menu_options = $setting->menu_options ? $setting->menu_options : '[{"title": "Home","url": "#banner","target": false},{"title": "Features","url": "#features","target": false},{"title": "How it Works","url": "#how-it-works","target": false},{"title": "Testimonials","url": "#testimonials","target": false},{"title": "Pricing","url": "#pricing","target": false},{"title": "FAQ","url": "#faq","target": false}]';
                                $menu_options = json_decode($setting->menu_options, true);
                                foreach( $menu_options as $menu_item ) {
                                    printf(
                                        '
                                        <div class="menu-item !bg-white rounded-lg shadow-[0_10px_10px_rgba(0,0,0,0.06)] border relative dark:!bg-opacity-5">
                                            <h4 class="accordion-title flex items-center justify-between !gap-1 mb-0 !ps-4 !pe-2 !py-1 cursor-pointer">
												<span>%1$s</span>
												<small class="opacity-60 me-auto">%4$s</small>
												<div class="accordion-controls flex items-center">
													<div class="menu-delete inline-flex items-center justify-center w-10 h-10 rounded-md hover:bg-red-100 hover:text-red-500 cursor-pointer">
														<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 7l16 0"></path> <path d="M10 11l0 6"></path> <path d="M14 11l0 6"></path> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path> </svg>
													</div>
													<span class="handle inline-flex items-center justify-center w-10 h-10 rounded-md cursor-move hover:bg-black hover:!bg-opacity-10 dark:hover:bg-white">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> </svg>
													</span>
												</div>
											</h4>
                                            <div class="accordion-content hidden mt-3 p-3 pt-0">
                                                <div class="mb-3">
                                                    <label class="form-label">%2$s</label>
                                                    <input type="text" class="form-control menu-title" name="title" value="%1$s" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">%3$s</label>
                                                    <input type="text" class="form-control menu-url" name="url" placeholder="https://" value="%4$s" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-check form-switch">
                                                        <span class="form-check-label mr-2">%5$s</span>
                                                        <input class="form-check-input menu-target" type="checkbox" %6$s>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        ',
                                        $menu_item['title'],
                                        __('Title'),
                                        __('URL'),
                                        $menu_item['url'],
                                        __('Open In New Tab'),
                                        ($menu_item['target'] === false ? '' : 'checked')
                                    );
                                }
                            @endphp

                            </div>
                        </div>
                    </div>

                    <button form="settings_form" id="settings_button" class="btn btn-primary w-100">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="/assets/js/panel/settings.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.js"></script>
    <script>
        $('#menu-items').sortable({
			handle: ".handle"
		});
    </script>

    <script>

        const new_menu_item = `
			<div class="menu-item !bg-white rounded-lg shadow-[0_10px_10px_rgba(0,0,0,0.06)] border relative dark:!bg-opacity-5">
				<h4 class="accordion-title flex items-center justify-between !gap-1 mb-0 !ps-4 !pe-2 !py-1 cursor-pointer">
					<span>Menu Item</span>
					<small class="opacity-60 me-auto">#</small>
					<div class="accordion-controls flex items-center">
						<div class="menu-delete inline-flex items-center justify-center w-10 h-10 rounded-md hover:bg-red-100 hover:text-red-500 cursor-pointer">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M4 7l16 0"></path> <path d="M10 11l0 6"></path> <path d="M14 11l0 6"></path> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path> </svg>
						</div>
						<span class="handle inline-flex items-center justify-center w-10 h-10 rounded-md cursor-move hover:bg-black hover:!bg-opacity-10 dark:hover:bg-white">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path> </svg>
						</span>
					</div>
				</h4>
				<div class="accordion-content hidden mt-3 p-3 pt-0">
					<div class="mb-3">
						<label class="form-label">{{__('Title')}}</label>
						<input type="text" class="form-control menu-title" name="title" value="" required>
					</div>
					<div class="mb-3">
						<label class="form-label">{{__('URL')}}</label>
						<input type="text" class="form-control menu-url" name="title" placeholder="https://" value="" required>
					</div>
					<div class="mb-3">
						<label class="form-check form-switch">
							<span class="form-check-label mr-2">{{ __('Open In New Tab') }}</span>
							<input class="form-check-input menu-target" type="checkbox">
						</label>
					</div>
				</div>
			</div>`;

		$('body').on('click', '.accordion-title', ev => {
			const accordionTitle = ev.currentTarget;
			accordionTitle.classList.toggle("active");
			accordionTitle.nextElementSibling.classList.toggle("hidden");
		});

        $(".add-menu").click(function () {
            $("#menu-items").append(new_menu_item);
        });

		$('body').on('input', 'input.menu-title', ev => {
			const input = ev.currentTarget;
			const value = input.value;

			input.closest('.menu-item').querySelector('.accordion-title > span').innerText = value;
		});

		$('body').on('input', 'input.menu-url', ev => {
			const input = ev.currentTarget;
			const value = input.value;

			input.closest('.menu-item').querySelector('.accordion-title > small').innerText = value;
		});

        $('body').on('click', '.menu-delete', function() {
            $(this).closest('.menu-item').remove();
        });
    </script>
@endsection
