
<div class="row text-[13px] items-center">
	<div class="col-12 ms-auto flex items-center">
		@if($workbook->generator->type != 'code')
		<div class="flex rtl:flex-row-reverse">
			<button class="bg-transparent p-1 inline-flex items-center justify-center rounded-sm w-[30px] h-[30px] border-0 text-[13px] hover:!bg-[var(--lqd-faded-out)] transition-colors" id="workbook_undo" title="{{__('Undo')}}">
				<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4.75342 12.7378H10.0868C11.9268 12.7378 13.4201 11.2445 13.4201 9.4045C13.4201 7.5645 11.9268 6.07117 10.0868 6.07117H2.75342" stroke="var(--lqd-heading-color)" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M4.28674 7.7378L2.58008 6.03113L4.28674 4.32446" stroke="var(--lqd-heading-color)" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="sr-only">{{__('Undo')}}</span>
			</button>
			<button class="bg-transparent p-1 inline-flex items-center justify-center rounded-sm w-[30px] h-[30px] border-0 text-[13px] hover:!bg-[var(--lqd-faded-out)] transition-colors" id="workbook_redo" title="{{__('Redo')}}">
				<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.2467 12.7378H5.91341C4.07341 12.7378 2.58008 11.2445 2.58008 9.4045C2.58008 7.5645 4.07341 6.07117 5.91341 6.07117H13.2467" stroke="var(--lqd-heading-color)" stroke-width="1.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M11.7134 7.7378L13.42 6.03113L11.7134 4.32446" stroke="var(--lqd-heading-color)" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="sr-only">{{__('Redo')}}</span>
			</button>
		</div>
		@endif
		<button class="bg-transparent p-1 inline-flex items-center justify-center rounded-sm w-[30px] h-[30px] border-0 text-[13px] hover:!bg-[var(--lqd-faded-out)] transition-colors" id="workbook_copy" title="{{__('Copy to clipboard')}}">
			<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 96 960 960" width="20" fill="var(--lqd-heading-color)">
				<path d="M180 975q-24 0-42-18t-18-42V312h60v603h474v60H180Zm120-120q-24 0-42-18t-18-42V235q0-24 18-42t42-18h440q24 0 42 18t18 42v560q0 24-18 42t-42 18H300Zm0-60h440V235H300v560Zm0 0V235v560Z"/>
			</svg>
			<span class="sr-only">{{__('Copy to clipboard')}}</span>
		</button>
		@if($workbook->generator->type != 'code')
		<div class="relative">
			<button class="bg-transparent p-1 inline-flex items-center justify-center rounded-sm w-[30px] h-[30px] border-0 text-[13px] hover:!bg-[var(--lqd-faded-out)] transition-colors" title="{{__('Download')}}" data-bs-toggle="dropdown" tabindex="-1">
				<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.01025 10.7186V12.3124C1.01025 12.7351 1.17817 13.1404 1.47705 13.4393C1.77594 13.7382 2.18132 13.9061 2.604 13.9061H12.1665C12.5892 13.9061 12.9946 13.7382 13.2935 13.4393C13.5923 13.1404 13.7603 12.7351 13.7603 12.3124V10.7186M10.5728 7.53113L7.38525 10.7186M7.38525 10.7186L4.19775 7.53113M7.38525 10.7186V1.15613" stroke="var(--lqd-heading-color)" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="sr-only">{{__('Download')}}</span>
			</button>
			<div class="dropdown-menu dropdown-menu-end text-center whitespace-nowrap p-0 [--tblr-dropdown-min-width:150px]">
				<div class="flex flex-col p-1 gap-1">
					<button class="workbook_download flex items-center gap-1 p-2 border-none rounded-md bg-[transparent] text-[12px] font-medium text-heading hover:bg-slate-100 dark:hover:bg-zinc-900" data-doc-type="doc" data-doc-name="{{$workbook->title}}">
						<svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M4 18h9v-12l-5 2v5l-4 2v-8l9 -4l7 2v13l-7 3z"></path> </svg>
						MS Word
					</button>
					<button class="workbook_download flex items-center gap-1 p-2 border-none rounded-md bg-[transparent] text-[12px] font-medium text-heading hover:bg-slate-100 dark:hover:bg-zinc-900" data-doc-type="html" data-doc-name="{{$workbook->title}}">
						<svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M20 4l-2 14.5l-6 2l-6 -2l-2 -14.5z"></path> <path d="M15.5 8h-7l.5 4h6l-.5 3.5l-2.5 .75l-2.5 -.75l-.1 -.5"></path> </svg>
						HTML
					</button>
				</div>
			</div>
		</div>
		@endif
		<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.delete', $workbook->slug)) }}" onclick="return confirm('Are you sure?')" class="bg-transparent -mr-1 p-1 inline-flex items-center justify-center rounded-sm w-[30px] h-[30px] border-0 text-[13px] hover:!bg-[var(--lqd-faded-out)] transition-colors" id="workbook_delete" title="{{__('Delete')}}">
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<mask id="mask0_1_7315" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
					<rect x="0.885254" width="19.0623" height="19.0623" fill="#D9D9D9"/>
				</mask>
				<g mask="url(#mask0_1_7315)">
					<path d="M6.44519 10.3254H14.3878V8.73687H6.44519V10.3254ZM10.4165 17.4738C9.31778 17.4738 8.28524 17.2653 7.31888 16.8483C6.35253 16.4313 5.51193 15.8654 4.7971 15.1505C4.08226 14.4357 3.51635 13.5951 3.09936 12.6288C2.68237 11.6624 2.47388 10.6299 2.47388 9.53113C2.47388 8.4324 2.68237 7.39986 3.09936 6.43351C3.51635 5.46715 4.08226 4.62656 4.7971 3.91172C5.51193 3.19688 6.35253 2.63097 7.31888 2.21398C8.28524 1.797 9.31778 1.5885 10.4165 1.5885C11.5152 1.5885 12.5478 1.797 13.5141 2.21398C14.4805 2.63097 15.3211 3.19688 16.0359 3.91172C16.7508 4.62656 17.3167 5.46715 17.7337 6.43351C18.1506 7.39986 18.3591 8.4324 18.3591 9.53113C18.3591 10.6299 18.1506 11.6624 17.7337 12.6288C17.3167 13.5951 16.7508 14.4357 16.0359 15.1505C15.3211 15.8654 14.4805 16.4313 13.5141 16.8483C12.5478 17.2653 11.5152 17.4738 10.4165 17.4738ZM10.4165 15.8852C12.1904 15.8852 13.6928 15.2697 14.924 14.0386C16.1551 12.8075 16.7706 11.305 16.7706 9.53113C16.7706 7.75728 16.1551 6.2548 14.924 5.02369C13.6928 3.79258 12.1904 3.17703 10.4165 3.17703C8.64265 3.17703 7.14017 3.79258 5.90907 5.02369C4.67796 6.2548 4.0624 7.75728 4.0624 9.53113C4.0624 11.305 4.67796 12.8075 5.90907 14.0386C7.14017 15.2697 8.64265 15.8852 10.4165 15.8852Z" fill="#CE3A3A"/>
				</g>
			</svg>
			<span class="sr-only">{{__('Delete')}}</span>
		</a>
	</div>
</div>
@if($workbook->generator->type == 'code')
<input id="code_lang" type="hidden" value="{{substr($workbook->input, strrpos($workbook->input, 'in') +3)}}">
<div class="min-h-full border-solid border-t border-r-0 border-b-0 border-l-0 border-[var(--tblr-border-color)] pt-[30px] mt-[15px] max-lg:mt-0 max-lg:pt-0 max-lg:border-t-0">
	<pre id="code-pre" class="line-numbers min-h-full [direction:ltr] resize"><code id="code-output">{{$workbook->output}}</code></pre>
</div>
@elseif($workbook->generator->type == 'text')
<div class="border-solid border-t border-r-0 border-b-0 border-l-0 border-[var(--tblr-border-color)] pt-[30px] mt-[15px] [&_.tox-edit-area__iframe]:!bg-transparent">
	<form class="workbook-form" onsubmit="editWorkbook('{{$workbook->slug}}'); return false;" method="POST">
		<div class="mb-[20px]">
			<input type="text" class="form-control rounded-md" placeholder="{{__('Untitled Document...')}}"  id="workbook_title"  value="{{$workbook->title}}">
		</div>
		<div class="mb-[20px]">
			<textarea class="form-control tinymce" id="workbook_text" rows="25">
				{!! $workbook->output !!}
			</textarea>
		</div>
		<div class="mb-[20px]">
			<button class="btn btn-success w-100 py-[0.75em]"  id="workbook_button" >{{__('Save')}}</button>
		</div>
	</form>
</div>
@elseif($workbook->generator->type == 'audio')
    <div class="border-solid border-t border-r-0 border-b-0 border-l-0 border-[var(--tblr-border-color)] pt-[30px] mt-[15px] [&_.tox-edit-area__iframe]:!bg-transparent">
        <form class="workbook-form" onsubmit="editWorkbook('{{$workbook->slug}}'); return false;" method="POST">
            <div class="mb-[20px]">
                <input type="text" class="form-control rounded-md" placeholder="{{__('Untitled Document...')}}"  id="workbook_title"  value="{{$workbook->title}}">
            </div>
            <div class="mb-[20px]">
			<textarea class="form-control tinymce" id="workbook_text" rows="25">
				{!! $workbook->output !!}
			</textarea>
            </div>
            <div class="mb-[20px]">
                <button class="btn btn-success w-100 py-[0.75em]"  id="workbook_button" >{{__('Save')}}</button>
            </div>
        </form>
    </div>
@endif
