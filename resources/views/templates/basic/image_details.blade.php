@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="photo-page">
        <div class="container">
            <div>
                <div class="row">
                    <!-- Image -->
                    <div class="col-12 col-md-6">
                        <div class="d-flex flex-row align-items-center">
                        <img src="{{ imageUrl(getFilePath('stockImage'), $image->image_name) }}" alt="@lang('Image')"
                            class="image-photo mx-auto w-100 d-md-block" />
                        </div>
                    </div>
                    <!-- Image Details -->
                    <div class=" col-12 col-md-6 my-md-0 my-4">
                        <div class="photo-details mb-4 mt-4 mt-sm-0 ">
                            <div class="photo-details__head pt-2">
                                <div class="photo-details__title ">
                                    <span class="photo-details__icon">
                                        <i class="las la-camera-retro"></i>
                                    </span>
                                    <span
                                        class="photo-details__title-link Fcolor--red Shamel-SansOneBold-font ">{{ __($image->title) }}
                                    </span>
                                </div>
                            </div>
                            <div class="photo-details__body">
                                <ul class="list" style="gap: 2.2rem">
                                    <li>
                                        <div class="d-flex align-items-center justify-content-start gap-3">
                                            <span class="d-inline-block sm-text lh-1 text-black"> @lang('Image type') </span>
                                            <span class="d-inline-block sm-text lh-1">
                                                @if ($image->extensions)
                                                    {{ __(strtoupper(implode(', ', $image->extensions))) }}
                                                @endif
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-start gap-4">
                                            <span class="d-inline-block sm-text lh-1 text-black"> @lang('Resolution') </span>
                                            <span class="d-inline-block sm-text lh-1 Shamel-SansOneBook-font">
                                                {{ $image->resolution }} </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-start gap-4">
                                            <span class="d-inline-block sm-text lh-1 text-black"> @lang('Extensions') </span>
                                            <span class="d-inline-block sm-text lh-1">
                                                {{ __(strtoupper(implode(', ', $image->extensions))) }} </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-start gap-4">
                                            <span class="d-inline-block sm-text lh-1 text-black"> @lang('Published') </span>
                                            <span class="d-inline-block sm-text lh-1 Shamel-SansOneBook-font">
                                                {{ showDateTime($image->upload_date, 'F d, Y') }}
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-start gap-4">
                                            <span class="d-inline-block sm-text lh-1 text-black"> @lang('Views') </span>
                                            <span class="d-inline-block sm-text lh-1 Shamel-SansOneBook-font">
                                                {{ $image->total_view }} </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center justify-content-start gap-4">
                                            <span class="d-inline-block sm-text lh-1 text-black"> @lang('Downloads') </span>
                                            <span class="d-inline-block sm-text lh-1 Shamel-SansOneBook-font">
                                                {{ $image->total_downloads }} </span>
                                        </div>
                                    </li>
                                    @if (!$image->is_free)
                                        <li>
                                            <div class="d-flex align-items-center justify-content-start gap-4">
                                                <span class="d-inline-block sm-text lh-1 text-black"> @lang('Price')
                                                </span>
                                                <span class="d-inline-block sm-text lh-1 Shamel-SansOneBook-font">
                                                    {{ showAmount($image->price) }}
                                                    {{ __($general->cur_text) }} </span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <form action="{{ route('image.download', encrypt($image->id)) }}" method="GET"
                            class="download-form">
                            @if (!$image->is_free && $image->user_id != @auth()->id())
                                @php
                                    $user = auth()->user();
                                @endphp
                                @if (!$user)
                                    <button type="button" class="common-btn w-100 login-btn">
                                        <span class="common-btn__icon">
                                            <i class="las la-download"></i>
                                        </span>
                                        @lang('Download')
                                    </button>
                                @else
                                    @if (!$user->purchasedPlan)
                                        <button type="button" class="common-btn w-100 downloadBtn"
                                            data-description="@lang('This image is premium. You don\'t have any active plan, so if you want to download this resource, download charge will be taken from your wallet balance')">
                                            <span class="common-btn__icon">
                                                <i class="las la-download f-size--56" id="download_icon"></i>
                                            </span>
                                            @lang('Download')
                                        </button>
                                    @elseif($user->purchasedPlan->daily_limit <= $todayDownload && !$alreadyDownloaded)
                                        <button type="button" class="common-btn w-100 downloadBtn"
                                            data-description="@lang('This image is premium. Your active plan\'s daily limit has been over, so if you want to download this resource, download charge will be taken from your wallet balance')">
                                            <span class="common-btn__icon">
                                                <i class="las la-download"></i>
                                            </span>
                                            @lang('Download')
                                        </button>
                                    @elseif($user->purchasedPlan->monthly_limit <= $monthlyDownload && !$alreadyDownloaded)
                                        <button type="button" class="common-btn w-100 downloadBtn"
                                            data-description="@lang('This image is premium. Your active plan\'s monthly limit has been over, so if you want to download this resource, download charge will be taken from your wallet balance')">
                                            <span class="common-btn__icon">
                                                <i class="las la-download"></i>
                                            </span>
                                            @lang('Download')
                                        </button>
                                    @else
                                        <input type="hidden" name="from_account" value="0">
                                        <button type="submit" class="common-btn w-100">
                                            <span class="common-btn__icon">
                                                <i class="las la-download"></i>
                                            </span>
                                            @lang('Download')
                                        </button>
                                    @endif
                                @endif
                            @else
                                <input type="hidden" name="from_account" value="0">
                                <button type="submit" class="common-btn w-100">
                                    <span class="common-btn__icon">
                                        <i class="las la-download"></i>
                                    </span>
                                    @lang('Download')
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="mt-3 mt-md-4 text-black Shamel-SansOneBook-font ">
                    <p class="">{{ __($image->description) }}</p>
                </div>
                <div>
                    @if ($relatedImages->count())
                            <h5 class="related-photo__title">@lang('Related Photos')</h5>
                            @include($activeTemplate . 'partials.image_grid', [
                                'images' => $relatedImages,
                                'class' => 'gallery--sm',
                            ])
                    @endif
                </div>
            </div>

        </div>
        <div class="photo-modal">
            <div class="photo-modal__img">
                <img src="{{ imageUrl(getFilePath('stockImage'), $image->thumb) }}" alt="image"
                    class="photo-modal__image">
            </div>
            <div class="photo-modal__content">
                <h6 class="photo-modal__title">@lang('Give Thanks!')</h6>
                <p class="photo-modal__description">
                    @lang('Give thanks to ')@<span class="fw-bold">{{ @$image->user->username }}</span> @lang('for sharing this photo for free, the easiest way, sharing on social network')
                </p>
                <ul class="list list--row social-list">
                    <li>
                        <a target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            class="t-link social-list__icon">
                            <i class="lab la-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank"
                            href="https://twitter.com/intent/tweet?text={{ $image->title }}&amp;url={{ urlencode(url()->current()) }}"
                            class="t-link social-list__icon">
                            <i class="lab la-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank"
                            href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ $image->title }}&amp;summary={{ $image->title }}"
                            class="t-link social-list__icon">
                            <i class="lab la-linkedin-in"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank"
                            href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ $image->description }}"
                            class="t-link social-list__icon">
                            <i class="lab la-pinterest-p"></i>
                        </a>

                    </li>
                </ul>
                <button type="button" class="photo-modal__close">
                    <i class="las la-times"></i>
                </button>
            </div>
        </div>
    </div>


@endsection
@push('modal')
    <!-- Download modal -->
    <div class="modal custom--modal fade" id="downloadModal" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">@lang('Download Alert!')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('image.download', encrypt($image->id)) }}" method="GET" class="download-form">
                    <input type="hidden" name="from_account" value="1">
                    <div class="modal-body">
                        <div class="alert-description fw-bold text--danger sm-text">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="common-btn w-100">@lang('Download')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include($activeTemplate . 'partials.collection_modal')
    @include($activeTemplate . 'partials.share_modal')
    @include($activeTemplate . 'partials.login_modal')
@endpush
@push('script')
    <script>
        "use strict";

        let likeRoutes = {
            updateLike: "{{ route('user.image.like.update') }}"

        };
        let likeParams = {
            loggedStatus: @json(Auth::check()),
            csrfToken: "{{ csrf_token() }}"
        }

        let followRoutes = {
            updateFollow: "{{ route('user.follow.update') }}",
        }

        let followParams = {
            loggedStatus: @json(Auth::check()),
            csrfToken: "{{ csrf_token() }}",
            appendStatus: 0
        }

        $('.login-btn').on('click', function() {
            let modal = $('#loginModal');
            modal.modal('show');
        });

        $('.downloadBtn').on('click', function() {
            let modal = $('#downloadModal');
            let description = $(this).data('description');
            modal.find('.alert-description').text(description);
            modal.modal('show');
        });

        $('.photo-modal__close').on('click', function() {
            $('.photo-modal').removeClass('active');
        });

        $('.download-form').on('submit', function() {
            setTimeout(() => {
                let session = "{{ session()->get('is_download') }}";
                if (session == 'downloaded') {
                    $('.photo-modal').addClass('active');
                }
            }, 2000);
        })
    </script>
    <script src="{{ asset($activeTemplateTrue . 'js/like.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/follow.js') }}"></script>
@endpush
