@extends($activeTemplate . 'layouts.frontend')
@section('content')
    {{-- @include($activeTemplate . 'partials.breadcrumb') --}}

    @php
        $content = getContent('verfication_code.content', true);
    @endphp

    <div class="section_lessPadding login-section position-relative">
        <img src="{{ getImage('assets/images/frontend/verfication_code/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-login object-cover position-absolute w-50 top-0  bottom-0 h-100  {{app()->getLocale() === 'ar' ? 'right-0 left-auto' : 'left-0 right-auto'}} d-none d-lg-flex" />
        <div class="section">
            <div class="container">
                <div class="row g-4 justify-content-start align-items-center">
                    <div class="col-lg-6 img-login d-none d-lg-flex">
                        {{-- <img src="{{ getImage('assets/images/frontend/verfication_code/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-login" /> --}}
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                        <div class="login-form">
                            <p class="FFShamel-SansOneBold xxxl--text text-dark">نسيان
                                <span class="bg--redqr  Fcolor--red">كلمة المرور</span>
                            </p>
                            <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="verification-text">@lang('A 6 digit verification code sent to your email address') : <span class="t-pr-5"
                                        style="font-size: 24px; font-weight: 600;"> {{ showEmailAddress($email) }}</span>
                                </p>
                                <input type="hidden" name="email" value="{{ $email }}">

                                @include($activeTemplate . 'partials.verification_code')

                                <div class="col-12 t-mt-15 d-flex align-items-center justify-content-center">
                                    <button type="submit"
                                        class="btn btn--lg t-pt-15 btn--red w-100 rounded--md">@lang('Submit')</button>
                                </div>
                                <div class="col-12 t-mt-10">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    </br>
                                    <a class="t-link t-link--base text--base"
                                        href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
