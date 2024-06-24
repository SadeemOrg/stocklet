@php
    $content = getContent('success_subscription.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend', ['pageTitle' => 'Success Subscription.blade'])
@section('content')

<section class="bg--light success_subscription">
    <div class="container custom--container">
        <div class="text-wrap text-center">
            <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_110_5533)">
                <path d="M31 62C48.1208 62 62 48.1208 62 31C62 13.8792 48.1208 0 31 0C13.8792 0 0 13.8792 0 31C0 48.1208 13.8792 62 31 62Z" fill="#00BA00"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.3201 46.1186L9.98239 33.984C8.4302 32.3227 8.51929 29.6942 10.1806 28.1421C11.8419 26.5899 14.4703 26.6792 16.0225 28.3403L24.7679 37.7003L38.6108 24.7665C38.7353 24.65 38.8654 24.5434 38.9999 24.4452L45.5096 18.3631C47.1709 16.8109 49.7996 16.9003 51.3515 18.5616C52.9037 20.2226 52.8144 22.8513 51.1533 24.4035L31.2708 42.9803L31.2496 42.9576L24.372 49.3836L21.3201 46.1186Z" fill="white"/>
                </g>
                <defs>
                <clipPath id="clip0_110_5533">
                <rect width="62" height="62" fill="white"/>
                </clipPath>
                </defs>
            </svg>
            <h1 class="mt-5 mb-4">تم الاشتراك بنجاح !</h1>
            <p>
                هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ
            </p>
        </div>
    </div>
</section>

@endsection

