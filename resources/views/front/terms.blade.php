@include('front.layout.header')
<div class="wrapper">
    @include('front.layout.topbar')
    <div class="breadcrumb">
        <div class="bd-container">
            <ul class="nav d-flex">
                <li><a href="{{ route('HomeUrl') }}">Home</a></li>
                <li class="active"><a href="{{ route('HomeUrl') }}term-conditions">Terms & Conditons</a></li>
            </ul>
        </div>
    </div>
    <div class="bd-container">
        <div class="privacy-policy row m-0">
            <main class="col-lg-8 quote-main__col mt-2x">
                @php
                $content = ($data["content"] !="" ) ? $data["content"]: "";
                @endphp
                {!! $content !!}
            </main>
            @include('front.sidebar.common')
        </div>
    </div>
    @php
    $row = \App\TermsCondition::select('views')->first();
    refresh_views($row['views'] , 0 , 5 , get_postid('full'));
    @endphp
    @include('front.layout.footer')
