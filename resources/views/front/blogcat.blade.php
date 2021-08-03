@include( 'front.layout.header' )
<div class="wrapper">
  @include( 'front.layout.topbar' )
  @include( 'front.temp.breadcrumb' )
  <!--====== New Quote Section ====-->
  @php
  $p_title = ($cats['title'] !="") ? $cats['title'] : "" ;
  $p_details = ($cats['details'] !="") ? $cats['details'] : "" ;
  $popular_title = ($cats['popular_title'] !="") ? "<h2 class='section-title'>".$cats['popular_title']."</h2>" : "" ;
  $after_title = ($cats['after_title'] !="") ? "<h2 class='section-title'>".$cats['after_title']."</h2>" : "" ;
  $bf = ($cats['before_popular'] !="") ? $cats['before_popular'] : 2 ;
  $st = $bf * 4;
  $aftr = ($cats['after_popular'] !="") ? $cats['after_popular'] : 2 ;
  $nd  = $aftr * 4;
  @endphp
  <section class="quotes-section insp-quotes quote-list-one isLoading" id="catSec0">
    <div class="bd-container p-0">
      <h1 class="main-title">{{ $p_title }}</h1>
      <p class="bd-secbottom">{!! $p_details !!}</p>
      <div class="row my-2x">
        @php
        $blog = json_decode(json_encode($blogs) , true);
        // dd($blog["data"]);
        
        $blog1 = array_slice($blog["data"], 0, $st);
        $blog2 = array_slice($blog["data"], $st);
        @endphp
        @isset ($blog1)
        @foreach ($blog1 as $v)
        @php
        $title = unslash( $v["title"] );
        $short_title = ( strlen( $title ) > 60 ) ? substr( $title, 0, 160 ) . "...": $title;
        $content = trim(trim_words( html_entity_decode($v["content"]), 35 ));
        $content = clean_short_code(html_entity_decode($content));
		  $content =  str_replace("\xc2\xa0",' ',$content); 
        $image = $v["cover"];
        $date = date("d M Y", $v["date"] );
        $views =  $v["views"];
        $url = route('HomeUrl')."/".$v["slug"]."-2".$v["id"];
        @endphp
        <article class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-1x wow animate__animated animate__bounceInUp">
          <div class="article__column">
            <div class="article-img">
              <a href="{{ $url }}" class="quote-image"> <img src="{{ get_post_mid($image) }}"   width="300" height="200"  class="img-fluid" alt="{{ $title }}"> </a>
            </div>
            
            <div class="quote-body">
              <div class="quote-title">
                <h3><a href="{{ $url }}">{{ $short_title }}</a></h3>
              </div>
              <div class="d-flex justify-content-between">
                <div class="quote-date d-flex pt-1x"> <i class="icon-calendar"></i> <span>{{ $date }}</span> </div>
                <div class="quote-views d-flex pt-1x"> <i class="icon-eye"></i> <span>{{ $views }}</span> </div>
              </div>
            </div>
          </div>
        </article>
        @endforeach
        @endisset
      </div>
    </div>
  </section>
  <section class="quotes-section popular-quotes isLoading" id="catSec1">
    {!! $popular_title !!}
    <div class="bd-container p-0">
      <div class="row my-2x"> @foreach ($res as $k => $v)
        @php
        $title = unslash( $v->title );
        $short_title = ( strlen( $title ) > 100 ) ? substr( $title, 0, 100 ) . "...": $title;
        $content = trim(trim_words( html_entity_decode($v->content), 15 ));
        $content = clean_short_code(html_entity_decode($content));
		  $content =  str_replace("\xc2\xa0",' ',$content); 
        $image = $v->cover;
        $date = date("d M Y", $v->date );
        $views =  $v->views;
        $url = route('HomeUrl')."/".$v->slug."-2".$v->id;
        @endphp
        <article class="col-md-12 col-lg-6 ">
          <div class="popular__column row">
            <div class="col-sm-4 pr-0">
              <div class="article-img">
                <a href="{{ $url }}" class="quote-image"> <img src="{{ get_image($image) }}" class="img-fluid" alt="{{ $title }}"> </a>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="quote-title">
                <h3><a href="{{ $url }}">{{ $short_title }}</a></h3>
              </div>
              <p>{!! $content !!}</p>
              <div class="d-flex justify-content-between popular-bottom">
                <div class="quote-date"> <i class="icon-calendar"></i> <span >{{ $date }}</span> </div>
                <div class="quote-views"> <i class="icon-eye"></i> <span >{{ $views }}</span> </div>
              </div>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @isset ($blog2)
  <section class="quotes-section insp-quotes quote-list-one isLoading" id="catSec2" >
    <div class="bd-container p-0">
      {!! $after_title !!}
      <div class="row my-2x">
        @foreach ($blog2 as $v)
        @php
        $title = unslash( $v["title"] );
        $short_title = ( strlen( $title ) > 60 ) ? substr( $title, 0, 160 ) . "...": $title;
        $content = trim(trim_words( html_entity_decode($v["content"]), 35 ));
        $content = clean_short_code(html_entity_decode($content));
		  $content =  str_replace("\xc2\xa0",' ',$content); 
        $image = $v["cover"];
        $date = date("d M Y", $v["date"] );
        $views =  $v["views"];
        $url = route('HomeUrl')."/".$v["slug"]."-2".$v["id"];
        @endphp
        <article class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-1x wow animate__animated animate__bounceInUp">
          <div class="article__column">
            <div class="article-img">
              <a href="{{ $url }}" class="quote-image"> <img src="{{ get_post_mid($image) }}"   width="300" height="200"  class="img-fluid" alt="{{ $title }}"> </a>
            </div>
            <div class="quote-body">
              <div class="quote-title">
                <h3><a href="{{ $url }}">{{ $short_title }}</a></h3>
              </div>
              <div class="d-flex justify-content-between">
                <div class="quote-date d-flex pt-1x"> <i class="icon-calendar"></i> <span>{{ $date }}</span> </div>
                <div class="quote-views d-flex pt-1x"> <i class="icon-eye"></i> <span>{{ $views }}</span> </div>
              </div>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @endisset
  {{ $blogs->links('front.layout.pagination') }}
</div>
@php
refresh_views($cats['views'] , get_postid('post_id') , get_postid('page_id'), "" );
@endphp
@include( 'front.layout.footer' )