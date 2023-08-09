@extends('panel.layout.app')
@section('title', 'Workbook')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<div class="page-pretitle">
						{{__('Edit your generations.')}}
					</div>
					<h2 class="page-title mb-2">
						{{__('Workbook')}}
					</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6 max-md:pt-3">
        <div class="container-xl">
			<div class="row">
				<div class="col-12"></div>
				<div class="col-lg-8 mx-auto">
					@if($workbook->generator->type == 'code')
					<div>
					@else
					<div class="border-solid border-t border-r-0 border-b-0 border-l-0 border-[var(--tblr-border-color)] pt-[30px] mt-[15px] max-lg:mt-0 max-lg:pt-0 max-lg:border-t-0">
					@endif
					@include('panel.user.openai.documents_workbook_textarea')
					</div>
				</div>
			</div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/libs/tinymce/tinymce.min.js" defer></script>
    <script src="/assets/js/panel/workbook.js"></script>

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
@endsection
