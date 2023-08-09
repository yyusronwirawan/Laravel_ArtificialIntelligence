@extends('panel.layout.app')
@section('title', __('Built-in Templates'))

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
                    <h2 class="page-title mb-3">
                        {{__('Built-in Templates')}}
                    </h2>
                    <p class="mb-2">{{__('Manage Built-in Prompts and Templates')}}</p>
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
							<th>{{__('Status')}}</th>
							<th>{{__('Template Name')}}</th>
							<th>{{__('Template Description')}}</th>
							<th>{{__('Package')}}</th>
							<th>{{__('Updated At')}}</th>
							<th>{{__('Actions')}}</th>
						</tr>
						</thead>
						<tbody class="table-tbody align-middle text-heading">
						@foreach($list as $entry)
							<tr>
								<td class="sort-status">
									@if($entry->active == 1)
										<div class="badge bg-success">{{__('Active')}}</div>
									@else
										<div class="badge bg-danger">{{__('Passive')}}</div>
									@endif
								</td>
								<td class="sort-name">{{__($entry->title)}}</td>
								<td class="sort-description">{{__($entry->description)}}</td>
								<td class="sort-package">{{$entry->premium == 1 ? __('Premium') : __('Regular')}}</td>

								<td class="sort-date" data-date="{{strtotime($entry->updated_at)}}">
									<p class="m-0">{{date("j.n.Y", strtotime($entry->updated_at))}}</p>
									<p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->updated_at))}}</p>
								</td>
								<td>
									@if(env('APP_STATUS') == 'Demo')
                                        <button onclick="return toastr.info('This feature is disabled in Demo version.')" class="btn btn-success" id="active_btn_{{$entry->id}}" title="{{__('Active')}}" style="display: {{ $entry->active == 0 ? 'none' : 'block'}};">
                                            {{__('Active')}}
                                        </button>
                                        <button onclick="return toastr.info('This feature is disabled in Demo version.')" class="btn btn-danger" id="passive_btn_{{$entry->id}}" title="{{__('Passive')}}" style="display: {{ $entry->active == 1 ? 'none' : 'block'}};" >
                                            {{__('Passive')}}
                                        </button>
                                    @else
                                        <button onclick="return updateStatus(0, {{$entry->id}});" class="btn btn-success" id="active_btn_{{$entry->id}}" title="{{__('Active')}}" style="display: {{ $entry->active == 0 ? 'none' : 'block'}};">
                                            {{__('Active')}}
                                        </button>
                                        <button onclick="return updateStatus(1, {{$entry->id}});" class="btn btn-danger" id="passive_btn_{{$entry->id}}" title="{{__('Passive')}}" style="display: {{ $entry->active == 1 ? 'none' : 'block'}};" >
                                            {{__('Passive')}}
                                        </button>
                                    @endif
								</td>
							</tr>
						@endforeach

						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/js/panel/openai.js"></script>
@endsection
