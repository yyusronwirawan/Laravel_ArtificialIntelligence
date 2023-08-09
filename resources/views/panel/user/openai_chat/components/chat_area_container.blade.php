<div class="flex flex-col justify-between conversation-area grow lg:h-full" id="chat_area_to_hide">
	<div class="overflow-hidden">
		<div class="chats-container h-full overflow-auto p-8 max-md:max-h-[60vh] max-md:p-4" >
			@include('panel.user.openai_chat.components.chat_area')
		</div>
	</div>

	<form class="flex items-end gap-3 p-8 pt-[1.5rem] pb-[2rem] sticky bottom-0 self-end w-full bg-[--tblr-body-bg] max-md:p-4" id="chat_form">
		<input type="hidden" value="{{$category->id}}" id="category_id">
		<input type="hidden" value="{{$chat->id}}" id="chat_id">
		<input class="form-control min-h-[52px] rounded-full" name="prompt" id="prompt" type="text" @if($setting->openai_api_secret == null)  placeholder="{{__('Please ask system administrator to add API key to the system.')}}" disabled @else  placeholder="{{__('Your Message')}}" @endif/>
        @if($setting->hosting_type == 'high')
        <button class="btn btn-primary w-[52px] h-[52px] rounded-full shrink-0" id="send_message_button" form="chat_form">
			<svg class="rtl:-scale-x-100" width="16" height="14" viewBox="0 0 16 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M0.125 14V8.76172L11.375 7.25L0.125 5.73828V0.5L15.875 7.25L0.125 14Z"/> </svg>
		</button>
        @else
            <input type="hidden" value="{{$category->id}}" id="category_id">
            <input type="hidden" value="{{$chat->id}}" id="chat_id">
            <button class="btn btn-primary w-[52px] h-[52px] rounded-full shrink-0" id="send_message_button" type="button">
                <svg class="rtl:-scale-x-100" width="16" height="14" viewBox="0 0 16 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M0.125 14V8.76172L11.375 7.25L0.125 5.73828V0.5L15.875 7.25L0.125 14Z"/> </svg>
            </button>
            <button class="btn btn-primary w-[52px] h-[52px] rounded-full shrink-0" id="stop_button" type="button">
                <svg class="rtl:-scale-x-100" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M8 13v-7.5a1.5 1.5 0 0 1 3 0v6.5"></path>
                    <path d="M11 5.5v-2a1.5 1.5 0 1 1 3 0v8.5"></path>
                    <path d="M14 5.5a1.5 1.5 0 0 1 3 0v6.5"></path>
                    <path d="M17 7.5a1.5 1.5 0 0 1 3 0v8.5a6 6 0 0 1 -6 6h-2h.208a6 6 0 0 1 -5.012 -2.7a69.74 69.74 0 0 1 -.196 -.3c-.312 -.479 -1.407 -2.388 -3.286 -5.728a1.5 1.5 0 0 1 .536 -2.022a1.867 1.867 0 0 1 2.28 .28l1.47 1.47"></path>
                </svg>
            </button>
        @endif
	</form>

</div>

