@extends('panel.layout.app')
@section('title', 'My Documents')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl(route('dashboard.index')) }}" class="page-pretitle flex items-center">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="page-title mb-2">
                        {{__('My Documents')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="card">
				<div id="table-default" class="card-table table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th>{{__('Type')}}</th>
							<th>{{__('Category')}}</th>
							<th>{{__('Tokens Used')}}</th>
							<th class="max-sm:min-w-[250px]">{{__('Output')}}</th>
							<th>{{__('Created At')}}</th>
							<th class="!text-end">{{__('Actions')}}</th>
						</tr>
						</thead>
						<tbody class="table-tbody align-middle text-heading">
						@foreach($items as $entry)
                            @if($entry->generator != null)
                                @if($entry->generator->type != 'image')
                                    <tr class="relative transition-colors hover:bg-black hover:bg-opacity-[0.03] dark:hover:bg-white dark:hover:bg-opacity-[0.03]">
                                        <td class="sort-type text-capitalize">
									<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]" style="background: {{$entry->generator->color}}">
										@if ( $entry->generator->image !== 'none' )
                                            {!! html_entity_decode($entry->generator->image) !!}
                                        @endif
									</span>
                                        </td>
                                        <td class="sort-category">{{$entry->generator->title}}</td>
                                        <td class="sort-tokens">{{$entry->credits}}</td>
                                        @if($entry->generator->type == 'text')
                                            <td class="max-sm:min-w-[250px]">
                                                {{\Illuminate\Support\Str::limit(strip_tags($entry->output), 200)}}
                                            </td>
                                        @elseif($entry->generator->type == 'audio')
                                            <td class="max-sm:min-w-[250px]">
                                                {!!  \Illuminate\Support\Str::limit($entry->output, 200) !!}
                                            </td>
                                        @elseif($entry->generator->type == 'code')
                                            <td class="max-sm:min-w-[250px]">
                                                {{\Illuminate\Support\Str::limit(strip_tags($entry->output), 200)}}
                                            </td>
                                        @elseif($entry->generator->type == 'voiceover')
                                            <td class="max-sm:min-w-[250px] data-audio" data-audio="/uploads/{{$entry->output}}">
												<div class="audio-preview"></div>
                                            </td>
                                        @else
                                            <td class="max-sm:min-w-[250px]">
                                                <a href="{{$entry->output}}" target="_blank"><img src="{{$entry->output}}" class="img-fluid" alt=""></a>
                                            </td>
                                        @endif
                                        <td class="sort-date" data-date="{{strtotime($entry->created_at)}}">
                                            <p class="m-0">{{date("j.n.Y", strtotime($entry->created_at))}}</p>
                                            <p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->created_at))}}</p>
                                        </td>
                                        <td class="!text-end whitespace-nowrap">
                                           @if($entry->generator->type == 'voiceover')
                                                <a href="/uploads/{{$entry->output}}" target="_blank" class="btn relative z-10 w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('View and edit')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                        <path d="M7 11l5 5l5 -5"></path>
                                                        <path d="M12 4l0 12"></path>
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.single', $entry->slug)) }}" class="btn relative z-10 w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('View and edit')}}">
                                                    <svg width="13" height="12" viewBox="0 0 16 15" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M9.3125 2.55064L12.8125 5.94302M11.5 12.3038H15M4.5 14L13.6875 5.09498C13.9173 4.87223 14.0996 4.60779 14.224 4.31676C14.3484 4.02572 14.4124 3.71379 14.4124 3.39878C14.4124 3.08377 14.3484 2.77184 14.224 2.48081C14.0996 2.18977 13.9173 1.92533 13.6875 1.70259C13.4577 1.47984 13.1849 1.30315 12.8846 1.1826C12.5843 1.06205 12.2625 1 11.9375 1C11.6125 1 11.2907 1.06205 10.9904 1.1826C10.6901 1.30315 10.4173 1.47984 10.1875 1.70259L1 10.6076V14H4.5Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            @endif
                                            <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.delete', $entry->slug)) }}" onclick="return confirm('Are you sure?')" class="btn relative z-10 p-0 border w-[36px] h-[36px] hover:bg-red-600 hover:text-white" title="{{__('Delete')}}">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
                                                </svg>
                                            </a>
                                        </td>
                                        @if($entry->generator->type != 'voiceover')
                                        <td class="w-full h-full absolute top-0 left-0 border-0">
                                            <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.single', $entry->slug)) }}" class="absolute top-0 left-0 w-full h-full z-[2]" title="{{__('View and edit')}}"></a>
                                        </td>
                                        @endif
                                    </tr>
                                @endif
                            @endif
						@endforeach

						</tbody>
					</table>
				</div>
                {{$items->links('pagination::bootstrap-5')}}
			</div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/libs/wavesurfer/wavesurfer.js"></script>
	<script src="/assets/js/panel/voiceover.js"></script>
@endsection