<?php

namespace App\Http\Controllers;

use App\Privacy;
use App\Models\Pages;
use App\Blogs;
use App\Faqs;
use App\blogcats;
use App\Homedata;
use App\ContactUs;
use App\Helpers\Options;
use Illuminate\Support\Facades\DB;

class MainController extends Controller {
  public $Options;
  public function __construct(){
      $this->Options = new Options;
  }
  public function index() {
    $blogs = Blogs::orderBy('id', 'desc')->take(4)->get();
    return view( 'front.home', compact( 'blogs' ) );
  }
  /*AMP Blog Function*/
  public function ampblogs() {
      $page_id = get_postid2('page_id');
      $post_id = get_postid2('post_id');
      //checks if category id not numeric
      if (!is_numeric($post_id)){
        return redirect(route("HomeUrl")."/404");
      }
      //checks if category does not exists 
      /*$blogs = Blogs::whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->get();*/
      $blog = Blogs::where('id', $post_id)->first();
      if (!isset($blog->id)){
        return redirect(route("HomeUrl")."/404");
      }
      
      $slug = get_postid2("slug");
      $c_slug = $blog->slug;
      if ($slug!=$c_slug){
        return redirect(route("HomeUrl")."/amp/".$blog->slug."-2".$blog->id);
      }
        $cats = blogcats::select('id', 'title','slug')->get();
        return view('front.blog-amp', compact('blog' , 'cats'));
      } 
  public function single() {
    if ( get_postid( 'page_id' ) == 1 ) {
      $page_id = get_postid( 'page_id' );
      $post_id = get_postid( 'post_id' );
      //checks if category id not numeric
      if ( !is_numeric( $post_id ) ) {
        return redirect( route( "HomeUrl" ) . "/404" );
      }
      //checks if category does not exists 
      $cats = blogcats::where( 'id', $post_id )->first();
      if ( !isset( $cats->id ) ) {
        return redirect( route( "HomeUrl" ) . "/404" );
      }

      $slug = get_postid( "slug" );
      $c_slug = $cats->slug;
      if ( $slug != $c_slug ) {
        return redirect( route( "HomeUrl" ) . "/" . $cats->slug . "-1" . $cats->id );
      }
      $r = blogcats::where( 'id', $post_id )->select("before_popular" , "after_popular")->first(); 
		//dd($r);
       $pgnt = ($r["before_popular"] + $r["after_popular"]) * 4 ;
     // dd($pgnt);
      $blogs = Blogs::orderBy('id', 'desc')->where('status' , 'publish')->whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->paginate($pgnt);
      $res = Blogs::orderBy('views', 'desc')->where('status' , 'publish')->whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->get()->take(4);
   //   dd($res);
      return view( 'front.blogcat', compact( 'cats', 'blogs' , 'res' ) );
    } elseif ( get_postid( 'page_id' ) == 2 ) {
      $page_id = get_postid( 'page_id' );
      $post_id = get_postid( 'post_id' );

      //checks if category id not numeric
      if ( !is_numeric( $post_id ) ) {
        return redirect( route( "HomeUrl" ) . "/404" );
      }
      //checks if category does not exists 
      /*$blogs = Blogs::whereRaw("FIND_IN_SET(?, category) > 0", [$post_id])->get();*/

      $blog = Blogs::where(['id'=> $post_id , 'status' => 'publish'])->first();
      if ( !isset( $blog->id ) ) {
        return redirect( route( "HomeUrl" ) . "/404" );
      }
      $slug = get_postid( "slug" );
      $c_slug = $blog->slug;
      if ( $slug != $c_slug ) {
        return redirect( route( "HomeUrl" ) . "/" . $blog->slug . "-2" . $blog->id );
      }
      $cats = blogcats::select( 'id', 'title', 'slug' )->get();
      return view( 'front.blog', compact( 'blog', 'cats' ) );
    } 
  }
  public function _contact() {
    $data = ContactUs::orderBy( "id", "desc" )->first();
    return view( 'front.contact-us', compact( 'data' ) );
  }
  public function privacy() {
    $data = Pages::where('page_name', 'privacy')->first();
    return view( 'front.privacy', compact( 'data' ) );
  }
 public function _faqs(){
    $data = Faqs::orderBy('tb_order', 'desc')->get();
    return view('front.faqs' , compact('data')); 
   }
  public function terms() {
    $data = Pages::where('page_name', 'terms-condition')->first();
    
    return view( 'front.terms', compact( 'data' ) );
  }
  public function search() {
    $where = request()->get('search');
    $query  = "select * , MATCH(title) AGAINST('$where') AS score from blogs where MATCH(title) AGAINST('$where')  and status='publish' ORDER BY ID DESC ";
      $data = DB::select($query);
      $where = $where;
      return view( 'front.temp.search', compact( 'data' , 'where') );
  }
  public function notFound() {
    return view( 'front.404' );
  }
}