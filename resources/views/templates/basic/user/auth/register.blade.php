@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('register.content', true);
        $policyPages = getContent('policy_pages.element', false, null, true);
    @endphp
    <div class="section_lessPadding login-section position-relative">
        <img src="{{ getImage('assets/images/frontend/register/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-register object-cover position-absolute w-50 top-0  bottom-0 h-100  {{app()->getLocale() === 'ar' ? 'right-0 left-auto' : 'left-0 right-auto'}} d-none d-lg-flex" />
        <div class="section">
            <div class="container">
                <div class="row g-4 justify-content-start align-items-center">
                    <div class="col-lg-6  img-login d-none d-lg-flex">
                        {{-- <img src="{{ getImage('assets/images/frontend/register/' . @$content->data_values->image, '690x550') }}"
                            alt="@lang('images')" class="img-fluid img-register " /> --}}
                    </div>
                    <div class="col-lg-6">
                        <div class="login-form">
                            <p class="FFShamel-SansOneBold xxxl--text text-dark">انشاء
                                <span class="color--red">حساب جديد</span>
                            </p>
                            {{-- <div
                                class="d-flex w-75 align-items-center justify-content-around FFShamel-SansOneBold fs-6 cursor-pointer pt-2 pe-auto text-dark">
                                <p class="bb--1 text-3xl font-bold underline login-form__title ">مشتري محتوى</p>
                                <p>بائع محتوى</p>
                            </div> --}}
                            <form action="{{ route('user.register') }}"
                                class="row g-3 g-xxl-4 w-100 t-mt-15 FFShamel-SansOneBold login_Form" method="post"
                                autocomplete="off">
                                @csrf
                                @if (session()->has('reference'))
                                    <div class="col-md-12">
                                        <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                        <input type="text" name="referBy" id="referenceBy"
                                            class="form-control form--control" value="{{ session()->get('reference') }}"
                                            readonly>
                                    </div>
                                @endif
                                <div class="col-md-11">
                                    <input type="text" class="form-control form--control checkUser" name="username"
                                        value="{{ old('username') }}" placeholder="@lang('Username')" required>
                                    <small class="text--danger usernameExist"></small>
                                </div>
                                <div class="col-md-11">
                                    <input type="email" class="form-control form--control checkUser" name="email"
                                        value="{{ old('email') }}" placeholder="@lang('E-Mail Address')" required>
                                </div>
                                <div class="col-md-11">
                                    <div class="form--select">
                                        <select name="country" class="form-select" style="font-size: 13px;">
                                            <option value="" disabled selected>@lang('choose country')</option>
                                            @foreach ($countries as $key => $country)
                                                <option class="xsm-text t-pt-5" data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $country->country }}" data-code="{{ $key }}">
                                                    {{ __($country->country) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-11 mobileNumber">
                                    <input type="number" name="mobile"
                                        style="font-size: 13px; font-weight: 200 color:black;    "
                                        placeholder="@lang('Mobile')" value="{{ old('mobile') }}"
                                        class="form-control form--control checkUser" required>
                                    <small class="text--danger mobileExist"></small>
                                </div>

                                <div class="col-md-11">
                                    <div class="form-group">
                                        <input type="password" placeholder="@lang('Password')"
                                            class="form-control form--control" name="password" required>
                                        @if ($general->secure_password)
                                            <div class="input-popup">
                                                <p class="error lower">@lang('1 small letter minimum')</p>
                                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                                <p class="error number">@lang('1 number minimum')</p>
                                                <p class="error special">@lang('1 special character minimum')</p>
                                                <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        {{-- <label class="form-label">@lang('Confirm Password')</label> --}}
                                        <input type="password" placeholder="@lang('Confirm Password')"
                                            class="form-control form--control" name="password_confirmation" required>
                                    </div>
                                </div>
                                <x-captcha googleCaptchaClass="col-12" customCaptchaDiv="col-12" customCaptchaCode="mb-3" />
                                <div class="col-md-11">
                                    <button class="btn btn--lg btn--red w-100 rounded md-text">@lang('REGISTER')</button>
                                </div>

                                <div class="col-12">
                                    <p class="m-0 sm-text text-center lh-1">
                                        @lang('Already have an account?') <a href="{{ route('user.login') }}"
                                            class="t-link t-link--base text--base">@lang('Login Now')</a>
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

@push('modal')
    <div class="modal custom--modal fade" id="existModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="text-center text--danger">@lang('You already have an account, please Login')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn--sm"
                        data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn--sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endpush

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
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

@push('style')
    <style>
        .input-group-text.mobile-code {
            padding: 0 5px;
        }
    </style>
@endpush
