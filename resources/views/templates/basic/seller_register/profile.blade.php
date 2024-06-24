@php
    $content = getContent('seller_register.profile.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend', ['pageTitle' => 'Privacy and Policy'])
@section('content')

<section class="bg--light success_subscription">
    <div class="container custom--container">
        <div class="register-page-wrap">
            <h1 class="text-center steps-page-title text-dark">إبدأ بانشاء ملف للنشر</h1>
            <div class="mt-4 mb-5">
                <ul class="steps-list list-unstyled m-0 p-0 d-md-flex justify-content-center gap-4 mx-auto mx-md-0">
                    <li class="d-md-flex align-items-center gap-3 position-relative mb-4 mb-md-0 active">
                        <div class="d-flex d-md-block d-lg-flex align-items-center gap-3">
                            <span class="step-num d-flex justify-content-center align-items-center mx-md-auto"><span class="pt-2">1</span></span>
                            <h5 class="text-dark">السياسة والخصوصية </h5>
                        </div>
                        <svg class="arrow-icon" width="74" height="24" viewBox="0 0 74 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.939339 10.9393C0.353554 11.5251 0.353554 12.4749 0.939339 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51471C13.1924 2.92893 13.1924 1.97918 12.6066 1.39339C12.0208 0.807606 11.0711 0.807606 10.4853 1.39339L0.939339 10.9393ZM74 10.5L2 10.5L2 13.5L74 13.5L74 10.5Z" fill="black"/>
                        </svg>
                    </li>
                    <li class="d-md-flex align-items-center position-relative mb-4 mb-md-0 gap-3 active">
                        <div class="d-flex d-md-block d-lg-flex align-items-center gap-3">
                            <span class="step-num d-flex justify-content-center align-items-center mx-md-auto"><span class="pt-2">2</span></span>
                            <h5 class="text-dark">الملف الشخصي</h5>
                        </div>
                        <svg class="arrow-icon" width="74" height="24" viewBox="0 0 74 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.939339 10.9393C0.353554 11.5251 0.353554 12.4749 0.939339 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51471C13.1924 2.92893 13.1924 1.97918 12.6066 1.39339C12.0208 0.807606 11.0711 0.807606 10.4853 1.39339L0.939339 10.9393ZM74 10.5L2 10.5L2 13.5L74 13.5L74 10.5Z" fill="black"/>
                        </svg>
                    </li>
                    <li class="d-md-flex align-items-center position-relative gap-3 ">
                        <div class="d-flex d-md-block d-lg-flex align-items-center gap-3">
                            <span class="step-num d-flex justify-content-center align-items-center mx-md-auto"><span class="pt-2">3</span></span>
                            <h5 class="text-dark">ابدأ النشر</h5>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="agreement-text p-4">
                <form action="" class="register-form">
                    <label for="avatar_image"  class="avatar mb-5 rounded-full overflow-hidden border-1 d-flex align-items-center justify-content-center position-relative cursor-pointer">
                        <input type="file" name="" value="" id="avatar_image" onchange="readURL(this);" class="position-absolute ">
                        <img src="{{ asset('assets/images/deafult-profile.svg') }}" class="object-cover" id="blah" alt="profile image">
                    </label>
                    <div class="d-sm-flex mb-3 gap-2 payment-form">
                        <input type="text" class="form-control mb-3 mb-sm-0 form--control" name="" required="" placeholder="الموقع الشخصي ">
                        <input type="text" class="form-control form--control" name="" required="" placeholder="محفظة الاعمال">
                    </div>
                    <div class="d-sm-flex mb-4 gap-2 payment-form">
                        <input type="text" class="form-control mb-3 mb-sm-0 form--control" name="" required="" placeholder="البلد">
                        <input type="text" class="form-control form--control" name="" required="" placeholder="محفظة الاعمال">
                    </div>
                    <div class="text-center mt-5">
                        <a href="#" class="base-btn font-500 TheSansArabic-bold px-5">
                            التالي
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@endsection

@push('script')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
            $('#blah').attr('src', e.target.result).width(150).height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

