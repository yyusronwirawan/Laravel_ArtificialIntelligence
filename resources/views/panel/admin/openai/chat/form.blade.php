@extends('panel.layout.app')
@section('title', 'Add or Edit Chat Template')
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
                        {{__('Add or Edit Chat Template')}}
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
					<form id="custom_template_form" onsubmit="return templateChatSave({{$template!=null ? $template->id : null}});" action="" enctype="multipart/form-data">

						<div class="flex items-center !p-4 !py-3 !gap-3 rounded-xl text-[17px] bg-[rgba(157,107,221,0.1)] font-semibold mb-10">
							<span class="inline-flex items-center justify-center !w-6 !h-6 rounded-full bg-[#9D6BDD] text-white text-[15px] font-bold">1</span>
							{{__('Template')}}
						</div>

						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Name')}}
								<x-info-tooltip text="{{__('Pick a name for the template.')}}" />
							</label>
							<input type="text" class="form-control" id="name" name="name" value="{{$template!=null ? $template->name : null}}">
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Short Name')}}
								<x-info-tooltip text="{{__('Shortened name of the template or human name. Maximum 3 letters is suggested.')}}" />
							</label>
							<input type="text" class="form-control" id="short_name" name="short_name" value="{{$template!=null ? $template->short_name : null}}">
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Description')}}
								<x-info-tooltip text="{{__('A short description of what this chat template can help with.')}}" />
							</label>
							<textarea class="form-control" id="description" name="description">{{$template!=null ? $template->description : null}}</textarea>
						</div>
                        <div class="mb-[20px]">
                            <label class="form-label">
                                {{__('Avatar')}}
                                <x-info-tooltip text="{{__('Avatar will shown in chat page.')}}" />
                            </label>
                            <input type="file" class="form-control" id="avatar" name="avatar" value="{{$template!=null ? $template->short_name : null}}">
                        </div>
						<div class="mb-20">
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

						<div class="flex items-center !p-4 !py-3 !gap-3 rounded-xl text-[17px] bg-[rgba(157,107,221,0.1)] font-semibold mb-10">
							<span class="inline-flex items-center justify-center !w-6 !h-6 rounded-full bg-[#9D6BDD] text-white text-[15px] font-bold">2</span>
							{{__('Personality')}}
						</div>

						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Human Name')}}
								<x-info-tooltip text="{{__('Define a human name for the chatbot to give it more personality.')}}" />
							</label>
							<input type="text" class="form-control" id="human_name" placeholder="Allison Burgers" name="human_name" value="{{$template!=null ? $template->human_name : null}}">
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Template Role')}}
								<x-info-tooltip text="{{__('A role for the chatbot that can define what it can help with. For example Finance Expert.')}}" />
							</label>
							<input type="text" class="form-control" id="role" name="role" placeholder="Finance Expert" value="{{$template!=null ? $template->role : null}}">
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Helps With')}}
								<x-info-tooltip text="{{__('Describe what this chatbot can help with. It shows when starting a conversation and the chatbot introducing itself.')}}" />
							</label>
							<textarea class="form-control" id="helps_with" placeholder="I can help you with managing your finance" name="helps_with">{{$template!=null ? $template->helps_with : null}}</textarea>
						</div>
						<div class="mb-[20px]">
							<label class="form-label">
								{{__('Chatbot Training')}}
								<x-info-tooltip text="{{__('Chat models take a list of messages as input and return a model-generated message as output. Although the chat format is designed to make multi-turn conversations easy, it’s just as useful for single-turn tasks without any conversation. Add your custom JSON data.')}}" />
								<button type="button" class="chat-completions-fill-btn bg-primary !bg-opacity-5 border-none !px-3 !py-1 rounded-full transition-transform cursor-pointer text-sm font-medium text-white">{{__('Create example input')}}</button>
							</label>
							<textarea class="form-control" id="chat_completions" name="chat_completions">{{$template!=null ? $template->chat_completions : null}}</textarea>
							<div class="!mt-3">
								<a class="text-heading" href="https://platform.openai.com/docs/guides/gpt/chat-completions-api" target="_blank">{{__('More Info')}}<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 7l-10 10"></path><path d="M8 7l9 0l0 9"></path></svg></a>
							</div>
						</div>
						<button form="custom_template_form" id="custom_template_button" class="btn btn-primary !py-3 w-100">
							{{__('Save')}}
						</button>
					</form>
				</div>
			</div>
        </div>
    </div>

@endsection

@section('script')
    <script src="/assets/js/panel/openai.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="/assets/libs/ace/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
	<style type="text/css" media="screen">
		#chat_completions {
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
		}
		.ace_editor{
			min-height: 200px;
		}
	</style>
	<script>
		var editor_chat_completions = ace.edit("chat_completions");
		//editor.setTheme("ace/theme/monokai");
		editor_chat_completions.session.setMode("ace/mode/json");
	</script>
@endsection
