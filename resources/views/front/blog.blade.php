@include( 'front.layout.header' )
@php
$post_id = get_postid('post_id');
$title = ($blog['title'] !="") ? '<h1 class="single-title ">'.$blog['title'].'</h1>' : "";
$views = ($blog['views'] !="") ? '<div class="icon"> <i class="icon-eye pr-2"></i>'.total_views($post_id).'</div>' : "";
$date = ($blog['date'] !="") ? '<div class="icon"> <i class="icon-calendar pr-2"></i>'.date("d M Y",$blog['date']).'</div>' : "";
$content = ($blog['content'] !="") ? $blog['content'] : "";
$cat = ($blog['category'] !="") ? (Array)get_catByname($blog['category']) : "";
$c_url = ($blog['category'] !="") ? get_catUrl($blog['category']) : "";

$c_title = isset($cat['title']) ? $cat['title'] : "";
$InternalLinks = new \App\Helpers\InternalLinks;
$i_tags = $InternalLinks->allDBLinks();
@endphp
<div class="wrapper">
    @include( 'front.layout.topbar' )
    @include( 'front.temp.breadcrumb' )
    
    <div class="bd-container">
        <div class="quote-single row m-0">
            <main class="col-lg-8 my-3 quote-main__col">
                <div class="single-header bg-white">
                    <div class="title-head">
                        {!! $title !!}
                    </div>
                    <div class="bd-sngtitle-bottom d-flex justify-content-between">
                        {!! $date !!} {!! $views !!}
                    </div>
                </div>
                @php
                $tags = explode(",", $blog['meta_tags']);
                $titles = explode(" ", $blog['title']);
                $content = do_short_code($content, $blog['id'] , "blogs",$titles, $tags);
                $ct = table_of_content($content);
                $content = $ct["content"];
                $tc = array("ct"=>$ct["table"]);
                $table = View::make('front/temp/table-of-content', $tc)->render();
                $content = str_replace("[[toc]]", $table, $content);
                $content = $InternalLinks->building($blog['id'], $content, $i_tags);
				$content = lazy_content($content);				
                @endphp
                {!! $content !!}
                @php
                    $author_id[] =  $blog['author'];
					$blog['author'];
                @endphp
                @if ($blog['author'] >0)
                    @include( "front.temp.author" , $author_id )
                @endif
                <br>
				<!-- facebook comments starts -->
				   <div class="fb-comments-plugin text-center" id="fb-commentbox">
						<h4 class="comment-title"><img src="{{ route('HomeUrl') }}/images/speech-bubble.svg" alt="comments icon" width="25" height="25"> Please Write Your Comments!</h4>
						<div class="fb-comments" id="fb_comments" data-href="{{  url()->full() }}" data-numposts="5" data-width="100%" data-order-by="reverse_time"></div>
					</div>
				<!-- facebook comments ends -->
            </main>
            @include('front.sidebar.common')
        </div>
    </div>
</div>
    @php
        $views = total_views($post_id);
     refresh_views($views , get_postid('post_id') , get_postid('page_id'), "" );
   @endphp
    @include( 'front.layout.footer' )



