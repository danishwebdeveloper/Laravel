
@php
    $d = \App\Authors::where('id' , $author_id[0])->first();
    $s = ( $d[ 'social_links' ] != "" ) ? json_decode( $d[ 'social_links' ], true ) : array();
@endphp
<div class="author-box row" id="author-box">
    <div class="col-sm-2 col-md-3 col-lg-2 px-0 image-col"> <img class="author-image" src="{{ get_post_thumbnail($d['cover']) }}" alt="author-image" width="100" height="100" > </div>
    <div class="col-sm-10 col-md-9 col-lg-10 auth__desc-col">
        <div class="authtop-box">
            <h4 class="text-lblue">{{ $d['name'] }}</h4>
            <ul class="nav author_nav">
                @foreach ($s as $k)
                    <li> <a href="{{ $k['link']}}" class="{{ $k['icon'] }}" target="_blank"></a> </li>
                @endforeach
            </ul>
        </div>
        {!! $d['details']  !!}
    </div>
</div>