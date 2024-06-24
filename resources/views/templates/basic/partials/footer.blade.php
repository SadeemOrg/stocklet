@php
    $content = getContent('footer.content', true);
    $socialIcons = getContent('social_icon.element', false, 4, true);
    $policies = getContent('policy_pages.element', false, 5, true);
    $categories = App\Models\Category::active()
        ->limit(5)
        ->get();
@endphp
@include($activeTemplate . 'partials.cookie')
<footer class="footer">
    <div class="section">
        <div class="container">
            <div class="row g-4 justify-content-xl-between">
                <div class="col-md-6 col-lg-3">
                    {{-- <h4 class="mt-0 text--white">{{ __(@$content->data_values->title) }}</h4> --}}
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')" class="img-fluid logo__is footer-logo mb-4" />
                    <p class="text--white FFShamel-SansOneBook">
                        {{ __(@$content->data_values->description) }}
                    </p>
                </div>
                <div class="col-md-6 col-lg-3 col-xl-2">
                    <h4 class="mt-0 text--white">@lang('Explore')</h4>
                    <ul class="list" style="--gap: 0.5rem">
                        <li>
                            <a href="{{ route('members') }}" class="t-link FFShamel-SansOneBook t-link--base text--white d-inline-block sm-text">
                                @lang('Members')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('collections') }}" class="t-link FFShamel-SansOneBook t-link--base text--white d-inline-block sm-text">
                                @lang('Collections')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('images', ['scope' => 'premium']) }}" class="t-link FFShamel-SansOneBook t-link--base text--white d-inline-block sm-text">
                                @lang('Premium')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('images', ['scope' => 'featured']) }}" class="t-link FFShamel-SansOneBook t-link--base text--white d-inline-block sm-text">
                                @lang('Featured')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('images', ['scope' => 'popular']) }}" class="t-link FFShamel-SansOneBook t-link--base text--white d-inline-block sm-text">
                                @lang('Popular')
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3 col-xl-2">
                    <h4 class="mt-0 text--white">@lang('Categories')</h4>
                    <ul class="list" style="--gap: 0.5rem">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('search', ['type' => 'image', 'category' => $category->slug]) }}" class="t-link t-link--base text--white d-inline-block sm-text FFShamel-SansOneBook">
                                    {{ __($category->name) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3 col-xl-2">
                    <h4 class="mt-0 text--white">@lang('Useful Links')</h4>
                    <ul class="list" style="--gap: 0.5rem">
                        @foreach ($policies as $policy)
                            <li>
                                <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" class="t-link t-link--base text--white d-inline-block sm-text FFShamel-SansOneBook">
                                    {{ __($policy->data_values->title) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div>

        <div class="container border-top pt-4 pb-4 pb-md-5">
            <div class="row">
                <div class="col-md-6 mb-md-0 mb-4">
                    <ul class="list list--row social-list justify-content-center justify-content-md-start gap-5">
                        @foreach ($socialIcons as $social)
                            <li>
                                <a href="{{ $social->data_values->url }}" class="t-link social-list__icon Shamel-SansOneBook-font text-white sm-text" target="_blank">

                                    {{$social->data_values->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="">
                        <p class="mb-0 sm-text text--white text-center text-md-start">

                            {{-- @lang('Copyright') --}}
                             <span>&copy;</span>  @lang('All Rights Reserved By')
                            @
                            <a href="{{ route('home') }}" class="t-link text-white">{{ date('Y') }} {{ __($general->site_name) }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
