
<div class="newsletter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 newsletter__text">
                <h3>Subscribe for SEO Tips & Tricks</h3>
            </div>
            <div class="col-lg-6">
                <form action="{{ $_SERVER['PHP_SELF'] }}">   
                <div class="newsletter__input">
                    <input type="email" name="email" class="form-control" placeholder="Please Enter Your Email to Subscribe">
                    <button class="btn btn-subscribe _sub_btn">Subscribe</button>
                </div>
                <div class="sub_error text-green"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Success Message -->
<div class="popup" id="popup-success">
    <div class="popup-content">
        <div class="popup-success">
            <h3><span>Success !! </span></h3>
            <h3><span class="icon icon-success"></span>
            <span class="alert">You have subscribed successfully</span>
            </h3>
            <button class="btn-close" type="button">Close</button>
        </div>
    </div>
</div>
<!-- Error Message -->
<div class="popup" id="popup-error">
    <div class="popup-content">
        <div class="popup-error">
            <h3><span>OOPs !!</span></h3>
            <h3><span class="icon icon-error"></span>
            <span class="alert">ok</span>
            </h3>
            <button class="btn-close" type="button">Close</button>
        </div>
    </div>
</div>
@php
    $d = \App\Homedata::select("social_links" , "copyrights")->first();
    $setting = \App\generalsetting::select("fbid")->first();
    $s = ( $d[ 'social_links' ] != "" ) ? json_decode( $d[ 'social_links' ], true ) : array();  
    $c = ( $d[ 'copyrights' ] != "" ) ? json_decode( $d[ 'copyrights' ], true ) : array();  
    $title = (isset($c['copyrights_title'])) ? $c['copyrights_title'] : "" ;
    $name = (isset($c['company_name'])) ? $c['company_name'] : "" ;
    $url = (isset($c['company_url'])) ? $c['company_url'] : "" ;
    if (get_postid("full") == ""){
        $type = "";
    }else{
        $type = " rel='nofollow noopener' ";
    }
@endphp
<footer>
    <div class="bd-footer-bottom">
        <div class="social-links text-center"> 
        @foreach ($s as $k)
             <a href="{{ $k['link']}}" target="_blank"><i class="{{ $k['icon'] }}"></i></a> 
        @endforeach
        </div>
        <ul class="nav footer-nav">
            <li><a href="{{ route('HomeUrl') }}/contact" class="text-center">Contact Us</a></li>
            <li><a href="{{ route('HomeUrl') }}/privacy-policy" class="text-center">Privacy Policy</a></li>
            <li><a href="{{ route('HomeUrl') }}/terms-conditions" class="text-center">Terms & Conditions</a></li>
			<li><a href="{{ route('HomeUrl') }}/faqs" class="text-center">FAQs</a></li>
        </ul>        
        <div class="footer-copyright">
        	<p class="text-center mt-1x">{!! $title !!} <a>{{ $name }}</a></p> <p class="text-center mt-1x">Developed By: <a href="https://dgaps.com" {!! $type !!} target="_blank">Digital Applications</a></p>
        </div>        
    </div>
</footer>
<div class="scroll-top"> <i class="icon-up"></i> </div>

@php 
$segment = request()->segment(1);
        $route = $segment;
        $page_name = get_postid("full");
		$page_id = get_postid("page_id");
        $post_id = get_postid("post_id");
@endphp

<script src="{{asset('assets/js/jquery.js') }}" ></script>
 @php
        $segment = request()->segment(1);
        $route = $segment;
        $page_name = get_postid("full");
        $page_id = get_postid("page_id");
        $post_id = get_postid("post_id");
@endphp

<script>
	var page_id = '{{ get_postid("page_id") }}';
	var post_id = '{{ get_postid("post_id") }}';
	var _slider_img = '<?php echo  _slider_img();  ?>';
</script>

	@php
		$home = \App\Homedata::all()->map->toArray();
		$slider = $home[0]['slider_images'];
		$slider = json_decode($slider);
	@endphp
    @if ($segment == "")
         <!--only For Home PAge-->
        @if (\Jenssegers\Agent\Facades\Agent::isDesktop())
            @if (count($slider) > 1)
                <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css') }}">
            @endif  
        @endif
    @endif



@if (  get_postid("page_id") == 2 )
<script src="{{asset('assets/js/jquery.lazy.min.js') }}" ></script>
<script>
	$("img.lazy" ).lazy();
</script>
@endif
@if (\Jenssegers\Agent\Facades\Agent::isDesktop())
    @if (request()->segment(1) == "" and _slider_img() >1)
        <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
            <script>
        jQuery("#carousel").owlCarousel({
          autoplay: true,
          lazyLoad: true,
          rewind: true,
          margin: 20,
          loop:true,
          autoplayHoverPause: true,
           /*
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          */
          responsiveClass: true,
          autoHeight: true,
          autoplayTimeout: 7000,
          smartSpeed: 800,
          nav: true,
          responsive: {
            0: {
              items: 1
            },

            600: {
              items: 1
            },

            1024: {
              items: 1
            },

            1366: {
              items: 1
            }
          }
        });
    </script>
    @endif
@endif

 @php
	$link = get_postid("full");
@endphp


<script>	

    function loadfiles(filename, filetype) {
        if (filetype == "js") { //if filename is a external JavaScript file
            var fileref = document.createElement('script');
            fileref.setAttribute("type", "text/javascript");
            fileref.setAttribute("src", filename);
        } else if (filetype == "css") { //if filename is an external CSS file
            var fileref = document.createElement("link");
            fileref.setAttribute("rel", "stylesheet");
            fileref.setAttribute("type", "text/css");
            fileref.setAttribute("href", filename);
        }
        if (typeof fileref != "undefined")
            document.getElementsByTagName("head")[0].appendChild(fileref);
    }

    setTimeout(function(){
        loadfiles("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap", "css");
    },500);


  
    function loadAddThis() {
        var js = document.createElement('script');
        js.src = '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e329ebb8882d29c';
        document.getElementById("add-this").appendChild(js);
		js.setAttribute("data-url" , "{{ route('HomeUrl') }}/{{ $link }}");
    }
	var dsktop = '{{ \Jenssegers\Agent\Facades\Agent::isDesktop() }}';
	if (dsktop == 1) {
	  setTimeout(loadAddThis, 9000);
	}

    $(".scroll-top").hide();
    $(".scroll-top").click(function() {
        $("html").animate({
            scrollTop: 0
        }, "slow");
    });
    $(window).on("scroll", function() {
        if ($(window).scrollTop() >= 5) {
            $(".bd-topnav").addClass("navbar-fixed");
        } else {
            $(".bd-topnav").removeClass("navbar-fixed");
        }
        if ($(window).scrollTop() <= 300) {
            $(".scroll-top").hide();
        } else {
            $(".scroll-top").show();
        }
    });
    $(window).on("resize", function() {
        if ($(window).width() < 768) {
            $(".bd-banner-text h3").text("Some Great Inspirational Words");
        };
    });
    if ($(window).width() < 768) {
        $(".bd-banner-text h3").text("Great Words");
    };
    $("li.dropdown").hover(function() {
        $(".btn-dropdown").css(
            "color", "#000"
        );
        $(".btn-dropdown").css(
            "border-radius", "5px 5px 0 0"
        );
    });
    $(".btn-dropdown").hover(function() {
       $('.searchContent').hide();
    });
    $("li.dropdown").mouseleave(function() {
        $(".btn-dropdown").css({
            "color": "#fff"
        });
    });
    $(".toggle-menu-btn").click(function() {
        $(".bd-topnav .navbar").toggle();
    });
     $("li.dropdown").click(function() {
        $(".dropdown-content").toggle();
    });
        $('.btn-popup').click(function(){
        $(".popup").show();
    });
        $(".btn-close").click(function(){
        $(".popup").hide();
    });
    $('.searchbtn').click(function(e){
      e.stopPropagation();
      $('.searchContent').toggle();
	  $('input[type="search"]').focus(); 
    })

    $('body').click(function(){
      $('.searchContent').hide();
    });
    $('.searchContent > *').click(function(e){
      e.stopPropagation();
    });
    $('.searchContent').click(function(e){
      e.stopPropagation();
    });
    @if ($setting['fbid'])
        function addMsgChat(){
         // console.log($("#facebook-jssdk").length);
        if($("#facebook-jssdk").length==0){
            window.fbAsyncInit = function() {
              FB.init({
                xfbml            : true,
                version          : 'v7.0'
              });
            };
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
        }
       }
        $(window).scroll(function(){
            var tp = $(window).scrollTop();
            if(tp > 500){
                addMsgChat();
            }
        });
    @endif
	if (location.href.includes('#')) {
		var urlHash = window.location.href.split("#")[1];
		//alert(urlHash);
		$('html, body').animate({scrollTop: $("#"+urlHash).offset().top -  160}, 100);
	}
 	jQuery('.smooth-goto').on('click', function() {  
		if($(".bd-topnav").hasClass("navbar-fixed")){
			$('html, body').animate({scrollTop: $(this.hash).offset().top - 120}, 100);
		}
		else{	
			$('html, body').animate({scrollTop: $(this.hash).offset().top - 200}, 100);
		}
		
	  //  return false;
	});
</script>
@if ($setting['fbid'])
    <!-- Your customer chat code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="1509153186066891"
         greeting_dialog_display="fade">
      </div>
@endif
@if (request()->segment(1) == "contact")
<script src="{{asset('assets/validate/validate.js') }}" ></script>
<link rel="stylesheet" href="{{asset('assets/validate/style.css') }}">
<script>
$(document).ready(function () {
    $(".close").on("click", function(){
        $(this).closest("div").remove();
    });
    _is_validate("#contactform", { name: { require: !0, min: 3, max: 50 }, email: { require: !0, email: !0 }, subject: { require: !0, min: 5, max: 100 }, message: { require: !0, min: 10, max: 5000 } }),
        $(".contactform").click(function (e) {
            e.preventDefault();
            var r = $(this),
                a = r.closest("form"),
                t = r.closest("form").serializeArray();
            r.attr("disabled", !0),
                $.ajax({ headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }, type: "post", global: "false", datatype: "html", url: "/contactform", data: t })
                    .done(function (e) {
                        if (e.resp === "success") {
                                r.closest("form").trigger("reset"),
                                r.closest("form").closest("div").find("img").remove(),
                                r.closest("form").find(".dg-b-icon").remove(),
                                r.attr("disabled", !1),
                                $("#errors").html(
                                "<div class='alert alert-success alert-dismissible'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Success!</strong> Your message has been submitted. You will get a response very soon.</div>"
                                ),
                                "undefined" != typeof grecaptcha && grecaptcha && grecaptcha.reset && grecaptcha.reset();
                        }else{
                        $("<p>", { id: "foo", class: "a" });
                        var error = e.msg;
                        r.closest("div").find("img").remove();
                            r.attr("disabled", !1);
                            a.find("div.error").remove();
                            a.find("input").prevAll("._dg_error").remove();
                            a.find("textarea").prevAll("._dg_error").remove();
                            error.name && ($("input[name='name']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + error.name + "</div>").insertBefore($("input[name='name']")));
                            error.message && ($("textarea[name='message']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + error.message + "</div>").insertBefore($("textarea[name='message']")));
                            error.email && ($("#contactform input[name='email']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + error.email + "</div>").insertBefore($("#contactform input[name='email']")));
                            error.phone && ($("input[name='phone']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + error.phone + "</div>").insertBefore($("input[name='phone']")));
                            error.subject && ($("input[name='subject']").addClass("dg-b-error"), $("<div class='_dg_error error'>" + error.subject + "</div>").insertBefore($("input[name='subject']")));
                            $("#errors").html("");
                        }
                        
                    })
                    
                e.preventDefault();
        });
});

</script>
@endif
<script>
	jQuery(document).ready(function (e) {
    $("._sub_btn").click(function (t) {
        t.preventDefault();
        var _this = $(this),
            a = _this.closest("form").serializeArray();
        _this.attr("disabled", false);
            e.ajax({ headers: { "X-CSRF-TOKEN": e('meta[name="csrf-token"]').attr("content") }, type: "post", global: "false", datatype: "html", url: "/subscriber", data: a })
                .done(function (e) {
                    if (e.resp === "success") {
                    _this.closest("form").trigger("reset");
                    _this.closest("div").find("img").remove();
                    _this.attr("disabled", true);
                     $("#popup-success").show();
                    }else{
                        var error = e.msg;
                        console.log(error);
                        _this.attr("disabled", true);
                         $("#popup-error .alert").text(error.email);
                         $("#popup-error").show();
                         _this.attr("disabled", false);
                    }
                })
            t.preventDefault();
    });
});

</script>
@if ( get_postid("page_id") == 2 OR request()->segment(1) == "faqs" )
<script>
  function loadPlugin(){var s=document.createElement("script");s.src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v5.0",document.getElementById("fb-commentbox").appendChild(s)}setTimeout(loadPlugin,9e3),$(".ex-faqs-item:not(.visible)").find(".ex-faqs-body").hide(),$(".ex-faqs-header").click(function(){var s=$(this).next(".ex-faqs-body");$(".ex-faqs-body").not(s).slideUp(500),$(".ex-faqs-body").not(s).parent(".ex-faqs-item").removeClass("visible"),$(this).parent().is(".visible")?($(this).closest(".ex-faqs-item").find(".ex-faqs-body").slideUp(500),$(this).closest(".ex-faqs-item").removeClass("visible"),$(".ex-faqs-header .faqs-icon i").addClass("plus-icon"),$(".ex-faqs-header .faqs-icon i").removeClass("minus-icon")):($(this).closest(".ex-faqs-item").find(".ex-faqs-body").slideDown(500),$(this).closest(".ex-faqs-item").addClass("visible"),$(".ex-faqs-header .faqs-icon i").addClass("plus-icon"),$(".ex-faqs-header .faqs-icon i").removeClass("minus-icon"),$(this).find(".faqs-icon i").addClass("minus-icon"),$(this).find(".faqs-icon i").removeClass("plus-icon"))});
</script>
@endif
<script>
	 $(window).on('resize , load', function(){
	if ($(window).width() >= 991 && $(window).width() <=1200) {
		$(".rec-4").hide();
		}else{
		$(".rec-4").show();	
		}
	});
  $(window).on('load', function(){
    $('.article__column .quote-image img').each(function() {
        var maxWidth = 300; // Max width for the image
        var minHeight = 200;    // Max height for the image
        var ratio = 1.5;  // Used for aspect ratio
        var width = $(this).width();    // Current image width
        var height = $(this).height();  // Current image height

        if(width > maxWidth){
            ratio = maxWidth / width;   // get ratio for scaling image
            $(this).css("width", maxWidth); // Set new width
            $(this).css("height", height * ratio);  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        }

        // Check if current height is larger than max
        if(height < minHeight){
            ratio = minHeight / height; // get ratio for scaling image
            $(this).css("height", minHeight);   // Set new height
            $(this).css("width", width * ratio);    // Scale width based on ratio
            width = width * ratio;    // Reset width to match scaled image
        }
		
   });
	$('.popular__column .quote-image img').each(function() {
        var maxWidth = 150; // Max width for the image
        var minHeight = 100;    // Max height for the image
        var ratio = 1.5;  // Used for aspect ratio
        var width = $(this).width();    // Current image width
        var height = $(this).height();  // Current image height

        if(width > maxWidth){
            ratio = maxWidth / width;   // get ratio for scaling image
            $(this).css("width", maxWidth); // Set new width
            $(this).css("height", height * ratio);  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        }

        // Check if current height is larger than max
        if(height < minHeight){
            ratio = minHeight / height; // get ratio for scaling image
            $(this).css("height", minHeight);   // Set new height
            $(this).css("width", width * ratio);    // Scale width based on ratio
            width = width * ratio;    // Reset width to match scaled image
        }
		
   });
});
</script>
<style>
	 #the-sticky-div.sticky {
     position: sticky;
     top: 100px;
  }
</style>
<script>
	   // Cache selectors outside callback for performance. 
   var $window = $(window),
       $stickyEl = $('#the-sticky-div'),
       elTop = $stickyEl.offset().top;

   $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });
</script>
</body>
</html>
