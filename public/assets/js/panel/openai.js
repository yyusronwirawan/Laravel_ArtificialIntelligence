//Admin

$( document ).ready( function () {
	"use strict";

	const colorInput = document.querySelector( '#color' );
	const colorValue = document.querySelector( '#color_value' );
	const chatCompletionFillBtn = document.querySelector( '.chat-completions-fill-btn' );

	colorInput?.addEventListener( 'input', ev => {
		const input = ev.currentTarget;

		if ( colorValue ) {
			colorValue.value = input.value
		};
	} );

	colorValue?.addEventListener( 'input', ev => {
		const input = ev.currentTarget;

		if ( colorInput ) {
			colorInput.value = input.value
		};
	} );

	chatCompletionFillBtn?.addEventListener( 'click', () => {
		editor_chat_completions?.setValue( `[
	{
		"role": "system",
		"content": "You are a helpful assistant."
	},
	{
		"role": "user",
		"content": "Who won the world series in 2020?"
	},
	{
		"role": "assistant",
		"content": "The Los Angeles Dodgers won the World Series in 2020."
	},
	{
		"role": "user",
		"content": "Where was it played?"
	}
]`, -1 )
	} )

	//admin.openai.custom.form
	if ( $.fn.select2 ) {
		$( '.select2' ).select2( {
			tags: true
		} );
	};

} );

//admin.openai.list
function updateStatus( status, entry_id ) {
	"use strict";

	var formData = new FormData();
	formData.append( 'status', status );
	formData.append( 'entry_id', entry_id );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/openai/update-status",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Status changed succesfully.' );
			if ( status == 1 ) {
				$( "#passive_btn_" + entry_id ).hide();
				$( "#active_btn_" + entry_id ).show();
			} else {
				$( "#passive_btn_" + entry_id ).show();
				$( "#active_btn_" + entry_id ).hide();
			}

		},
		error: function ( data ) {
			toastr.error( 'Something went wrong. Please reload the page and try it again.' );
		}
	} );
	return false;
}

function templateSave( template_id ) {
	"use strict";

	document.getElementById( "custom_template_button" ).disabled = true;
	document.getElementById( "custom_template_button" ).innerHTML = "Please Wait...";

	var input_name = [];
	$( ".input_name" ).each( function () {
		input_name.push( $( this ).val() );
	} );
	var input_description = [];
	$( ".input_description" ).each( function () {
		input_description.push( $( this ).val() );
	} );
	var input_type = [];
	$( ".input_type" ).each( function () {
		input_type.push( $( this ).val() );
	} );

	var formData = new FormData();
	formData.append( 'template_id', template_id );
	formData.append( 'title', $( "#title" ).val() );
	formData.append( 'filters', $( "#filters" ).val() );
	formData.append( 'description', $( "#description" ).val() );
	formData.append( 'image', $( "#image" ).val() );
	formData.append( 'color', $( "#color" ).val() );
	formData.append( 'prompt', $( "#prompt" ).val() );
	formData.append( 'input_name', input_name );
	formData.append( 'input_description', input_description );
	formData.append( 'input_type', input_type );


	$.ajax( {
		type: "post",
		url: "/dashboard/admin/openai/custom/save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Template Saved Succesfully.' );
			location.href = '/dashboard/admin/openai/custom';
			document.getElementById( "custom_template_button" ).disabled = false;
			document.getElementById( "custom_template_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "custom_template_button" ).disabled = false;
			document.getElementById( "custom_template_button" ).innerHTML = "Save";
		}
	} );
	return false;
}

function templateChatSave( template_id ) {
	"use strict";

	document.getElementById( "custom_template_button" ).disabled = true;
	document.getElementById( "custom_template_button" ).innerHTML = "Please Wait...";


	var formData = new FormData();
	formData.append( 'template_id', template_id );
	formData.append( 'name', $( "#name" ).val() );
	formData.append( 'short_name', $( "#short_name" ).val() );
	formData.append( 'description', $( "#description" ).val() );
	formData.append( 'role', $( "#role" ).val() );
	formData.append( 'human_name', $( "#human_name" ).val() );
	formData.append( 'helps_with', $( "#helps_with" ).val() );
	formData.append( 'color', $( "#color" ).val() );

	if ( $( '#avatar' ).val() != 'undefined' ) {
		formData.append( 'avatar', $( '#avatar' ).prop( 'files' )[ 0 ] );
	}

	console.log( editor_chat_completions.getValue() );
	if ( editor_chat_completions ) {
		formData.append( 'chat_completions', editor_chat_completions.getValue() );
	}


	$.ajax( {
		type: "post",
		url: "/dashboard/admin/openai/chat/save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Chat Template Saved Succesfully.' );
			location.href = '/dashboard/admin/openai/chat';
			document.getElementById( "custom_template_button" ).disabled = false;
			document.getElementById( "custom_template_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "custom_template_button" ).disabled = false;
			document.getElementById( "custom_template_button" ).innerHTML = "Save";
		}
	} );
	return false;
}


$( document ).ready( function () {
	"use strict";

	const slugify = str => `**${ str.toLowerCase().trim().replace( /[^\w\s-]/g, '' ).replace( /[\s_-]+/g, '-' ).replace( /^-+|-+$/g, '' ) }** `;

	/** @type {HTMLTemplateElement} */
	const userInputTemplate = document.querySelector( '#user-input-template' );
	const afterAddMoreButton = document.querySelector( '.after-add-more-button' );
	const addMorePlaceholder = document.querySelector( '.add-more-placeholder' );
	let currentInputGroupts = document.querySelectorAll( '.user-input-group' );
	let lastInputsParent = [ ...currentInputGroupts ].at( -1 );
	let lastInpusGroupId = lastInputsParent ? parseInt( lastInputsParent.getAttribute( 'data-inputs-id' ), 10 ) : 0;

	$( ".add-more" ).click( function () {
		const button = this;
		const currentInputs = document.querySelectorAll( '.input_name, .input_description, .input_type' );
		let anInputIsEmpty = false;

		currentInputs.forEach( input => {
			const { value } = input;
			if ( !value || value.length === 0 || value.replace( /\s/g, '' ) === '' ) {
				return anInputIsEmpty = true;
			}
		} );

		if ( anInputIsEmpty ) {
			return toastr.error( 'Please fill all fields in User Group Input areas.' );
		}

		const newInputsMarkup = userInputTemplate.content.cloneNode( true );
		const newInputsWrapper = newInputsMarkup.firstElementChild;

		newInputsWrapper.dataset.inputsId = lastInpusGroupId + 1;

		addMorePlaceholder.before( newInputsMarkup );

		currentInputGroupts = document.querySelectorAll( '.user-input-group' );
		lastInputsParent = [ ...currentInputGroupts ].at( -1 );

		if ( currentInputGroupts.length > 1 ) {
			document.querySelectorAll( '.remove-inputs-group' ).forEach( el => el.removeAttribute( 'disabled' ) );
		}

		lastInpusGroupId++;

		const timeout = setTimeout( () => {
			newInputsWrapper.querySelector( '.input_name' ).focus();
			clearTimeout( timeout );
		}, 100 );

		return;

	} );

	$( "body" ).on( "click", ".remove-inputs-group", function () {
		const button = $( this );
		const parent = button.closest( '.user-input-group' );
		const inputsId = parent.attr( 'data-inputs-id' );
		const prompt = $( '#prompt' );
		const currentPromptVal = prompt.val();

		prompt.val( currentPromptVal.replaceAll( slugify( parent.attr( 'data-input-name' ) ), '' ) );

		$( `[data-inputs-id=${ inputsId }]` ).remove();

		currentInputGroupts = document.querySelectorAll( '.user-input-group' );
		lastInputsParent = [ ...currentInputGroupts ].at( -1 );

		if ( currentInputGroupts.length > 1 ) {
			document.querySelectorAll( '.remove-inputs-group' ).forEach( el => el.removeAttribute( 'disabled' ) );
		} else {
			document.querySelectorAll( '.remove-inputs-group' ).forEach( el => el.setAttribute( 'disabled', true ) );
		}
	} );

	$( "body" ).on( "click", "button[data-input-name]", function () {
		const prompt = $( '#prompt' );
		const currentPromptVal = prompt.val();
		prompt.val( currentPromptVal + slugify( $( this ).attr( 'data-input-name' ) ) )
	} );

	$( 'body' ).on( 'input', '.input_name', ev => {
		const input = ev.currentTarget;
		const parent = input.closest( '.user-input-group' );
		const parentId = parent.getAttribute( 'data-inputs-id' );
		const inputName = slugify( input.value );
		let button = document.querySelector( `button[data-inputs-id="${ parentId }"]` );

		if ( !button ) {
			button = document.createElement( 'button' );
			button.className = 'bg-[#EFEFEF] text-black cursor-pointer py-[0.15rem] px-[0.5rem] border-none rounded-full transition-all duration-300 hover:bg-black hover:!text-white';
			button.dataset.inputsId = parentId;
			button.type = 'button';
			afterAddMoreButton.append( button );
		}

		parent.dataset.inputName = inputName;
		button.dataset.inputName = inputName;
		button.innerText = inputName;
	} );

} );
