@extends($activeTemplate . 'layouts.frontend')
@section('content')

    @include($activeTemplate . 'partials.banner')
    @include($activeTemplate . 'partials.category')
    @include($activeTemplate . 'partials.images', ['images' => $images])
    @include($activeTemplate . 'partials.videos')

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
