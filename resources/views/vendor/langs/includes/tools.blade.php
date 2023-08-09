<div class="row">

    <div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200 mb-4">
        {{__('If you have previously created or edited a language file (JSON), the Generate process will overwrite those files. Take a backup before process.')}}
    </div>

    <div class="flex justify-between mb-4">
        <a href="{{route('amamarul.translations.home')}}" class="btn btn-default flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M3.6 9h16.8"></path><path d="M3.6 15h16.8"></path><path d="M11.5 3a17 17 0 0 0 0 18"></path><path d="M12.5 3a17 17 0 0 1 0 18"></path></svg>
            {{__('All Locations')}}
        </a>
        <a href="{{route('amamarul.translations.lang.publishAll')}}" class="btn btn-primary flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8"></path><path d="M3 10h18"></path><path d="M10 3v18"></path><path d="M16 22l5 -5"></path><path d="M21 21.5v-4.5h-4.5"></path></svg>
            {{__('Publish All Json Files')}}
        </a>

        <a href="{{route('amamarul.translations.lang.reinstall')}}" class="btn btn-danger flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                <path d="M7 11l5 5l5 -5"></path>
                <path d="M12 4l0 12"></path>
            </svg>
            {{__('Reinstall Locations')}}
        </a>
    </div>

    <div class="col-12 mb-3">
        <form action="{{route('amamarul.translations.lang.search')}}" class="relative" method="GET">
            <input type="text" class="form-control rounded-full" name="search" id="new-search" placeholder="{{__('Search')}}">
            <button type="submit" class='absolute top-1.5 right-1.5 btn btn-success btn-block flex space-x-2'>
                {{__('Search')}}
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
            </button>
        </form>
    </div>

    <div class="col-6">
        <form action="{{route('amamarul.translations.lang.newString')}}" class="relative" method="GET" onSubmit="if(!confirm('{{__('Are you sure you want to create a new string?')}}')){return false;}">
            <input type="text" class="form-control rounded-full" name="newString" id="new-string" placeholder="{{__('Ex. Hello')}}">
            <button type="submit" class='btn btn-success btn-block absolute top-1.5 right-1.5 flex space-x-2'>
            {{__('New String')}}
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M19 8h-14"></path><path d="M5 12h9"></path><path d="M11 16h-6"></path><path d="M15 16h6"></path><path d="M18 13v6"></path></svg>
            </button>
        </form>
    </div>

    <div class="col-6">
        <form action="{{route('amamarul.translations.lang.newLang')}}" class="relative" method="GET" onSubmit="if(!confirm('{{__('Are you sure you want to create a new language?')}}')){return false;}">
            <input type="text" class="form-control rounded-full" name="newLang" id="new-lang" placeholder="{{__('lang code Ex. es')}}">
            <button type="submit" class='btn btn-success btn-block absolute top-1.5 right-1.5 flex space-x-2'>
            {{__('New Language')}}
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 5h7"></path><path d="M9 3v2c0 4.418 -2.239 8 -5 8"></path><path d="M5 9c0 2.144 2.952 3.908 6.7 4"></path><path d="M12 20l4 -9l4 9"></path><path d="M19.1 18h-6.2"></path></svg>
            </button>
        </form>
    </div>

    <div class="col-12 mt-4 mb-4">
        <hr>
    </div>
</div>
