@php
    $content = getContent('about.content', true);
    $elements = getContent('about.element', false, 4, true);
@endphp

<div class="container custom--container">
    <div class="about-section section">
        <div class="section__head-xl">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-6">
                        <h2 class="section__title text-center">
                            {{ __(@$content->data_values->title) }}
                            <span class=" Fcolor--red">{{ __(@$content->data_values->colortitle) }}</span>
                        </h2>
                        <p class="mb-0 text-center sm-text">
                            {{ __(@$content->data_values->subtitle) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <div class="list--container">
                    <ul class="list-unstyled row ">
                        @foreach ($elements as $element)
                            <li class="col-md-6 mb-4">
                                <div class="about-card">
                                    <div class="about-card__icon align-items-start">
                                        <img class="w-100 h-100 video-img"
                                            src="{{ asset('assets/images/frontend/about/' . $element->data_values->image) }}"
                                            alt="">
                                    </div>
                                    <div class="about-card__content">
                                        <h4 class="about-card__title  text-black">{{ __($element->data_values->title) }}
                                        </h4>
                                        <p class="about-card__text Shamel-SansOneBook-font font-400">
                                            {{ __($element->data_values->description) }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
