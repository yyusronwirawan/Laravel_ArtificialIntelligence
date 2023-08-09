@extends('panel.layout.app')
@section('title', 'Frontend Section Settings')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
                    <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to dashboard')}}
                    </a>
                    <h2 class="page-title mb-2">
                        {{__('Frontend Section Settings')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            <div class="row col-md-5 mx-auto">
                <form id="settings_form" onsubmit="return frontendSectionSettingsSave();" enctype="multipart/form-data">
                    <div class="row">
                    <h3 class="mb-[25px] text-[20px]">{{__('Features Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Features Section Active')}}</label>
                                <select class="form-select" name="features_active" id="features_active">
                                    <option value="1" {{$fSectSettings->features_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->features_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Features Title')}}</label>
                                <input type="text" class="form-control" id="features_title" name="features_title" value="{{$fSectSettings->features_title}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Features Description')}}</label>
                                <textarea class="form-control" id="features_description" name="features_description">{{$fSectSettings->features_description}}</textarea>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('Generators Section')}}</h3>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Generators Active')}}</label>
                                <select class="form-select" name="generators_active" id="generators_active">
                                    <option value="1" {{$fSectSettings->generators_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->generators_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="mb-[25px] text-[20px]">{{__('For Who Section')}}</h3>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('For Who Section Active')}}</label>
                                <select class="form-select" name="who_is_for_active" id="who_is_for_active">
                                    <option value="1" {{$fSectSettings->who_is_for_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->who_is_for_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('Custom Templates Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Custom Templates Active')}}</label>
                                <select class="form-select" name="custom_templates_active" id="custom_templates_active">
                                    <option value="1" {{$fSectSettings->custom_templates_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->custom_templates_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Custom Templates Subtitle One')}}</label>
                                <input type="text" class="form-control" id="custom_templates_subtitle_one" name="custom_templates_subtitle_one" value="{{$fSectSettings->custom_templates_subtitle_one}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Custom Templates Subtitle Two')}}</label>
                                <input type="text" class="form-control" id="custom_templates_subtitle_two" name="custom_templates_subtitle_two" value="{{$fSectSettings->custom_templates_subtitle_two}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Custom Templates Title')}}</label>
                                <input type="text" class="form-control" id="custom_templates_title" name="custom_templates_title" value="{{$fSectSettings->custom_templates_title}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Custom Templates Description')}}</label>
                                <textarea class="form-control" id="custom_templates_description" name="custom_templates_description">{{$fSectSettings->custom_templates_description}}</textarea>
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('Tools Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Tools Active')}}</label>
                                <select class="form-select" name="tools_active" id="tools_active">
                                    <option value="1" {{$fSectSettings->tools_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->tools_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Tools Title')}}</label>
                                <input type="text" class="form-control" id="tools_title" name="tools_title" value="{{$fSectSettings->tools_title}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Tools Description')}}</label>
                                <textarea class="form-control" id="tools_description" name="tools_description">{{$fSectSettings->tools_description}}</textarea>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('How It Works Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('How It Works Active')}}</label>
                                <select class="form-select" name="how_it_works_active" id="how_it_works_active">
                                    <option value="1" {{$fSectSettings->how_it_works_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->how_it_works_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('How It Works Title')}}</label>
                                <input type="text" class="form-control" id="how_it_works_title" name="how_it_works_title" value="{{$fSectSettings->how_it_works_title}}">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('Testimonials Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Testimonials Active')}}</label>
                                <select class="form-select" name="testimonials_active" id="testimonials_active">
                                    <option value="1" {{$fSectSettings->testimonials_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->testimonials_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Testimonials Title')}}</label>
                                <input type="text" class="form-control" id="testimonials_title" name="testimonials_title" value="{{$fSectSettings->testimonials_title}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Testimonials Subtitle One')}}</label>
                                <input type="text" class="form-control" id="testimonials_subtitle_one" name="testimonials_subtitle_one" value="{{$fSectSettings->testimonials_subtitle_one}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Testimonials Subtitle Two')}}</label>
                                <input type="text" class="form-control" id="testimonials_subtitle_two" name="testimonials_subtitle_two" value="{{$fSectSettings->testimonials_subtitle_two}}">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('Pricing Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Pricing Active')}}</label>
                                <select class="form-select" name="pricing_active" id="pricing_active">
                                    <option value="1" {{$fSectSettings->pricing_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->pricing_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Pricing Title')}}</label>
                                <input type="text" class="form-control" id="pricing_title" name="pricing_title" value="{{$fSectSettings->pricing_title}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Pricing Description')}}</label>
                                <textarea class="form-control" id="pricing_description" name="pricing_description">{{$fSectSettings->pricing_description}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('Pricing Save Percent')}}</label>
                                <input type="text" class="form-control" id="pricing_save_percent" name="pricing_save_percent" value="{{$fSectSettings->pricing_save_percent}}">
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <h3 class="mb-[25px] text-[20px]">{{__('FAQ Section')}}</h3>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('FAQ Active')}}</label>
                                <select class="form-select" name="faq_active" id="faq_active">
                                    <option value="1" {{$fSectSettings->faq_active == 1 ? 'selected' : ''}}>{{__('Active')}}</option>
                                    <option value="0" {{$fSectSettings->faq_active == 0 ? 'selected' : ''}}>{{__('Passive')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('FAQ Title')}}</label>
                                <input type="text" class="form-control" id="faq_title" name="faq_title" value="{{$fSectSettings->faq_title}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('FAQ Subtitle')}}</label>
                                <input type="text" class="form-control" id="faq_subtitle" name="faq_subtitle" value="{{$fSectSettings->faq_subtitle}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('FAQ Text One')}}</label>
                                <input type="text" class="form-control" id="faq_text_one" name="faq_text_one" value="{{$fSectSettings->faq_text_one}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">{{__('FAQ Text Two')}}</label>
                                <input type="text" class="form-control" id="faq_text_two" name="faq_text_two" value="{{$fSectSettings->faq_text_two}}">
                            </div>
                        </div>

                    </div>


                    <button form="settings_form" id="settings_button" class="btn btn-primary w-100">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/settings.js"></script>
@endsection
