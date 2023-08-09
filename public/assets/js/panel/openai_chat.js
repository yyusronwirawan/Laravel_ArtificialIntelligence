$( document ).ready( function () {
	"use strict";

	$( ".chats-container" ).stop().animate( { scrollTop: $( ".chats-container" )[ 0 ]?.scrollHeight }, 200 );
	$( "#scrollable_content" ).stop().animate( { scrollTop: $( "#scrollable_content" ).outerHeight() }, 200 );

	$( '.chat-list-ul' ).on( 'click', 'a', function () {
		const parentLi = $( this ).parent();
		parentLi.siblings().removeClass( 'active' );
		parentLi.addClass( 'active' );
	} );

	function saveChatNewTitle( chatId, newTitle ) {

		var formData = new FormData();
		formData.append( 'chat_id', chatId );
		formData.append( 'title', newTitle );

		$.ajax( {
			type: "post",
			url: "/dashboard/user/openai/chat/rename-chat",
			data: formData,
			contentType: false,
			processData: false,
		} );
		return false;

	}

	function deleteChatItem( chatId, chatTitle ) {
		if ( confirm( `Are you sure you want to remove ${ chatTitle }?` ) ) {
			var formData = new FormData();
			formData.append( 'chat_id', chatId );

			$.ajax( {
				type: "post",
				url: "/dashboard/user/openai/chat/delete-chat",
				data: formData,
				contentType: false,
				processData: false,
				success: function ( data ) {
					//Remove chat li
					$( "#" + chatId ).hide();
					$( "#chat_area_to_hide" ).hide();
				},
				error: function ( data ) {
					var err = data.responseJSON.errors;
					if ( err ) {
						$.each( err, function ( index, value ) {
							toastr.error( value );
						} );
					} else {
						toastr.error( data.responseJSON.message );
					}
				},
			} );
			return false;
		}

	}

	$( '.chat-list-ul' ).on( 'click', '.chat-item-delete', ev => {
		const button = ev.currentTarget;
		const parent = button.closest( 'li' );
		const chatId = parent.getAttribute( 'id' );
		const chatTitle = parent.querySelector( '.chat-item-title' ).innerText;
		deleteChatItem( chatId, chatTitle );
	} );

	$( '.chat-list-ul' ).on( 'click', '.chat-item-update-title', ev => {
		const button = ev.currentTarget;
		const parent = button.closest( '.chat-list-item' );
		const title = parent.querySelector( '.chat-item-title' );
		const chatId = parent.getAttribute( 'id' );
		const currentText = title.innerText;

		function setEditMode( mode ) {

			if ( mode === 'editStart' ) {
				parent.classList.add( 'edit-mode' );

				title.setAttribute( 'data-current-text', currentText );
				title.setAttribute( 'contentEditable', true );
				title.focus();
				window.getSelection().selectAllChildren( title );
			} else if ( mode === 'editEnd' ) {
				parent.classList.remove( 'edit-mode' );

				title.removeAttribute( 'contentEditable' );
				title.removeAttribute( 'data-current-text' );
			}

		}

		function keydownHandler( ev ) {
			const { key } = ev;
			const escapePressed = key === 'Escape';
			const enterPressed = key === 'Enter';

			if ( !escapePressed && !enterPressed ) return;

			ev.preventDefault();

			if ( escapePressed ) {
				title.innerText = currentText;
			}

			if ( enterPressed ) {
				saveChatNewTitle( chatId, title.innerText );
			}

			setEditMode( 'editEnd' );
			document.removeEventListener( 'keydown', keydownHandler );
		}

		// if alreay editting then turn the edit button to a save button
		if ( title.hasAttribute( 'contentEditable' ) ) {
			setEditMode( 'editEnd' );
			document.removeEventListener( 'keydown', keydownHandler );
			return saveChatNewTitle( chatId, title.innerText );
		}

		$( '.chat-list-ul .edit-mode' ).each( ( i, el ) => {
			const title = el.querySelector( '.chat-item-title' );
			title.innerText = title.getAttribute( 'data-current-text' );
			title.removeAttribute( 'data-current-text' );
			title.removeAttribute( 'contentEditable' );
			el.classList.remove( 'edit-mode' );
		} );

		setEditMode( 'editStart' );

		document.addEventListener( 'keydown', keydownHandler );
	} );

} );

/*

DO NOT FORGET TO ADD THE CHANGES TO BOTH FUNCTION makeDocumentReadyAgain and the document ready function on the top!!!!

 */

function makeDocumentReadyAgain() {
	$( document ).ready( function () {
		"use strict";

		$( ".chats-container" ).stop().animate( { scrollTop: $( ".chats-container" )[ 0 ]?.scrollHeight }, 200 );
		$( "#scrollable_content" ).stop().animate( { scrollTop: $( "#scrollable_content" ).outerHeight() }, 200 );

		$( '.chat-list-ul' ).on( 'click', 'a', function () {
			const parentLi = $( this ).parent();
			parentLi.siblings().removeClass( 'active' );
			parentLi.addClass( 'active' );
		} );

		function saveChatNewTitle( chatId, newTitle ) {

			var formData = new FormData();
			formData.append( 'chat_id', chatId );
			formData.append( 'title', newTitle );

			$.ajax( {
				type: "post",
				url: "/dashboard/user/openai/chat/rename-chat",
				data: formData,
				contentType: false,
				processData: false,
			} );
			return false;

		}

		function deleteChatItem( chatId, chatTitle ) {
			if ( confirm( `Are you sure you want to remove ${ chatTitle }?` ) ) {
				var formData = new FormData();
				formData.append( 'chat_id', chatId );

				$.ajax( {
					type: "post",
					url: "/dashboard/user/openai/chat/delete-chat",
					data: formData,
					contentType: false,
					processData: false,
					success: function ( data ) {
						//Remove chat li
						$( "#" + chatId ).hide();
						$( "#chat_area_to_hide" ).hide();
					},
					error: function ( data ) {
						var err = data.responseJSON.errors;
						if ( err ) {
							$.each( err, function ( index, value ) {
								toastr.error( value );
							} );
						} else {
							toastr.error( data.responseJSON.message );
						}
					},
				} );
				return false;
			}

		}

		$( '.chat-list-ul' ).on( 'click', '.chat-item-delete', ev => {
			const button = ev.currentTarget;
			const parent = button.closest( 'li' );
			const chatId = parent.getAttribute( 'id' );
			const chatTitle = parent.querySelector( '.chat-item-title' ).innerText;
			deleteChatItem( chatId, chatTitle );
		} );

		$( '.chat-list-ul' ).on( 'click', '.chat-item-update-title', ev => {
			const button = ev.currentTarget;
			const parent = button.closest( '.chat-list-item' );
			const title = parent.querySelector( '.chat-item-title' );
			const chatId = parent.getAttribute( 'id' );
			const currentText = title.innerText;

			function setEditMode( mode ) {

				if ( mode === 'editStart' ) {
					parent.classList.add( 'edit-mode' );

					title.setAttribute( 'data-current-text', currentText );
					title.setAttribute( 'contentEditable', true );
					title.focus();
					window.getSelection().selectAllChildren( title );
				} else if ( mode === 'editEnd' ) {
					parent.classList.remove( 'edit-mode' );

					title.removeAttribute( 'contentEditable' );
					title.removeAttribute( 'data-current-text' );
				}

			}

			function keydownHandler( ev ) {
				const { key } = ev;
				const escapePressed = key === 'Escape';
				const enterPressed = key === 'Enter';

				if ( !escapePressed && !enterPressed ) return;

				ev.preventDefault();

				if ( escapePressed ) {
					title.innerText = currentText;
				}

				if ( enterPressed ) {
					saveChatNewTitle( chatId, title.innerText );
				}

				setEditMode( 'editEnd' );
				document.removeEventListener( 'keydown', keydownHandler );
			}

			// if alreay editting then turn the edit button to a save button
			if ( title.hasAttribute( 'contentEditable' ) ) {
				setEditMode( 'editEnd' );
				document.removeEventListener( 'keydown', keydownHandler );
				return saveChatNewTitle( chatId, title.innerText );
			}

			$( '.chat-list-ul .edit-mode' ).each( ( i, el ) => {
				const title = el.querySelector( '.chat-item-title' );
				title.innerText = title.getAttribute( 'data-current-text' );
				title.removeAttribute( 'data-current-text' );
				title.removeAttribute( 'contentEditable' );
				el.classList.remove( 'edit-mode' );
			} );

			setEditMode( 'editStart' );

			document.addEventListener( 'keydown', keydownHandler );
		} );

	} );
}

( ( $ ) => {
	"use strict";

	function submitForm( ev ) {
		ev?.preventDefault();
		const prompt = document.getElementById( 'prompt' );
		let scrollLocked = false;
		let chatsContainer = $( ".chats-container" );

		if ( !prompt.value || prompt.value.length === 0 || prompt.value.replace( /\s/g, '' ) === '' ) {
			return toastr.error( 'Please fill the message field.' );
		}

		const category_id = document.getElementById( 'category_id' );
		const chat_id = document.getElementById( 'chat_id' );
		const submitBtn = document.getElementById( "send_message_button" );

		if ( submitBtn.classList.contains( 'submitting' ) ) return;

		submitBtn.disabled = true;
		submitBtn.classList.add( 'submitting' );

		var formData = new FormData();
		formData.append( 'prompt', prompt.value );
		formData.append( 'chat_id', chat_id.value );
		formData.append( 'category_id', category_id.value );

		function onBeforePageUnload( e ) {
			e.preventDefault();
			e.returnValue = '';
		}

		function onWindowScroll() {
			if ( chatsContainer[ 0 ].scrollTop + chatsContainer[ 0 ].offsetHeight >= chatsContainer[ 0 ].scrollHeight ) {
				scrollLocked = true;
			} else {
				scrollLocked = false;
			}
		}

		// to prevent from reloading when generating respond
		window.addEventListener( 'beforeunload', onBeforePageUnload );

		$.ajax( {
			type: "post",
			url: "/dashboard/user/openai/chat/chat-send",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {

				chatsContainer = $( ".chats-container" );
				const userBubbleTemplate = document.querySelector( '#chat_user_bubble' ).content.cloneNode( true );
				const aiBubbleTemplate = document.querySelector( '#chat_ai_bubble' ).content.cloneNode( true );
				const { chat_id, message_id } = data;

				//Here you can append user input to the chat area
				userBubbleTemplate.querySelector( '.chat-content' ).innerHTML = prompt.value;
				chatsContainer.append( userBubbleTemplate );

				const eventSource = new EventSource( "/dashboard/user/openai/chat/chat-send?chat_id=" + chat_id + "&message_id=" + message_id );

				//This is the div which the text will append continuously.
				let responseText = '';

				const aiBubbleWrapper = aiBubbleTemplate.firstElementChild;
				aiBubbleWrapper.classList.add( 'loading' );
				aiBubbleTemplate.querySelector( '.chat-content' ).innerHTML = responseText;
				chatsContainer.append( aiBubbleTemplate );

				aiBubbleWrapper.setAttribute( 'data-message-id', message_id );

				chatsContainer[ 0 ].scrollTo( 0, chatsContainer[ 0 ].scrollHeight );

				chatsContainer[ 0 ].addEventListener( 'scroll', onWindowScroll );

				eventSource.onmessage = function ( e ) {
					if ( e.data === '[DONE]' ) {
						//This is the area when the chat ends.
						eventSource.close();
						submitBtn.disabled = false;
						submitBtn.classList.remove( 'submitting' );
						document.getElementById( "chat_form" ).reset();
						aiBubbleWrapper.classList.remove( 'loading' );

						window.removeEventListener( 'beforeunload', onBeforePageUnload );
					}
					let txt = e.data
					if ( txt !== undefined && e.data != '[DONE]' ) {
						//This is the area which the text will append to the div
						responseText += txt.split( "/**" )[ 0 ];
						aiBubbleWrapper.classList.remove( 'loading' );
						aiBubbleWrapper.querySelector( '.chat-content' ).innerHTML = responseText;

						scrollLocked && chatsContainer[ 0 ].scrollTo( 0, chatsContainer[ 0 ].scrollHeight );
					}
				};

				eventSource.onerror = function ( e ) {
					//If error from the openai.
					eventSource.close();
					submitBtn.disabled = false;
					submitBtn.classList.remove( 'submitting' );
					document.getElementById( "chat_form" ).reset();

					window.removeEventListener( 'beforeunload', onBeforePageUnload );
					chatsContainer[ 0 ].removeEventListener( 'scroll', onWindowScroll );
				};

			},
			error: function ( data ) {
				var err = data.responseJSON.errors;
				if ( err ) {
					$.each( err, function ( index, value ) {
						toastr.error( value );
					} );
				} else {
					toastr.error( data.responseJSON.message );
				}
				submitBtn.disabled = false;
				submitBtn.classList.remove( 'submitting' );

				window.removeEventListener( 'beforeunload', onBeforePageUnload );
				chatsContainer[ 0 ].removeEventListener( 'scroll', onWindowScroll );
			},
		} );
		return false;
	}

	$( 'body' ).on( 'submit', '#chat_form', submitForm );

	const prompt = document.getElementById( 'prompt' );

	prompt?.addEventListener( 'keypress', ev => {
		if ( ev.keyCode == 13 ) {
			ev.preventDefault();
			return submitForm();
		}
	} );
} )( jQuery );


function openChatAreaContainer( chat_id ) {
	"use strict";

	var formData = new FormData();
	formData.append( 'chat_id', chat_id );

	$.ajax( {
		type: "post",
		url: "/dashboard/user/openai/chat/open-chat-area-container",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			$( "#load_chat_area_container" ).html( data.html );
			setTimeout( function () {
				$( ".chats-container" ).stop().animate( { scrollTop: $( ".chats-container" )[ 0 ].scrollHeight }, 200 );
			}, 750 );
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			if ( err ) {
				$.each( err, function ( index, value ) {
					toastr.error( value );
				} );
			} else {
				toastr.error( data.responseJSON.message );
			}
		},
	} );
	return false;
}

function startNewChat( category_id ) {
	"use strict";
	var formData = new FormData();
	formData.append( 'category_id', category_id );

	$.ajax( {
		type: "post",
		url: "/dashboard/user/openai/chat/start-new-chat",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			$( "#load_chat_area_container" ).html( data.html );
			$( "#chat_sidebar_container" ).html( data.html2 );
			makeDocumentReadyAgain();

			setTimeout( function () {
				$( ".chats-container" ).stop().animate( { scrollTop: $( ".chats-container" ).outerHeight() }, 200 );
			}, 750 );

		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			if ( err ) {
				$.each( err, function ( index, value ) {
					toastr.error( value );
				} );
			} else {
				toastr.error( data.responseJSON.message );
			}
		},
	} );
	return false;
}

/* microphone (speech to text) */
const microphoneButton = document.querySelector( '#chat-microphone' );
let isTranscribing = false; // Initially not transcribing

if ( microphoneButton ) {
	if ( 'SpeechRecognition' in window || 'webkitSpeechRecognition' in window ) {
		const recognition = new ( window.SpeechRecognition || window.webkitSpeechRecognition )();

		recognition.continuous = true;

		recognition.addEventListener( 'start', () => {
			$msgSendBtn.attr( "disabled", true );
			$( "#chat-microphone" ).find( 'i' ).removeClass( 'fa-microphone' ).addClass( 'fa-stop-circle' );
		} );

		recognition.addEventListener( 'result', ( event ) => {
			const transcript = event.results[ 0 ][ 0 ].transcript;
			$msgInput.val( $msgInput.val() + transcript + ' ' );

			microphoneButton.click();
		} );

		recognition.addEventListener( 'end', () => {
			$msgSendBtn.attr( "disabled", false );
			$( "#chat-microphone" ).find( 'i' ).addClass( 'fa-microphone' ).removeClass( 'fa-stop-circle' );
			isTranscribing = false;
		} );

		microphoneButton.addEventListener( 'click', () => {
			if ( !isTranscribing ) {
				// Start transcription if not transcribing
				recognition.start();
				isTranscribing = true;
			} else {
				// Stop transcription if already transcribing
				recognition.stop();
				isTranscribing = false;
			}
		} );
	} else {
		console.log( 'Web Speech Recognition API not supported by this browser' );
		$( "#chat-microphone" ).hide()
	}
}


$( document ).ready( function () {
	$( "#chat_search_word" ).on( 'keyup', function () {
		return searchChatFunction();
	} );
} );


function searchChatFunction() {
	"use strict";

	const categoryId = $( '#chat_search_word' ).data( "category-id" );
	const formData = new FormData();
	formData.append( '_token', document.querySelector( "input[name=_token]" )?.value );
	formData.append( 'search_word', document.getElementById( 'chat_search_word' ).value );
	formData.append( 'category_id', categoryId );

	$.ajax( {
		type: "POST",
		url: '/dashboard/user/openai/chat/search',
		data: formData,
		contentType: false,
		processData: false,
		success: function ( result ) {
			$( "#chat_sidebar_container" ).html( result.html );
			$( document ).trigger( 'ready' );
		}
	} );
}

