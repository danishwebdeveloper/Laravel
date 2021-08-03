<!--====== Most Popular Quotes Section ====-->
@php
$count = substr($data["category"], -1);
$blogs = \App\Blogs::where('status' , 'publish')->orderBy('views', 'desc')->take(12)->get()->toArray();
$blogs = array_chunk($blogs, 4);
if ($count ==1) {
$blogs = $blogs[0];
} elseif($count ==2) {
$blogs = $blogs[1];
}elseif($count ==3) {
$blogs = $blogs[2];
}else{
$blogs = $blogs[0];
}
@endphp
<section class="quotes-section popular-quotes">
  <div class="isLoading" id="homeSec{{ $data["num"] }}">
    <h2 class="section-title">{{ $data["title"] }}</h2>
    <div class="bd-container p-0">
      <div class="row">
        @foreach ($blogs as $v)
        @php
        $title = unslash( $v['title'] );
        $short_title = ( strlen( $title ) > 75 ) ? substr( $title, 0, 140 ) . "...": $title;
        $content = trim(trim_words( html_entity_decode($v['content']), 35 ));
        $content = trim(clean_short_code(html_entity_decode($content)));
		$content =  str_replace("\xc2\xa0",' ',$content); 
        $image = $v['cover'];
        $date = date("d M Y", $v['date'] );
        $views =  $v['views'];
        $url = route('HomeUrl')."/".$v['slug']."-2".$v['id'];
        @endphp
        <article class="col-md-12 col-lg-6">
          <div class="popular__column row">
            <div class="col-sm-4 pr-0">
              <div class="article-img">
                <a href="{{ $url }}" class="quote-image">
                  <img  src="{{ get_post_mid($image) }}" width="300" height="200"  class="img-fluid" alt="{{ $title }}">
                </a>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="quote-title">
                <h3><a href="{{ $url }}">{{ $title }}</a></h3>
              </div>
              <p>{!! trim(strip_tags($content)) !!}</p>
              <div class="d-flex justify-content-between popular-bottom">
                <div class="quote-date"> <i class="icon-calendar"></i> <span>{{ $date }}</span> </div>
                <div class="quote-views"> <i class="icon-eye"></i> <span>{{ $views }}</span> </div>
              </div>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </div>
</section>