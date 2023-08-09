@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.requirements.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-list-ul fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.requirements.title') }}
@endsection

@section('container')
	<h4 class="mt-0 mb-5 text-[26px] font-golos">{{__('Server Requirements')}}</h4>
    @foreach($requirements['requirements'] as $type => $requirement)
        <ul class="text-start mb-6">
            <li class="flex items-center px-5 py-2 mb-6 -mx-5 gap-4 rounded-xl shadow-[0_4px_10px_rgba(0,0,0,0.05)] {{ $phpSupportInfo['supported'] ? 'text-green-500' : 'text-red-600' }}">
				<span>
					{{ strtoupper($type) }}
					@if($type == 'php')
					{{__('version')}} {{ $phpSupportInfo['minimum'] }} {{__('required')}}
					@endif
				</span>
                @if($type == 'php')
				<span class="flex items-center gap-1 ms-auto">
					{{ $phpSupportInfo['current'] }}
					@if ( $phpSupportInfo['supported'] )
					<svg class="stroke-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M9 12l2 2l4 -4"></path> </svg>
					@else
					<svg class="stroke-red-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M12 9v4"></path> <path d="M12 16v.01"></path> </svg>
					@endif
				</span>
                @endif
            </li>
            @foreach($requirements['requirements'][$type] as $extention => $enabled)
                <li class="flex items-center gap-4 mb-2 {{ $enabled ? 'success' : 'error' }}">
					<span class="inline-block min-w-[65px]">
						{{ $extention }}
					</span>
					<span class="grow">
						<span class="inline-block w-full h-px bg-black bg-opacity-5"></span>
					</span>
					@if ( $enabled )
					<svg class="stroke-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M9 12l2 2l4 -4"></path> </svg>
					@else
					<svg class="stroke-red-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path> <path d="M12 9v4"></path> <path d="M12 16v.01"></path> </svg>
					@endif
                </li>
            @endforeach
        </ul>

		@if ( ! isset($requirements['errors']) && $phpSupportInfo['supported'] )
		<a class="flex items-center justify-center p-2 gap-2 rounded-xl shadow-[0_4px_10px_rgba(0,0,0,0.05)] transition-all duration-300 font-medium hover:bg-black hover:text-white hover:scale-105" href="{{ route('LaravelInstaller::environmentWizard') }}">
			{{__('Next')}}
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M9 6l6 6l-6 6"></path> </svg>
		</a>
		@endif
    @endforeach

@endsection