    @php
        use App\Models\admin;
        $admin = admin::first();
    @endphp
    <input type="hidden" id="admin_slug" value="{{ $admin->slug }}">
             </div><!--/.main content-->
                <footer class="footer-content">
                    <div class="footer-text d-flex align-items-center justify-content-between">
                        <div class="copy">Developed by: <a href="https://dgaps.com">Digital Applications</a></div>
                    </div>
                </footer><!--/.footer content-->
                <div class="overlay"></div>
            </div><!--/.wrapper-->
        </div>
         <script>
             var _token ="{{csrf_token()}}";
             var seg2 = "{{Request::segment(2)}}";
             var seg3 = "{{Request::segment(3)}}";
        </script>
          <!--Global script(used by all pages)-->
        
        <script src="{{ asset("admin-assets/dist/js/popper.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/metisMenu/metisMenu.min.js")}}"></script>
        <script src="{{ asset("admin-assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js")}}"></script>
        @if (Request::segment(2)=='dashboard')
           <!-- Third Party Scripts(used by this page)-->
{{-- 		    <script src="{{ asset("admin-assets/plugins/chartJs/Chart.min.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/apexcharts/dist/apexcharts.min.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/apexcharts/dist/apexcharts.active.js")}}"></script>
            <script src="{{ asset("admin-assets/plugins/emojionearea/dist/emojionearea.min.js")}}"></script> --}}
           
            <!--Page Active Scripts(used by this page)-->

        @endif
        @if (Request::segment(2)=='blogs' Or Request::segment(2)=='services')
           <!-- I-check for checkbox and radio button -->
            <script src="{{ asset("admin-assets/plugins/icheck/icheck.min.js")}}"></script>
            <script src="{{ asset("admin-assets/dist/js/pages/icheck.active.js")}}"></script>
             <link rel="stylesheet" href="{{ asset("admin-assets/dist/js/crop/jquery.Jcrop.min.css")}}">
            <script src="{{ asset("admin-assets/dist/js/crop/jquery.Jcrop.min.js")}}"></script>
          
        @endif  
        @if (Request::segment(2)=='blogs' and Request::segment(3)=='')
           <!-- TagsComplete Plugin -->
           <link rel="stylesheet" href="{{ asset("admin-assets/plugins/tags/tagcomplete.min.css")}}">
            <script src="{{ asset("admin-assets/plugins/tags/tagcomplete.min.js")}}"></script>
            
        @endif
        @if (Request::segment(2)=='homepage' || Request::segment(2)=='footer' || Request::segment(2)=='sidebar-settings' || Request::segment(2)=='authors' || ( Request::segment(2)=='blogs' and Request::segment(3)=='category') || Request::segment(2)=='faqs' )
           <!-- Nestable and dragable list -->
            <script src="{{ asset("admin-assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js")}}"></script>
            <script>
              $( function() {
                 $( "#sortable" ).sortable({
					 update: function( event, ui ) {
						 var n = 0;
						 $("#sortable .row").each(function(){
							 $(this).find(".uc-image").find("input").attr("name", "img"+n);
							 $(this).find(".image_display").attr("id", "img"+n);
							 n++;
						 });
					 },
                     revert: true
                 });
                 $( "#draggable" ).draggable({
                     connectToSortable: "#sortable",
                     helper: "clone",
                     revert: "invalid"
                 });
                 $( "ul, li" ).disableSelection();
             });
            </script>
        @endif
        <!--Page Scripts(used by all page)-->
        <script src="{{ asset("admin-assets/dist/js/sidebar.js")}}"></script>
        <script src="{{ asset("admin-assets/dist/js/custom.js")}}"></script>
        @if (Request::segment(2)=='blogs' && Request::segment(3)==''  )
            <link rel="stylesheet" href="{{ asset("admin-assets/plugins/jquery-ui-1.12.1/jquery-ui.css")}}">
            <script src="{{ asset("admin-assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js")}}"></script>
            <script >
               $(document).ready(function(){
					$('input').on("ifChanged",function(){
						if($(this).prop("checked") == true){
							$(this).parent().addClass("icheckbox_line-green c-checked");
                            $(this).parent().removeClass("icheckbox_line-grey");
						}
						else{
							$(this).parent().addClass("icheckbox_line-red");
                            $(this).parent().removeClass("icheckbox_line-green c-checked");
						}
					});
				});
               $(document).ready( function(){
                   setTimeout(function(){
                         $(".i-check input[type='checkbox']").each(function(){
                            if($(this).prop("checked") == true){
                                var el =  $(this).closest('.i-check').find(".checked");
                                el.addClass(" icheckbox_line-green ");
                                el.removeClass("icheckbox_line-grey");
                            }else{
                                var el =  $(this).closest('.i-check').find(".icheckbox_line-grey");
                                el.addClass(" icheckbox_line-red ");
                                el.removeClass("icheckbox_line-grey");
                            }     
                       });
                   },200);
               });
				$(function() {
                    $("#datepicker").datepicker({ dateFormat: "dd-mm-yy" }).val()
                 });
            </script>
        @endif
 @php
$mediaPanel = new \hassankwl1001\mediapanel\Http\Controllers\MediaPanelController;
echo $mediaPanel->index();
@endphp
@if (Request::segment(2)=='sidebar-settings')
    <script>
    $(document).on("click" , ".check_list" , function(){
        var chk = $(this).is(":checked"); 
        var d = $(this).attr("data-id");
        if (chk){
            var v = $(this).closest("tr").find("th").text();
            var sp = v.split("-");
            var sn = sp[1];
            var li = "<li id='li"+d+"'><b>"+sn+"</b><input type='hidden' name='order[]' value='"+d+"' class='form-control'/><span class='menu-del float-right' data-id='"+d+"'>x</span></li>";
            $(".msortable").append(li);
        }else{
            $(".msortable #li"+d).remove();
        }
    });
     $( document ).ready( function () {
        $(".msortable" ).sortable();
    });
</script>
@endif
    </body>
</html>