@extends('panel.layout.app')
@section('title', 'AI Chat')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="items-center row g-2">
                <div class="col">
                    <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.index')) }}"
                       class="flex items-center page-pretitle">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to dashboard')}}
                    </a>
                    <h2 class="mb-2 page-title">
                        {{__('AI Chat')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="pt-6 page-body">
        <div class="container-xl">
            <div class="card">
                <div class="p-0 card-body" id="scrollable_content">
                    <div id="user_chat_area" class="flex overflow-hidden h-[75vh] max-md:flex-col-reverse max-md:h-auto">
                        @include('panel.user.openai_chat.components.chat_sidebar')
                        <div class="lg:w-full" id="load_chat_area_container">
                          @if($chat != null)
                              @include('panel.user.openai_chat.components.chat_area_container')
                          @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<template id="chat_user_bubble">
		<div class="flex flex-row-reverse content-end mb-2 lg:ms-auto lg:max-w-[50%] gap-[8px]">
			<span class="text-dark">
				<span class="avatar w-[24px] h-[24px] shrink-0" style="background-image: url(/{{Auth::user()->avatar}})"></span>
			</span>
			<div class="border-none rounded-[2em] mb-[7px] bg-[#F3E2FD] text-[#090A0A] dark:bg-[rgba(var(--tblr-primary-rgb),0.3)] dark:text-white">
				<div class="chat-content py-[0.75rem] px-[1.5rem]">
				</div>
			</div>
		</div>
	</template>

	<template id="chat_ai_bubble">
		<div class="flex content-start mb-2 lg:max-w-[50%] gap-[8px] group">
			<span class="text-dark">
				<span class="avatar w-[24px] h-[24px] shrink-0" style="background-image: url(/assets/img/default-ai-img.png)"></span>
			</span>
			<div class="border-none rounded-[2em] mb-[7px] min-h-[44px] text-[#090A0A] relative before:content-[''] before:rounded-[2em] before:inline-block before:bg-[#E5E7EB] before:absolute before:inset-0 group-[&.loading]:before:animate-pulse-intense dark:before:bg-[rgba(255,255,255,0.02)] dark:text-white">
				<pre class="chat-content py-[0.75rem] px-[1.5rem] bg-transparent text-inherit font-[inherit] text-[1em] indent-0 m-0 w-full relative whitespace-pre-wrap"></pre>
			</div>
		</div>
	</template>

    @if($setting->hosting_type != 'high')
        <input type="hidden" id="guest_id" value="{{$apiUrl}}">
        <input type="hidden" id="guest_event_id" value="{{$apikeyPart1}}">
        <input type="hidden" id="guest_look_id" value="{{$apikeyPart2}}">
        <input type="hidden" id="guest_product_id" value="{{$apikeyPart3}}">
        @if($category->prompt_prefix != null)
            <input type="hidden" id="prompt_prefix" value="You will now play a character and respond as that character (You will never break character). Your name is {{$category->human_name}}.
        You will act as {{$category->role}}. {{$category->prompt_prefix}}">
        @else
            <input type="hidden" id="prompt_prefix" value="{{$category->prompt_prefix}}">

        @endif
    @endif

@endsection

@section('script')
    @if($setting->hosting_type == 'high')
        <script src="/assets/js/panel/openai_chat.js"></script>
    @else
        <script>
            const guest_id = document.getElementById("guest_id").value;
            const guest_event_id = document.getElementById("guest_event_id").value;
            const guest_look_id = document.getElementById("guest_look_id").value;
            const guest_product_id = document.getElementById("guest_product_id").value;
            const prompt_prefix = document.getElementById("prompt_prefix").value;

            const messages = [];
            @if($lastThreeMessage != null)
                @foreach($lastThreeMessage as $entry)
                    message = {
                    role: "user",
                    content: "{{$entry->input}}"
                };messages.push(message);
                message = {
                    role: "assistant",
                    content: "{{$entry->output}}"
                };messages.push(message);
                @endforeach
            @endif

            @if($chat_completions != null)
                @foreach($chat_completions as $item)
                message = {
                role: "{{$item["role"]}}",
                content: "{{$item["content"]}}"
                };messages.push(message);
            @endforeach
            @else
                message = {
                role: "system",
                content: "You are a helpful assistant."
            };messages.push(message);
            @endif

            console.log(messages);
        </script>

        <script src="/assets/js/panel/openai_chat_low.js"></script>
        <script>
            function saveResponse(input, response, chat_id){
                "use strict";
                var formData = new FormData();
                formData.append('chat_id', chat_id);
                formData.append('input', input);
                formData.append('response', response);
                jQuery.ajax({
                    url: '/dashboard/user/openai/chat/low/chat_save',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                });
                return false;
            }
        </script>
    @endif

    @if(count($list)==0)
        <script>
            window.addEventListener("load", (event) => {
                return startNewChat({{$category->id}});
            });
        </script>
    @endif

@endsection
