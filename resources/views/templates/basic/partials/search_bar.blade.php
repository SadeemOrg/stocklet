@php
    $colors = App\Models\Color::orderBy('id', 'DESC')->get();
@endphp
<div class="filter-sidebar">
    <div class="filter-sidebar__header">
        <div class="d-flex align-items-center">
            <span class="filter-sidebar__text Shamel-SansOneBold-font text-black">@lang('Filters')</span>
        </div>
        <button class="btn filter-close">
            <div class="clear-all">
                <i class="las la-times"></i>
            </div>
        </button>
    </div>
    <div class="filter-sidebar__body" data-simplebar>
        <ul class="list w-100" style="--gap: 0.5rem">
            <li>
                <div class="t-py-20 px-4 list-style-table">
                    <div class="filter-sidebar__title t-mt-15">
                        <div class="filter-sidebar__title-icon">
                            <svg class="t-ml-10" width="21" height="19" viewBox="0 0 21 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.875 3.375C14.875 2.85583 15.029 2.34831 15.3174 1.91663C15.6058 1.48495 16.0158 1.1485 16.4955 0.949817C16.9751 0.751137 17.5029 0.699154 18.0121 0.80044C18.5213 0.901726 18.989 1.15173 19.3562 1.51885C19.7233 1.88596 19.9733 2.35369 20.0746 2.86289C20.1758 3.37209 20.1239 3.89989 19.9252 4.37955C19.7265 4.8592 19.3901 5.26917 18.9584 5.55761C18.5267 5.84605 18.0192 6 17.5 6C16.8038 6 16.1361 5.72344 15.6438 5.23116C15.1516 4.73887 14.875 4.07119 14.875 3.375ZM1.75 4.25H12.25C12.4821 4.25 12.7046 4.15781 12.8687 3.99372C13.0328 3.82963 13.125 3.60707 13.125 3.375C13.125 3.14294 13.0328 2.92038 12.8687 2.75628C12.7046 2.59219 12.4821 2.5 12.25 2.5H1.75C1.51794 2.5 1.29538 2.59219 1.13128 2.75628C0.967187 2.92038 0.875 3.14294 0.875 3.375C0.875 3.60707 0.967187 3.82963 1.13128 3.99372C1.29538 4.15781 1.51794 4.25 1.75 4.25ZM7 6.875C6.45842 6.87652 5.93057 7.04552 5.48882 7.35882C5.04706 7.67213 4.71302 8.1144 4.5325 8.625H1.75C1.51794 8.625 1.29538 8.71719 1.13128 8.88128C0.967187 9.04538 0.875 9.26794 0.875 9.5C0.875 9.73207 0.967187 9.95463 1.13128 10.1187C1.29538 10.2828 1.51794 10.375 1.75 10.375H4.5325C4.69302 10.829 4.97534 11.2301 5.34856 11.5344C5.72179 11.8388 6.17153 12.0345 6.64857 12.1004C7.12561 12.1662 7.61156 12.0995 8.05325 11.9076C8.49493 11.7158 8.87533 11.4061 9.1528 11.0125C9.43028 10.6189 9.59414 10.1566 9.62645 9.67614C9.65877 9.19566 9.55829 8.71556 9.33602 8.28837C9.11374 7.86117 8.77824 7.50336 8.36622 7.25407C7.95421 7.00479 7.48156 6.87365 7 6.875ZM19.25 8.625H12.25C12.0179 8.625 11.7954 8.71719 11.6313 8.88128C11.4672 9.04538 11.375 9.26794 11.375 9.5C11.375 9.73207 11.4672 9.95463 11.6313 10.1187C11.7954 10.2828 12.0179 10.375 12.25 10.375H19.25C19.4821 10.375 19.7046 10.2828 19.8687 10.1187C20.0328 9.95463 20.125 9.73207 20.125 9.5C20.125 9.26794 20.0328 9.04538 19.8687 8.88128C19.7046 8.71719 19.4821 8.625 19.25 8.625ZM8.75 14.75H1.75C1.51794 14.75 1.29538 14.8422 1.13128 15.0063C0.967187 15.1704 0.875 15.3929 0.875 15.625C0.875 15.8571 0.967187 16.0796 1.13128 16.2437C1.29538 16.4078 1.51794 16.5 1.75 16.5H8.75C8.98206 16.5 9.20462 16.4078 9.36872 16.2437C9.53281 16.0796 9.625 15.8571 9.625 15.625C9.625 15.3929 9.53281 15.1704 9.36872 15.0063C9.20462 14.8422 8.98206 14.75 8.75 14.75ZM19.25 14.75H16.4675C16.2611 14.1662 15.8549 13.6741 15.3208 13.3608C14.7867 13.0475 14.159 12.9331 13.5487 13.0378C12.9384 13.1425 12.3848 13.4596 11.9857 13.933C11.5865 14.4065 11.3676 15.0058 11.3676 15.625C11.3676 16.2442 11.5865 16.8435 11.9857 17.317C12.3848 17.7904 12.9384 18.1075 13.5487 18.2122C14.159 18.3169 14.7867 18.2025 15.3208 17.8892C15.8549 17.5759 16.2611 17.0838 16.4675 16.5H19.25C19.4821 16.5 19.7046 16.4078 19.8687 16.2437C20.0328 16.0796 20.125 15.8571 20.125 15.625C20.125 15.3929 20.0328 15.1704 19.8687 15.0063C19.7046 14.8422 19.4821 14.75 19.25 14.75Z"
                                    fill="#748394" />
                            </svg>
                        </div>
                        <span
                            class="filter-sidebar__title-text Shamel-SansOneBold-font text-gray201">@lang('Sort by')</span>
                    </div>
                    <ul class="list list--row flex-wrap align-items-center ">
                        <li>
                            <span class="filter-btn__is sortBy @if (!request()->has('sort_by')) active @endif">
                                @lang('Recent') </span>
                        </li>
                        <li>
                            <span class="filter-btn__is search-param" data-param="popular" data-param_value="1">
                                @lang('Popular') </span>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="t-py-20 px-4 list-style-table">
                    <div class="filter-sidebar__title">
                        <span class="filter-sidebar__title-icon">
                            <svg class="t-ml-10" width="26" height="29" viewBox="0 0 26 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.3125 20.4886H18.6875C19.136 20.4886 19.5 20.0896 19.5 19.5978C19.5 19.1061 19.136 18.707 18.6875 18.707H7.3125C6.864 18.707 6.5 19.1061 6.5 19.5978C6.5 20.0896 6.864 20.4886 7.3125 20.4886Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M15.9648 13.6638C16.1289 13.6638 16.2951 13.6095 16.4385 13.4959L21.5995 9.42446C21.9635 9.13717 22.0468 8.58042 21.7843 8.18133C21.5223 7.78225 21.0149 7.6905 20.6505 7.97868L15.4895 12.0501C15.1255 12.3374 15.0422 12.8942 15.3046 13.2932C15.4631 13.5351 15.7121 13.6638 15.9648 13.6638Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M10.0353 13.6645C10.288 13.6645 10.5366 13.5358 10.6955 13.2939C10.9579 12.8948 10.8746 12.3381 10.5106 12.0508L5.34962 7.97933C4.9848 7.6916 4.4778 7.78336 4.21577 8.18199C3.95333 8.58107 4.03662 9.13783 4.40062 9.42512L9.56162 13.4966C9.70543 13.6101 9.87118 13.6645 10.0353 13.6645Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M15.9644 13.6646C16.0733 13.6646 16.1838 13.6401 16.2898 13.5893C16.7009 13.3924 16.8886 12.8668 16.7083 12.4161L13.7443 4.98807C13.5647 4.53732 13.0857 4.33155 12.6742 4.52931C12.2631 4.72618 12.0754 5.25175 12.2558 5.7025L15.2198 13.1305C15.353 13.4646 15.6512 13.6646 15.9644 13.6646Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M10.0355 13.6643C10.3487 13.6643 10.6469 13.4648 10.7801 13.1303L13.7441 5.70225C13.9241 5.2515 13.7364 4.72637 13.3257 4.52905C12.9146 4.33174 12.4356 4.53751 12.2556 4.98782L9.29164 12.4158C9.11167 12.8666 9.29936 13.3917 9.71008 13.589C9.81611 13.6398 9.92701 13.6643 10.0355 13.6643Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M18.6883 20.4894C19.0535 20.4894 19.3859 20.2177 19.4765 19.811L21.914 8.91465C22.0208 8.43673 21.7539 7.95436 21.3184 7.83722C20.8841 7.72052 20.4429 8.01226 20.3357 8.49018L17.8982 19.3866C17.7913 19.8645 18.0582 20.3469 18.4937 20.464C18.5591 20.4809 18.6241 20.4894 18.6883 20.4894Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M7.31179 20.4888C7.37597 20.4888 7.44097 20.4804 7.50638 20.463C7.94188 20.3458 8.20879 19.8635 8.10194 19.3856L5.66444 8.48918C5.5576 8.01171 5.11722 7.71952 4.68172 7.83622C4.24622 7.95336 3.97932 8.43573 4.08616 8.91365L6.52366 19.81C6.61425 20.2167 6.94657 20.4888 7.31179 20.4888Z"
                                    fill="#FDBF00" />
                                <path
                                    d="M7.3125 24.0521H18.6875C19.136 24.0521 19.5 23.653 19.5 23.1613C19.5 22.6696 19.136 22.2705 18.6875 22.2705H7.3125C6.864 22.2705 6.5 22.6696 6.5 23.1613C6.5 23.653 6.864 24.0521 7.3125 24.0521Z"
                                    fill="#FDBF00" />
                            </svg>
                        </span>
                        <span
                            class="filter-sidebar__title-text Shamel-SansOneBold-font text-gray201">@lang('price')</span>
                    </div>
                    <ul class="list list--row flex-wrap align-items-center">
                        <li>
                            <span class="filter-btn__is search-param" data-param="is_free" data-param_value="1"
                                data-search_type="single"> @lang('Free') </span>
                        </li>
                        <li>
                            <span class="filter-btn__is search-param" data-param="is_free" data-param_value="0"
                                data-search_type="single"> @lang('Premium') </span>
                        </li>
                    </ul>
                </div>
            </li>
            @if ($colors->count())
                <li>
                    <div class="t-py-20 px-4 list-style-table">
                        <div class="filter-sidebar__title">
                            <span class="filter-sidebar__title-icon">
                                {{-- <i class="las la-tint"></i> --}}
                                <svg class="t-ml-10" width="21" height="21" viewBox="0 0 21 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_67_1815)">
                                        <path
                                            d="M10.455 14.2922L10.8652 16.0376L10.455 17.6226C9.50062 17.6226 8.34389 17.845 7.5121 17.5044C6.62985 17.1431 6.08229 16.1998 5.41895 15.5365L6.23926 13.8961L7.77427 13.1816C8.46001 13.8679 9.40804 14.2922 10.455 14.2922Z"
                                            fill="#EE61EB" />
                                        <path
                                            d="M7.77411 13.1807V13.1812L5.41879 15.5361C4.77444 14.8917 3.84281 14.1654 3.4824 13.3134C3.12196 12.4613 3.33274 11.4834 3.33274 10.5L5.09936 10.0898L6.66353 10.5C6.66357 11.5465 7.08792 12.4945 7.77411 13.1807Z"
                                            fill="#0065A3" />
                                        <path
                                            d="M7.77443 7.81915C7.08824 8.50534 6.66385 9.45342 6.66385 10.4999H3.33305C3.33305 9.61338 3.04389 8.47757 3.3399 7.69467C3.70055 6.74077 4.7113 6.17167 5.41911 5.46387L7.16432 6.38881L7.77443 7.81915Z"
                                            fill="#99EEFF" />
                                        <path
                                            d="M10.455 3.37771L10.8652 5.04471L10.455 6.70806C9.40767 6.70806 8.46005 7.13286 7.77427 7.81905L5.41895 5.46373C6.0633 4.81937 6.42051 3.8877 7.27261 3.52725C8.12471 3.16685 9.4717 3.37771 10.455 3.37771Z"
                                            fill="#93E300" />
                                        <path
                                            d="M15.4911 5.46418L14.6664 7.1092L13.1363 7.81906C12.4501 7.13286 11.502 6.70848 10.4551 6.70848V3.37813C11.4036 3.37813 12.7189 3.15345 13.5465 3.49006C14.4349 3.85137 14.8237 4.79698 15.4911 5.46418Z"
                                            fill="#FFF375" />
                                        <path
                                            d="M17.5776 10.4999L15.9003 10.9101L14.2468 10.4999C14.2468 9.45297 13.8225 8.50493 13.1362 7.81874L15.4911 5.46387H15.4916C16.1588 6.13107 17.1044 6.51994 17.4657 7.40834C17.8023 8.23599 17.5776 9.5514 17.5776 10.4999Z"
                                            fill="#FFC34D" />
                                        <path
                                            d="M17.5776 10.5C17.5776 11.4486 18.0895 12.6409 17.7529 13.4685C17.3915 14.3571 16.1586 14.869 15.4911 15.5361L13.9365 14.8018L13.1362 13.1812C13.8224 12.495 14.2468 11.547 14.2468 10.5H17.5776V10.5Z"
                                            fill="#FF3377" />
                                        <path
                                            d="M15.4912 15.5356C14.8466 16.18 14.2023 17.1116 13.3502 17.472C12.4982 17.8325 11.4384 17.6216 10.4551 17.6216V14.2912C11.502 14.2912 12.4501 13.8669 13.1363 13.1807L15.4912 15.5356Z"
                                            fill="#FF5CA8" />
                                        <path
                                            d="M10.4551 17.6222L10.8652 19.3731L10.4551 20.9996C7.5617 20.9878 4.94495 19.8058 3.05322 17.9019L3.81931 16.3155L5.419 15.5361C6.70776 16.8249 8.48837 17.6222 10.4551 17.6222Z"
                                            fill="#C331C8" />
                                        <path
                                            d="M17.9018 17.9468C16.0035 19.8338 13.3881 21.0001 10.4999 21.0001C10.4851 21.0001 10.4699 21.0001 10.4551 20.9996V17.6222C12.4218 17.6222 14.202 16.8249 15.4911 15.5361L17.2314 16.456L17.9018 17.9468Z"
                                            fill="#FF3377" />
                                        <path
                                            d="M21 10.5C21 13.4108 19.8154 16.0454 17.9019 17.9467L15.4912 15.5361C16.7804 14.2478 17.5777 12.4671 17.5777 10.5L19.3184 10.0898L21 10.5Z"
                                            fill="#E50048" />
                                        <path
                                            d="M21.0001 10.5004H17.5778C17.5778 8.53373 16.7805 6.75311 15.4917 5.46436L16.302 3.83358L17.9019 3.05371C19.8154 4.95503 21.0001 7.58963 21.0001 10.5004Z"
                                            fill="#FF9933" />
                                        <path
                                            d="M17.9018 3.05328L15.4916 5.46394H15.4911C14.2019 4.17519 12.4217 3.37788 10.4551 3.37788L10.0449 1.84574L10.4551 0.000451172C10.4699 0 10.4851 0 10.4999 0C13.3881 0 16.0035 1.16632 17.9018 3.05328Z"
                                            fill="#FFDE46" />
                                        <path
                                            d="M10.4551 0V3.37743C8.48841 3.37743 6.70776 4.17473 5.419 5.46349L3.84675 4.71155L3.05322 3.09771C4.94495 1.19376 7.5617 0.0117305 10.4551 0Z"
                                            fill="#00DA26" />
                                        <path
                                            d="M5.41907 5.46441C4.13027 6.75317 3.33297 8.53378 3.33297 10.5005L1.54494 10.9106L0 10.5005C0 7.61232 1.16632 4.99692 3.05329 3.09863L5.41907 5.46441Z"
                                            fill="#33DDFF" />
                                        <path
                                            d="M5.41907 15.5361L3.05329 17.9018C1.16632 16.0036 0 13.3882 0 10.5H3.33297C3.33297 12.4667 4.13027 14.2473 5.41907 15.5361Z"
                                            fill="#194D80" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_67_1815">
                                            <rect width="21" height="21" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                            </span>
                            <span
                                class="filter-sidebar__title-text Shamel-SansOneBold-font text-gray201">@lang('Colors')</span>
                        </div>
                        <ul class="list list--row flex-wrap align-items-center">
                            <li>
                                <span type="checkbox" id="color-1" class="color-clear clear-param"
                                    data-param="color"></span>
                            </li>
                            @foreach ($colors as $color)
                                <li>
                                    <span id="color-{{ $color->id }}" class="color-selector search-param"
                                        style="background: #{{ $color->color_code }};border: 1px solid @if ($color->color_code != 'ffffff' && $color->color_code != 'fff') #{{ $color->color_code }}; @else #bac8d3 @endif"
                                        data-param="color" data-param_value="{{ $color->color_code }}"
                                        data-search_type="single"></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif
            <li>
                <div class="t-py-20 px-4 list-style-table">
                    <div class="filter-sidebar__title">
                        <span class="filter-sidebar__title-icon">
                            <i class="las la-calendar-week t-ml-10"></i>
                        </span>
                        <span class="filter-sidebar__title-text text-gray201 Shamel-SansOneBold-font ">@lang('Publish date')</span>
                    </div>
                    <ul class="list list--row flex-wrap align-items-center pb-3">
                        <li>
                            <span class="filter-btn__is search-param" data-param="period" data-search_type="single"
                                data-param_value="3"> @lang('Last 3 months') </span>
                        </li>
                        <li>
                            <span class="filter-btn__is search-param" data-param="period" data-search_type="single"
                                data-param_value="6"> @lang('Last 6 months') </span>
                        </li>
                        <li>
                            <span class="filter-btn__is search-param" data-param="period" data-search_type="single"
                                data-param_value="12"> @lang('Last year') </span>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";

            //clear all parameter wihout specefic field
            $('.clear-all').on('click', function() {
                let url = new URL($(location).attr("href"));
                let params = new URLSearchParams(url.search);
                let searchParams = [];
                for (const key of params.keys()) {
                    if (key != 'type' && key != 'category') {
                        searchParams.push(key);
                    }
                }

                searchParams.forEach(element => {
                    params.delete(element);
                });

                const newUrl = new URL(`${url.origin}${url.pathname}?${params}`);
                window.location.href = newUrl;
            });

            // page on load active searched field
            $.each($('.search-param'), function(index, element) {
                let url = new URL($(location).attr("href"));
                let params = new URLSearchParams(url.search);

                params.forEach((value, key) => {
                    if ($(element).data('param') == key && $(element).data('param_value') == value) {
                        $(element).addClass('active');
                    }
                });
            });


            // on click search field
            $(document).on('click', '.search-param', function() {
                let searchItem = $(this);
                let link = new URL($(location).attr('href'));
                let param = $(this).data('param');
                let paramValue = $(this).data('param_value');
                let searchType = $(this).data('search_type') ?? null;
                link = removeParam(link, 'page');
                if (searchType == 'single') {
                    let sameTypeSearchField = $(`[data-param='${param}']`).not(this);

                    $.each(sameTypeSearchField, function(index, element) {
                        let params = new URLSearchParams(link.search);
                        let param = $(element).data('param');
                        let paramValue = $(element).data('param_value');

                        params.forEach((value, key) => {
                            if (param == key && paramValue == value) {
                                link = removeParam(link, param, paramValue, searchType);
                            }
                        });
                        $(element).removeClass('active');
                    });
                }

                if (searchItem.hasClass('active')) {
                    searchItem.removeClass('active');
                    link = removeParam(link, param, paramValue, searchType);
                } else {
                    searchItem.addClass('active');
                    link = appendParam(link, param, paramValue);
                }
                window.location.href = link;
            })

            // append parameter to the current route
            function appendParam(currentUrl, param = null, paramValue = null) {
                let url = new URL(currentUrl);
                const addParam = {
                    [param]: paramValue
                }
                const newParams = new URLSearchParams([
                    ...Array.from(url.searchParams.entries()),
                    ...Object.entries(addParam)
                ]);
                const newUrl = new URL(`${url.origin}${url.pathname}?${newParams}`);
                return newUrl;
            }

            //remove parameter from the current route
            function removeParam(currentUrl, param = null, paramValue = null, searchType = 'single') {
                let url = new URL(currentUrl);
                let params = new URLSearchParams(url.search);
                if (searchType == 'multiple') {
                    const multipleParams = params.getAll(param).filter(param => param != paramValue);
                    params.delete(param);
                    for (const value of multipleParams) {
                        params.append(param, value);
                    }

                } else {
                    params.delete(param);
                }
                const newUrl = new URL(`${url.origin}${url.pathname}?${params}`);
                return newUrl;
            }

            //clear individual parameter
            $('.clear-param').on('click', function() {
                let url = new URL($(location).attr("href"));
                let param = $(this).data('param');
                // console.log(param);
                url = removeParam(url, param);
                $(`span[data-param='${param}']`).removeClass('active');
                window.location.href = url;
            });

            //search from search input
            let searchInputField = $(document).find('.search-input');
            $(searchInputField).keypress(function(event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    let url = new URL($(location).attr('href'));
                    let queryParam = $(this).val();
                    url = removeParam(url, 'filter');
                    url = appendParam(url, 'filter', queryParam);
                    window.location.href = url;
                }
            });

            $('.sortBy').on('click', function() {
                let link = new URL($(location).attr('href'));
                link = removeParam(link, 'page');

                if ($(this).hasClass('active')) {
                    link = appendParam(link, 'sort_by', 'asc');
                } else {
                    link = removeParam(link, 'sort_by');
                }
                window.location.href = link;
            });

            $(document).on('click', '.search-images', function() {
                if (!$(this).hasClass('active')) {
                    let link = new URL($(location).attr('href'));
                    link = removeParam(link, 'page');
                    link = removeParam(link, 'type');
                    link = appendParam(link, 'type', 'image');
                    window.location.href = link;
                }
            })
            $(document).on('click', '.search-videos', function() {
                if (!$(this).hasClass('active')) {
                    let link = new URL($(location).attr('href'));
                    link = removeParam(link, 'page');
                    link = removeParam(link, 'type');
                    link = appendParam(link, 'type', 'video');
                    window.location.href = link;
                }
            })
            $(document).on('click', '.search-collections', function() {
                if (!$(this).hasClass('active')) {
                    let link = new URL($(location).attr('href'));
                    link = removeParam(link, 'page');
                    link = removeParam(link, 'type');
                    link = appendParam(link, 'type', 'collection');
                    window.location.href = link;
                }
            })
        })(jQuery);
    </script>
@endpush
