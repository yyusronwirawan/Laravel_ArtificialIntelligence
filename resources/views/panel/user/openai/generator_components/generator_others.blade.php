<div class="row row-cards">
    <div class="col-sm-6 col-lg-5 lg:pr-14">
        <div class="card mb-[25px]">
            <div class="card-body">
                <h5 class="mb-3 text-[14px] font-normal">{{__('Remaining Credits')}}</h5>
                <div class="progress progress-separated mb-2">
                    @if((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images != 0)
                        <div class="progress-bar grow-0 shrink-0 basis-auto bg-primary" role="progressbar"
                             style="width: {{(int)Auth::user()->remaining_words/((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images)*100}}%"
                             aria-label="{{__('Text')}}"></div>
                    @endif
                    @if((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images != 0)
                        <div class="progress-bar grow-0 shrink-0 basis-auto bg-[#9E9EFF]" role="progressbar"
                             style="width: {{(int)Auth::user()->remaining_images/((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images)*100}}%"
                             aria-label="{{__('Images')}}"></div>
                    @endif
                </div>
                <div class="flex justify-between flex-wrap">
                    <div class="d-flex align-items-center">
                        <span class="legend !me-2 rounded-full bg-primary"></span>
                        <span>{{__('Words')}}</span>
                        <span class="ms-2 text-heading font-medium">
                            @if(Auth::user()->remaining_words == -1)
                                Unlimited
                            @else
                                {{number_format((int)Auth::user()->remaining_words)}}
                            @endif
                        </span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="legend !me-2 rounded-full bg-[#9E9EFF]"></span>
                        <span>{{__('Images')}}</span>
                        <span class="ms-2 text-heading font-medium">
                            @if(Auth::user()->remaining_images == -1)
                                Unlimited
                            @else
                                {{number_format((int)Auth::user()->remaining_images)}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($openai->type != 'image')
            <form id="openai_generator_form" onsubmit="return sendOpenaiGeneratorForm();" enctype="multipart/form-data">

                @foreach(json_decode($openai->questions) as $question)
                    <div class="mb-[20px]">
                        @if($question->type == 'text')
                            <label class="form-label">{{$question->question}}</label>
                            <input type="{{$question->type}}" class="form-control" id="{{$question->name}}"
                                   name="{{$question->name}}" placeholder="{{$question->question}}"
                                   required="required">
                        @elseif($question->type == 'textarea')
                            <label class="form-label">{{$question->question}}</label>
                            <textarea class="form-control" id="{{$question->name}}"
                                      name="{{$question->name}}" rows="8"
                                      placeholder="{{$question->question}}" required="required"></textarea>
                        @elseif($question->type == 'select')
                            <div class="form-label">{{$question->question}}</div>
                            <select class="form-select" id="{{$question->name}}" name="{{$question->name}}"
                                    required="required">
                                {!! $question->select !!}
                            </select>
                        @elseif($question->type == 'file')
                            <div class="form-label">{{$question->question}}</div>
                            <input type="file" class="form-control" id="{{$question->name}}"
                                   name="{{$question->name}}" required="required">
                        @endif
                    </div>
                @endforeach

                @if($openai->type == 'text')
                    <div class="mb-[20px]">
                        <label class="form-label">{{__('Maximum Length')}}</label>
                        <input type="number" class="form-control" id="maximum_length" name="maximum_length"
                               max="{{Auth::user()->remaining_words}}"
                               placeholder="{{__('Maximum character length of text')}}" required>
                    </div>

                    <div class="mb-[20px]">
                        <label class="form-label">{{__('Creativity')}}</label>
                        <select type="text" class="form-select" name="creativity" id="creativity" required>
                            <option value="0.25" {{$setting->openai_default_creativity == 0.25 ? 'selected' : ''}}>{{__('Economic')}}</option>
                            <option value="0.5" {{$setting->openai_default_creativity == 0.5 ? 'selected' : ''}}>{{__('Average')}}</option>
                            <option value="0.75" {{$setting->openai_default_creativity == 0.75 ? 'selected' : ''}}>{{__('Good')}}</option>
                            <option value="1" {{$setting->openai_default_creativity == 1 ? 'selected' : ''}}>{{__('Premium')}}</option>
                        </select>
                    </div>

                    <div class="mb-[20px]">
                        <label class="form-label">{{__('Language')}}</label>
                        <select type="text" class="form-select" name="language" id="language" required>
                            @include('panel.user.openai.components.countries')
                        </select>
                    </div>

                    <div class="mb-[20px]">
                        <div class="form-label">{{__('Tone of Voice')}}</div>
                        <select class="form-select" id="tone_of_voice" name="tone_of_voice" required>
                            <option value="Funny">{{__('Funny')}}</option>
                            <option value="Casual">{{__('Casual')}}</option>
                            <option value="Excited">{{__('Excited')}}</option>
                            <option value="Professional" selected>{{__('Professional')}}</option>
                            <option value="Witty">{{__('Witty')}}</option>
                            <option value="Sarcastic">{{__('Sarcastic')}}</option>
                            <option value="Feminine">{{__('Feminine')}}</option>
                            <option value="Masculine">{{__('Masculine')}}</option>
                            <option value="Bold">{{__('Bold')}}</option>
                            <option value="Dramatic">{{__('Dramatic')}}</option>
                            <option value="Grumpy">{{__('Grumpy')}}</option>
                            <option value="Secretive">{{__('Secretive')}}</option>
                        </select>
                    </div>

                    <div class="mb-[20px]">
                        <label class="form-label">{{__('Number of Results')}}</label>
                        <input type="number" class="form-control" id="number_of_results"
                               name="number_of_results" value="1"
                               placeholder="{{__('Maximum character length of text')}}" required>
                    </div>
                @endif

                <button form="openai_generator_form" id="openai_generator_button"
                        class="btn btn-primary w-100 py-[0.75em]">
                    {{__('Generate')}}
                </button>
            </form>
        @endif
    </div>

    <div
        class="col-sm-6 col-lg-7 lg:pl-16 lg:border-l lg:border-solid border-t-0 border-r-0 border-b-0 border-[var(--tblr-border-color)]"
        id="generator_sidebar_table">
        @include('panel.user.openai.generator_components.generator_sidebar_table')
    </div>

</div>
