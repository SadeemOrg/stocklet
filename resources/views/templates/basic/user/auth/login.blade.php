@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('login.content', true);
        $currentLocale = app()->getLocale();
        // dd($currentLocale);
    @endphp
    <div class="section_lessPadding login-section position-relative">
        <img src="{{ getImage('assets/images/frontend/login/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-login object-cover position-absolute w-50 top-0  bottom-0 h-100  {{app()->getLocale() === 'ar' ? 'right-0 left-auto' : 'left-0 right-auto'}} d-none d-lg-flex" />
        <div class="section">
            <div class="container">
                <div class="row g-4 justify-content-start align-items-start">
                    <div class="col-lg-6 img-login d-none d-lg-flex">
                        {{-- <img src="{{ getImage('assets/images/frontend/login/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-login" /> --}}
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                        <div class="login-form">
                            <p class="FFShamel-SansOneBold xxxl--text text-dark">تسجيل
                                <span class="bg--redqr  Fcolor--red">الدخول</span>
                            </p>
                            {{-- <div
                                class="d-flex w-75 align-items-center justify-content-around FFShamel-SansOneBold fs-6 cursor-pointer pt-2 pe-auto text-dark">
                                <p class="bb--1 text-3xl font-bold underline login-form__title ">مشتري محتوى</p>
                                <p>بائع محتوى</p>
                            </div> --}}
                            <form action="{{ route('user.login') }}" class="row g-3 g-xxl-4 w-100 t-mt-15 login_Form"
                                method="post" autocomplete="off">
                                @csrf
                                <div class="col-12 loginFormP">
                                    <input type="text" class="form-control form--control "
                                        placeholder="@lang('Enter your email')" name="username" required />
                                </div>
                                <div class="col-12">
                                    <input type="password" class="form-control form--control"
                                        placeholder="@lang('Password')" name="password" required />
                                </div>
                                <x-captcha googleCaptchaClass="col-12" customCaptchaDiv="col-12" customCaptchaCode="mb-3" />
                                <div class="col-sm-6">
                                    <a href="{{ route('user.password.request') }}"
                                        class="t-link d-block text-sm-end text--base t-link--base form-label lh-1 text-dark">
                                        @lang('Forgot Password?')
                                    </a>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn--lg btn--red w-100 rounded md-text">@lang('LOGIN')</button>
                                </div>
                                <div class="col-12">
                                    <p class="m-0 sm-text text-center lh-1">
                                        @lang('Don\'t have an account?') <a href="{{ route('user.register') }}"
                                            class="t-link t-link--base text--base">@lang('Create Account')</a>
                                    </p>
                                </div>
                                @php
                                    $credentials = $general->socialite_credentials;
                                @endphp
                                @if (
                                    $credentials->google->status == Status::ENABLE ||
                                        $credentials->facebook->status == Status::ENABLE ||
                                        $credentials->linkedin->status == Status::ENABLE)
                                    <div class="col-12">
                                        <div class="d-none d-sm-flex devider-Container t-py-10">
                                            <div class="devider-fdev">
                                                <div class="devider-arrows"></div>
                                            </div>
                                            <div class="devider-text">
                                                <p class="text-center sm-text">@lang('Or Login with')</p>
                                            </div>
                                            <div class="devider-fdev">
                                                <div class="devider-arrows"></div>
                                            </div>
                                        </div>
                                        <p class="d-sm-flex d-md-none text-center sm-text">@lang('Or Login with')</p>
                                        <ul class="list list--row justify-content-center social-list">
                                            @if ($credentials->google->status == Status::ENABLE)
                                                <li><a href="{{ route('user.social.login', 'google') }}"
                                                        class="t-link social-list__icon"><i class="lab la-google"></i></a>
                                                </li>
                                            @endif
                                            @if ($credentials->facebook->status == Status::ENABLE)
                                                <li><a href="{{ route('user.social.login', 'facebook') }}"
                                                        class="t-link social-list__icon"><i
                                                            class="lab la-facebook-f"></i></a></li>
                                            @endif
                                            @if ($credentials->linkedin->status == Status::ENABLE)
                                                <li><a href="{{ route('user.social.login', 'linkedin') }}"
                                                        class="t-link social-list__icon"><i
                                                            class="lab la-linkedin-in"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.section_lessPadding .login_Form input').on('input', function() {
                adjustFontSize(this);
            });
            function adjustFontSize(element) {
                var inputText = element.value;
                var fontSize = inputText.length > 0 && /[^\x00-\x7F]/.test(inputText) ? '14px' : '18px';
                $(element).css('font-size', fontSize);
            }
        })(jQuery);
    </script>
@endpush
