@php
    $segment = request()->segment(1);
    $route = $segment;
    $page_name = get_postid("full");
    $page_id = get_postid("page_id");
    $post_id = get_postid("post_id");
    $setting = \App\generalsetting::first();
    $favicon =  (isset($setting->favicon)) ? $setting->favicon : "";
    $google_analytics =  (isset($setting->google_analytics)) ? $setting->google_analytics : "";
    $web_master =  (isset($setting->web_master)) ? $setting->web_master : "";
    $bing_master =  (isset($setting->bing_master)) ? $setting->bing_master : "";
    $og_image = (isset($setting->og)) ? $setting->og: "" ;
    $schema = array();
    if($page_name == ""){
        $data = \App\Homedata::first();
        $schema   = ($data['microdata']  !="" )? json_decode($data['microdata']  , true) : array();
        $data   = ($data['home_meta']  !="" )? json_decode($data['home_meta']  , true) : array();
        $meta_title = (isset($data["meta_title"]) and $data["meta_title"] !="") ? $data["meta_title"] : "";
        $meta_description = (isset($data["meta_description"]) and  $data["meta_description"]!="") ? $data["meta_description"] : "";
        $meta_tags = (isset($data["meta_tags"]) and $data["meta_tags"] !="") ? $data["meta_tags"] : "";
        $og_image = (isset($data["og_image"])) ? $data["og_image"] : $og_image ;
    }elseif($page_name == "who-is-ghulam-abbas"){
        $data = \App\AboutUs::first();
        $schema   = ($data['microdata']  !="" )? json_decode($data['microdata']  , true) : array();
        $about_og = isset($data['og_image']) ? $data['og_image'] : "";
        $data = isset($data['about_meta']) ? json_decode($data['about_meta'] , true) : array();
        $meta_title = ($data["meta_title"] !="") ? $data["meta_title"] : "";
        $meta_description = ($data["meta_description"] !="") ? $data["meta_description"] : "";
        $meta_tags = ($data["meta_tags"] !="") ? $data["meta_tags"] : "";
        $og_image = ($about_og!="") ? $about_og :$og_image;
    }elseif($page_name == "blogs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->og_image)?$r->og_image:$og_image;
    }elseif($page_name == "careers"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = isset($r->meta_tags)?$r->meta_tags:$og_image;
    }elseif($page_name == "faqs"){
        $r = DB::table('meta')->where('page_name',$page_name)->first();
        $meta_title = $r->meta_title?$r->meta_title:'';
        $meta_description = $r->meta_description?$r->meta_description:'';
        $meta_tags = $r->meta_tags?$r->meta_tags:'';
        $og_image = $r->og_image?$r->meta_tags:$og_image;
    }elseif($page_name == "contact"){
        $data = \App\ContactUs::first();
        $schema   = ($data['microdata']  !="" )? json_decode($data['microdata']  , true) : array();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->meta_tags:$og_image;
    }elseif($page_name == "privacy-policy"){
        $data = \App\Privacy::first();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "terms-conditions"){
        $data = \App\TermsCondition::first();
        $meta_title = (isset($data->meta_title))?$data->meta_title:'';
        $meta_description = (isset($data->meta_description))?$data->meta_description:'';
        $meta_tags = (isset($data->meta_tags))?$data->meta_tags:'';
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "pension-calculator"){
        $r = \App\Pension::first();
        $meta_title = isset($r->meta_title)?$r->meta_title:'';
        $meta_description = isset($r->meta_description)?$r->meta_description:'';
        $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
        $og_image = isset($r->og_image)?$r->og_image:$og_image;
        $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
    }elseif($page_name == "404"){
        $meta_title = "Page Not Found";
        $meta_description = "Page Not Found";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }elseif($page_name == "search"){
        if (request()->has('search')) {
               $meta_title = (!empty(request()->get('search'))) ? "Search - ".request()->get('search') : "Search - Xrays Blog";
        }
        $meta_description = "Search Result";
        $meta_tags = "";
        $og_image = isset($data->og_image)?$data->og_image:$og_image;
    }else{
        switch ($page_id) {
            case 2:
                $r = \App\Blogs::find($post_id);
                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                    $og_image = isset($r->og_image)?$r->og_image:"";
                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                    break;
            case 1:
                    $r = \App\blogcats::find($post_id);
                    $meta_title = isset($r->meta_title)?$r->meta_title:'';
                    $meta_description = isset($r->meta_description)?$r->meta_description:'';
                    $meta_tags = isset($r->meta_tags)?$r->meta_tags:'';
                    $og_image = isset($r->og_image)?$r->og_image:$setting->og;
                    $schema   = ($r->microdata  !="" )? json_decode($r->microdata  , true) : array();
                    break;
            default:
                $meta_title = $meta_title;
                $meta_description =$meta_description;
                $meta_tags = $meta_tags;
                $og_image = $setting->og;
        }
          $og_image;
}
@endphp
		<meta charset="utf-8">
		<title>{{$meta_title}}</title>
		<meta http-equiv="Content-Security-Policy" content="base-uri 'self'">
		<meta name="theme-color" content="#4B9DD6"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="{{$favicon}}" rel="shortcut icon" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{$favicon}}">
        <link rel="canonical" href="{{ url('/'.$page_name) }}" />
		<meta name="title" content="{{$meta_title}}">
		<meta name="description" content="{{$meta_description}}">
		<meta name="keywords" content="{{ $meta_tags }}">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:url" content="{{ url('/'.$page_name) }}">
		<meta name="twitter:title" content="{{$meta_title}}">
		<meta name="twitter:description" content="{{$meta_description}}">
		<meta name="twitter:image" content="{{$og_image}}">
		<meta property="og:type" content="website">
		<meta property="og:url" content="{{ url('/'.$page_name) }}">
		<meta property="og:title" content="{{$meta_title}}">
		<meta property="og:description" content="{{$meta_description}}">
		<meta property="og:image" content="{{$og_image}}">
		<meta name="robots" content = "noindex, nofollow">
@if ($page_id == 2)
        <link rel="amphtml" href="{{ route("HomeUrl")}}/amp/{{$page_name}}" />
@endif
        <meta name="csrf-token" content="{{ csrf_token() }}">
	@foreach ($schema as $element) @if (strpos($element['schema'], "script") !==false)
		{!! $element['schema'] !!} 
	@endif
	@endforeach
		<script>
			var page_id = {{ get_postid("page_id") }};
		</script>
		{!! $web_master !!}
		{!! $google_analytics !!}
		{!! $bing_master !!}