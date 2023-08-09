@extends('panel.layout.app')
@section('title', __('Payment Gateways'))

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

                    <h2 class="page-title mb-2">
                        {{__('Payment Gateways')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">

            <div class="row row-cols-auto  flex justify-content-center gap-3" >

                @foreach($gateways as $entry)
                    
                    <div class="card w-[150px] h-[250px] pt-0 px-0 rounded-md relative">
                        <div class="w-[148px] h-[148px] flex justify-content-center rounded-md pt-1 {{ $entry['whiteLogo'] == 1 ? 'bg-[#1a1d23]' : ''}} ">
                            <img src="{{ url('').$entry['img'] }}" style="max-width:130px; max-height:130px; object-fit: contain; width: 100%;  " alt="{{ $entry['title'] }}" class=""/>
                        </div>
                        <div class="flex justify-content-center w-100 mt-2">
                            <a href="{{ $entry['link'] }}" class="text-decoration-none" target="_blank"><h3>{{ $entry['title'] }}</h3></a>
                        </div>
                        <div class="flex justify-content-center w-100 px-4 mt-2">
                        @if($entry["available"] == 1)
                            <a href="{{route('dashboard.admin.finance.paymentGateways.settings', $entry['code'])}}" class="btn btn-primary w-100">
                                {{__('Settings')}}
                            </a>
                        @else
                            <h6><em class="text-muted">{{ __('Coming soon') }}</em></h6>
                        @endif
                        </div>
                        @if($entry["available"] == 1)
                        @if($entry["active"] == 1)
                        <div class="w-2 h-2 text-xs text-bg-success absolute top-2 left-2 rounded-circle"><i class="fa fa-check"></i></div>
                        @else
                        <div class="w-2 h-2 text-xs text-bg-danger absolute top-2 left-2 rounded-circle"><i class="fa fa-check"></i></div>
                        @endif
                        @endif
                    </div>
                    
                @endforeach

            </div>

        </div>
    </div>
@endsection
