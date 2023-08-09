@extends('panel.layout.app')
@section('title', 'Support Request #'.$ticket->ticket_id)

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
                        {{__('Support Request')}} #{{$ticket->ticket_id}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body py-6">
        <div class="container-xl">
			<div class="card">
				<div class="flex overflow-hidden h-[75vh] max-md:flex-col max-md:h-auto">
					<div class="flex flex-col w-1/4 shrink-0 grow-0 border-l-0 border-b-0 border-t-0 border-solid border-[--tblr-border-color] text-heading font-medium max-md:w-full">
						<p class="flex flex-wrap items-center gap-2 !py-4 !px-5 m-0 border-solid border-b border-[--tblr-border-color] border-t-0 border-r-0 border-l-0" title="{{__('Ticket')}}">
							<span class="shrink-0 inline-flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M15 5l0 2"></path> <path d="M15 11l0 2"></path> <path d="M15 17l0 2"></path> <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2"></path> </svg>
							</span>
							#{{$ticket->ticket_id}}
						</p>
						<p class="flex flex-wrap items-center gap-2 !py-4 !px-5 m-0 border-solid border-b border-[--tblr-border-color] border-t-0 border-r-0 border-l-0" title="{{__('Ticket Subject')}}">
							<span class="shrink-0 inline-flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M8 20l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4h4z"></path> <path d="M13.5 6.5l4 4"></path> <path d="M16 18h4"></path> </svg>
							</span>
							{{$ticket->subject}}
						</p>
						<p class="flex flex-wrap items-center gap-2 !py-4 !px-5 m-0 border-solid border-b border-[--tblr-border-color] border-t-0 border-r-0 border-l-0" title="{{__('Ticket Category')}}">
							<span class="shrink-0 inline-flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M14 4h6v6h-6z"></path> <path d="M4 14h6v6h-6z"></path> <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path> <path d="M7 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path> </svg>
							</span>
							{{$ticket->category}}
						</p>
						<p class="flex flex-wrap items-center gap-2 !py-4 !px-5 m-0 border-solid border-b border-[--tblr-border-color] border-t-0 border-r-0 border-l-0" title="{{__('Ticket Status')}}">
							<span class="shrink-0 inline-flex items-center justify-center">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M6 16m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path> <path d="M16 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path> <path d="M14.5 7.5m-4.5 0a4.5 4.5 0 1 0 9 0a4.5 4.5 0 1 0 -9 0"></path> </svg>
							</span>
							{{$ticket->status}}
						</p>
					</div>
					<div class="lg:w-full">
						<div class="flex flex-col justify-between conversation-area grow lg:h-full max-md:max-h-[100vh]">
							<div class="overflow-hidden">
								<div class="chats-container h-full overflow-auto p-8 max-md:max-h-[60vh] max-md:p-4">
									@foreach($ticket->messages as $message)
										@if($message->sender == 'user')
											<div class="d-flex flex-wrap justify-content-end mb-2 !text-end lg:ms-auto lg:max-w-[50%]">
												<strong class="text-dark w-full block mb-1 dark:!text-white rtl:!text-end">{{$ticket->user->fullName()}}</strong>
												<div class="border-none rounded-[2em] mb-[7px] bg-[#F3E2FD] text-[#090A0A]">
													<div class="py-[0.75rem] px-[1.5rem]">
														{{$message->message}}
													</div>
												</div>
												<div class="w-full text-[11px] font-normal text-[rgba(0,0,0,0.4)] dark:!text-[rgba(255,255,255,0.7)] rtl:!text-end">
													{{$message->created_at}}
												</div>
											</div>
										@else
											<div class="d-flex flex-wrap justify-content-start mb-2 lg:max-w-[50%]">
												<strong class="text-dark w-full block mb-1 dark:!text-white">{{__('Administrator')}}</strong>
												<div class="border-none rounded-[2em] mb-[7px] bg-[#E5E7EB] text-[#090A0A]">
													<div class="py-[0.75rem] px-[1.5rem]">
														{{$message->message}}
													</div>
												</div>
												<div class="w-full text-[11px] font-normal text-[rgba(0,0,0,0.4)] dark:!text-[rgba(255,255,255,0.7)]">
													{{$message->created_at}}
												</div>
											</div>
										@endif
									@endforeach
								</div>
							</div>
							<form class="flex items-end gap-3 p-3 pt-0" id="support_form" onsubmit="return sendMessage('{{$ticket->ticket_id}}');">
								<textarea class="form-control min-h-[52px] rounded-3xl" name="message" id="message" cols="30" rows="1" placeholder="{{__('Your Message')}}"></textarea>
								<button class="btn btn-primary w-[52px] h-[52px] rounded-full" id="send_message_button" form="support_form">
									<svg class="rtl:-scale-x-100" width="16" height="14" viewBox="0 0 16 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M0.125 14V8.76172L11.375 7.25L0.125 5.73828V0.5L15.875 7.25L0.125 14Z" /> </svg>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/js/panel/support.js"></script>
@endsection
