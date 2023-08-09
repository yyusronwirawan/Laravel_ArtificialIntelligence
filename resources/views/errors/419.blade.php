<!DOCTYPE html>
<html>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<title>{{__('419 Token Missmatch')}}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/frontend/css/index.css" />
<link href="/assets/css/tabler.min.css" rel="stylesheet"/>
<link href="/assets/css/magic-ai.css" rel="stylesheet"/>
<body>

<div class="page page-center page-404">
    <div class="container-tight py-4">
        <div class="empty">
            <h1 class="empty-header">419</h1>
            <p class="empty-title">{{__('Your token has been expired. Please go previous page and reload.')}}</p>
            <p class="empty-subtitle text-muted">
                If this is an error it will be logged and our technic team will resolve it shortly.
            </p>
            <div class="empty-action">
                <a href="{{route('index')}}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path><path d="M5 12l6 6"></path><path d="M5 12l6 -6"></path></svg>
                    {{__('Take me home')}}
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

