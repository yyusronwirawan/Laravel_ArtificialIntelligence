@extends('panel.layout.app')
@section('title', 'Order #'.\Illuminate\Support\Str::upper($invoice->order_id))

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="container-xl">
        <div class="row g-2 items-center">
            <div class="col">
                <h2 class="page-title mb-2">
                    {{__('Invoice')}} #{{\Illuminate\Support\Str::upper($invoice->order_id)}}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto">
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="!me-2" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                    {{__('Print Invoice')}}
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body pt-6">
    <div class="container-xl">
		<div class="row">
			<div class="col-6">
				<p class="h3">{{$setting->invoice_name}}</p>
				<address>
					{{$setting->invoice_address}}<br>
					{{$setting->invoice_state}}, {{$setting->invoice_city}}<br>
					{{$setting->invoice_country}}, {{$setting->invoice_postal}}<br>
					{{$setting->invoice_website}}<br>
					{{$setting->invoice_phone}}
				</address>
			</div>
			<div class="col-6 !text-end">
				<p class="h3">{{__('Client')}}</p>
				<address>
					{{$invoice->user->fullName()}}<br>
					{{$invoice->user->country}}<br>
					{{$invoice->user->email}}<br>
					{{$invoice->user->phone}}
				</address>
			</div>
			<div class="col-12 my-5">
				<h1>{{__('Invoice')}} #{{$invoice->order_id}}</h1>
			</div>
		</div>
		<table class="table table-transparent table-responsive">
			<thead>
			<tr>
				<th class="text-center" style="width: 1%"></th>
				<th>{{__('Product')}}</th>
				<th class="text-center" style="width: 1%">{{__('Qnt')}}</th>
				<th class="!text-end" style="width: 1%">{{__('Unit')}}</th>
				<th class="!text-end" style="width: 1%">{{__('Amount')}}</th>
			</tr>
			</thead>
			<tr>
				<td class="text-center">1</td>
				<td>
					<p class="strong mb-1">{{@$invoice->plan->name ?? __('Archived Plan') }}</p>
					<div class="text-muted">
						@if($invoice->type == 'subscription')
							{{__('Subscription Plan Payment')}}
						@else
							{{__('Prepaid Plan Payment')}}
						@endif
					</div>
				</td>
				<td class="text-center">
					1
				</td>
				<td class="!text-end">{{$invoice->price}}{{currency()->symbol}}</td>
				<td class="!text-end">{{$invoice->price}}{{currency()->symbol}}</td>
			</tr>
			<tr>
				<td colspan="4" class="strong !text-end">{{__('Subtotal')}}</td>
				<td class="!text-end">{{$invoice->price}}{{currency()->symbol}}</td>
			</tr>
			<tr>
				<td colspan="4" class="strong !text-end">{{__('Vat Rate')}}</td>
				<td class="!text-end">{{$setting->invoice_vat}}%</td>
			</tr>
			<tr>
				<td colspan="4" class="strong !text-end">{{__('Vat Due')}}</td>
				@if(isset($setting->invoice_vat) and $setting->invoice_vat > 0)
				<td class="!text-end">{{$invoice->price*$setting->invoice_vat/100}}{{currency()->symbol}}</td>
				@else
				<td class="!text-end">-</td>
				@endif
			</tr>
			<tr>
				<td colspan="4" class="font-weight-bold text-uppercase !text-end">{{__('Total Due')}}</td>
				<td class="font-weight-bold !text-end">{{$invoice->price}}{{currency()->symbol}}</td>
			</tr>
		</table>
		<p class="text-muted text-center mt-5">{{__('Thank you very much for doing business with us. We look forward to working with you again!')}}</p>
    </div>
</div>
@endsection
