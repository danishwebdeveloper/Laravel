<?php
use App\Models\Admin;
use Jenssegers\Agent\Agent;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Admin Routes

$admin = admin::first();
$admin =  $admin->slug;
define("admin", "$admin");
Route::match(['get','post'],'/'.admin, "\App\Http\Controllers\AdminController@index")->name('admin')->middleware('guest:admin');
Route::group(['prefix' => admin,'middleware' => ['auth:admin'] , 'namespace'=>'\App\Http\Controllers' ] , function() {
    Route::get('/dashboard','AdminController@dashboard');
    Route::get('/logout','AdminController@logout');
    Route::match(["get", "post"] , '/homepage', 'HomeContoller@homemeta');
    Route::match(["get", "post"] , '/footer', 'HomeContoller@footer');
    //General Settings
    Route::get('/general-setting', 'GeneralsettingController@index');   
    Route::match(["get", "post"] ,'/menu', 'GeneralsettingController@menu');   
    Route::patch('/general-setting', 'GeneralsettingController@store');
    Route::get('/login-info', 'AdminController@logininfo');
    Route::post('/login-info', 'AdminController@storelogininfo');
    Route::get('/log-book', 'AdminController@logBook');
    Route::get('/send-email', 'AdminController@send_email');
    Route::post('/multiEmail', 'AdminController@_sendMail');
    Route::match(["get", "post"],'/internal-links', 'AdminController@internal_links');
    Route::get('/emails', 'AdminController@emails');
    Route::match(["get", "post"] , '/sorting', 'AdminController@_sorting');
    Route::match(["get", "post"],'/edit-emails', 'AdminController@edit_emails');
    Route::match(["get", "post"],'/internal-links', 'AdminController@internal_links');
    Route::match(["get", "post"],'/sidebar-settings', 'AdminController@sidebar_settings');
    //Blog Routes 
    Route::match(["get", "post"] , '/blogs', 'BlogsController@addBlogsSave')->name("save-blog");
    Route::get('/blogs/list', 'BlogsController@blogsList');
    Route::match(["get", "post"], '/blogs/meta', 'BlogsController@meta');
    Route::match(["get", "post"], '/blogs/category', 'BlogsController@blogCategory');
    Route::match(["get", "post"], '/blogs/cats-store', 'BlogsController@catsStore');
    Route::post('/category/order', 'BlogsController@catsorder');
    //Authors Routes 
    Route::match(["get", "post"],'/add-author', 'AuthorsController@addAuthor')->name("add-author");
    Route::get('/authors-list', 'AuthorsController@authorsList')->name("authors-list");

    // CMS ROUTES       
    Route::match(["get", "post"], '/faqs/meta', 'CmsController@faqs_meta');
    Route::match(["get", "post"],'/privacy-policy', 'CmsController@privacy')->name("privacy");
    Route::match(["get", "post"],'/terms-condition', 'CmsController@termscondition')->name("terms");
    Route::match(["get", "post"],'/faqs', 'CmsController@faqs')->name("admin-faqs");
    Route::get('/faqs-list', 'CmsController@allfaqs');
    Route::match(["get", "post"], '/faqs/meta', 'CmsController@faqs_meta');
    Route::post('/faqs/store', 'CmsController@faqsstore');
    Route::post('/faqs/order', 'CmsController@faqsorder');

    Route::get('/contact', 'CmsController@contact');
    Route::post('/contactus/store', 'CmsController@storecontactus');
    Route::match(["get", "post"] , '/ads', 'AdsController@index')->name("ads");
    Route::post('/get_views', 'AdminAjaxController@get_views');
    Route::get('/image-crop', 'AdminAjaxController@Croppie')->name("cropie");

    Route::post('/get-internal-links', 'AdminAjaxController@get_internalLinks');
});
//Front Routes
Route::group(["namespace"=>"\App\Http\Controllers"],function(){
	 $req_path = trim($_SERVER['REQUEST_URI'], "/");
      if (strpos($req_path,"index.php") !==false){
          $req_path = str_replace("index.php", "", $req_path);
          $req_path = trim($req_path,"/");
          $url = "https://foxynature.com/".$req_path;
          header("location:".$url, true,301);
      }
     if (substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.') {
     $scheme = "http";
     $on = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'')."://";
     $host = substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI'];
     $url = $scheme.$on.$host;
     header('Location:'.$url, true, 301);
     exit;
     }
    Route::get('/', 'MainController@index')->name("HomeUrl");
    Route::get('/contact', 'MainController@_contact');
    Route::get('/privacy-policy', 'MainController@privacy');
    Route::get('/terms-conditions', 'MainController@terms');
    Route::post('/contactform', 'AjaxController@contactform');
	Route::get('/faqs', 'MainController@_faqs');
    Route::post('/subscriber', 'AjaxController@subscriber');
    Route::get('/search', 'MainController@search');
    Route::get('/404', 'MainController@notFound');
    Route::get('sitemap.xml', 'SitemapController@_show');
    Route::get('images-sitemap.xml', 'SitemapController@_showimages');
    Route::get('/amp/{pageid}', function($last_id){
        $agent = new Agent();
        if ($agent->isDesktop()) {
             return  redirect($last_id);
        }else{
             return (new \App\Http\Controllers\MainController())->ampblogs();
        }
    });
    Route::get('/{url}', function ($url) {
        $last_id = get_postid("last_id");
        $page_id = get_postid("page_id");
        $full =  get_postid("full");
        $seg = Request::segment(1);
        if (is_numeric($last_id) and $seg!="404"){
            if ($page_id==1 or $page_id==2 ){
                 $agent = new Agent();
                 if($page_id==2 and ($agent->isMobile() OR $agent->isTablet())){
                  return  redirect("amp/".$full);
                }else{
                    return (new \App\Http\Controllers\MainController())->single();
                }
                return (new \App\Http\Controllers\MainController())->single();
            }else{
                return redirect("/404" , 301);
            }
        }else{
           return redirect("/404" , 301); 
        }
    });
});