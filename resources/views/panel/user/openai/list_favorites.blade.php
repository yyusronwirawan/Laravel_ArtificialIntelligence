@extends('panel.layout.app')
@section('title', __('Favorite Templates'))
@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">

                <div class="col">
                    <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.user.openai.list')) }}" class="page-pretitle flex items-center">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to All Templates')}}
                    </a>
                    <h2 class="page-title mb-[22px]">
                        {{__('Favorite Templates')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body mt-2 relative after:h-px after:w-full after:bg-[var(--tblr-body-bg)] after:absolute after:top-full after:left-0 after:-mt-px">
        <div class="container-fluid">
            <div class="row">
                @foreach(Auth::user()->favoriteOpenai as $item)
                    <div class="col-lg-4 col-xl-3 col-md-6 pt-8 pb-10 px-16 relative border-b border-solid border-t-0 border-l-0 border-[var(--tblr-border-color)] group max-xl:px-10">
						<span class="avatar w-[43px] h-[43px] mb-[18px] [&_svg]:w-[20px] [&_svg]:h-[20px] relative transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg" style="background: {{$item->color}}">
							@if ( $item->image !== 'none' )
								<span class="inline-block transition-all duration-300 group-hover:scale-110">
									{!! html_entity_decode($item->image) !!}
								</span>
							@endif
							@if($item->active == 1)
								<span class="badge bg-green !w-[9px] !h-[9px]"></span>
							@else
								<span class="badge bg-red !w-[9px] !h-[9px]"></span>
							@endif
						</span>
                        <div>
                            <h4 class="text-[17px] font-semibold mb-[0.85em]">
                                {{$item->title}}
                            </h4>
                            <div class="text-muted">
                                {{$item->description}}
                            </div>
                        </div>
                        @if($item->active == 1)
                            <a onclick="return favoriteTemplate({{$item->id}});" id="favorite_area_{{$item->id}}" class="btn inline-flex items-center justify-center w-[34px] h-[34px] p-0 absolute top-4 right-4 z-3">
                                @if(!isFavorited($item->id))
                                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99989 11.8333L3.88522 13.9966L4.67122 9.41459L1.33789 6.16993L5.93789 5.50326L7.99522 1.33459L10.0526 5.50326L14.6526 6.16993L11.3192 9.41459L12.1052 13.9966L7.99989 11.8333Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @else
                                    <svg width="16" height="15" viewBox="0 0 16 15" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.99989 11.8333L3.88522 13.9966L4.67122 9.41459L1.33789 6.16993L5.93789 5.50326L7.99522 1.33459L10.0526 5.50326L14.6526 6.16993L11.3192 9.41459L12.1052 13.9966L7.99989 11.8333Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </a>
                            <div class="w-full h-full absolute top-0 left-0 z-2 transition-all">
                                @if($item->type == 'text' or $item->type == 'code')
                                    @if(Auth::user()->remaining_words > 0 or Auth::user()->remaining_words == -1)
                                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator.workbook', $item->slug)) }}" class="inline-block w-full h-full absolute top-0 left-0 overflow-hidden -indent-[99999px]">
                                            {{__('Create Workbook')}}
                                        </a>
                                    @endif
                                @elseif($item->type == 'voiceover')
                                    @if(Auth::user()->remaining_words > 0 or Auth::user()->remaining_words == -1)
                                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator', $item->slug)) }}" class="inline-block w-full h-full absolute top-0 left-0 overflow-hidden -indent-[99999px]">
                                            {{__('Create Workbook')}}
                                        </a>
                                    @endif
                                @elseif($item->type == 'image')
                                    @if(Auth::user()->remaining_images > 0 or Auth::user()->remaining_images == -1)
                                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator', $item->slug)) }}" class="inline-block w-full h-full absolute top-0 left-0 overflow-hidden -indent-[99999px]">
                                            {{__('Create')}}
                                        </a>
                                    @endif
                                @elseif($item->type == 'audio')
                                    @if(Auth::user()->remaining_words>0 or Auth::user()->remaining_words == -1)
                                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator', $item->slug)) }}" class="inline-block w-full h-full absolute top-0 left-0 overflow-hidden -indent-[99999px]">
                                            {{__('Create')}}
                                        </a>
                                    @endif
                                @else
                                    <div class="flex items-center justify-center absolute inset-0 bg-zinc-900 bg-opacity-5 backdrop-blur-[1px]">
                                        <a href="#" disabled="" class="bg-white pointer-events-none btn text-dark cursor-default">
                                            {{__('No Tokens Left')}}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/openai_list.js"></script>
@endsection

