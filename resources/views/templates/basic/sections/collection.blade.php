@php
    $content = getContent('collection.content', true);
    $collections = App\Models\Collection::public()
        // ->where('is_featured', Status::ENABLE)
        // ->whereHas('images')
        // ->limit('8')
        // ->orderBy('title')
        ->with('images', 'user')->take(3)
        ->get();
@endphp
@if ($collections->count())
    <div class="section">
        <div class="section__head-xl">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-6">
                        <h2 class="section__title text-center mb-0">{{ __($content->data_values->title) }}
                        <span class=" Fcolor--red">{{ __($content->data_values->colortitle) }}</span>
                        </h2>
                        <p class="mb-0 sm-text text-center">
                            {{ __($content->data_values->subtitle) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row g-4 justify-content-center">
                {{-- @include($activeTemplate . 'partials.collection_grid', ['collections' => $collections]) --}}
                {{-- @foreach ($collections as $collection) --}}
                @foreach ($collections as $key => $collection)

                @php
                    $images = $collection->images->pluck('tags')->toArray();
                    $tags = array_slice(array_unique(array_merge(...$images)), 0, 4);
                @endphp
                <div class="col-sm-6 col-lg-4 grid_{{$key}}">
                    <div class="collection">
                        <div class="collection__group">
                            <ul class="collection__list collection__list-tripple">
                                @foreach ($collection->images->sortByDesc('id')->take(3) as $image)
                                    <li class="bg--light">
                                        <a href="{{ route('collection.detail', [slug($collection->title), $collection->id]) }}" class="collection__link">
                                            <img src="{{ imageUrl(getFilePath('stockImage'), $image->thumb) }}" alt="@lang('image')" class="collection__img" />
                                        </a>
                                    </li>
                                @endforeach
                                @if (count($collection->images) < 3)
                                    @for ($i = 0; $i < 3 - count($collection->images); $i++)
                                        <li class="bg--light">
                                            <a href="{{ route('collection.detail', [slug($collection->title), $collection->id]) }}" class="collection__link"></a>
                                        </li>
                                    @endfor
                                @endif
                            </ul>
                        </div>
                        <a href="{{ route('collection.detail', [slug($collection->title), $collection->id]) }}">
                            <h4 class="collection__title text-dark">{{ __($collection->title) }}</h4>
                        </a>
                        <p class="collection__subtitle">{{ shortNumber($collection->images->count()) }} @lang('Photos') - @lang('Created by') <a href="{{ route('member.images', $collection->user->username) }}" class="Fcolor--red">{{ __($collection->user->fullname) }}</a></p>
                        @if (count($tags))
                            <ul class="list list--row flex-wrap" style="--gap: 5px">
                                @foreach ($tags as $tag)
                                    <li>
                                        <a class="btn btn--tag_collection" href="{{ route('search', ['type' => 'image', 'tag' => $tag]) }}">{{ __(ucfirst($tag)) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach

            </div>
        </div>
    </div>
@endif
