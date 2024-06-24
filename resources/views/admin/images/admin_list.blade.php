@extends('admin.layouts.app')

@section('panel')
    <div class="d-flex flex-row align-items-center justify-content-start mb-15">
        <a href="{{ route('admin.images.add') }}"
            class="d-flex flex-row align-items-center justify-content-start btn btn--base btn-sm f-size--16">
            <i class="las la-cloud-upload-alt "></i>
            @lang('Upload')</a>
    </div>
    @push('breadcrumb-plugins')
    <div class="image-search-filter">
        <x-search-form placeholder="Search by User/Image/Category" />
    </div>
    @endpush
    <div class="images_row row g-3">
        @forelse ($images as $image)
            <div class="card_1 custom--card image-information-card">
                <div class="card-body">
                    <div class="image-information">
                        <a href="{{ route('admin.images.edit', $image->id) }}" class="t-link image-information__img">
                            <img src="{{ imageUrl(getFilePath('stockImage'), @$image->thumb) }}" alt="image"
                                class="image-information__img-is">
                            @if (!$image->is_free)
                                <span class="gallery__premium gellery_position ">
                                    <i class="fas fa-crown" id="crown-icon"></i>
                                </span>
                            @endif
                        </a>
                        <div class="action-btns">
                            <div class="btn-group btns-list">
                                <a href="{{ route('admin.images.download.file', $image->id) }}"
                                    class="btn_1 btn-sm btn-secondary">
                                    <i class="las la-download"></i>
                                </a>
                                <a href="{{ route('admin.images.edit', $image->id) }}" class="btn_1 btn-sm btn--primary">
                                    <i class="las la-pen"></i>
                                </a>

                                @if ($image->is_active)
                                    <button data-action="{{ route('admin.images.status', $image->id) }}"
                                        data-question="@lang('Are you sure that you want to deactivate this image?')" class="btn_1 btn-sm btn--success confirmationBtn">
                                        <i class="las la-eye"></i>
                                    </button>
                                @else
                                    <button data-action="{{ route('admin.images.status', $image->id) }}"
                                        data-question="@lang('Are you sure that you want to active this image?')" class="btn_1 btn-sm btn-dark confirmationBtn">
                                        <i class="las la-eye-slash"></i>
                                    </button>
                                @endif
                                <button data-action="{{ route('admin.images.delete', $image->id) }}"
                                    data-question="@lang('Are you sure that you want to delete this image?')"
                                    class="btn_1 btn-sm btn--danger btn-danger confirmationBtn">
                                    <i class="las la-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="image-information__content">
                            <h5 class="image-information__title"><a href="{{ route('admin.images.edit', $image->id) }}"
                                    class="text--base">{{ __($image->title) }}</a></h5>
                            <ul class="list" style="--gap: 0;">
                                <li>
                                    <div class="image-information__item">
                                        <div class="image-information__item-left">
                                            @lang('Category :')
                                        </div>
                                        <div class="image-information__item-right">
                                            {{ __($image->category->name) }}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="image-information__item">
                                        <div class="image-information__item-left">
                                            @lang('Total Likes :')
                                        </div>
                                        <div class="image-information__item-right">
                                            {{ shortNumber($image->total_like) }}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="image-information__item">
                                        <div class="image-information__item-left">
                                            @lang('Total Views :')
                                        </div>
                                        <div class="image-information__item-right">
                                            {{ shortNumber($image->total_view) }}
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="image-information__item">
                                        <div class="image-information__item-left">
                                            @lang('Total Downloads :')
                                        </div>
                                        <div class="image-information__item-right">
                                            {{ shortNumber($image->total_downloads) }}
                                        </div>
                                    </div>
                                </li>
                                @if (request()->routeIs('admin.images.all'))
                                    <li>
                                        <div class="image-information__item">
                                            <div class="image-information__item-left">
                                                @lang(' Status :')
                                            </div>
                                            <div class="image-information__item-right">
                                                @php echo $image->statusBadge; @endphp
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <img src="{{ getImage('assets/images/empty_message.png') }}" alt="@lang('Image')">
            </div>
        @endforelse

        @if ($images->hasPages())
            <div class="d-flex justify-content-end">
                {{ paginateLinks($images) }}
            </div>
        @endif
    </div>

    <x-confirmation-modal />
@endsection
