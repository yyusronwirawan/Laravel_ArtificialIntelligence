@extends('panel.layout.app')
@section('title', 'Billing Settings')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="items-center row g-2">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="flex items-center page-pretitle">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="mb-2 page-title">
                        {{__('Billing Settings')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="pt-6 page-body">
		<div class="container-xl">
			<div class="row">
				<div class="mx-auto col-md-5">
					<form id="settings_form" onsubmit="return invoiceSettingsSave();" enctype="multipart/form-data">
						<h3 class="mb-[25px] text-[20px]">{{__('Billing Settings')}}</h3>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice Name')}}</label>
									<input type="text" class="form-control" id="invoice_name" name="invoice_name" value="{{$setting->invoice_name}}">
								</div>
							</div>

							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice Website')}}</label>
									<input type="text" class="form-control" id="invoice_website" name="invoice_website" value="{{$setting->invoice_website}}">
								</div>
							</div>

							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice Address')}}</label>
									<textarea type="text" class="form-control" id="invoice_address" name="invoice_address">{{$setting->invoice_address}}</textarea>
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice City')}}</label>
									<input type="text" class="form-control" id="invoice_city" name="invoice_city" value="{{$setting->invoice_city}}">
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice State')}}</label>
									<input type="text" class="form-control" id="invoice_state" name="invoice_state" value="{{$setting->invoice_state}}">
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice Postal')}}</label>
									<input type="text" class="form-control" id="invoice_postal" name="invoice_postal" value="{{$setting->invoice_postal}}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice Country')}}</label>
									<input type="text" class="form-control" id="invoice_country" name="invoice_country" value="{{$setting->invoice_country}}">
								</div>
							</div>

							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice Phone')}}</label>
									<input type="text" class="form-control" id="invoice_phone" name="invoice_phone" value="{{$setting->invoice_phone}}">
								</div>
							</div>

							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Invoice VAT')}}%</label>
									<input type="number" class="form-control" id="invoice_vat" name="invoice_vat" value="{{$setting->invoice_vat}}">
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
    </div>
@endsection
@section('script')
    <script src="/assets/js/panel/settings.js"></script>
@endsection
