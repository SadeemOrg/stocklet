@php
    $content = getContent('payment.content', true);
    $general = gs();
@endphp
@extends($activeTemplate . 'layouts.frontend', ['pageTitle' => 'payment'])
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif

    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false"
        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
        @csrf
        <section class="bg--light pb-5">
            <div class="container custom--container">
                <h3 class="m-0 py-5">اشترك بالخطة </h3>
                <div class="row">
                    <div class="col-md-8 col-lg-9 ">

                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <h4>معلومات الفواتير</h4>
                                    <p class="sm-text">سنستخدم هذه المعلومات لإصدار أول فاتورة. ستتمكن من تحديث تفاصيل
                                        الفواتير المستقبلية من الملف الشخصي لحسابك.</p>

                                    <div class="form--select mb-3">
                                        <select name="country" class="form-select form--control">
                                            <option>الدولة</option>
                                            <option data-mobile_code="01" value="1" data-code="en">مصر</option>
                                            <option data-mobile_code="01" value="1" data-code="en">فلسطين</option>
                                            <option data-mobile_code="01" value="1" data-code="en">السودان</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input class='form-control form--control' size='4' type='text'
                                            placeholder="الاسم الكامل">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 md:mb-5">
                                <h4>معلومات الدفع</h4>
                                <div class="mb-3 d-flex">
                                    <div class="form-check custom-radio ">
                                        <input class="form-check-input opacity-0" type="radio" name="payment_type"
                                            id="exampleRadios1" value="visa" checked>
                                        <label class="form-check-label position-relative" for="exampleRadios1">
                                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.7155 12.3672L12.9088 23.6105H15.7966L17.6023 12.3672H14.7155ZM23.4264 16.9471C22.4172 16.4487 21.7986 16.1124 21.7986 15.6027C21.8109 15.1392 22.3217 14.6644 23.4625 14.6644C24.4007 14.6408 25.0903 14.8613 25.6135 15.0807L25.8755 15.1977L26.2682 12.8453C25.6977 12.6248 24.7933 12.3819 23.6762 12.3819C20.8243 12.3819 18.8162 13.8646 18.8037 15.9853C18.7802 17.5502 20.2414 18.4186 21.335 18.9395C22.4522 19.4739 22.8324 19.8204 22.8324 20.2952C22.8201 21.0242 21.9291 21.3605 21.0977 21.3605C19.9458 21.3605 19.327 21.1873 18.3877 20.7811L18.0074 20.6079L17.6035 23.0525C18.2819 23.3541 19.5295 23.6195 20.8244 23.6331C23.8552 23.6331 25.8273 22.1728 25.8521 19.9127C25.862 18.6729 25.0914 17.7233 23.4264 16.9471ZM33.6718 12.402H31.4375C30.749 12.402 30.2258 12.6 29.9277 13.3065L25.638 23.6105H28.6688L29.5035 21.3797H32.8943L33.3274 23.6195H36.0005L33.6718 12.402ZM30.344 19.1283C30.4025 19.134 31.5073 15.4867 31.5073 15.4867L32.3871 19.1283C32.3871 19.1283 30.9144 19.1283 30.344 19.1283ZM10.4957 12.3672L7.66628 20.006L7.35806 18.4995C6.8349 16.7614 5.19471 14.8726 3.36426 13.9343L5.95515 23.5993H9.01071L13.5512 12.3684H10.4957V12.3672Z"
                                                    fill="#2394BC" />
                                                <path
                                                    d="M6.40578 13.817C6.18529 12.9597 5.4821 12.3815 4.52708 12.3691H0.0461469L0 12.5772C3.49544 13.4389 6.42935 16.0905 7.38116 18.5847L6.40578 13.817Z"
                                                    fill="#EFC75E" />
                                            </svg>
                                        </label>
                                    </div>
                                    {{-- <div class="form-check custom-radio">
                                        <input class="form-check-input opacity-0" type="radio" name="payment_type"
                                            id="exampleRadios2" value="paypal">
                                        <label class="form-check-label position-relative" for="exampleRadios2">
                                            <svg width="67" height="30" viewBox="0 18 67 30" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M51.7918 29.4053H48.1759C47.9632 29.4053 47.7505 29.618 47.6442 29.8307L46.1553 39.1894C46.1553 39.4021 46.2616 39.5085 46.4743 39.5085H48.3886C48.6013 39.5085 48.7077 39.4021 48.7077 39.1894L49.1331 36.5307C49.1331 36.318 49.3457 36.1053 49.6648 36.1053H50.8346C53.2807 36.1053 54.6632 34.9354 54.9823 32.5958C55.195 31.6386 54.9823 30.7878 54.5569 30.2561C53.9188 29.7243 52.9616 29.4053 51.7918 29.4053ZM52.2172 32.9148C52.0045 34.191 51.0473 34.191 50.0902 34.191H49.4521L49.8775 31.745C49.8775 31.6386 49.9838 31.5323 50.1965 31.5323H50.4092C51.0473 31.5323 51.6854 31.5323 52.0045 31.9577C52.2172 32.064 52.2172 32.3831 52.2172 32.9148Z"
                                                    fill="#139AD6"></path>
                                                <path
                                                    d="M25.7361 29.4053H22.1202C21.9075 29.4053 21.6948 29.618 21.5885 29.8307L20.0996 39.1894C20.0996 39.4021 20.206 39.5085 20.4187 39.5085H22.1202C22.3329 39.5085 22.5456 39.2958 22.652 39.0831L23.0774 36.5307C23.0774 36.318 23.2901 36.1053 23.6091 36.1053H24.779C27.225 36.1053 28.6075 34.9354 28.9266 32.5958C29.1393 31.6386 28.9266 30.7878 28.5012 30.2561C27.8631 29.7243 27.0123 29.4053 25.7361 29.4053ZM26.1615 32.9148C25.9488 34.191 24.9917 34.191 24.0345 34.191H23.5028L23.9282 31.745C23.9282 31.6386 24.0345 31.5323 24.2472 31.5323H24.4599C25.098 31.5323 25.7361 31.5323 26.0552 31.9577C26.1615 32.064 26.2679 32.3831 26.1615 32.9148Z"
                                                    fill="#263B80"></path>
                                                <path
                                                    d="M36.6901 32.8084H34.9885C34.8821 32.8084 34.6694 32.9148 34.6694 33.0211L34.5631 33.5528L34.4568 33.3401C34.0314 32.8084 33.2869 32.5957 32.4361 32.5957C30.5218 32.5957 28.8202 34.0846 28.5012 36.1052C28.2885 37.1687 28.6075 38.1259 29.1393 38.764C29.671 39.4021 30.4155 39.6148 31.3726 39.6148C32.9679 39.6148 33.8187 38.6576 33.8187 38.6576L33.7123 39.1894C33.7123 39.4021 33.8187 39.5084 34.0314 39.5084H35.6266C35.8393 39.5084 36.052 39.2957 36.1583 39.083L37.1155 33.1274C37.0091 33.0211 36.7964 32.8084 36.6901 32.8084ZM34.2441 36.2116C34.0314 37.1687 33.2869 37.9132 32.2234 37.9132C31.6917 37.9132 31.2663 37.7005 31.0536 37.4878C30.8409 37.1687 30.7345 36.7433 30.7345 36.2116C30.8409 35.2544 31.6917 34.51 32.6488 34.51C33.1806 34.51 33.4996 34.7227 33.8187 34.9354C34.1377 35.2544 34.2441 35.7862 34.2441 36.2116Z"
                                                    fill="#263B80"></path>
                                                <path
                                                    d="M62.6393 32.8084H60.9377C60.8314 32.8084 60.6187 32.9148 60.6187 33.0211L60.5123 33.5528L60.406 33.3401C59.9806 32.8084 59.2361 32.5957 58.3853 32.5957C56.471 32.5957 54.7695 34.0846 54.4504 36.1052C54.2377 37.1687 54.5568 38.1259 55.0885 38.764C55.6203 39.4021 56.3647 39.6148 57.3218 39.6148C58.9171 39.6148 59.7679 38.6576 59.7679 38.6576L59.6615 39.1894C59.6615 39.4021 59.7679 39.5084 59.9806 39.5084H61.5758C61.7885 39.5084 62.0012 39.2957 62.1076 39.083L63.0647 33.1274C62.9584 33.0211 62.852 32.8084 62.6393 32.8084ZM60.1933 36.2116C59.9806 37.1687 59.2361 37.9132 58.1726 37.9132C57.6409 37.9132 57.2155 37.7005 57.0028 37.4878C56.7901 37.1687 56.6837 36.7433 56.6837 36.2116C56.7901 35.2544 57.6409 34.51 58.598 34.51C59.1298 34.51 59.4488 34.7227 59.7679 34.9354C60.1933 35.2544 60.2996 35.7862 60.1933 36.2116Z"
                                                    fill="#139AD6"></path>
                                                <path
                                                    d="M45.9428 32.8086H44.1349C43.9222 32.8086 43.8158 32.9149 43.7095 33.0213L41.3698 36.6372L40.3063 33.234C40.1999 33.0213 40.0936 32.9149 39.7745 32.9149H38.073C37.8603 32.9149 37.7539 33.1276 37.7539 33.3403L39.6682 38.9768L37.8603 41.5292C37.7539 41.7419 37.8603 42.061 38.073 42.061H39.7745C39.9872 42.061 40.0936 41.9546 40.1999 41.8483L46.0491 33.4467C46.3682 33.1276 46.1555 32.8086 45.9428 32.8086Z"
                                                    fill="#263B80"></path>
                                                <path
                                                    d="M64.6608 29.7241L63.1719 39.2956C63.1719 39.5083 63.2782 39.6146 63.4909 39.6146H64.9798C65.1925 39.6146 65.4052 39.4019 65.5116 39.1892L67.0004 29.8305C67.0004 29.6178 66.8941 29.5114 66.6814 29.5114H64.9798C64.8735 29.4051 64.7671 29.5114 64.6608 29.7241Z"
                                                    fill="#139AD6"></path>
                                                <path
                                                    d="M12.2302 26.2147C11.4857 25.3639 10.1032 24.9385 8.18889 24.9385H2.87143C2.55238 24.9385 2.23333 25.2575 2.12698 25.5766L0 39.5083C0 39.8274 0.212698 40.0401 0.425397 40.0401H3.72222L4.57302 34.829V35.0417C4.67937 34.7226 4.99841 34.4036 5.31746 34.4036H6.9127C9.99683 34.4036 12.3365 33.1274 13.081 29.6178C13.081 29.5115 13.081 29.4051 13.081 29.2988C12.9746 29.2988 12.9746 29.2988 13.081 29.2988C13.1873 27.9163 12.9746 27.0655 12.2302 26.2147Z"
                                                    fill="#263B80"></path>
                                                <path
                                                    d="M12.9747 29.2988C12.9747 29.4052 12.9747 29.5115 12.9747 29.6179C12.2303 33.2337 9.89062 34.4036 6.80649 34.4036H5.21126C4.89221 34.4036 4.57316 34.7226 4.46681 35.0417L3.40332 41.529C3.40332 41.7417 3.50967 41.9544 3.82872 41.9544H6.5938C6.91284 41.9544 7.23189 41.7417 7.23189 41.4226V41.3163L7.76364 38.0195V37.8068C7.76364 37.4877 8.08268 37.275 8.40173 37.275H8.82713C11.4859 37.275 13.6128 36.2115 14.1446 33.021C14.3573 31.7449 14.2509 30.575 13.6128 29.8306C13.5065 29.6179 13.2938 29.4052 12.9747 29.2988Z"
                                                    fill="#139AD6"></path>
                                                <path
                                                    d="M12.2304 28.9802C12.124 28.9802 12.0177 28.8738 11.9113 28.8738C11.805 28.8738 11.6986 28.8738 11.5923 28.7675C11.1669 28.6611 10.7415 28.6611 10.2098 28.6611H6.06213C5.95578 28.6611 5.84943 28.6611 5.74308 28.7675C5.53039 28.8738 5.42404 29.0865 5.42404 29.2992L4.57324 34.8294V35.0421C4.67959 34.723 4.99864 34.404 5.31769 34.404H6.91292C9.99705 34.404 12.3367 33.1278 13.0812 29.6183C13.0812 29.5119 13.0812 29.4056 13.1875 29.2992C12.9748 29.1929 12.8685 29.0865 12.6558 29.0865C12.3367 28.9802 12.3367 28.9802 12.2304 28.9802Z"
                                                    fill="#232C65"></path>
                                            </svg>
                                        </label>
                                    </div> --}}
                                </div>

                                <div class="visa-form">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form--control card-number"
                                            name="" required="" placeholder=" رقم البطاقة ">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form--control" name=""
                                            required="" placeholder="الاسم الكامل">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label required">تاريخ صلاحية البطاقة</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control form--control card-expiry-month"
                                                name="" required="" placeholder="MM">
                                            <input type="text" class="form-control form--control card-expiry-year"
                                                name="" required="" placeholder="YY">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form--control card-cvc" name=""
                                            required="" placeholder=" رمز الحماية">
                                    </div>
                                </div>





                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group d-none'>
                                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 col-lg-3">
                        <input type="hidden" value="{{ $period }}" name="period">
                        <input type="hidden" value="{{ $plan->id }}" name="plan">
                        <h4 class="mb-4 text-dark">تفاصيل الطلب</h4>
                        <ul class="list-unstyled m-0 p-0 mb-4">
                            <li class="d-flex justify-content-between text-dark">
                                <span>اسم الخطة </span>

                                <span>{{ $plan->name }} / {{ $period }}</span>
                            </li>
                            <li class="d-flex justify-content-between text-dark">
                                <span>السعر</span>
                                @if ($period == 'monthly')
                                    <span>{{ (double) $plan->monthly_price }} {{ $general->cur_sym }}</span>
                                @elseif ($period == 'yearly')
                                    <span>{{ (double) $plan->yearly_price }} {{ $general->cur_sym }}</span>
                                @endif
                            </li>
                            <li class="d-flex justify-content-between text-dark">
                                <span>المجموع الكلي</span>
                                @if ($period == 'monthly')
                                    <span>{{ (double) $plan->monthly_price }} {{ $general->cur_sym }}</span>
                                @elseif ($period == 'yearly')
                                    <span>{{ (double) $plan->yearly_price }} {{ $general->cur_sym }}</span>
                                @endif
                            </li>
                        </ul>
                        <button class="base-btn font-500 TheSansArabic-bold w-100 mb-4" type="submit">Pay Now
                            ( @if ($period == 'monthly')
                                <span>{{  (double) $plan->monthly_price }} {{ $general->cur_sym }}</span>
                            @elseif ($period == 'yearly')
                                <span>{{  (double) $plan->yearly_price }} {{ $general->cur_sym }}</span>
                            @endif)</button>
                        <p class="sm-text">
                            تجديد تلقائي:
                            سيتم تجديد اشتراكك تلقائيًا كل عام كدفعة واحدة بقيمة @if ($period == 'monthly')
                                <span>{{ (double) $plan->monthly_price }} {{ $general->cur_sym }}</span>
                            @elseif ($period == 'yearly')
                                <span>{{ (double) $plan->yearly_price }} {{ $general->cur_sym }}</span>
                            @endif يمكنك إلغاء اشتراكك في أي وقت
                            من قسم اشتراكي في ملفك الشخصي.
                            بالنقر على "تأكيد وادفع" ، فإنك توافق على
                            <a href="#">الشروط والاحكام</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection


@push('script')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $('.custom-radio .form-check-input').change(function() {
                if($('[value="paypal"]').is(':checked')) {
                    $('.paypal-form').fadeIn();
                    $('.visa-form').hide();
                } else if($('[value="visa"]').is(':checked')) {
                    $('.paypal-form').hide();
                    $('.visa-form').fadeIn();
                }
            });
        });
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('d-none')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>

    </html>
@endpush
