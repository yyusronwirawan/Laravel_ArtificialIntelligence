@extends('panel.layout.app')
@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center justify-between max-md:flex-col max-md:items-start max-md:gap-4">
                <div class="col">
                    <div class="page-pretitle">
                        {{__('User Dashboard')}}
                    </div>
                    <h2 class="mb-2 page-title">
                        {{__('Welcome')}}, {{\Illuminate\Support\Facades\Auth::user()->name}}.
                    </h2>
                </div>
                <div class="col-auto">
                    <div class="btn-list">
                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.all') ) }}" class="btn">
                            {{__('My Documents')}}
                        </a>
                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.list') ) }}" class="btn btn-primary items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="!me-2" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            {{__('New')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
					@include('panel.user.payment.subscriptionStatus')
                </div>

                @if($ongoingPayments != null)
                <div class="col-12">
                    @include('panel.user.payment.ongoingPayments')
                </div>
                @endif

                <div class="col-lg-12">
                    <div class="card">
                        <div class="px-10 py-8 card-body">
							<h2 class="mb-[1em]">{{__('Overview')}}</h2>
                            <div class="row">
								<div class="col-auto max-xl:w-full max-xl:mb-5">
									<div class="flex max-sm:flex-col max-sm:mb-4">
										<div class="px-9 !ps-0 border-e border-solid border-t-0 border-b-0 border-s-0 border-[var(--tblr-border-color)] max-sm:border-b max-sm:border-e-0 max-sm:px-0 max-sm:pb-3 max-sm:mb-3">
											<p class="subheader">{{__('Words Left')}}</p>
											<p class="mt-2 h1 text-[30px] font-semibold">
                                                @if(Auth::user()->remaining_words == -1)
                                                    Unlimited
                                                @else
                                                    {{number_format((int)Auth::user()->remaining_words)}}
                                                @endif
                                            </p>
										</div>
										<div class="px-9 border-e border-solid border-t-0 border-b-0 border-s-0 border-[var(--tblr-border-color)] max-sm:border-b max-sm:border-e-0 max-sm:px-0 max-sm:pb-3 max-sm:mb-3">
											<p class="subheader">{{__('Images Left')}}</p>
											<p class="mt-2 h1 text-[30px] font-semibold">
                                                @if(Auth::user()->remaining_images == -1)
                                                    Unlimited
                                                @else
                                                    {{number_format((int)Auth::user()->remaining_images)}}
                                                @endif
                                            </p>
										</div>
										<div class="px-9 max-sm:p-0">
											<p class="subheader">{{__('Hours Saved')}}</p>
											<p class="mt-2 h1 text-[30px] font-semibold">{{number_format($total_words*0.5/60)}}</p>
										</div>
									</div>
								</div>
                                <div class="col max-xl:w-full">
                                    <p class="mb-3">{{__('Your Documents')}}</p>
                                    <div class="mb-3 progress progress-separated">
                                        @if($total_documents != 0)
                                        <div class="progress-bar grow-0 shrink-0 basis-auto bg-primary" role="progressbar" style="width: {{100*(int)$total_text_documents/(int)$total_documents}}%" aria-label="{{__('Text')}}"></div>
                                        @endif
                                        @if($total_documents != 0)
                                        <div class="progress-bar grow-0 shrink-0 basis-auto bg-[#9E9EFF]" role="progressbar" style="width: {{100*(int)$total_image_documents/(int)$total_documents}}%" aria-label="{{__('Images')}}"></div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-auto d-flex align-items-center pe-2">
                                            <span class="legend !me-2 rounded-full bg-primary"></span>
                                            <span>{{__('Text')}}</span>
                                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$total_text_documents}}</span>
                                        </div>
                                        <div class="col-auto px-2 d-flex align-items-center">
                                            <span class="legend !me-2 rounded-full bg-[#9E9EFF]"></span>
                                            <span>{{__('Image')}}</span>
                                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$total_image_documents}}</span>
                                        </div>
                                        <div class="col-auto px-2 d-flex align-items-center">
                                            <span class="legend !me-2 rounded-full bg-success"></span>
                                            <span>{{__('Total')}}</span>
                                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">{{$total_documents}}</span>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-heading">{{__('Documents')}}</h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                @foreach(Auth::user()->openai()->orderBy('created_at', 'desc')->take(4)->get() as $entry)
                                    @if($entry->generator != null)
                                    <tr>
										<td class="w-1 !pe-0">
											<span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]" style="background: {{$entry->generator->color}}">
												@if ( $entry->generator->image !== 'none' )
												{!! html_entity_decode($entry->generator->image) !!}
												@endif
											</span>
                                        </td>
                                        <td class="td-truncate">
                                            <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.documents.single', $entry->slug) ) }}" class="block text-truncate text-heading hover:no-underline">
                                                <span class="font-medium">{{$entry->generator->title}}</span>
                                                <br>
                                                <span class="italic text-muted opacity-80 dark:!text-white dark:!opacity-50">{{$entry->generator->description}}</span>
                                            </a>
                                        </td>
                                        <td class="text-nowrap">
											<span class="text-heading">{{__('in Workbook')}}</span>
											<br>
                                            <span class="italic text-muted opacity-80 dark:!text-white dark:!opacity-50">{{$entry->created_at->format('M d, Y')}}</span>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-heading">{{__('Favorite Templates')}}</h3>
                        </div>
                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                @foreach(\Illuminate\Support\Facades\Auth::user()->favoriteOpenai as $entry)
                                        <tr>
                                            <td class="w-1 !pe-0">
                                      <span class="avatar w-[43px] h-[43px] [&_svg]:w-[20px] [&_svg]:h-[20px]" style="background: {{$entry->color}}">
                                        @if ( $entry->image !== 'none' )
                                            {!! html_entity_decode($entry->image) !!}
                                        @endif

                                        @if($entry->active == 1)
                                            <span class="badge bg-green !w-[9px] !h-[9px]"></span>
                                        @else
                                            <span class="badge bg-red !w-[9px] !h-[9px]"></span>
                                        @endif
										</span>
                                            </td>
                                            <td class="td-truncate">
                                                @if($entry->active == 1)
                                                    <a href="@if($entry->type == 'voiceover'){{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator', $entry->slug)) }}@else {{ LaravelLocalization::localizeUrl( route('dashboard.user.openai.generator.workbook', $entry->slug)) }}@endif" class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{$entry->title}}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{$entry->description}}</span>
                                                    </a>
                                                @else
                                                    <div class="text-heading hover:no-underline">
                                                        <span class="font-medium">{{$entry->title}}</span>
                                                        <br>
                                                        <span class="block italic text-muted opacity-80 text-truncate dark:!text-white dark:!opacity-50">{{$entry->description}}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <span class="text-heading">{{__('in Workbook')}}</span>
                                                <br>
                                                <span class="italic text-muted opacity-80">{{$entry->created_at->format('M d, Y')}}</span>
                                            </td>
                                        </tr>
                                    @if($loop->iteration == 4)
                                        @break
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
