@extends('panel.layout.app')
@section('title', $openai->title)

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
                    <div class="page-pretitle">
                        {{$openai->description}}
                    </div>
                    <h2 class="page-title mb-2">
                        {{$openai->title}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body page-generator pt-6">
        <div class="container-xl">
            @if($openai->type == 'image')
                @include('panel.user.openai.generator_components.generator_image')
            @elseif($openai->type == 'voiceover')
                @include('panel.user.openai.generator_components.generator_voiceover')
            @else
                @include('panel.user.openai.generator_components.generator_others')
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/libs/tom-select/dist/js/tom-select.base.min.js?1674944402" defer></script>
    <script src="/assets/js/panel/openai_generator.js"></script>
    <script src="/assets/libs/fslightbox/index.js?1674944402" defer></script>
    <script src="/assets/libs/wavesurfer/wavesurfer.js"></script>
    <script src="/assets/js/panel/voiceover.js"></script>

    @if($openai->type == 'voiceover')

        <script>

            function generateSpeech() {
                "use strict";

                document.getElementById( "generate_speech_button" ).disabled = true;
                document.getElementById( "generate_speech_button" ).innerHTML = "Please Wait...";

                var formData = new FormData();
                var speechData = [];
                formData.append( 'workbook_title', $('#workbook_title').val() );

                $('.speeches .speech').each(function() {
                    var data = {
                        voice:   $(this).find('textarea').attr('data-voice'),
                        lang:    $(this).find('textarea').attr('data-lang'),
                        pace:    $(this).find('textarea').attr('data-pace'),
                        break:   $(this).find('textarea').attr('data-break'),
                        content: $(this).find('textarea').val()
                    };
                    speechData.push(data);
                });

                var jsonData = JSON.stringify(speechData);
                formData.append( 'speeches', jsonData );
                console.log(formData);

                $.ajax( {
                    type: "post",
                    url: "/dashboard/user/openai/generate-speech",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function ( data ) {
                        toastr.success( data.message );
                        document.getElementById( "generate_speech_button" ).disabled = false;
                        document.getElementById( "generate_speech_button" ).innerHTML = "Generate";
                        $("#generator_sidebar_table").html(data.html2);

						var audioElements = document.querySelectorAll('.data-audio');
						audioElements.forEach( generateWaveForm );
                    },
                    error: function ( data ) {
                        var err = data.responseJSON.errors;
                        $.each( err, function ( index, value ) {
                            toastr.error( value );
                        } );
                        document.getElementById( "generate_speech_button" ).disabled = false;
                        document.getElementById( "generate_speech_button" ).innerHTML = "Save";
                    }
                } );
                return false;
            }

            const voicesData = {
                "af-ZA": [
                    {value:"af-ZA-Standard-A", label: "Standart - FEMALE"}
                ],
                "ar-XA": [
                    {value:"ar-XA-Standard-A", label: "Standard - FEMALE"},
                    {value:"ar-XA-Standard-B", label: "Standard - MALE"},
                    {value:"ar-XA-Standard-C", label: "Standard - MALE"},
                    {value:"ar-XA-Standard-D", label: "Standard - FEMALE"},
                    {value:"ar-XA-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ar-XA-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"ar-XA-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"ar-XA-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "eu-ES": [
                    {value:"eu-ES-Standard-A", label: "Standart - FEMALE"}
                ],
                "bn-IN": [
                    {value:"bn-IN-Standard-A", label: "Standart - FEMALE"},
                    {value:"bn-IN-Standard-B", label: "Standart - MALE"},
                    {value:"bn-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"bn-IN-Wavenet-B", label: "WaveNet - MALE"}
                ],
                "bg-BG": [
                    {value:"bg-BG-Standard-A", label: "Standart - FEMALE"}
                ],
                "ca-ES": [
                    {value:"ca-ES-Standard-A", label: "Standart - FEMALE"}
                ],
                "yue-HK": [
                    {value:"yue-HK-Standard-A", label: "Standart - FEMALE"},
                    {value:"yue-HK-Standard-B", label: "Standart - MALE"},
                    {value:"yue-HK-Standard-C", label: "Standart - FEMALE"},
                    {value:"yue-HK-Standard-D", label: "Standart - MALE"}
                ],
                "cs-CZ": [
                    {value:"cs-CZ-Standard-A", label: "Standart - FEMALE"},
                    {value:"cs-CZ-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "da-DK": [
                    {value:"da-DK-Neural2-D", label: "Neural2 - FEMALE"},
                    {value:"da-DK-Neural2-F", label: "Neural2 - MALE"},
                    {value:"da-DK-Standard-A", label: "Standard - FEMALE"},
                    {value:"da-DK-Standard-A", label: "Standard - FEMALE"},
                    {value:"da-DK-Standard-A", label: "Standard - FEMALE"},
                    {value:"da-DK-Standard-C", label: "Standard - MALE"},
                    {value:"da-DK-Standard-D", label: "Standard - FEMALE"},
                    {value:"da-DK-Standard-E", label: "Standard - FEMALE"},
                    {value:"da-DK-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"da-DK-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"da-DK-Wavenet-D", label: "WaveNet - FEMALE"},
                    {value:"da-DK-Wavenet-E", label: "WaveNet - FEMALE"}
                ],
                "nl-BE": [
                    {value:"nl-BE-Standard-A", label: "Standard - FEMALE"},
                    {value:"nl-BE-Standard-B", label: "Standard - MALE"},
                    {value:"nl-BE-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"nl-BE-Wavenet-B", label: "WaveNet - MALE"}
                ],
                "nl-NL": [
                    {value:"nl-NL-Standard-A", label: "Standard - FEMALE"},
                    {value:"nl-NL-Standard-B", label: "Standard - MALE"},
                    {value:"nl-NL-Standard-C", label: "Standard - MALE"},
                    {value:"nl-NL-Standard-D", label: "Standard - FEMALE"},
                    {value:"nl-NL-Standard-E", label: "Standard - FEMALE"},
                    {value:"nl-NL-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"nl-NL-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"nl-NL-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"nl-NL-Wavenet-D", label: "WaveNet - FEMALE"},
                    {value:"nl-NL-Wavenet-E", label: "WaveNet - FEMALE"}
                ],
                "en-AU": [
                    {value:"en-AU-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"en-AU-Neural2-B", label: "Neural2 - MALE"},
                    {value:"en-AU-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"en-AU-Neural2-D", label: "Neural2 - MALE"},
                    {value:"en-AU-News-E", label: "WaveNet - FEMALE"},
                    {value:"en-AU-News-F", label: "WaveNet - FEMALE"},
                    {value:"en-AU-News-G", label: "WaveNet - MALE"},
                    {value:"en-AU-Polyglot-1", label: "Standard - MALE"},
                    {value:"en-AU-Standard-A", label: "Standard - FEMALE"},
                    {value:"en-AU-Standard-B", label: "Standard - MALE"},
                    {value:"en-AU-Standard-C", label: "Standard - FEMALE"},
                    {value:"en-AU-Standard-D", label: "Standard - MALE"},
                    {value:"en-AU-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"en-AU-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"en-AU-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"en-AU-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "en-IN": [
                    {value:"en-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"en-IN-Standard-B", label: "Standard - MALE"},
                    {value:"en-IN-Standard-C", label: "Standard - MALE"},
                    {value:"en-IN-Standard-D", label: "Standard - FEMALE"},
                    {value:"en-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"en-IN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"en-IN-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"en-IN-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "en-GB": [
                    {value:"en-GB-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"en-GB-Neural2-B", label: "Neural2 - MALE"},
                    {value:"en-GB-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"en-GB-Neural2-D", label: "Neural2 - MALE"},
                    {value:"en-GB-Neural2-F", label: "Neural2 - FEMALE"},
                    {value:"en-GB-News-G", label: "WaveNet - FEMALE"},
                    {value:"en-GB-News-H", label: "WaveNet - FEMALE"},
                    {value:"en-GB-News-I", label: "WaveNet - FEMALE"},
                    {value:"en-GB-News-J", label: "WaveNet - FEMALE"},
                    {value:"en-GB-News-K", label: "WaveNet - MALE"},
                    {value:"en-GB-News-L", label: "WaveNet - MALE"},
                    {value:"en-GB-News-M", label: "WaveNet - MALE"},
                    {value:"en-GB-Standard-A", label: "Standard - FEMALE"},
                    {value:"en-GB-Standard-B", label: "Standard - MALE"},
                    {value:"en-GB-Standard-C", label: "Standard - FEMALE"},
                    {value:"en-GB-Standard-D", label: "Standard - MALE"},
                    {value:"en-GB-Standard-F", label: "Standard - FEMALE"},
                    {value:"en-GB-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"en-GB-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"en-GB-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"en-GB-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"en-GB-Wavenet-F", label: "WaveNet - FEMALE"}
                ],
                "en-US": [
                    {value:"en-US-Neural2-A", label: "Neural2 - MALE"},
                    {value:"en-US-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"en-US-Neural2-D", label: "Neural2 - MALE"},
                    {value:"en-US-Neural2-E", label: "Neural2 - FEMALE"},
                    {value:"en-US-Neural2-F", label: "Neural2 - FEMALE"},
                    {value:"en-US-Neural2-G", label: "Neural2 - FEMALE"},
                    {value:"en-US-Neural2-H", label: "Neural2 - FEMALE"},
                    {value:"en-US-Neural2-I", label: "Neural2 - MALE"},
                    {value:"en-US-Neural2-J", label: "Neural2 - MALE"},
                    {value:"en-US-News-K", label: "WaveNet - FEMALE"},
                    {value:"en-US-News-L", label: "WaveNet - FEMALE"},
                    {value:"en-US-News-M", label: "WaveNet - MALE"},
                    {value:"en-US-News-N", label: "WaveNet - MALE"},
                    {value:"en-US-Polyglot-1", label: "Standard - MALE"},
                    {value:"en-US-Standard-A", label: "Standard - MALE"},
                    {value:"en-US-Standard-B", label: "Standard - MALE"},
                    {value:"en-US-Standard-C", label: "Standard - FEMALE"},
                    {value:"en-US-Standard-D", label: "Standard - MALE"},
                    {value:"en-US-Standard-E", label: "Standard - FEMALE"},
                    {value:"en-US-Standard-F", label: "Standard - FEMALE"},
                    {value:"en-US-Standard-G", label: "Standard - FEMALE"},
                    {value:"en-US-Standard-H", label: "Standard - FEMALE"},
                    {value:"en-US-Standard-I", label: "Standard - MALE"},
                    {value:"en-US-Standard-J", label: "Standard - MALE"},
                    {value:"en-US-Studio-M", label: "Studio - MALE"},
                    {value:"en-US-Studio-O", label: "Studio - FEMALE"},
                    {value:"en-US-Wavenet-A", label: "WaveNet - MALE"},
                    {value:"en-US-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"en-US-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"en-US-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"en-US-Wavenet-E", label: "WaveNet - FEMALE"},
                    {value:"en-US-Wavenet-F", label: "WaveNet - FEMALE"},
                    {value:"en-US-Wavenet-G", label: "WaveNet - FEMALE"},
                    {value:"en-US-Wavenet-H", label: "WaveNet - FEMALE"},
                    {value:"en-US-Wavenet-I", label: "WaveNet - MALE"},
                    {value:"en-US-Wavenet-J", label: "WaveNet - MALE"}
                ],
                "fil-PH": [
                    {value:"fil-PH-Standard-A", label: "Standard - FEMALE"},
                    {value:"fil-PH-Standard-B", label: "Standard - FEMALE"},
                    {value:"fil-PH-Standard-C", label: "Standard - MALE"},
                    {value:"fil-PH-Standard-D", label: "Standard - MALE"},
                    {value:"fil-PH-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"fil-PH-Wavenet-B", label: "WaveNet - FEMALE"},
                    {value:"fil-PH-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"fil-PH-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"fil-ph-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"fil-ph-Neural2-D", label: "Neural2 - MALE"}
                ],
                "fi-FI": [
                    {value:"fi-FI-Standard-A", label: "Standard - FEMALE"},
                    {value:"fi-FI-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "fr-CA": [
                    {value:"fr-CA-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"fr-CA-Neural2-B", label: "Neural2 - MALE"},
                    {value:"fr-CA-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"fr-CA-Neural2-D", label: "Neural2 - MALE"},
                    {value:"fr-CA-Standard-A", label: "Standard - FEMALE"},
                    {value:"fr-CA-Standard-B", label: "Standard - MALE"},
                    {value:"fr-CA-Standard-C", label: "Standard - FEMALE"},
                    {value:"fr-CA-Standard-D", label: "Standard - MALE"},
                    {value:"fr-CA-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"fr-CA-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"fr-CA-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"fr-CA-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "fr-FR": [
                    {value:"fr-FR-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"fr-FR-Neural2-B", label: "Neural2 - MALE"},
                    {value:"fr-FR-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"fr-FR-Neural2-D", label: "Neural2 - MALE"},
                    {value:"fr-FR-Neural2-E", label: "Neural2 - FEMALE"},
                    {value:"fr-FR-Polyglot-1", label: "Standard - MALE"},
                    {value:"fr-FR-Standard-A", label: "Standard - FEMALE"},
                    {value:"fr-FR-Standard-B", label: "Standard - MALE"},
                    {value:"fr-FR-Standard-C", label: "Standard - FEMALE"},
                    {value:"fr-FR-Standard-D", label: "Standard - MALE"},
                    {value:"fr-FR-Standard-E", label: "Standard - FEMALE"},
                    {value:"fr-FR-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"fr-FR-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"fr-FR-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"fr-FR-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"fr-FR-Wavenet-E", label: "WaveNet - FEMALE"}
                ],
                "gl-ES": [
                    {value:"gl-ES-Standard-A", label: "Standard - FEMALE"}
                ],
                "de-DE": [
                    {value:"de-DE-Neural2-B", label: "Neural2 - MALE"},
                    {value:"de-DE-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"de-DE-Neural2-D", label: "Neural2 - MALE"},
                    {value:"de-DE-Neural2-F", label: "Neural2 - FEMALE"},
                    {value:"de-DE-Polyglot-1", label: "Standard - MALE"},
                    {value:"de-DE-Standard-A", label: "Standard - FEMALE"},
                    {value:"de-DE-Standard-B", label: "Standard - MALE"},
                    {value:"de-DE-Standard-C", label: "Standard - FEMALE"},
                    {value:"de-DE-Standard-D", label: "Standard - MALE"},
                    {value:"de-DE-Standard-E", label: "Standard - MALE"},
                    {value:"de-DE-Standard-F", label: "Standard - FEMALE"},
                    {value:"de-DE-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"de-DE-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"de-DE-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"de-DE-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"de-DE-Wavenet-E", label: "WaveNet - MALE"},
                    {value:"de-DE-Wavenet-F", label: "WaveNet - FEMALE"}
                ],
                "el-GR": [
                    {value:"el-GR-Standard-A", label: "Standard - FEMALE"},
                    {value:"el-GR-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "gu-IN": [
                    {value:"gu-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"gu-IN-Standard-B", label: "Standard - MALE"},
                    {value:"gu-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"gu-IN-Wavenet-B", label: "WaveNet - MALE"}
                ],
                "he-IL": [
                    {value:"he-IL-Standard-A", label: "Standard - FEMALE"},
                    {value:"he-IL-Standard-B", label: "Standard - MALE"},
                    {value:"he-IL-Standard-C", label: "Standard - FEMALE"},
                    {value:"he-IL-Standard-D", label: "Standard - MALE"},
                    {value:"he-IL-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"he-IL-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"he-IL-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"he-IL-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "hi-IN": [
                    {value:"hi-IN-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"hi-IN-Neural2-B", label: "Neural2 - MALE"},
                    {value:"hi-IN-Neural2-C", label: "Neural2 - MALE"},
                    {value:"hi-IN-Neural2-D", label: "Neural2 - FEMALE"},
                    {value:"hi-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"hi-IN-Standard-B", label: "Standard - MALE"},
                    {value:"hi-IN-Standard-C", label: "Standard - MALE"},
                    {value:"hi-IN-Standard-D", label: "Standard - FEMALE"},
                    {value:"hi-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"hi-IN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"hi-IN-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"hi-IN-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "hu-HU": [
                    {value:"hu-HU-Standard-A", label: "Standard - FEMALE"},
                    {value:"hu-HU-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "is-IS": [
                    {value:"is-IS-Standard-A", label: "Standard - FEMALE"}
                ],
                "id-ID": [
                    {value:"id-ID-Standard-A", label: "Standard - FEMALE"},
                    {value:"id-ID-Standard-B", label: "Standard - MALE"},
                    {value:"id-ID-Standard-C", label: "Standard - MALE"},
                    {value:"id-ID-Standard-D", label: "Standard - FEMALE"},
                    {value:"id-ID-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"id-ID-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"id-ID-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"id-ID-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "it-IT": [
                    {value:"it-IT-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"it-IT-Neural2-C", label: "Neural2 - MALE"},
                    {value:"it-IT-Standard-A", label: "Standard - FEMALE"},
                    {value:"it-IT-Standard-B", label: "Standard - FEMALE"},
                    {value:"it-IT-Standard-C", label: "Standard - MALE"},
                    {value:"it-IT-Standard-D", label: "Standard - MALE"},
                    {value:"it-IT-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"it-IT-Wavenet-B", label: "WaveNet - FEMALE"},
                    {value:"it-IT-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"it-IT-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "ja-JP": [
                    {value:"ja-JP-Neural2-B", label: "Neural2 - FEMALE"},
                    {value:"ja-JP-Neural2-C", label: "Neural2 - MALE"},
                    {value:"ja-JP-Neural2-D", label: "Neural2 - MALE"},
                    {value:"ja-JP-Standard-A", label: "Standard - FEMALE"},
                    {value:"ja-JP-Standard-B", label: "Standard - FEMALE"},
                    {value:"ja-JP-Standard-C", label: "Standard - MALE"},
                    {value:"ja-JP-Standard-D", label: "Standard - MALE"},
                    {value:"ja-JP-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ja-JP-Wavenet-B", label: "WaveNet - FEMALE"},
                    {value:"ja-JP-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"ja-JP-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "kn-IN": [
                    {value:"kn-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"kn-IN-Standard-B", label: "Standard - MALE"},
                    {value:"kn-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"kn-IN-Wavenet-B", label: "WaveNet - MALE"}
                ],
                "ko-KR": [
                    {value:"ko-KR-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"ko-KR-Neural2-B", label: "Neural2 - FEMALE"},
                    {value:"ko-KR-Neural2-C", label: "Neural2 - MALE"},
                    {value:"ko-KR-Standard-A", label: "Standard - FEMALE"},
                    {value:"ko-KR-Standard-B", label: "Standard - FEMALE"},
                    {value:"ko-KR-Standard-C", label: "Standard - MALE"},
                    {value:"ko-KR-Standard-D", label: "Standard - MALE"},
                    {value:"ko-KR-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ko-KR-Wavenet-B", label: "WaveNet - FEMALE"},
                    {value:"ko-KR-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"ko-KR-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "lv-LV": [
                    {value:"lv-LV-Standard-A", label: "Standard - MALE"}
                ],
                "lv-LT": [
                    {value:"lv-LT-Standard-A", label: "Standard - MALE"}
                ],
                "ms-MY": [
                    {value:"ms-MY-Standard-A", label: "Standard - FEMALE"},
                    {value:"ms-MY-Standard-B", label: "Standard - MALE"},
                    {value:"ms-MY-Standard-C", label: "Standard - FEMALE"},
                    {value:"ms-MY-Standard-D", label: "Standard - MALE"},
                    {value:"ms-MY-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ms-MY-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"ms-MY-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"ms-MY-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "ml-IN": [
                    {value:"ml-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"ml-IN-Standard-B", label: "Standard - MALE"},
                    {value:"ml-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ml-IN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"ml-IN-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"ml-IN-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "cmn-CN": [
                    {value:"cmn-CN-Standard-A", label: "Standard - FEMALE"},
                    {value:"cmn-CN-Standard-B", label: "Standard - MALE"},
                    {value:"cmn-CN-Standard-C", label: "Standard - MALE"},
                    {value:"cmn-CN-Standard-D", label: "Standard - FEMALE"},
                    {value:"cmn-CN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"cmn-CN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"cmn-CN-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"cmn-CN-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "cmn-TW": [
                    {value:"cmn-TW-Standard-A", label: "Standard - FEMALE"},
                    {value:"cmn-TW-Standard-B", label: "Standard - MALE"},
                    {value:"cmn-TW-Standard-C", label: "Standard - MALE"},
                    {value:"cmn-TW-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"cmn-TW-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"cmn-TW-Wavenet-C", label: "WaveNet - MALE"}
                ],
                "mr-IN": [
                    {value:"mr-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"mr-IN-Standard-B", label: "Standard - MALE"},
                    {value:"mr-IN-Standard-C", label: "Standard - FEMALE"},
                    {value:"mr-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"mr-IN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"mr-IN-Wavenet-C", label: "WaveNet - FEMALE"}
                ],
                "nb-NO": [
                    {value:"nb-NO-Standard-A", label: "Standard - FEMALE"},
                    {value:"nb-NO-Standard-B", label: "Standard - MALE"},
                    {value:"nb-NO-Standard-C", label: "Standard - FEMALE"},
                    {value:"nb-NO-Standard-D", label: "Standard - MALE"},
                    {value:"nb-NO-Standard-E", label: "Standard - FEMALE"},
                    {value:"nb-NO-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"nb-NO-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"nb-NO-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"nb-NO-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"nb-NO-Wavenet-E", label: "WaveNet - FEMALE"}
                ],
                "pl-PL": [
                    {value:"pl-PL-Standard-A", label: "Standard - FEMALE"},
                    {value:"pl-PL-Standard-B", label: "Standard - MALE"},
                    {value:"pl-PL-Standard-C", label: "Standard - MALE"},
                    {value:"pl-PL-Standard-D", label: "Standard - FEMALE"},
                    {value:"pl-PL-Standard-E", label: "Standard - FEMALE"},
                    {value:"pl-PL-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"pl-PL-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"pl-PL-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"pl-PL-Wavenet-D", label: "WaveNet - FEMALE"},
                    {value:"pl-PL-Wavenet-E", label: "WaveNet - FEMALE"}
                ],
                "pt-BR": [
                    {value:"pt-BR-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"pt-BR-Neural2-B", label: "Neural2 - MALE"},
                    {value:"pt-BR-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"pt-BR-Standard-A", label: "Standard - FEMALE"},
                    {value:"pt-BR-Standard-B", label: "Standard - MALE"},
                    {value:"pt-BR-Standard-C", label: "Standard - FEMALE"},
                    {value:"pt-BR-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"pt-BR-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"pt-BR-Wavenet-C", label: "WaveNet - FEMALE"}
                ],
                "pt-PT": [
                    {value:"pt-PT-Standard-A", label: "Standard - FEMALE"},
                    {value:"pt-PT-Standard-B", label: "Standard - MALE"},
                    {value:"pt-PT-Standard-C", label: "Standard - MALE"},
                    {value:"pt-PT-Standard-D", label: "Standard - FEMALE"},
                    {value:"pt-PT-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"pt-PT-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"pt-PT-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"pt-PT-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "pa-IN": [
                    {value:"pa-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"pa-IN-Standard-B", label: "Standard - MALE"},
                    {value:"pa-IN-Standard-C", label: "Standard - FEMALE"},
                    {value:"pa-IN-Standard-D", label: "Standard - MALE"},
                    {value:"pa-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"pa-IN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"pa-IN-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"pa-IN-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "ro-RO": [
                    {value:"ro-RO-Standard-A", label: "Standard - FEMALE"},
                    {value:"ro-RO-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "ru-RU": [
                    {value:"ru-RU-Standard-A", label: "Standard - FEMALE"},
                    {value:"ru-RU-Standard-B", label: "Standard - MALE"},
                    {value:"ru-RU-Standard-C", label: "Standard - FEMALE"},
                    {value:"ru-RU-Standard-D", label: "Standard - MALE"},
                    {value:"ru-RU-Standard-E", label: "Standard - FEMALE"},
                    {value:"ru-RU-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ru-RU-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"ru-RU-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"ru-RU-Wavenet-D", label: "WaveNet - MALE"},
                    {value:"ru-RU-Wavenet-E", label: "WaveNet - FEMALE"}
                ],
                "sr-RS": [
                    {value:"sr-RS-Standard-A", label: "Standard - FEMALE"}
                ],
                "sk-SK": [
                    {value:"sk-SK-Standard-A", label: "Standard - FEMALE"},
                    {value:"sk-SK-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "es-ES": [
                    {value:"es-ES-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"es-ES-Neural2-B", label: "Neural2 - MALE"},
                    {value:"es-ES-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"es-ES-Neural2-D", label: "Neural2 - FEMALE"},
                    {value:"es-ES-Neural2-E", label: "Neural2 - FEMALE"},
                    {value:"es-ES-Neural2-F", label: "Neural2 - MALE"},
                    {value:"es-ES-Polyglot-1", label: "Standard - MALE"},
                    {value:"es-ES-Standard-A", label: "Standard - FEMALE"},
                    {value:"es-ES-Standard-B", label: "Standard - MALE"},
                    {value:"es-ES-Standard-C", label: "Standard - FEMALE"},
                    {value:"es-ES-Standard-D", label: "Standard - FEMALE"},
                    {value:"es-ES-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"es-ES-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"es-ES-Wavenet-D", label: "WaveNet - FEMALE"}
                ],
                "es-US": [
                    {value:"es-US-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"es-US-Neural2-B", label: "Neural2 - MALE"},
                    {value:"es-US-Neural2-C", label: "Neural2 - MALE"},
                    {value:"es-US-News-D", label: "WaveNet - MALE"},
                    {value:"es-US-News-E", label: "WaveNet - MALE"},
                    {value:"es-US-News-F", label: "WaveNet - FEMALE"},
                    {value:"es-US-News-G", label: "WaveNet - FEMALE"},
                    {value:"es-US-Polyglot-1", label: "Standard - MALE"},
                    {value:"es-US-Standard-A", label: "Standard - FEMALE"},
                    {value:"es-US-Standard-B", label: "Standard - MALE"},
                    {value:"es-US-Standard-C", label: "Standard - MALE"},
                    {value:"es-US-Studio-B", label: "Studio - MALE"},
                    {value:"es-US-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"es-US-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"es-US-Wavenet-C", label: "WaveNet - MALE"}
                ],
                "sv-SE": [
                    {value:"sv-SE-Standard-A", label: "Standard - FEMALE"},
                    {value:"sv-SE-Standard-B", label: "Standard - FEMALE"},
                    {value:"sv-SE-Standard-C", label: "Standard - FEMALE"},
                    {value:"sv-SE-Standard-D", label: "Standard - MALE"},
                    {value:"sv-SE-Standard-E", label: "Standard - MALE"},
                    {value:"sv-SE-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"sv-SE-Wavenet-B", label: "WaveNet - FEMALE"},
                    {value:"sv-SE-Wavenet-C", label: "WaveNet - MALE"},
                    {value:"sv-SE-Wavenet-D", label: "WaveNet - FEMALE"},
                    {value:"sv-SE-Wavenet-E", label: "WaveNet - MALE"}
                ],
                "ta-IN": [
                    {value:"ta-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"ta-IN-Standard-B", label: "Standard - MALE"},
                    {value:"ta-IN-Standard-C", label: "Standard - FEMALE"},
                    {value:"ta-IN-Standard-D", label: "Standard - MALE"},
                    {value:"ta-IN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"ta-IN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"ta-IN-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"ta-IN-Wavenet-D", label: "WaveNet - MALE"}
                ],
                "te-IN": [
                    {value:"-IN-Standard-A", label: "Standard - FEMALE"},
                    {value:"-IN-Standard-B", label: "Standard - MALE"}
                ],
                "th-TH": [
                    {value:"th-TH-Neural2-C", label: "Neural2 - FEMALE"},
                    {value:"th-TH-Standard-A", label: "Standard - FEMALE"}
                ],
                "tr-TR": [
                    {value:"tr-TR-Standard-A", label: "Standard - FEMALE"},
                    {value:"tr-TR-Standard-B", label: "Standard - MALE"},
                    {value:"tr-TR-Standard-C", label: "Standard - FEMALE"},
                    {value:"tr-TR-Standard-D", label: "Standard - FEMALE"},
                    {value:"tr-TR-Standard-E", label: "Standard - MALE"},
                    {value:"tr-TR-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"tr-TR-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"tr-TR-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"tr-TR-Wavenet-D", label: "WaveNet - FEMALE"},
                    {value:"tr-TR-Wavenet-E", label: "WaveNet - MALE"}
                ],
                "uk-UA": [
                    {value:"uk-UA-Standard-A", label: "Standard - FEMALE"},
                    {value:"uk-UA-Wavenet-A", label: "WaveNet - FEMALE"}
                ],
                "vi-VN": [
                    {value:"vi-VN-Neural2-A", label: "Neural2 - FEMALE"},
                    {value:"vi-VN-Neural2-D", label: "Neural2 - MALE"},
                    {value:"vi-VN-Standard-A", label: "Standard - FEMALE"},
                    {value:"vi-VN-Standard-B", label: "Standard - MALE"},
                    {value:"vi-VN-Standard-C", label: "Standard - FEMALE"},
                    {value:"vi-VN-Standard-D", label: "Standard - MALE"},
                    {value:"vi-VN-Wavenet-A", label: "WaveNet - FEMALE"},
                    {value:"vi-VN-Wavenet-B", label: "WaveNet - MALE"},
                    {value:"vi-VN-Wavenet-C", label: "WaveNet - FEMALE"},
                    {value:"vi-VN-Wavenet-D", label: "WaveNet - MALE"}
                ]
            }

            $(document).ready(function() {
                "use strict";

                populateVoiceSelect();

                $("#languages").on("change", function() {
                populateVoiceSelect();
                });

                function populateVoiceSelect() {
                const selectedLanguage = $("#languages").val();
                const selectedOptions = voicesData[selectedLanguage];
                const voiceSelect = $("#voice");

                voiceSelect.empty();

                if (selectedOptions) {
                    selectedOptions.forEach(option => {
                    $("<option></option>")
                        .val(option.value)
                        .text(option.label)
                        .appendTo(voiceSelect);
                    });
                }
                }

                $('.add-new-text').click(function() {
                    var selectedVoice = $('#voice option:selected').val();
                    var selectedLang = $('#languages option:selected').val();
                    var selectedPace = $('#pace option:selected').val();
                    var selectedBreak = $('#break option:selected').val();

                    var speechContent = `
                        <div class="speech mb-3">
                            <div class="speech-info flex items-center space-x-2 mb-2">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-world" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M3.6 9h16.8"></path>
                                        <path d="M3.6 15h16.8"></path>
                                        <path d="M11.5 3a17 17 0 0 0 0 18"></path>
                                        <path d="M12.5 3a17 17 0 0 1 0 18"></path>
                                    </svg>
                                    <span class="data-lang">${selectedLang}</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
                                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
                                    </svg>
                                    <span class="data-voice">${selectedVoice}</span>
                                </div>
                                <div>
                                    <select class="form-control form-select bg-[#fff] placeholder:text-black say-as">
                                        <option value="0" selected>{{__('say-as')}}</option>
                                        <option value="currency">{{__('currency')}}</option>
                                        <option value="telephone">{{__('telephone')}}</option>
                                        <option value="verbatim">{{__('verbatim')}}</option>
                                        <option value="date">{{__('date')}}</option>
                                        <option value="characters">{{__('characters')}}</option>
                                        <option value="cardinal">{{__('cardinal')}}</option>
                                        <option value="ordinal">{{__('ordinal')}}</option>
                                        <option value="fraction">{{__('fraction')}}</option>
                                        <option value="bleep">{{__('bleep')}}</option>
                                        <option value="unit">{{__('unit')}}</option>
                                        <option value="unit">{{__('time')}}</option>
                                    </select>
                                </div>
                                <div style="margin-left:auto">
                                    <button type="button" class="delete-speech btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="{{__('Delete')}}">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <textarea data-voice="${selectedVoice}" data-lang="${selectedLang}" data-pace="${selectedPace}" data-break="${selectedBreak}" placeholder="write something..." class="form-control bg-[#fff] placeholder:text-gray" cols="30" rows="2"></textarea>
                        </div>
                    `;

                    $('.speeches').append(speechContent);
                });

                $(document).on('click', '.delete-speech', function() {
                    $(this).closest('.speech').remove();
                });

                $(document).on('change', '.say-as', function() {
                    var selectedValue = $(this).val();
                    if ( selectedValue === 'currency' ){
                        selectedValue = "<say-as interpret-as='currency' language='en-US'>$42.01</say-as>";
                    } else if ( selectedValue === 'telephone' ){
                        selectedValue = "<say-as interpret-as='telephone' google:style='zero-as-zero'>1800-202-1212</say-as>";
                    } else if ( selectedValue === 'verbatim' ){
                        selectedValue = "<say-as interpret-as='verbatim'>abcdefg</say-as>";
                    } else if ( selectedValue === 'date' ){
                        selectedValue = "<say-as interpret-as='date' format='yyyymmdd' detail='1'>1960-09-10</say-as>";
                    } else if ( selectedValue === 'characters' ){
                        selectedValue = "<say-as interpret-as='characters'>can</say-as>";
                    } else if ( selectedValue === 'cardinal' ){
                        selectedValue = "<say-as interpret-as='cardinal'>12345</say-as>";
                    } else if ( selectedValue === 'ordinal' ){
                        selectedValue = "<say-as interpret-as='ordinal'>1</say-as>";
                    } else if ( selectedValue === 'fraction' ){
                        selectedValue = "<say-as interpret-as='fraction'>5+1/2</say-as>";
                    } else if ( selectedValue === 'bleep' ){
                        selectedValue = "<say-as interpret-as='expletive'>censor this</say-as>";
                    } else if ( selectedValue === 'unit' ){
                        selectedValue = "<say-as interpret-as='unit'>10 foot</say-as>";
                    } else if ( selectedValue === 'time' ){
                        selectedValue = "<say-as interpret-as='time' format='hms12'>2:30pm</say-as>";
                    }
                    var textarea = $(this).closest('.speech').find('textarea');
                    var existingValue = textarea.val();
                    textarea.val(existingValue + selectedValue);
                    $(this).val('0');
                });

            });


        </script>
    @endif

    @if($openai->type == 'code')
        <link rel="stylesheet" href="/assets/libs/prism/prism.css">
        <script src="/assets/libs/prism/prism.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
				"use strict";

                const codeLang = document.querySelector('#code_lang');
                const codePre = document.querySelector('#code-pre');
                const codeOutput = codePre?.querySelector('#code-output');

                if (!codeOutput) return;

                codePre.classList.add(`language-${codeLang && codeLang.value !== '' ? codeLang.value : 'javascript'}`);

                // saving for copy
                window.codeRaw = codeOutput.innerText;

                Prism.highlightElement(codeOutput);
            });
        </script>
    @endif

    <script>
        function sendOpenaiGeneratorForm(ev) {
			"use strict";

			ev?.preventDefault();
			ev?.stopPropagation();
            document.getElementById("openai_generator_button").disabled = true;
            document.getElementById("openai_generator_button").innerHTML = "Please Wait";
			document.querySelector('#app-loading-indicator')?.classList?.remove('opacity-0');

            var formData = new FormData();
            formData.append('post_type', '{{$openai->slug}}');
            formData.append('openai_id', {{$openai->id}});
            formData.append('custom_template', {{$openai->custom_template}});
            @if($openai->type == 'text')
            formData.append('maximum_length', $("#maximum_length").val());
            formData.append('number_of_results', $("#number_of_results").val());
            formData.append('creativity', $("#creativity").val());
            formData.append('tone_of_voice', $("#tone_of_voice").val());
            formData.append('language', $("#language").val());
            @endif
            @if($openai->type == 'audio')
            formData.append('file', $('#file').prop('files')[0]);
            @endif

            @if($openai->type == 'image')
            formData.append('image_style', $("#image_style").val());
            formData.append('image_lighting', $("#image_lighting").val());
            formData.append('image_mood', $("#image_mood").val());
            formData.append('image_number_of_images', $("#image_number_of_images").val());
            @endif

            @foreach(json_decode($openai->questions) as $question)
            formData.append('{{$question->name}}', $("{{'#'.$question->name}}").val());
            @endforeach

            $.ajax({
                type: "post",
                url: "/dashboard/user/openai/generate",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    toastr.success('Generated Successfully!');
                    setTimeout(function () {
                        @if($openai->type == 'image')
                        $("#generator_sidebar_table").html(data.html2);
                        setTimeout(function (){

                            window.refreshFsLightbox();

                        }, 500);

                        @elseif($openai->type == 'audio')
                        $("#generator_sidebar_table").html(data.html2);
                        @else
                        if ( $("#code-output").length ) {
                            $("#workbook_textarea").html(data.html2);
                            window.codeRaw = $("#code-output").text();
                            $("#code-output").addClass(`language-${$('#code_lang').val() || 'javascript'}`);
                            Prism.highlightElement($("#code-output")[0]);
                        } else {
                            tinymce.activeEditor.destroy();
                            $("#generator_sidebar_table").html(data.html2);
                            getResult();
                        }
                        @endif

                        document.getElementById("openai_generator_button").disabled = false;
                        document.getElementById("openai_generator_button").innerHTML = "Regenerate";
						document.querySelector('#app-loading-indicator')?.classList?.add('opacity-0');
						document.querySelector('#workbook_regenerate')?.classList?.remove('hidden');
                    }, 750);
                },
                error: function (data) {
                    if ( data.responseJSON.errors ) {
						$.each(data.responseJSON.errors, function(index, value) {
							toastr.error(value);
						});
					} else if ( data.responseJSON.message ) {
						toastr.error(data.responseJSON.message);
					}
                    document.getElementById("openai_generator_button").disabled = false;
                    document.getElementById("openai_generator_button").innerHTML = "Genarate";
					document.querySelector('#app-loading-indicator')?.classList?.add('opacity-0');
					document.querySelector('#workbook_regenerate')?.classList?.add('hidden');
                }
            });
            return false;
        }
    </script>
@endsection
