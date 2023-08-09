<!-- Start image generator -->
@if($openai->type == 'image')
    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card bg-[#F3E2FD] !shadow-sm dark:bg-[#14171C] dark:shadow-black">
                <div class="card-body md:p-10">
                    <div class="row">
                        <label for="description" class="h2 mb-3">{{__('Explain your idea')}}. | <a onclick="return fillAnExample();" class="text-success" href="">{{__('Generate example prompt')}}</a> </label>
                        <form id="openai_generator_form" onsubmit="return sendOpenaiGeneratorForm();">
                            <div class="relative mb-3">
                                @php
                                    $placeholders = [
                                        'Cityscape at sunset in retro vector illustration ',
                                        'Painting of a flower vase on a kitchen table with a window in the backdrop.',
                                        'Memphis style painting of a flower vase on a kitchen table with a window in the backdrop.',
                                        'Illustration of a cat sitting on a couch in a living room with a coffee mug in its hand.',
                                        'Delicious pizza with all the toppings.'];
                                @endphp
                                @foreach(json_decode($openai->questions) as $question)
                                    @if($question->type == 'textarea')
                                        <input class="image-input-for-fillanexample form-control bg-[#fff] rounded-full h-[53px] text-[#000] !shadow-sm placeholder:text-black placeholder:text-opacity-50 focus:bg-white focus:border-white dark:!border-none dark:!bg-[--lqd-header-search-bg] dark:focus:!bg-[--lqd-header-search-bg] dark:placeholder:text-[#a5a9b1]" type="text" id="{{$question->name}}" name="{{$question->name}}" placeholder="{{$placeholders[array_rand($placeholders)]}}">
                                    @endif
                                @endforeach
                                <button id="openai_generator_button" class="btn btn-primary h-[36px] absolute top-1/2 end-[1rem] -translate-y-1/2 hover:-translate-y-1/2 hover:scale-110 max-lg:relative max-lg:top-auto max-lg:right-auto max-lg:translate-y-0 max-lg:w-full max-lg:mt-2" type="submit">
                                    {{__('Generate')}}
                                    <svg class="!ms-2 rtl:-scale-x-100 translate-x-0 translate-y-0" width="14" height="13" viewBox="0 0 14 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.25 13L6.09219 11.8625L10.6422 7.3125H0.75V5.6875H10.6422L6.09219 1.1375L7.25 0L13.75 6.5L7.25 13Z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-wrap justify-between">
                                <a href="#advanced-settings" class="flex items-center text-[11px] font-semibold text-heading hover:no-underline group collapsed" data-bs-toggle="collapse" data-bs-auto-close="false">
                                    {{__('Advanced Settings')}}
                                    <span class="inline-flex items-center justify-center w-[36px] h-[36px] p-0 !ms-2 bg-white !shadow-sm rounded-full dark:!bg-[--tblr-bg-surface]">
										<svg class="hidden group-[&.collapsed]:block" width="12" height="12" viewBox="0 0 12 12" fill="var(--lqd-heading-color)" xmlns="http://www.w3.org/2000/svg">
											<path d="M6.76708 5.464H11.1451V7.026H6.76708V11.558H5.18308V7.026H0.805078V5.464H5.18308V0.909999H6.76708V5.464Z"/>
										</svg>
										<svg class="block group-[&.collapsed]:hidden" width="6" height="2" viewBox="0 0 6 2" fill="var(--lqd-heading-color)" xmlns="http://www.w3.org/2000/svg">
											<path d="M0.335078 1.962V0.246H5.65908V1.962H0.335078Z"/>
										</svg>
									</span>
                                </a>

                                <div class="max-sm:-order-1 max-sm:mb-4 max-sm:w-full">
                                    <div class="flex justify-between flex-wrap mb-2">
                                        <div class="flex items-center mr-3">
                                            <span class="legend !me-2 rounded-full bg-primary" style="--tblr-legend-size:0.5rem;"></span>
                                            <span>{{__('Words')}}</span>
                                            <span class="ms-2 text-heading font-medium">
                                                @if(Auth::user()->remaining_words == -1)
                                                    Unlimited
                                                @else
                                                    {{number_format((int)Auth::user()->remaining_words)}}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="legend !me-2 rounded-full bg-[#9E9EFF]" style="--tblr-legend-size:0.5rem;"></span>
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
                                    <div class="progress progress-separated h-1">
                                        @if((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images != 0)
                                            <div class="progress-bar grow-0 shrink-0 basis-auto bg-primary" role="progressbar" style="width: {{(int)Auth::user()->remaining_words/((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images)*100}}%" aria-label="{{__('Text')}}"></div>
                                        @endif
                                        @if((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images != 0)
                                            <div class="progress-bar grow-0 shrink-0 basis-auto bg-[#9E9EFF]" role="progressbar" style="width: {{(int)Auth::user()->remaining_images/((int)Auth::user()->remaining_words+(int)Auth::user()->remaining_images)*100}}%" aria-label="{{__('Images')}}"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="advanced-settings" class="collapse">
                                <div class="flex flex-wrap justify-between gap-3 mt-8">
                                    @foreach(json_decode($openai->questions) as $question)
                                        @if($question->type == 'select')
                                            <div class="grow">
                                                <label for="{{$question->name}}" class="form-label text-heading">{{__('Image resolution')}}</label>
                                                <select class="form-control form-select bg-[#fff] placeholder:text-black" name="{{$question->name}}" id="{{$question->name}}">
                                                    {!! $question->select !!}
                                                </select>
                                            </div>
                                        @endif
                                    @endforeach
                                        <div class="grow">
                                            <label for="image_style" class="form-label text-heading">{{__('Art Style')}}</label>
                                            <select name="image_style" id="image_style" class="form-control form-select bg-[#fff] placeholder:text-black">
                                                <option value="" selected="selected">{{__('None')}}</option>
                                                <option value="3d_render">{{__('3D Render')}}</option>
                                                <option value="anime">{{__('Anime')}}</option>
                                                <option value="ballpoint_pen">{{__('Ballpoint Pen Drawing')}}</option>
                                                <option value="bauhaus">{{__('Bauhaus')}}</option>
                                                <option value="cartoon">{{__('Cartoon')}}</option>
                                                <option value="clay">{{__('Clay')}}</option>
                                                <option value="contemporary">{{__('Contemporary')}}</option>
                                                <option value="cubism">{{__('Cubism')}}</option>
                                                <option value="cyberpunk">{{__('Cyberpunk')}}</option>
                                                <option value="glitchcore">{{__('Glitchcore')}}</option>
                                                <option value="impressionism">{{__('Impressionism')}}</option>
                                                <option value="isometric">{{__('Isometric')}}</option>
                                                <option value="line">{{__('Line Art')}}</option>
                                                <option value="low_poly">{{__('Low Poly')}}</option>
                                                <option value="minimalism">{{__('Minimalism')}}</option>
                                                <option value="modern">{{__('Modern')}}</option>
                                                <option value="origami">{{__('Origami')}}</option>
                                                <option value="pencil">{{__('Pencil Drawing')}}</option>
                                                <option value="pixel">{{__('Pixel')}}</option>
                                                <option value="pointillism">{{__('Pointillism')}}</option>
                                                <option value="pop">{{__('Pop')}}</option>
                                                <option value="realistic">{{__('Realistic')}}</option>
                                                <option value="renaissance">{{__('Renaissance')}}</option>
                                                <option value="retro">{{__('Retro')}}</option>
                                                <option value="steampunk">{{__('Steampunk')}}</option>
                                                <option value="sticker">{{__('Sticker')}}</option>
                                                <option value="ukiyo">{{__('Ukiyo')}}</option>
                                                <option value="vaporwave">{{__('Vaporwave')}}</option>
                                                <option value="vector">{{__('Vector')}}</option>
                                                <option value="watercolor">{{__('Watercolor')}}</option>
                                            </select>
                                        </div>
                                        <div class="grow">
                                            <label for="image_lighting" class="form-label text-heading">{{__('Lightning Style')}}</label>
                                            <select id="image_lighting" name="image_lighting" class="form-control form-select bg-[#fff] placeholder:text-black">
                                                <option value="" selected="selected">{{ __('None') }}</option>
                                                <option value="ambient">{{ __('Ambient') }}</option>
                                                <option value="backlight">{{ __('Backlight') }}</option>
                                                <option value="blue_hour">{{ __('Blue Hour') }}</option>
                                                <option value="cinematic">{{ __('Cinematic') }}</option>
                                                <option value="cold">{{ __('Cold') }}</option>
                                                <option value="dramatic">{{ __('Dramatic') }}</option>
                                                <option value="foggy">{{ __('Foggy') }}</option>
                                                <option value="golden_hour">{{ __('Golden Hour') }}</option>
                                                <option value="hard">{{ __('Hard') }}</option>
                                                <option value="natural">{{ __('Natural') }}</option>
                                                <option value="neon">{{ __('Neon') }}</option>
                                                <option value="studio">{{ __('Studio') }}</option>
                                                <option value="warm">{{ __('Warm') }}</option>
                                            </select>
                                        </div>
                                        <div class="grow">
                                            <label for="image_mood" class="form-label text-heading">{{__('Mood')}}</label>
                                            <select id="image_mood" name="image_mood" class="form-control form-select bg-[#fff] placeholder:text-black">
                                                <option value="" selected="selected">{{ __('None') }}</option>
                                                <option value="aggressive">{{ __('Aggressive') }}</option>
                                                <option value="angry">{{ __('Angry') }}</option>
                                                <option value="boring">{{ __('Boring') }}</option>
                                                <option value="bright">{{ __('Bright') }}</option>
                                                <option value="calm">{{ __('Calm') }}</option>
                                                <option value="cheerful">{{ __('Cheerful') }}</option>
                                                <option value="chilling">{{ __('Chilling') }}</option>
                                                <option value="colorful">{{ __('Colorful') }}</option>
                                                <option value="dark">{{ __('Dark') }}</option>
                                                <option value="neutral">{{ __('Neutral') }}</option>
                                            </select>
                                        </div>
                                        <div class="grow">
                                            <label for="image_number_of_images" class="form-label text-heading">{{__('Number of Images')}}</label>
                                            <select name="image_number_of_images" id="image_number_of_images" class="form-control form-select bg-[#fff] placeholder:text-black">
                                                <option value="1" selected="selected">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="generator_sidebar_table">
        @include('panel.user.openai.generator_components.generator_sidebar_table')
        </div>
    </div>
@endif
<!-- End image generator -->
