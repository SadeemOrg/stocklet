@php
   $categories = App\Models\Category::active()
        ->orderBy('name')->withCount('images')->withCount('videos')
        ->get();
@endphp
<div class="category section--sm pb-0">
    <div class="container custom--container">
        <div class="row">
            <div class="col-12">
                <div id="owl-carousel_Category" class="owl-carousel owl-theme">
                    @foreach ($categories as $key=>$category)
                        <a href="{{ route('search', ['type' => 'image', 'category' => $category->slug]) }}" class="category__link">
                            <div class="category__text mb-1">
                                <span class="{{app()->getLocale() === 'ar' ? 'ml-auto' : 'mr-auto'}}">{{ __($category->name) }}</span>
                                <span class="{{app()->getLocale() === 'ar' ? 'ml-auto Shamel-SansOneBook-font font-400' : 'mr-auto'}}">{{ __($category->images_count)   }} صورة</span>
                                <span class="{{app()->getLocale() === 'ar' ? 'ml-auto Shamel-SansOneBook-font font-400' : 'mr-auto'}}">{{ __($category->videos_count)   }} فيديو</span>
                            </div>
                            <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}" alt="{{ _($category->name) }}" class="category_img" />
                        </a>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
