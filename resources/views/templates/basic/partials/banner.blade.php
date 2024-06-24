@php
    $content = getContent('banner.content', true);
    $images = App\Models\Image::approved()
        ->inrandomOrder()
        ->limit(6)
        ->get('tags')
        ->pluck('tags')
        ->toArray();
    $tags = array_slice(array_unique(array_merge(...$images)), 0, 6);
@endphp
<section class="hero">
    <div class="container custom--container">
        <div class="row">
            <div class="col-12">
                <div class="hero__container">
                    <form action="{{ route('search') }}" method="get" class="position-relative" style="z-index:10">
                        <input type="hidden" name="type" value="image">
                        <div class="hero__content mx-auto">
                            <h1 class="hero__content-title text-center text--white">

                                {{ __(@$content->data_values->title) }}
                                <span class=" Fcolor--red">
                                    {{ __(@$content->data_values->colortitle) }}
                                    </span>
                            </h1>
                            <p class="text-center text-white m-0 FFShamel-SansOneBook">سواء كنت تبحث عن تصميمات أو صور
                                فوتوغرافية ، ستجد الأصل المثالي لدينا .</p>
                            <div class="search-bar">
                                <div class="search-bar__icon_home">
                                    <i class="las la-search"></i>
                                </div>
                                <input type="text" name="filter"
                                    class="form-control form--control form--control_home search-bar__input_home"
                                    placeholder="@lang('Search anything')...">
                            </div>
                            @if (count($tags))
                                @php
                                    // dd($tags);
                                @endphp
                                <ul class="list list--row flex-wrap justify-content-center" style="--gap: 5px;">
                                    @foreach ($tags as $tag)
                                        <li class="list_group">
                                            <a href="{{ route('search', ['type' => 'image', 'tag' => $tag]) }}"
                                                class=" FFShamel-SansOneBook link_color">
                                                    # {{ __(ucfirst($tag)) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </form>
                    <div class="hero__image d-none">
                        <img src="{{ getImage('assets/images/frontend/banner/' . @$content->data_values->image, '750x500') }}"
                            alt="@lang('Banner')" class="hero__image-is">
                    </div>
                    <div class="hero__image-left d-none">
                        <img src="{{ getImage('assets/images/frontend/banner/' . @$content->data_values->left_image, '1100x1140') }}"
                            alt="@lang('Banner')" class="hero__image-is">
                    </div>
                    <div class="position-absolute main-section-bg-wrap">
                        <img src="{{ getImage('assets/images/frontend/banner/' . @$content->data_values->image, '750x500') }}"
                            class="hero__image-is">
                    </div>
                    <div class="bg-over"></div>
                </div>
            </div>
        </div>
    </div>
</section>
