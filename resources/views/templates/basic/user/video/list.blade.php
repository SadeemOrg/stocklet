@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="text-end mb-3">
        <a href="{{ route('user.video.add') }}" class="btn btn--base btn-sm"><i class="las la-cloud-upload-alt"></i> @lang('Upload')</a>
    </div>
    <div class="row g-3">
        @forelse ($videos as $video)
            <div class="col-md-6 col-xl-4">
                <div class="card custom--card image-information-card">
                    <div class="card-body">
                        <div class="image-information">

                            <div class="action-btns">
                                <div class="btn-group">
                                    <a href="{{ route('user.video.download.file',  $video->id) }}" class="btn btn-sm btn-secondary">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a href="{{ route('user.video.edit',  $video->id) }}" class="btn btn-sm btn--primary">
                                        <i class="las la-pen"></i>
                                    </a>
                                    @if ( $video->is_active)
                                        <button data-action="{{ route('user.video.status',  $video->id) }}" data-question="@lang('Are you sure that you want to deactivate this video?')" class="btn btn-sm btn--success confirmationBtn">
                                            <i class="las la-eye"></i>
                                        </button>
                                    @else
                                        <button data-action="{{ route('user.video.status',  $video->id) }}" data-question="@lang('Are you sure that you want to active this video?')" class="btn btn-sm btn--danger confirmationBtn">
                                            <i class="las la-eye-slash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <a   class="file-upload-content" href="{{ route('user.video.edit',  $video->id) }}" class="t-link image-information__img">
                                <video class="file-upload-image" controls src={{ URL::asset('/videos/'.$video->thumb) }}
                                poster="benefits-of-coding.jpg"></video>
                                @if (! $video->is_free)
                                    <span class="gallery__premium">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                @endif
                            </a>

                            <div class="image-information__content">
                                <h5 class="image-information__title"><a href="{{ route('user.image.edit',  $video->id) }}" class="text--base">{{ __( $video->title) }}</a></h5>
                                <ul class="list" style="--gap: 0;">
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Category :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ __( $video->category->name) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Total Likes :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ shortNumber( $video->total_like) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Total Views :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ shortNumber( $video->total_view) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Total Downloads :')
                                            </div>
                                            <div class="image-information__item-right">
                                                {{ shortNumber( $video->total_downloads) }}
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang('Price :')
                                            </div>
                                            <div class="image-information__item-right">
                                                @if ( $video->is_free)
                                                    @lang('N/A')
                                                @else
                                                    {{ showAmount( $video->price) }} {{ $general->cur_text }}
                                                @endif
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

        @if ( $videos->hasPages())
            <div class="d-flex justify-content-end">
                {{ paginateLinks( $videos) }}
            </div>
        @endif
    </div>

    <x-confirmation-modal />
@endsection
