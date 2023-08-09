@foreach($chat->messages as $message)
@if($message->input != null)
    <div class="flex flex-row-reverse content-end mb-2 lg:ms-auto lg:max-w-[50%] gap-[8px]">
        <span class="text-dark">
            <span class="avatar w-[24px] h-[24px] shrink-0" style="background-image: url(/{{Auth::user()->avatar}})"></span>
        </span>
        <div class="border-none rounded-[2em] mb-[7px] bg-[#F3E2FD] text-[#090A0A] dark:bg-[rgba(var(--tblr-primary-rgb),0.3)] dark:text-white">
            <div class="chat-content py-[0.75rem] px-[1.5rem]">
                {{$message->input}}
            </div>
        </div>
    </div>
@endif

<div class="flex content-start mb-2 lg:max-w-[50%] gap-[8px]">
	<span class="text-dark">
		<span class="avatar w-[24px] h-[24px] shrink-0" style="background-image: url('/{{$message->chat->category->image ?? 'assets/img/auth/default-avatar.png'}}')"></span>
	</span>
	<div class="border-none rounded-[2em] mb-[7px] bg-[#E5E7EB] text-[#090A0A] dark:bg-[rgba(255,255,255,0.02)] dark:text-white">
		<pre class="chat-content py-[0.75rem] px-[1.5rem] bg-transparent text-inherit font-[inherit] text-[1em] indent-0 m-0 w-full whitespace-pre-wrap">{!!  $message->output !!}
        </pre>
	</div>
</div>
@endforeach
@if(count($chat->messages) == 0)
<div class="flex content-end mb-2">
	<div class="border w-full-none rounded-[2em] bg-[#F3E2FD] text-[#090A0A] dark:bg-[rgba(255,255,255,0.02)] dark:text-white">
		<div class="chat-content py-[0.75rem] px-[1.5rem]">
			{{__('You have no message... Please start typing.')}}
		</div>
	</div>
</div>
@endif<?php
