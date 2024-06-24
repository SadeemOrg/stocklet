@php
    $content = getContent('cta.content', true);
@endphp
{{-- <div class="section--sm">
    <div class="cta-section" style="background-image:url({{ getImage('assets/images/frontend/cta/'. @$content->data_values->image, '1700x700') }})">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section--xl">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="cta">
                                    <h2 class="cta__title text-md-center">
                                        {{ __(@$content->data_values->title) }}
                                    </h2>
                                    <p class="cta__text text-md-center">
                                        {{ __(@$content->data_values->subtitle) }}
                                    </p>
                                    <div class="text-md-center">
                                        <a href="{{ url(@$content->data_values->button_url) }}" class="base-btn">{{ __(@$content->data_values->button_text) }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<section class="sign-up-newsletter mb-5">
    <div class="row mx-0">
        <div class="col-lg-4 col-sm-6 px-0 ">
            <img class="img-fluid h-100 w-100 side-img"
                src="{{ asset('assets/images/newsletter/rt-img-newsletter.jpg') }}" alt="rt-img-newsletter">
        </div>
        <div class="col-lg-4 col-sm-6 px-0 d-flex align-items-center">
            <div class="cta">
                <h2 class="cta__title text-md-center">
                    {{ __(@$content->data_values->title) }}
                    <span class=" Fcolor--red">
                        {{ __(@$content->data_values->colortitle) }}
                    </span>
                </h2>
                <p class="cta__text text-md-center Shamel-SansOneBook-font">
                    {{ __(@$content->data_values->subtitle) }}
                </p>
                <div class="text-md-center">
                    <a href="{{ url(@$content->data_values->button_url) }}"
                        class="base-btn ">{{ __(@$content->data_values->button_text) }}</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 px-0 d-none d-lg-block">
            <img class="img-fluid h-100 w-100 side-img"
                src="{{ asset('assets/images/newsletter/lt-img-newsletter.jpg') }}" alt="lt-img-newsletter">
        </div>
    </div>
</section>
