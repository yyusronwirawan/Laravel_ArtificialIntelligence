@extends(config('amamarul-location.layout'))
@section(config('amamarul-location.content_section'))
        @include('langs::includes.tools')
        <div class="col-md-12">

            <h2 class="text-center">{{__('Editing')}} {{__('Language')}} <code class="rounded-md px-2">{{ucfirst($lang)}} {{country2flag($lang)}}</code></h2>
            <div class="text-center flex justify-center items-center space-x-3 mt-3 mb-6">
                <div>
                    En {{country2flag('us')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 15l3 -3l-3 -3"></path><path d="M3 12h18"></path><path d="M3 9v6"></path></svg> 
                    {{ucfirst($lang)}} {{country2flag($lang)}}
                </div>
                <a href="{{route('amamarul.translations.lang.generateJson',$lang)}}" class="btn btn-default">{{__('Generate Json File')}}<svg class="ml-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8"></path><path d="M3 10h18"></path><path d="M10 3v18"></path><path d="M16 22l5 -5"></path><path d="M21 21.5v-4.5h-4.5"></path></svg></a>
            </div>
            <table class="table table-striped">
            @foreach($list as $key => $value)
                <tr>
                    <td width="10px"><input type="checkbox" name="ids_to_edit[]" value="{{$value->id}}" /></td>
                    @foreach ($value->toArray() as $key => $element)
                        @if ($key !== 'code')
                            <td class="min-w-[400px]"><a href="#" class="testEdit" data-type="textarea" data-column="code" data-url="{{url('translations/lang/update/'.$value->code)}}" data-pk="{{$value->code}}" data-title="change" data-name="{{$key}}">{{$element}}</a></td>
                        @endif
                    @endforeach
                    <td><a href="{{route('amamarul.translations.lang.string',$value->code)}}" class="btn btn-xs btn-default">
                        {{__('Show')}}
                        <svg class="ml-2" width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.76045 10.3668C7.18545 9.79279 6.83545 9.01279 6.83545 8.13779C6.83545 6.38479 8.24745 4.97179 9.99945 4.97179C10.8664 4.97179 11.6644 5.32279 12.2294 5.89679" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.1049 8.6989C12.8729 9.9889 11.8569 11.0069 10.5679 11.2409" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.65451 13.4723C3.06751 12.2263 1.72351 10.4063 0.749512 8.1373C1.73351 5.8583 3.08651 4.0283 4.68351 2.7723C6.27051 1.5163 8.10151 0.834297 9.99951 0.834297C11.9085 0.834297 13.7385 1.5263 15.3355 2.7913" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.4473 4.9908C18.1353 5.9048 18.7403 6.9598 19.2493 8.1368C17.2823 12.6938 13.8063 15.4388 9.99929 15.4388C9.13629 15.4388 8.28529 15.2988 7.46729 15.0258" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a></td>
                </tr>
            @endforeach
            </table>
        </div>
@endsection
@section(config('amamarul-location.scripts_section'))
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
$.fn.editable.defaults.mode = 'inline';
$.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M9 15l2 2l4 -4"></path></svg></button><button type="button" class="btn btn-default btn-sm editable-cancel"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M10 12l4 4m0 -4l-4 4"></path></svg></button>';
$(document).ready(function() {
    $('.testEdit').editable({
        rows: 3,
        params: function(params) {
            // add additional params from data-attributes of trigger element
            params.name = $(this).editable().data('name');
            return params;
        },
        error: function(response, newValue) {
            if(response.status === 500) {
                return 'Server error. Check entered data.';
            } else {
                return response.responseText;
                // return "Error.";
            }
        }
    });
});
</script>
@endsection
