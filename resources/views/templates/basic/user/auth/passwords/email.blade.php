@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('reset_Password.content', true);
    @endphp
    {{-- @include($activeTemplate . 'partials.breadcrumb') --}}
    <div class="section_lessPadding login-section position-relative">
        <img src="{{ getImage('assets/images/frontend/reset_Password/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-login object-cover position-absolute w-50 top-0  bottom-0 h-100  {{app()->getLocale() === 'ar' ? 'right-0 left-auto' : 'left-0 right-auto'}} d-none d-lg-flex" />
        <div class="section">
            <div class="container">
                <div class="row g-4 justify-content-start align-items-center">
                    <div class="col-lg-6 img-login d-none d-lg-flex">
                        {{-- <img src="{{ getImage('assets/images/frontend/reset_Password/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-login" /> --}}
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                        <div class="login-form">
                            <p class="FFShamel-SansOneBold xxxl--text text-dark">نسيان
                                <span class="bg--redqr  Fcolor--red">كلمة المرور</span>
                            </p>
                            <form method="POST" class="login_Form align-items-center d-flex flex-column w-100 justify-content-center" action="{{ route('user.password.email') }}">
                                @csrf
                                <div class="col-md-11 t-mt-10">
                                    <input type="text" class="form-control form--control" placeholder="@lang('Email or Username')" name="value" value="{{ old('value') }}" required autofocus="off">
                                </div>
                                <div class="col-11 t-mt-15 d-flex align-items-center justify-content-center" >
                                    <button type="submit" class="btn btn--lg t-pt-15 btn--red w-100 rounded--md">@lang('Reset Password')</button>
                                </div>
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
