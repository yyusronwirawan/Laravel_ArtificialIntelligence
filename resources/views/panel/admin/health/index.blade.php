@extends('panel.layout.app')
@section('title', __('Site Health'))

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
                        {{__('Site Health')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			@if(Auth::user()->type == 'admin')
            @php
                function backgroundColor($status) {
                    return match ($status) {
                        Spatie\Health\Enums\Status::ok()->value => 'bg-green-500',
                        Spatie\Health\Enums\Status::warning()->value => 'bg-yellow-500',
                        Spatie\Health\Enums\Status::skipped()->value => 'bg-blue-500',
                        Spatie\Health\Enums\Status::failed()->value, Spatie\Health\Enums\Status::crashed()->value => 'bg-red-500',
                        default => 'bg-gray-500'
                    };
                }

                function iconColor($status)
                {
                    return match ($status) {
                        Spatie\Health\Enums\Status::ok()->value => 'text-green-500',
                        Spatie\Health\Enums\Status::warning()->value => 'text-yellow-500',
                        Spatie\Health\Enums\Status::skipped()->value => 'text-blue-500',
                        Spatie\Health\Enums\Status::failed()->value, Spatie\Health\Enums\Status::crashed()->value => 'text-red-500',
                        default => 'text-gray-500'
                    };
                }

                function icon($status)
                {
                    return match ($status) {
                        Spatie\Health\Enums\Status::ok()->value => 'check-circle',
                        Spatie\Health\Enums\Status::warning()->value => 'exclamation-circle',
                        Spatie\Health\Enums\Status::skipped()->value => 'arrow-circle-right',
                        Spatie\Health\Enums\Status::failed()->value, Spatie\Health\Enums\Status::crashed()->value => 'x-circle',
                        default => ''
                    };
                }
            @endphp

                @if (count($checkResults?->storedCheckResults ?? []))
                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($checkResults->storedCheckResults as $result)
                            <div class="flex items-start p-6 space-x-2 rtl:space-x-reverse overflow-hidden text-opacity-0 transform bg-[#fff] rounded-xl shadow-[0_7px_25px_rgba(0,0,0,0.07)] dark:bg-white-500 dark:bg-opacity-5">
                                <div class="flex justify-center items-center rounded-full p-2.5 {{ backgroundColor($result->status) }} bg-opacity-25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ iconColor($result->status) }}" viewBox="0 0 20 20" fill="currentColor">
                                        @if(icon($result->status) == 'check-circle')
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        @elseif(icon($result->status) == 'exclamation-circle')
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        @elseif(icon($result->status) == 'arrow-circle-right')
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                        @elseif(icon($result->status) == 'x-circle')
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        @else
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        @endif
                                    </svg>
                                </div>

                                <div>
                                    <dd class="-mt-1 font-semibold text-gray-800 md:text-xl dark:text-gray-200">
                                        {{ $result->label }}
                                    </dd>
                                    <dt class="mt-0 text-sm font-medium text-gray-600 dark:text-gray-400">
                                        @if (!empty($result->notificationMessage))
                                            {{ $result->notificationMessage }}
                                        @else
                                            {{ $result->shortSummary }}
                                        @endif
                                    </dt>
                                </div>
                            </div>
                        @endforeach
                    </dl>
                @endif

			@endif
        </div>
    </div>
@endsection
@section('script')
@endsection
