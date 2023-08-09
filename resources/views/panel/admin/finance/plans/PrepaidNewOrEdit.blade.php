@extends('panel.layout.app')
@section('title', isset($subscription) ? __('Edit') : __('Create').' '.__('Token Pack'))

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<div class="hstack gap-1">
						<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
							<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
							</svg>
							{{__('Back to dashboard')}}
						</a>
						<a href="{{route('dashboard.admin.finance.plans.index')}}" class="page-pretitle flex items-center">
                            / {{__('Back to Manage Plans')}}
                        </a>
                    </div>
                    <h2 class="page-title mb-2">
                        {{isset($subscription) ? __('Edit') : __('Create')}} {{__('Token Pack')}}
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
					<form id="item_edit_form" onsubmit="return prepaidSave({{$subscription->id ?? null}});" action="">
						<div class="row">
							<div class="col-md-12 col-xl-12">
								@if($isActiveGateway == 0)
								<div class="row">
									<div class="col-md-12 mb-3">
                                        <div class="bg-amber-100 text-amber-600 rounded-xl !p-3 !mt-2 dark:bg-amber-600/20 dark:text-amber-200">
                                            <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                                            {{ __('Please enable at least one gateway!') }}
                                        </div>
                                    </div>
								</div>
								@endif
								<div class="row">
									<div class="col-md-12">
										<div class="mb-3">
											<label class="form-label">{{__('Plan Name')}}</label>
											<input type="text" class="form-control" id="name" name="name" value="{{isset($subscription) ? $subscription->name : null}}" required>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Price')}}</label>
											<input type="number" class="form-control" id="price" step="0.01" name="price" value="{{isset($subscription) ? $subscription->price : null}}" required>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<div class="form-label">{{__('Featured Plan')}}</div>
											<select class="form-select" id="is_featured" name="is_featured" required>
												@if(isset($subscription))
												<option value="1" {{$subscription->is_featured == 1 ? 'selected' : ''}}>{{__('Yes')}}</option>
												<option value="0" {{$subscription->is_featured == 0 ? 'selected' : ''}}>{{__('No')}}</option>
                                                @else
                                                    <option value="1">{{__('Yes')}}</option>
                                                    <option value="0">{{__('No')}}</option>
                                                @endif
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Total Words')}}</label>
											<input type="number" name="total_words" id="total_words" class="form-control"  value="{{isset($subscription) ? $subscription->total_words : null}}"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Total Images')}}</label>
											<input type="number" name="total_images" id="total_images" class="form-control"  value="{{isset($subscription) ? $subscription->total_images : null}}"/>
										</div>
									</div>
                                    <div class="col-md-12 mb-3">
                                        <div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200">
                                            <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                                            Enter "-1" for unlimited usage.
                                        </div>
                                    </div>
                                </div>


								<div class="row">
									<div class="col-md-12">
										<div class="mb-3">
											<div class="form-label">{{__('Features (Comma Seperated)')}}</div>
											<textarea class="form-control" name="features" id="features" cols="30" rows="10" required>{{isset($subscription) ? $subscription->features : null}}</textarea>
										</div>
									</div>
								</div>


								@if($isActiveGateway == 0)
								<div class="row">
									<div class="col-md-12 mb-3">
                                        <div class="bg-amber-100 text-amber-600 rounded-xl !p-3 !mt-2 dark:bg-amber-600/20 dark:text-amber-200">
                                            <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                                            {{ __('Please enable at least one gateway!') }}
                                        </div>
                                    </div>
								</div>
								@else
								<button form="item_edit_form" id="item_edit_button" class="btn btn-primary w-100">
									{{__('Save')}}
								</button>
								@endif

							</div>
						</div>
					</form>

					<!-- WHAT HAPPENS WHEN YOU SAVE -->
					@if(isset($subscription))
					<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 mt-3 dark:bg-blue-600/20 dark:text-blue-200">
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__("What happens when you save?")}}
                        <ul class="ml-2 mt-2">
                            <li>{{__('Save your settings.')}}</li>
                            <li>{{__('Remove all products and prices defined before for old settings.')}}</li>
                            <li>{{__('Generate new product definitions in your gateway accounts.')}}</li>
                            <li>{{__('Generate new price definitions in your gateway accounts.')}}</li>
                            <!-- <li>{{__('')}}</li> -->
                        </ul>
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__('This process will take time. So, please be patient and wait until success message appears.')}}
                    </div>
					@else
					<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 mt-3 dark:bg-blue-600/20 dark:text-blue-200">
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__("What happens when you save?")}}
                        <ul class="ml-2 mt-2">
							<li>{{__('Save your settings.')}}</li>
                            <li>{{__('Generate new product definitions in your gateway accounts.')}}</li>
                            <li>{{__('Generate new price definitions in your gateway accounts.')}}</li>
                        </ul>
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__('This process will take time. So, please be patient and wait until success message appears.')}}
                    </div>
					@endif


					@if(isset($generatedData))
					<div class="mt-5">
						<h4 class="">{{ __('These values are generated for you') }}</h4>
						<table class="table table-sm table-responsive table-striped">
							<thead>
								<th>{{ __('Gateway') }}</th>
								<th>{{ __('Product ID') }}</th>
								<th>{{ __('Plan / Price ID') }}</th>
							</thead>
							<tbody>
								@foreach($generatedData as $data)
								<tr>
									<td>{{ $data->gateway_title }}</td>
									<td>{{ $data->product_id }}</td>
									<td>{{ $data->price_id }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					@endif
				</div>
			</div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/finance.js"></script>
@endsection

