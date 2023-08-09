function prepaidSave( plan_id ) {
	"use strict";

	document.getElementById( "item_edit_button" ).disabled = true;
	document.getElementById( "item_edit_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	if ( plan_id != 'undefined' ) {
		formData.append( 'plan_id', plan_id );
	} else {
		formData.append( 'plan_id', null );
	}

	formData.append( 'name', $( "#name" ).val() );
	formData.append( 'price', $( "#price" ).val() );
	formData.append( 'is_featured', $( "#is_featured" ).val() );
	formData.append( 'total_words', $( "#total_words" ).val() );
	formData.append( 'total_images', $( "#total_images" ).val() );
	formData.append( 'plan_type', $( "#plan_type" ).val() );
	formData.append( 'features', $( "#features" ).val() );

	formData.append( 'type', 'prepaid' );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/finance/plans/save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Plan Saved Succesfully. Redirecting...' );
			setTimeout( function () {
				location.href = '/dashboard/admin/finance/plans'
			}, 1000 );

		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "item_edit_button" ).disabled = false;
			document.getElementById( "item_edit_button" ).innerHTML = "Save";
		}
	} );
	return false;
}


function subscriptionSave( plan_id ) {
	"use_strict";

	document.getElementById( "item_edit_button" ).disabled = true;
	document.getElementById( "item_edit_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	if ( plan_id != 'undefined' ) {
		formData.append( 'plan_id', plan_id );
	} else {
		formData.append( 'plan_id', null );
	}


	formData.append( 'name', $( "#name" ).val() );
	formData.append( 'price', $( "#price" ).val() );
	formData.append( 'frequency', $( "#frequency" ).val() );
	formData.append( 'is_featured', $( "#is_featured" ).val() );
	formData.append( 'stripe_product_id', $( "#stripe_product_id" ).val() );
	formData.append( 'total_words', $( "#total_words" ).val() );
	formData.append( 'total_images', $( "#total_images" ).val() );
	formData.append( 'ai_name', $( "#ai_name" ).val() );
	formData.append( 'max_tokens', $( "#max_tokens" ).val() );
	formData.append( 'can_create_ai_images', $( "#can_create_ai_images" ).val() );
	formData.append( 'plan_type', $( "#plan_type" ).val() );
	formData.append( 'features', $( "#features" ).val() );
	formData.append( 'trial_days', parseInt($( "#trial_days" ).val()) );


	formData.append( 'type', 'subscription' );


	$.ajax( {
		type: "post",
		url: "/dashboard/admin/finance/plans/save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Plan Saved Succesfully. Redirecting...' );
			setTimeout( function () {
				location.href = '/dashboard/admin/finance/plans'
			}, 1000 );

		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "item_edit_button" ).disabled = false;
			document.getElementById( "item_edit_button" ).innerHTML = "Save";
		}
	} );
	return false;
}

