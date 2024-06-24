@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endpush

@section('panel')
    <div class="text-end mb-3">
        <a href="{{ route('admin.videos.add') }}" class="btn btn--base btn-sm"><i class="las la-cloud-upload-alt"></i>
            @lang('Upload videos')</a>
    </div>
    <div class="row g-3">
        @forelse ($videos as $video)
            @php
                $filePath = getFilePath('stockImage') . '/' . $video->cover_image;
            @endphp
            <div class="col-md-6 col-xl-4">
                <div class="card custom--card image-information-card">
                    <div class="card-body">
                        <div class="image-information">
                            <div class="Video_cover_Content scalabel-img-box">
                                <a href={{ URL::asset('/videos/' . $video->thumb) }}
                                    class="mediabox rounded-[5px] overflow-hidden block" data-fancybox>
                                    <img class="scale-hover w-100 h-100 video-img" src="/{{ $filePath }}"
                                        alt="fliePath">
                                    <svg class="play_Icon" width="60" height="60" viewBox="0 0 82 82" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_141_3225)">
                                            <circle cx="40.3167" cy="40.3167" r="37.5833" fill="white" />
                                            <path
                                                d="M41 0C18.3563 0 0 18.3563 0 41C0 63.6437 18.3563 82 41 82C63.6437 82 82 63.6437 82 41C82 18.3563 63.6437 0 41 0ZM29.7975 58.8326V23.1674L60.6845 41L29.7975 58.8326Z"
                                                fill="#ED3126" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_141_3225">
                                                <rect width="82" height="82" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </div>
                            <div class="action-btns">
                                <div class="btn-group btns-list">
                                    <a href="{{ route('admin.videos.download.file', $video->id) }}"
                                        class="btn_1 btn-sm btn-secondary">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a href="{{ route('admin.videos.edit', $video->id) }}"
                                        class="btn_1 btn-sm btn--primary">
                                        <i class="las la-pen"></i>
                                    </a>
                                    @if ($video->is_active)
                                        <button data-action="{{ route('admin.videos.status', $video->id) }}"
                                            data-question="@lang('Are you sure that you want to deactivate this video?')"
                                            class="btn_1 btn-sm btn--success confirmationBtn">
                                            <i class="las la-eye"></i>
                                        </button>
                                    @else
                                        <button data-action="{{ route('admin.videos.status', $video->id) }}"
                                            data-question="@lang('Are you sure that you want to active this video?')" class="btn_1 btn-sm btn-dark confirmationBtn">
                                            <i class="las la-eye-slash"></i>
                                        </button>
                                    @endif
                                    <button data-action="{{ route('admin.videos.delete', $video->id) }}"
                                        data-question="@lang('Are you sure that you want to delete this video?')"
                                        class="btn_1 btn-sm btn--danger btn-danger confirmationBtn">
                                        <i class="las la-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="image-information__content">
                                <h5 class="image-information__title"><a href="{{ route('admin.videos.edit', $video->id) }}"
                                        class="text--base">{{ __($video->title) }}</a></h5>
                                <ul class="list" style="--gap: 0;">
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Category :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ __($video->category->name) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Total Likes :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ shortNumber($video->total_like) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Total Views :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ shortNumber($video->total_view) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Total Downloads :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ shortNumber($video->total_downloads) }}
                                            </div>
                                        </div>
                                    </li>
                                    @if (request()->routeIs('user.image.all'))
                                        <li>
                                            <div class="image-information__item">
                                                <div class="image-information__item-left">
                                                    @lang(' Status :')
                                                </div>
                                                <div class="image-information__item-right">
                                                    @php echo  $video->statusBadge; @endphp
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <img src="{{ getImage('assets/images/empty_message.png') }}" alt="@lang('Image')">
            </div>
        @endforelse

        @if ($videos->hasPages())
            <div class="d-flex justify-content-end">
                {{ paginateLinks($videos) }}
            </div>
        @endif
    </div>
    <x-confirmation-modal />
@endsection


@push('script')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox]', {
            // Custom options
        });
    </script>

    {{-- <script>
        (function(root, factory) {
            "use strict";
            if (typeof define === 'function' && define.amd) {
                define([], factory);
            } else if (typeof exports === 'object') {
                module.exports = factory();
            } else {
                root.MediaBox = factory();
            }
        }(this, function() {
            "use strict";

            var MediaBox = function(element) {
                if (!this || !(this instanceof MediaBox)) {
                    return new MediaBox(element);
                }
                this.selector = document.querySelectorAll(element);
                this.root = document.querySelector('body');
                this.run();
            };

            MediaBox.prototype = {
                run: function() {
                    Array.prototype.forEach.call(this.selector, function(el) {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();

                            var link = this.parseUrl(el.getAttribute('href'));
                            this.render(link);
                            this.close();
                        }.bind(this), false);
                    }.bind(this));
                },
                template: function(s, d) {
                    var p;

                    for (p in d) {
                        if (d.hasOwnProperty(p)) {
                            s = s.replace(new RegExp('{' + p + '}', 'g'), d[p]);
                        }
                    }
                    return s;
                },
                parseUrl: function(url) {
                    var service = {},
                        matches;

                    if (matches = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/)) {
                        service.provider = "youtube";
                        service.id = matches[2];
                    } else if (matches = url.match(
                            /https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/
                        )) {
                        service.provider = "vimeo";
                        service.id = matches[3];
                    } else {
                        service.provider = "Unknown";
                        service.id = '';
                    }

                    return service;
                },
                render: function(service) {
                    var embedLink,
                        lightbox;

                        console.log("hereeee",service)
                    if (service.provider === 'youtube') {
                        embedLink = 'https://www.youtube.com/embed/' + service.id;
                    } else if (service.provider === 'vimeo') {
                        embedLink = 'https://player.vimeo.com/video/' + service.id;
                    } else {
                        throw new Error("Invalid video URL",Error);
                    }

                    lightbox = this.template(
                        '<div class="mediabox-wrap"><div class="mediabox-content"><span class="mediabox-close"></span><iframe src="{embed}?autoplay=1" frameborder="0" allowfullscreen></iframe></div></div>', {
                            embed: embedLink
                        });

                    this.root.insertAdjacentHTML('beforeend', lightbox);
                },
                close: function() {
                    var wrapper = document.querySelector('.mediabox-wrap');

                    wrapper.addEventListener('click', function(e) {
                        if (e.target && e.target.nodeName === 'SPAN' && e.target.className ===
                            'mediabox-close') {
                            wrapper.classList.add('mediabox-hide');
                            setTimeout(function() {
                                this.root.removeChild(wrapper);
                            }.bind(this), 500);
                        }
                    }.bind(this), false);
                }
            };

            return MediaBox;
        }));


        //Initialize the MediaBox.

        MediaBox('.mediabox');
    </script> --}}
@endpush
