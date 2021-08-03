<!--====== New Quote Section ====-->
@php
$blogs = \App\Blogs::orderBy('id', 'desc')->where('status' , 'publish')->whereRaw("FIND_IN_SET(?, category) > 0", $data['category'])->take(4)->get();
$heading = ($data['num'] == 0) ? '<h1 class="main-title">'.$data["title"].'</h1>' : '<h2 class="main-title">'.$data["title"].'</h2>' ;
$catUrl = get_catUrl($data['category']);
@endphp
<section class="quotes-section new-quotes">
  <div class="isLoading" id="homeSec{{ $data["num"] }}">
  {!! $heading !!}
  <div class="bd-container p-0">
    <div class="row">
      @foreach ($blogs as $k => $v)
      @php
		$nu = $k+1;
      $title = unslash( $v->title );
      $short_title = ( strlen( $title ) > 100 ) ? substr( $title, 0, 100 ) . "...": $title;
      $content = trim(trim_words( html_entity_decode($v->content), 35 ));
      $content = clean_short_code(html_entity_decode($content));
		$content =  str_replace("\xc2\xa0",' ',$content); 
      $image = $v->cover;
      $date = date("d M Y", $v->date );
      $views =  $v->views;
      $url = route('HomeUrl')."/".$v->slug."-2".$v->id;
      @endphp
      <article class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-1x wow animate__animated animate__bounceInUp rec-{{ $nu }}">
        <div class="article__column">
          <div class="article-img">
            <a href="{{ $url }}" class="quote-image"> 
          <img src="{{ get_post_mid($image) }}"   width="300" height="200"  class="img-fluid" alt="{{ $title }}">
           </a>
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
  <div class="row col-md-12 d-flex justify-content-center mt-2x"> <a href="{{ $catUrl }}" class="view-more text-center">View More <i class="icon-arrow"></i></a> </div>
</div>
</div>
</section>