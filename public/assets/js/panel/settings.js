//admin.openai.custom.form
$( document ).ready( function () {
    "use strict";
    if ( !$.fn.select2 ) return;
    $( '.select2' ).select2( {
        tags: true
    } );
} );

function frontendSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'site_name', $( "#site_name" ).val() );
	formData.append( 'register_active', $( "#register_active" ).val() );
	formData.append( 'site_url', $( "#site_url" ).val() );
	formData.append( 'site_email', $( "#site_email" ).val() );
	formData.append( 'frontend_pricing_section', $( "#frontend_pricing_section" ).val() );
	formData.append( 'frontend_custom_templates_section', $( "#frontend_custom_templates_section" ).val() );
	formData.append( 'frontend_business_partners_section', $( "#frontend_business_partners_section" ).val() );
	formData.append( 'frontend_additional_url', $( "#frontend_additional_url" ).val() );
	formData.append( 'frontend_custom_css', $( "#frontend_custom_css" ).val() );
	formData.append( 'frontend_custom_js', $( "#frontend_custom_js" ).val() );
	formData.append( 'frontend_footer_facebook', $( "#frontend_footer_facebook" ).val() );
	formData.append( 'frontend_footer_twitter', $( "#frontend_footer_twitter" ).val() );
	formData.append( 'frontend_footer_instagram', $( "#frontend_footer_instagram" ).val() );

    formData.append( 'header_title', $( "#header_title" ).val() );
    formData.append( 'header_text', $( "#header_text" ).val() );
    formData.append( 'sign_in', $( "#sign_in" ).val() );
    formData.append( 'join_hub', $( "#join_hub" ).val() );

    formData.append( 'hero_subtitle', $( "#hero_subtitle" ).val() );
    formData.append( 'hero_title', $( "#hero_title" ).val() );
    formData.append( 'hero_title_text_rotator', $( "#hero_title_text_rotator" ).val() );
    formData.append( 'hero_description', $( "#hero_description" ).val() );
    formData.append( 'hero_scroll_text', $( "#hero_scroll_text" ).val() );
    formData.append( 'hero_button', $( "#hero_button" ).val() );
    formData.append( 'hero_button_url', $( "#hero_button_url" ).val() );

    if ( frontend_code_before_head ) {
		formData.append( 'frontend_code_before_head', frontend_code_before_head.getValue() );
	}
    if ( frontend_code_before_body ) {
		formData.append( 'frontend_code_before_body', frontend_code_before_body.getValue() );
	}

    formData.append( 'footer_header', $( "#footer_header" ).val() );
    formData.append( 'footer_text_small', $( "#footer_text_small" ).val() );
    formData.append( 'footer_text', $( "#footer_text" ).val() );
    formData.append( 'footer_button_text', $( "#footer_button_text" ).val() );
    formData.append( 'footer_button_url', $( "#footer_button_url" ).val() );
    formData.append( 'footer_copyright', $( "#footer_copyright" ).val() );

    $.ajax( {
		type: "post",
		url: "/dashboard/admin/frontend/settings-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}

function frontendSectionSettingsSave() {
    "use strict";

    document.getElementById( "settings_button" ).disabled = true;
    document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'features_active', $( "#features_active" ).val() );
    formData.append( 'features_title', $( "#features_title" ).val() );
    formData.append( 'features_description', $( "#features_description" ).val() );


    formData.append( 'generators_active', $( "#generators_active" ).val() );

    formData.append( 'who_is_for_active', $( "#who_is_for_active" ).val() );

    formData.append( 'custom_templates_active', $( "#custom_templates_active" ).val() );
    formData.append( 'custom_templates_subtitle_one', $( "#custom_templates_subtitle_one" ).val() );
    formData.append( 'custom_templates_subtitle_two', $( "#custom_templates_subtitle_two" ).val() );
    formData.append( 'custom_templates_title', $( "#custom_templates_title" ).val() );
    formData.append( 'custom_templates_description', $( "#custom_templates_description" ).val() );


    formData.append( 'tools_active', $( "#tools_active" ).val() );
    formData.append( 'tools_title', $( "#tools_title" ).val() );
    formData.append( 'tools_description', $( "#tools_description" ).val() );

    formData.append( 'how_it_works_active', $( "#how_it_works_active" ).val() );
    formData.append( 'how_it_works_title', $( "#how_it_works_title" ).val() );

    formData.append( 'testimonials_active', $( "#testimonials_active" ).val() );
    formData.append( 'testimonials_title', $( "#testimonials_title" ).val() );
    formData.append( 'testimonials_subtitle_one', $( "#testimonials_subtitle_one" ).val() );
    formData.append( 'testimonials_subtitle_two', $( "#testimonials_subtitle_two" ).val() );

    formData.append( 'pricing_active', $( "#pricing_active" ).val() );
    formData.append( 'pricing_title', $( "#pricing_title" ).val() );
    formData.append( 'pricing_description', $( "#pricing_description" ).val() );
    formData.append( 'pricing_save_percent', $( "#pricing_save_percent" ).val() );


    formData.append( 'faq_active', $( "#faq_active" ).val() );
    formData.append( 'faq_title', $( "#faq_title" ).val() );
    formData.append( 'faq_subtitle', $( "#faq_subtitle" ).val() );
    formData.append( 'faq_text_one', $( "#faq_text_one" ).val() );
    formData.append( 'faq_text_two', $( "#faq_text_two" ).val() );


    $.ajax( {
        type: "post",
        url: "/dashboard/admin/frontend/section-settings-save",
        data: formData,
        contentType: false,
        processData: false,
        success: function ( data ) {
            toastr.success( 'Settings saved succesfully.' );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function menuSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	var menuData = [];
    $("#menu-items .accordion-content").each(function() {
        var title = $(this).find(".menu-title").val();
        var url = $(this).find(".menu-url").val();
        var target = $(this).find(".menu-target").prop("checked");

        var data = {
            title: title,
            url: url,
            target: target
        };

        menuData.push(data);
    });

    var jsonData = JSON.stringify(menuData);
    formData.append( 'menu_options', jsonData );

    $.ajax( {
		type: "post",
		url: "/dashboard/admin/frontend/menu-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}

function affiliateSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'affiliate_minimum_withdrawal', $( "#affiliate_minimum_withdrawal" ).val() );
	formData.append( 'affiliate_commission_percentage', $( "#affiliate_commission_percentage" ).val() );
	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/affiliate-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}


function generalSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'site_name', $( "#site_name" ).val() );
	formData.append( 'site_url', $( "#site_url" ).val() );
	formData.append( 'site_email', $( "#site_email" ).val() );
	formData.append( 'register_active', $( "#register_active" ).val() );
	formData.append( 'free_plan', $( "#free_plan" ).val() );
	formData.append( 'default_country', $( "#default_country" ).val() );
	formData.append( 'default_currency', $( "#default_currency" ).val() );
    formData.append( 'hosting_type', $( "#hosting_type" ).is(":checked") ? 'low' : 'high' );
    formData.append( 'login_without_confirmation', $( "#login_without_confirmation" ).is(":checked") ? 0 : 1 );

    formData.append( 'facebook_active', $( "#facebook_active" ).is(":checked") ? 1 : 0 );
    formData.append( 'google_active', $( "#google_active" ).is(":checked") ? 1 : 0 );
    formData.append( 'github_active', $( "#github_active" ).is(":checked") ? 1 : 0 );

	if ( $( '#logo' ).val() != 'undefined' ) {
		formData.append( 'logo', $( '#logo' ).prop( 'files' )[ 0 ] );
	}
    if ( $( '#logo_dark' ).val() != 'undefined' ) {
        formData.append( 'logo_dark', $( '#logo_dark' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_sticky' ).val() != 'undefined' ) {
        formData.append( 'logo_sticky', $( '#logo_sticky' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_dashboard' ).val() != 'undefined' ) {
        formData.append( 'logo_dashboard', $( '#logo_dashboard' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_dashboard_dark' ).val() != 'undefined' ) {
        formData.append( 'logo_dashboard_dark', $( '#logo_dashboard_dark' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_collapsed' ).val() != 'undefined' ) {
        formData.append( 'logo_collapsed', $( '#logo_collapsed' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_collapsed_dark' ).val() != 'undefined' ) {
        formData.append( 'logo_collapsed_dark', $( '#logo_collapsed_dark' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_2x', $( '#logo_2x' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_dark_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_dark_2x', $( '#logo_dark_2x' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_sticky_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_sticky_2x', $( '#logo_sticky_2x' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_dashboard_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_dashboard_2x', $( '#logo_dashboard_2x' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_dashboard_dark_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_dashboard_dark_2x', $( '#logo_dashboard_dark_2x' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_collapsed_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_collapsed_2x', $( '#logo_collapsed_2x' ).prop( 'files' )[ 0 ] );
    }
    if ( $( '#logo_collapsed_dark_2x' ).val() != 'undefined' ) {
        formData.append( 'logo_collapsed_dark_2x', $( '#logo_collapsed_dark_2x' ).prop( 'files' )[ 0 ] );
    }
	if ( $( '#favicon' ).val() != 'undefined' ) {
		formData.append( 'favicon', $( '#favicon' ).prop( 'files' )[ 0 ] );
	}

	formData.append( 'google_analytics_code', $( "#google_analytics_code" ).val() );
	formData.append( 'meta_title', $( "#meta_title" ).val() );
	formData.append( 'meta_description', $( "#meta_description" ).val() );
	formData.append( 'meta_keywords', $( "#meta_keywords" ).val() );

    if ( dashboard_code_before_head ) {
		formData.append( 'dashboard_code_before_head', dashboard_code_before_head.getValue() );
	}
    if ( dashboard_code_before_head ) {
		formData.append( 'dashboard_code_before_body', dashboard_code_before_body.getValue() );
	}

    formData.append( 'feature_ai_writer', $( "#feature_ai_writer" ).is(":checked") ? 1 : 0 );
    formData.append( 'feature_ai_image', $( "#feature_ai_image" ).is(":checked") ? 1 : 0 );
    formData.append( 'feature_ai_chat', $( "#feature_ai_chat" ).is(":checked") ? 1 : 0 );
    formData.append( 'feature_ai_code', $( "#feature_ai_code" ).is(":checked") ? 1 : 0 );
    formData.append( 'feature_ai_speech_to_text', $( "#feature_ai_speech_to_text" ).is(":checked") ? 1 : 0 );
    formData.append( 'feature_ai_voiceover', $( "#feature_ai_voiceover" ).is(":checked") ? 1 : 0 );
    formData.append( 'feature_affilates', $( "#feature_affilates" ).is(":checked") ? 1 : 0 );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/general-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully. Redirecting...' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
            setTimeout( function () {
				location.href = '/dashboard/admin/settings/general'
			}, 1000 );
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}


function invoiceSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'invoice_name', $( "#invoice_name" ).val() );
	formData.append( 'invoice_website', $( "#invoice_website" ).val() );
	formData.append( 'invoice_address', $( "#invoice_address" ).val() );
	formData.append( 'invoice_city', $( "#invoice_city" ).val() );
	formData.append( 'invoice_state', $( "#invoice_state" ).val() );
	formData.append( 'invoice_postal', $( "#invoice_postal" ).val() );
	formData.append( 'invoice_country', $( "#invoice_country" ).val() );
	formData.append( 'invoice_phone', $( "#invoice_phone" ).val() );
	formData.append( 'invoice_vat', $( "#invoice_vat" ).val() );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/invoice-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}

function stripeSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'default_currency', $( "#default_currency" ).val() );
	formData.append( 'stripe_key', $( "#stripe_key" ).val() );
	formData.append( 'stripe_secret', $( "#stripe_secret" ).val() );
	formData.append( 'stripe_base_url', $( "#stripe_base_url" ).val() );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/payment-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}


function openaiSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'openai_api_secret', $( "#openai_api_secret" ).val() );
	formData.append( 'openai_default_model', $( "#openai_default_model" ).val() );
	formData.append( 'openai_default_language', $( "#openai_default_language" ).val() );
	formData.append( 'openai_default_tone_of_voice', $( "#openai_default_tone_of_voice" ).val() );
	formData.append( 'openai_default_creativity', $( "#openai_default_creativity" ).val() );
	formData.append( 'openai_max_input_length', $( "#openai_max_input_length" ).val() );
	formData.append( 'openai_max_output_length', $( "#openai_max_output_length" ).val() );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/openai-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}

function ttsSettingsSave() {
	"use strict";

	document.getElementById( "settings_button" ).disabled = true;
	document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'gcs_file', $( "#gcs_file" ).val() );
	formData.append( 'gcs_name', $( "#gcs_name" ).val() );

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/tts-save",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			toastr.success( 'Settings saved succesfully.' );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			} );
			document.getElementById( "settings_button" ).disabled = false;
			document.getElementById( "settings_button" ).innerHTML = "Save";
		}
	} );
	return false;
}


function smtpSettingsSave() {
    "use strict";

    document.getElementById( "settings_button" ).disabled = true;
    document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'smtp_host', $( "#smtp_host" ).val() );
    formData.append( 'smtp_port', $( "#smtp_port" ).val() );
    formData.append( 'smtp_username', $( "#smtp_username" ).val() );
    formData.append( 'smtp_password', $( "#smtp_password" ).val() );
    formData.append( 'smtp_email', $( "#smtp_email" ).val() );
    formData.append( 'smtp_sender_name', $( "#smtp_sender_name" ).val() );
    formData.append( 'smtp_encryption', $( "#smtp_encryption" ).val() );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/settings/smtp-save",
        data: formData,
        contentType: false,
        processData: false,
        success: function ( data ) {
            toastr.success( 'Settings saved succesfully.' );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function gdprSettingsSave() {
    "use strict";

    document.getElementById( "settings_button" ).disabled = true;
    document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'gdpr_status', $( "#gdpr_status" ).is(":checked") ? 1 : 0 );
    formData.append( 'gdpr_button', $( "#gdpr_button" ).val() );
    formData.append( 'gdpr_content', $( "#gdpr_content" ).val() );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/settings/gdpr-save",
        data: formData,
        contentType: false,
        processData: false,
        success: function ( data ) {
            toastr.success( 'Settings saved succesfully.' );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function privacySettingsSave() {
    "use strict";

    document.getElementById( "settings_button" ).disabled = true;
    document.getElementById( "settings_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'privacy_enable', $( "#privacy_enable" ).is(":checked") ? 1 : 0 );
    formData.append( 'privacy_enable_login', $( "#privacy_enable_login" ).is(":checked") ? 1 : 0 );
    formData.append( 'privacy_content', tinymce.get("privacy_content").getContent() );
    formData.append( 'terms_content', tinymce.get("terms_content").getContent() );

    console.log(formData);

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/settings/privacy-save",
        data: formData,
        contentType: false,
        processData: false,
        success: function ( data ) {
            toastr.success( 'Settings saved succesfully.' );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "settings_button" ).disabled = false;
            document.getElementById( "settings_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function faqCreateOrUpdate(faq_id) {
    "use strict";

    document.getElementById( "faq_button" ).disabled = true;
    document.getElementById( "faq_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'question', $( "#question" ).val() );
    formData.append( 'answer', $( "#answer" ).val() );
    formData.append( 'faq_id', faq_id );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/frontend/faq/action/save",
        data: formData,
        contentType: false,
        processData: false,
        success: function (  ) {
            toastr.success( 'Faq saved succesfully. Redirecting' );
            setTimeout(function (){
                location.href = "/dashboard/admin/frontend/faq"
            }, 750);
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "faq_button" ).disabled = false;
            document.getElementById( "faq_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function toolsCreateOrUpdate(item_id) {
    "use strict";

    document.getElementById( "item_button" ).disabled = true;
    document.getElementById( "item_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'title', $( "#title" ).val() );
    formData.append( 'description', $( "#description" ).val() );
    if ( $( '#image' ).val() != 'undefined' ) {
        formData.append( 'image', $( '#image' ).prop( 'files' )[ 0 ] );
    }
    formData.append( 'item_id', item_id );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/frontend/tools/action/save",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            toastr.success( 'Item saved succesfully. Redirecting' );
            setTimeout(function (){
                location.href = "/dashboard/admin/frontend/tools"
            }, 750);
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "item_button" ).disabled = false;
            document.getElementById( "item_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function futureCreateOrUpdate(item_id) {
    "use strict";

    document.getElementById( "item_button" ).disabled = true;
    document.getElementById( "item_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'title', $( "#title" ).val() );
    formData.append( 'description', $( "#description" ).val() );
    formData.append( 'image', $( "#image" ).val() );
    formData.append( 'item_id', item_id );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/frontend/future/action/save",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            toastr.success( 'Item saved succesfully. Redirecting' );
            setTimeout(function (){
                location.href = "/dashboard/admin/frontend/future"
            }, 750);
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "item_button" ).disabled = false;
            document.getElementById( "item_button" ).innerHTML = "Save";
        }
    } );
    return false;
}


function whoisCreateOrUpdate(item_id) {
    "use strict";

    document.getElementById( "item_button" ).disabled = true;
    document.getElementById( "item_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'title', $( "#title" ).val() );
    formData.append( 'color', $( "#color" ).val() );
    formData.append( 'item_id', item_id );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/frontend/whois/action/save",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            toastr.success( 'Item saved succesfully. Redirecting' );
            setTimeout(function (){
                location.href = "/dashboard/admin/frontend/whois"
            }, 750);
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "item_button" ).disabled = false;
            document.getElementById( "item_button" ).innerHTML = "Save";
        }
    } );
    return false;
}

function generatorlistCreateOrUpdate(item_id) {
    "use strict";

    document.getElementById( "item_button" ).disabled = true;
    document.getElementById( "item_button" ).innerHTML = "Please Wait...";

    var formData = new FormData();
    formData.append( 'menu_title', $( "#menu_title" ).val() );
    formData.append( 'subtitle_one', $( "#subtitle_one" ).val() );
    formData.append( 'subtitle_two', $( "#subtitle_two" ).val() );
    formData.append( 'title', $( "#title" ).val() );
    formData.append( 'text', $( "#text" ).val() );
    formData.append( 'image_title', $( "#image_title" ).val() );
    formData.append( 'image_subtitle', $( "#image_subtitle" ).val() );
    formData.append( 'color', $( "#color" ).val() );
    if ( $( '#image' ).val() != 'undefined' ) {
        formData.append( 'image', $( '#image' ).prop( 'files' )[ 0 ] );
    }
    formData.append( 'item_id', item_id );

    $.ajax( {
        type: "post",
        url: "/dashboard/admin/frontend/generatorlist/action/save",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            toastr.success( 'Item saved succesfully. Redirecting' );
            setTimeout(function (){
                location.href = "/dashboard/admin/frontend/generatorlist"
            }, 750);
        },
        error: function ( data ) {
            var err = data.responseJSON.errors;
            $.each( err, function ( index, value ) {
                toastr.error( value );
            } );
            document.getElementById( "item_button" ).disabled = false;
            document.getElementById( "item_button" ).innerHTML = "Save";
        }
    } );
    return false;
}
