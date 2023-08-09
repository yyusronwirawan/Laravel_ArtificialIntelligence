@extends('panel.layout.app')
@section('title', 'Add or Edit Custom Template')
@section('additional_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="page-header" xmlns="http://www.w3.org/1999/html">
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
                        {{__('Add or Edit Custom Template')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row">
				<div class="col-md-5 mx-auto">
					<form id="custom_template_form" onsubmit="return templateSave({{$template!=null ? $template->id : null}});" action="">

						<div class="flex items-center !p-4 !py-3 !gap-3 rounded-xl text-[17px] bg-[rgba(157,107,221,0.1)] font-semibold mb-10">
							<span class="inline-flex items-center justify-center !w-6 !h-6 rounded-full bg-[#9D6BDD] text-white text-[15px] font-bold">1</span>
							{{__('Template')}}
						</div>

						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Title')}}
								<x-info-tooltip text="{{__('A title for the template that will show in templates list and in search results')}}" />
							</label>
							<input type="text" class="form-control" id="title" name="title" value="{{$template!=null ? $template->title : null}}">
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Description')}}
								<x-info-tooltip text="{{__('A short description about what this template do.')}}" />
							</label>
							<textarea class="form-control" rows="3" id="description" name="description">{{$template!=null ? $template->description : null}}</textarea>
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Icon')}}
								<a target="_blank" href="https://tabler-icons.io/">TablerIcons as SVG</a>
								<x-info-tooltip text="{{__('Paste the svg code you get from the Tabler Icons or any other icon sets')}}" />
							</label>
							<input type="text" class="form-control" id="image" name="image" value="{{$template!=null ? $template->image : null}}">
						</div>

						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Color')}}
								<x-info-tooltip text="{{__('Pick a color for for the icon container shape. Color is in HEX format.')}}" />
							</label>
							<div class="form-control flex items-center gap-2 relative">
								<div class="w-[17px] h-[17px] rounded-full overflow-hidden">
									<input type="color" class="w-[150%] h-[150%] relative -start-1/4 -top-1/4 p-0 rounded-full border-none cursor-pointer appearance-none" id="color" name="color" value="{{$template!=null ? $template->color : '#8fd2d0'}}">
								</div>
								<input class="bg-transparent border-none outline-none text-inherit" id="color_value" name="color_value" value="{{$template!=null ? $template->color : '#8fd2d0'}}" />
							</div>
						</div>


						<div class="form-control border-none p-0 mb-20 [&_.select2-selection--multiple]:!border-[--tblr-border-color] [&_.select2-selection--multiple]:!p-[1em_1.23em] [&_.select2-selection--multiple]:!rounded-[--tblr-border-radius]">
							<label class="form-label">
								{{__('Template Category')}}
								<x-info-tooltip text="{{__('Categories of the template. Useful for filtering in the templates list.')}}" />
							</label>
							<select class="form-control select2" name="filters" id="filters" multiple>
                                @foreach($filters as $filter)
                                    <option value="{{$filter->name}}" {{isset($template) && isset($template->filters) && in_array($filter->name, explode(',', $template->filters)) ? 'selected' : ''}}>
                                        {{$filter->name}}
                                    </option>
                                @endforeach
							</select>
							<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200">
								<svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
								{{__('You can add more filters, just add a filter and hit enter.')}}
							</div>
						</div>

						<div class="flex items-center !p-4 !py-3 !gap-3 rounded-xl text-[17px] bg-[rgba(157,107,221,0.1)] font-semibold mb-10">
							<span class="inline-flex items-center justify-center !w-6 !h-6 rounded-full bg-[#9D6BDD] text-white text-[15px] font-bold">2</span>
							{{__('Input Groups')}}
							<button type="button" class="add-more inline-flex items-center justify-center w-8 h-8 border-none rounded-full !ms-auto bg-[#fff] text-[#000] transition-all duration-300 hover:bg-black hover:text-white hover:shadow-lg">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 5l0 14"></path> <path d="M5 12l14 0"></path> </svg>
							</button>
						</div>

						<div class="mb-20">
							@if($template!= null)
								<?php $question_i = 1; ?>
								@foreach(json_decode($template->questions) as $question)
									<div class="user-input-group input-group control-group flex-col !p-5 mb-[20px] relative border border-solid rounded-[--tblr-border-radius]" data-input-name="{{$question->question}}" data-inputs-id="{{$question_i}}">
										<div class="mb-[20px]">
											<label class="form-label">
												{{__('Select Input Type')}}
												<x-info-tooltip text="{{__('Input fields for short texts and Textarea fields are good for long text.')}}" />
											</label>
											<select class="form-select input_type">
												<option value="text" {{$question->type == 'text' ? 'selected' : null}}>{{__('Input Field')}}</option>
												<option value="textarea" {{$question->type == 'textarea' ? 'selected' : null}}>{{__('Textarea Field')}}</option>
											</select>
										</div>
										<div class="mb-[20px]">
											<label class="form-label">
												{{__('Input Name')}}
												<x-info-tooltip text="{{__('Unique input name that you can use in your prompts later.')}}" />
											</label>
											<input type="text" class="form-control input_name" placeholder="{{__('Enter Name Here')}}" oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'');" value="{{$question->question}}">
										</div>
										<div class="mb-[20px]">
											<label class="form-label">
												{{__('Input Description')}}
												<x-info-tooltip text="{{__('A description for the input.')}}" />
											</label>
											<input type="text" class="form-control input_description" placeholder="{{__('Enter Description Here')}}" value="{{$question->description}}">
										</div>
										<button class="remove-inputs-group inline-flex items-center justify-center !w-6 !h-6 p-0 border-none rounded-md absolute !top-4 !end-5 bg-[transparent] text-red-700 transition-all hover:text-white hover:bg-red-600" type="button">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M9 12l6 0"></path> </svg>
										</button>
									</div>
									<div class="add-more-placeholder"></div>
									<?php $question_i++ ?>
								@endforeach
							@else
								<div class="user-input-group input-group control-group flex-col !p-5 mb-[20px] relative border border-solid rounded-[--tblr-border-radius]" data-inputs-id="1">
									<div class="mb-[20px]">
										<label class="form-label">
												{{__('Select Input Type')}}
												<x-info-tooltip text="{{__('Input fields for short texts and Textarea fields are good for long text.')}}" />
											</label>
										<select class="form-select input_type">
											<option value="text">{{__('Input Field')}}</option>
											<option value="textarea">{{__('Textarea Field')}}</option>
										</select>
									</div>
									<div class="mb-[20px]">
										<label class="form-label">
											{{__('Input Name')}}
											<x-info-tooltip text="{{__('Unique input name that you can use in your prompts later.')}}" />
										</label>
										<input type="text" class="form-control input_name" oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'');" placeholder="{{__('Enter Name Here')}}">
									</div>
									<div class="mb-[20px]">
										<label class="form-label">
											{{__('Input Description')}}
											<x-info-tooltip text="{{__('A description for the input.')}}" />
										</label>
										<input type="text" class="form-control input_description" placeholder="{{__('Enter Description Here')}}">
									</div>
									<button class="remove-inputs-group inline-flex items-center justify-center !w-6 !h-6 p-0 border-none rounded-md absolute !top-4 !end-5 bg-[transparent] text-red-700 transition-all hover:text-white hover:bg-red-600" type="button" disabled>
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M9 12l6 0"></path> </svg>
									</button>
								</div>
								<div class="add-more-placeholder"></div>
							@endif

						</div>

						<div class="flex items-center !p-4 !py-3 !gap-3 rounded-xl text-[17px] bg-[rgba(157,107,221,0.1)] font-semibold mb-10">
							<span class="inline-flex items-center justify-center !w-6 !h-6 rounded-full bg-[#9D6BDD] text-white text-[15px] font-bold">3</span>
							{{__('Prompt')}}
						</div>

						<div class="mb-11">
							<label class="form-label">
								{{__('Created Inputs')}}
								<x-info-tooltip text="{{__('Click on each item to get the dynamic data from users input.')}}" />
							</label>
							<div class="after-add-more-button form-control flex flex-wrap !gap-2 mb-[20px] min-h-[47px]">
								@if($template!= null)
									<?php $question_btn_i = 1; ?>
									@foreach(json_decode($template->questions) as $question)
										<button type="button" class="bg-[#EFEFEF] text-black cursor-pointer py-[0.15rem] px-[0.5rem] border-none rounded-full transition-all duration-300 hover:bg-black hover:!text-white" data-input-name="{{$question->question}}" data-inputs-id="{{$question_btn_i}}"> **{{$question->name}}** </button>
										<?php $question_btn_i++; ?>
									@endforeach
								@endif
							</div>
							<label class="form-label">{{__('Custom Prompt')}}</label>
							<textarea class="form-control" id="prompt" rows="6">{{$template!=null ? $template->prompt : null}}</textarea>
						</div>

						<button form="custom_template_form" id="custom_template_button" class="btn btn-primary !py-3 w-100">
							{{__('Save')}}
						</button>

					</form>
				</div>
			</div>
        </div>
    </div>

	<template id="user-input-template">
		<div class="user-input-group input-group control-group flex-col !p-5 mb-[20px] relative border border-solid rounded-[--tblr-border-radius]" data-inputs-id="1">
			<div class="mb-[20px]">
				<label class="form-label">
						{{__('Select Input Type')}}
						<x-info-tooltip text="{{__('Input fields for short texts and Textarea fields are good for long text.')}}" />
					</label>
				<select class="form-select input_type">
					<option value="text">{{__('Input Field')}}</option>
					<option value="textarea">{{__('Textarea Field')}}</option>
				</select>
			</div>
			<div class="mb-[20px]">
				<label class="form-label">
					{{__('Input Name')}}
					<x-info-tooltip text="{{__('Unique input name that you can use in your prompts later.')}}" />
				</label>
				<input type="text" class="form-control input_name" oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'');" placeholder="{{__('Enter Name Here')}}">
			</div>
			<div class="mb-[20px]">
				<label class="form-label">
					{{__('Input Description')}}
					<x-info-tooltip text="{{__('A description for the input.')}}" />
				</label>
				<input type="text" class="form-control input_description" placeholder="{{__('Enter Description Here')}}">
			</div>
			<button class="remove-inputs-group inline-flex items-center justify-center !w-6 !h-6 p-0 border-none rounded-md absolute !top-4 !end-5 bg-[transparent] text-red-700 transition-all hover:text-white hover:bg-red-600" type="button" disabled>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M9 12l6 0"></path> </svg>
			</button>
		</div>
	</template>
@endsection

@section('script')
    <script src="/assets/js/panel/openai.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
