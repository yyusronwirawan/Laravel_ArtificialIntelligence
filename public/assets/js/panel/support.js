
document.addEventListener( "DOMContentLoaded", function () {
	"use strict";

	var el;
	window.TomSelect && ( new TomSelect( el = document.getElementById( 'priority' ), {
		copyClassesToDropdown: false,
		dropdownClass: 'dropdown-menu ts-dropdown',
		optionClass: 'dropdown-item',
		controlInput: '<input>',
		render: {
			item: function ( data, escape ) {
				if ( data.customProperties ) {
					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape( data.text ) + '</div>';
				}
				return '<div>' + escape( data.text ) + '</div>';
			},
			option: function ( data, escape ) {
				if ( data.customProperties ) {
					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape( data.text ) + '</div>';
				}
				return '<div>' + escape( data.text ) + '</div>';
			},
		},
	} ) );
	window.TomSelect && ( new TomSelect( et = document.getElementById( 'category' ), {
		copyClassesToDropdown: false,
		dropdownClass: 'dropdown-menu ts-dropdown',
		optionClass: 'dropdown-item',
		controlInput: '<input>',
		render: {
			item: function ( data, escape ) {
				if ( data.customProperties ) {
					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape( data.text ) + '</div>';
				}
				return '<div>' + escape( data.text ) + '</div>';
			},
			option: function ( data, escape ) {
				if ( data.customProperties ) {
					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape( data.text ) + '</div>';
				}
				return '<div>' + escape( data.text ) + '</div>';
			},
		},
	} ) );
} );

function sendSupportForm() {
	"use strict";

	const submitBtn = document.getElementById( "support_button" );
	submitBtn.disabled = true;
	submitBtn.classList.add( 'submitting' );

	var formData = new FormData();
	formData.append( 'category', $( "#category" ).val() );
	formData.append( 'priority', $( "#priority" ).val() );
	formData.append( 'subject', $( "#subject" ).val() );
	formData.append( 'message', $( "#message" ).val() );

	$.ajax( {
		type: "post",
		url: "/dashboard/support/new-support-request/send",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Support Ticket Created Succesfully. Redirecting...' );
			setTimeout( function () {
				location.href = '/dashboard/support/my-requests'
			}, 1500 );
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			submitBtn.disabled = false;
			submitBtn.classList.remove( 'submitting' );
		}
	} );
	return false;
}

$( document ).on( 'ready', function () {
	"use strict";

	$( "#scrollable_content" ).animate( { scrollTop: 1000 }, 200 );
} );

function sendMessage( ticket_id ) {
	"use strict";

	const submitBtn = document.getElementById( "send_message_button" );
	submitBtn.disabled = true;
	submitBtn.classList.add( 'submitting' );

	var formData = new FormData();
	formData.append( 'message', $( "#message" ).val() );
	formData.append( 'ticket_id', ticket_id );

	$.ajax( {
		type: "post",
		url: "/dashboard/support/requests-action/send-message",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Message sent succesfully. Please Wait' );
			setTimeout( function () {
				location.reload();
			}, 1500 );
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			submitBtn.disabled = false;
			submitBtn.classList.remove( 'submitting' );
		}
	} );
	return false;
}
