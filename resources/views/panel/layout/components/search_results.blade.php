@if(count($template_search)>0)
<ul class="m-0 p-0 list-none font-medium">
    @foreach($template_search as $item)
    <li class="p-2 px-3 border-solid border-b border-t-0 border-r-0 border-l-0 border-[--tblr-border-color] last:border-b-0 transition-colors hover:bg-slate-50  dark:hover:!bg-[rgba(255,255,255,0.05)]">
        @if($item->type == 'text')
            <a href="{{route('dashboard.user.openai.generator.workbook', $item->slug)}}" class="d-flex align-items-center text-heading !no-underline">
				<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative !me-2" style="background: {{$item->color}}">
					@if ( $item->image !== 'none' )
					{!! html_entity_decode($item->image) !!}
					@endif
					@if($item->active == 1)
						<span class="badge bg-green !w-[9px] !h-[9px]"></span>
					@else
						<span class="badge bg-red !w-[9px] !h-[9px]"></span>
					@endif
				</span>
                {{$item->title}}
				<small class="ml-auto text-muted opacity-75">{{__('Template')}}</small>
            </a>
        @elseif($item->type == 'image')
            <a href="{{route('dashboard.user.openai.generator', $item->slug)}}" class="d-flex align-items-center text-heading !no-underline">
				<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative !me-2" style="background: {{$item->color}}">
					@if ( $item->image !== 'none' )
					{!! html_entity_decode($item->image) !!}
					@endif
					@if($item->active == 1)
						<span class="badge bg-green !w-[9px] !h-[9px]"></span>
					@else
						<span class="badge bg-red !w-[9px] !h-[9px]"></span>
					@endif
				</span>
                {{$item->title}}
				<small class="ml-auto text-muted opacity-75">{{__('Template')}}</small>
            </a>
        @elseif($item->type == 'audio')
            <a href="{{route('dashboard.user.openai.generator', $item->slug)}}" class="d-flex align-items-center text-heading !no-underline">
				<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative !me-2" style="background: {{$item->color}}">
					@if ( $item->image !== 'none' )
					{!! html_entity_decode($item->image) !!}
					@endif
					@if($item->active == 1)
						<span class="badge bg-green !w-[9px] !h-[9px]"></span>
					@else
						<span class="badge bg-red !w-[9px] !h-[9px]"></span>
					@endif
				</span>
                {{$item->title}}
				<small class="ml-auto text-muted opacity-75">{{__('Template')}}</small>
            </a>
        @elseif($item->type == 'code')
            <a href="{{route('dashboard.user.openai.generator.workbook', $item->slug)}}" class="d-flex align-items-center text-heading !no-underline">
				<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative !me-2" style="background: {{$item->color}}">
					@if ( $item->image !== 'none' )
					{!! html_entity_decode($item->image) !!}
					@endif
					@if($item->active == 1)
						<span class="badge bg-green !w-[9px] !h-[9px]"></span>
					@else
						<span class="badge bg-red !w-[9px] !h-[9px]"></span>
					@endif
				</span>
                {{$item->title}}
				<small class="ml-auto text-muted opacity-75">{{__('Template')}}</small>
            </a>
        @endif
    </li>
    @endforeach
</ul>
@endif
@if(count($ai_chat_search)>0)
    <ul class="m-0 p-0 list-none font-medium">
        @foreach($ai_chat_search as $item)
            <li class="p-2 px-3 border-solid border-b border-t-0 border-r-0 border-l-0 border-[--tblr-border-color] last:border-b-0 transition-colors hover:bg-slate-50  dark:hover:!bg-[rgba(255,255,255,0.05)]">
                <a href="{{LaravelLocalization::localizeUrl(route('dashboard.user.openai.chat.chat', $item->slug))}}" class="d-flex align-items-center text-heading !no-underline">
                    <div class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative !me-2" style="background: {{$item->color}}">
                        @if( $item->slug == 'ai-chat-bot' )
                            <svg class="svg" width="57" height="54" viewBox="0 0 57 54" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.387695 53.827V5.44295C0.387695 4.00269 0.870131 2.80012 1.835 1.83525C2.79987 0.870375 4.00244 0.387939 5.44271 0.387939H51.6603C53.1006 0.387939 54.3032 0.870375 55.268 1.83525C56.2329 2.80012 56.7153 4.00269 56.7153 5.44295V39.1433C56.7153 40.5836 56.2329 41.7861 55.268 42.751C54.3032 43.7159 53.1006 44.1983 51.6603 44.1983H10.0164L0.387695 53.827ZM3.51701 46.2505L8.69845 41.069H51.6603C52.222 41.069 52.6833 40.8885 53.0444 40.5274C53.4055 40.1663 53.586 39.705 53.586 39.1433V5.44295C53.586 4.88129 53.4055 4.41993 53.0444 4.05886C52.6833 3.69779 52.222 3.51725 51.6603 3.51725H5.44271C4.88105 3.51725 4.41969 3.69779 4.05861 4.05886C3.69754 4.41993 3.51701 4.88129 3.51701 5.44295V46.2505ZM3.51701 5.44295V3.51725V46.2505V5.44295ZM27.1674 36.375H29.9356V8.21122H27.1674V36.375ZM18.5618 30.1164H21.33V14.4698H18.5618V30.1164ZM10.7385 23.8578H13.5067V20.7285H10.7385V23.8578ZM35.773 30.1164H38.5412V14.4698H35.773V30.1164ZM43.5963 23.8578H46.3645V20.7285H43.5963V23.8578Z"
                                    fill="#0C6152"/>
                            </svg>
                        @else
                            {{$item->short_name}}
                        @endif
                    </div>
                    {{$item->name}}
                    <small class="ml-auto text-muted opacity-75">{{__('AI Chat Template')}}</small>
                </a>
            </li>
        @endforeach
    </ul>
@endif
@if(count($workbook_search)>0)
    <hr class="border-[2px]">
    <h3 class="m-0 py-[0.75rem] px-3 border-solid border-b border-t-0 border-r-0 border-l-0 border-[--tblr-border-color] text-[1rem] font-medium">{{__('Workbooks')}}</h3>
    <ul class="m-0 p-0 list-none">
        @foreach($workbook_search as $item)
        <li class="p-2 px-3 border-solid border-b border-t-0 border-r-0 border-l-0 border-[--tblr-border-color] last:border-b-0 transition-colors hover:bg-slate-50  dark:hover:!bg-[rgba(255,255,255,0.05)]">
			<a href="{{route('dashboard.user.openai.generator.workbook', $item->slug)}}" class="d-flex align-items-center text-heading !no-underline">
				<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative !me-2" style="background: {{$item->color}}">
					@if ( $item->image !== 'none' )
					{!! html_entity_decode($item->image) !!}
					@endif
				</span>
				{{$item->title}}
				<small class="ml-auto text-muted opacity-75">{{__('Workbook')}}</small>
			</a>
		</li>
        @endforeach
    </ul>
@endif

@if(isset($result) and $result=='null')
	<div class="p-6 font-medium text-center text-heading">
		<h3 class="mb-2">{{__('No results.')}}</h3>
		<p class="opacity-70">{{__('Please try with another word.')}}</p>
	</div>
@endif
