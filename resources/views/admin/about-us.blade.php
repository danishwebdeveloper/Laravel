@include('admin.layout.header')
@php
tiny_editor();
@endphp
<div class="body-content">
  <div class="row">
    <div class="col-md-10 col-lg-12">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">About Us</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <a href="{{url('/'.admin.'/about')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Main Record</a>
                <a href="{{url('/'.admin.'/about/works')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='works'  ? 'btn-inverse' : 'btn-info' }} pull-right">Works / Projects</a>
                <a href="{{url('/'.admin.'/about/skills')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='skills'  ? 'btn-inverse' : 'btn-info' }} pull-right">Skills / Rewards</a>
                <a href="{{url('/'.admin.'/about/reviews')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='reviews'  ? 'btn-inverse' : 'btn-info' }} pull-right">Reviews</a>
                <a href="{{url('/'.admin.'/about/interest')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='interest'  ? 'btn-inverse' : 'btn-info' }} pull-right">Interest</a>
                <a href="{{url('/'.admin.'/about/research')}}" class="btn {{Request::segment(2)=='about'  &&  Request::segment(3)=='research'  ? 'btn-inverse' : 'btn-info' }} pull-right">Research Publications</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          @if (Session::has('flash_message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message') !!}</strong>
          </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          @php
         
          $meta   = ($data->about_meta  !="" )? json_decode($data->about_meta , true) : array();
          $info   = ($data->info  !="" )? json_decode($data->info , true) : array();
          $quotes1   = ($data->quotes1  !="" )? json_decode($data->quotes1 , true) : array();
          $quotes2   = ($data->quotes2  !="" )? json_decode($data->quotes2 , true) : array();
          $education   = ($data->education  !="" )? json_decode($data->education , true) : array();
          $services   = ($data->services  !="" )? json_decode($data->services , true) : array();
          $schema   = ($data->microdata  !="" )? json_decode($data->microdata , true) : array();
          @endphp
          <form method="POST" action="/{{ admin }}/about" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}"> 
                <div class="form-group col-lg-10 p-0">
                  <label class="font-weight-600">Meta Title</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$meta['meta_title']:''}}" data-count="text">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-10 p-0">
                  <label class="font-weight-600">Meta Description</label>
                  <div class="input-group">
                    <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ isset($data)?$meta['meta_description']:''}}</textarea>
                    <div class="input-group-append">
                      <span class="input-group-text count countshow"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-10 p-0">
                  <div class="schema">
                  <div class="schema-rows">
                    @php
                    $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                    for ($n=0; $n <=$t_quotes; $n++){
                     $schema_d = (isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "";
                  
                    @endphp
                    <div class="new-schema border row p-2">
                      <span class="clear-data2">x</span>
                      <div class="col-lg-12">
                        <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <input  type="text" name="type[]" placeholder="schema name herre" value="{{ $type }}"  >  </div> <br>
                        <div class="form-row">
                          <div class="form-group col-lg-12">
                            <textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Quotes heere..." > {!! $schema_d !!} </textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    @php
                    }
                    @endphp
                  </div>
                </div>
                <div style="text-align:right;">
                  <a href="" class="btn btn-success add-more-schema text-white">Add More</a>
                </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-4">
                    <label class="font-weight-600">About-Us Image</label> <br>
                    <div class="uc-image mx-auto" style="width:150px;height:150px;">
                      <span class="clear-image-x">x</span>
                      <input type="hidden" name="about_image" value="{{ isset($data)?$meta['about_image']:''}}">
                      <div id="about_image" class="image_display">
                        <img src="{{ isset($data)?$meta['about_image']:''}}" alt="">
                      </div>
                      <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#about_image" data-link="about_image">Add Image</a></div>
                    </div>
                  </div>
                  <div class="form-group col-lg-4">
                    <label class="font-weight-600">OG Image</label> <br>
                    <div class="uc-image mx-auto" style="width:150px;height:150px;">
                      <span class="clear-image-x">x</span>
                      <input type="hidden" name="og_image" value="{{ isset($data)?$data['og_image']:''}}">
                      <div id="og_image" class="image_display">
                        <img src="{{ isset($data)?$data['og_image']:''}}" alt="">
                      </div>
                      <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a></div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-12 p-0">
                  <label class="font-weight-600">Meta Tags</label>
                  <div class="input-group">
                    <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ isset($data)?$meta['meta_tags']:''}}">
                    <div class="input-group-append">
                      <span class="input-group-text count countshow"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-10">
                  <label>Objective:</label>
                  <textarea class="form-control tinyeditor" rows="5" name="objective">{{ isset($data)?$data['objective']:''}}</textarea>
                </div>
                <div class="form-group col-lg-10">
                  <label>Vision:</label>
                  <textarea class="form-control tinyeditor" rows="5" name="vision">{{ isset($data)?$data['vision']:''}}</textarea>
                </div>
                <div class="form-group col-lg-12 col-md-12">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Information </b>
                    </div>
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Name</label>
                          <input type="text" placeholder="Name" name="name" class="form-control" value="{{ isset($data)?$info['name']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Designation</label>
                          <input type="text" placeholder="Designation" name="designation" class="form-control" value="{{ isset($data)?$info['designation']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Email</label>
                          <input type="email" placeholder="Email" name="email" class="form-control" value="{{ isset($data)?$info['email']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Website</label>
                          <input type="text" placeholder="website url" name="website" class="form-control" value="{{ isset($data)?$info['website']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Skype</label>
                          <input type="text" placeholder="Skype" name="skype" class="form-control" value="{{ isset($data)?$info['skype']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">phone</label>
                          <input type="text" placeholder="Phone Number" name="phone" class="form-control" value="{{ isset($data)?$info['phone']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Address</label>
                          <input type="text" placeholder="Address" name="address" class="form-control" value="{{ isset($data)?$info['address']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Favebook Url</label>
                          <input type="text" placeholder="Facebook Url" name="fb_url" class="form-control" value="{{ isset($data)?$info['fb_url']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Twitter Url</label>
                          <input type="text" placeholder="Twitter Url" name="twitter_url" class="form-control" value="{{ isset($data)?$info['twitter_url']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Google Url</label>
                          <input type="text" placeholder="Google Url" name="google_url" class="form-control" value="{{ isset($data)?$info['google_url']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                        <div class="form-group col-lg-6">
                          <label class="font-weight-600">Linkedin Url</label>
                          <input type="text" placeholder="Linkedin Url" name="linkedin_url" class="form-control" value="{{ isset($data)?$info['linkedin_url']:''}}">
                          <div class="text-danger"> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-10 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Quotes 1 </b>
                    </div>
                    <div class="card-body">
                      <div class="quotes1">
                        <div class="quotes1-rows">
                          @php
                          $t_quotes = (count($quotes1)==0) ? 0 : count($quotes1) - 1;
                          for ($n=0; $n <=$t_quotes; $n++){
                          $quote1 = (isset($quotes1[$n]["quotes"])) ? $quotes1[$n]["quotes"]: "";
                          $auth_name1 = (isset($quotes1[$n]["auth_name"])) ? $quotes1[$n]["auth_name"]: "";
                          @endphp
                          <div class="new-quotes1 border row">
                            <span class="clear-data2">x</span>
                            <div class="col-lg-12">
                              <div style="text-align: center;"><b> Quotes <span class="no">{{ $n+1 }}</span></b> </div> <br>
                              <div class="form-row">
                                <div class="form-group col-lg-12">
                                  <textarea rows="3" name="quotes1[]" class="form-control" placeholder="type Your Quotes heere..." > {{ $quote1 }} </textarea>
                                  <label class="font-weight-600">Author Name</label>
                                  <input type="text" name="auth_name1[]"  class="form-control" value="{{ $auth_name1 }}" placeholder="Author Name">
                                  <div class="text-danger"> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          @php
                          }
                          @endphp
                        </div>
                      </div>
                      <div style="text-align:right;">
                        <a href="" class="btn btn-success add-more-quotes1 text-white">Add More</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <div class="card">
                      <div class="card-header card bg-secondary text-white">
                        <b> Education Record 1 </b>
                      </div>
                      <div class="card-body">
                        <div class="form-row">
                          <div class="form-group col-lg-12">
                            <label class="font-weight-600">Title</label>
                            <input type="text" placeholder="Title" name="ed1_title" class="form-control" value="{{ isset($data)?$education['ed1_title']:''}}">
                            <div class="text-danger"> </div>
                          </div>
                          <div class="form-group col-lg-12">
                            <label class="font-weight-600">Institute</label>
                            <input type="text" placeholder="institute" name="ed1_institute" class="form-control" value="{{ isset($data)?$education['ed1_institute']:''}}">
                            <div class="text-danger"> </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-lg-7">
                            <label class="font-weight-600">Date</label>
                            <input type="text" placeholder="date" name="ed1_date" class="form-control" value="{{ isset($data)?$education['ed1_date']:''}}">
                            <div class="text-danger"> </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Detail:</label>
                          <textarea class="form-control tinyeditor" rows="3" name="ed1_detail">{{ isset($data)?$education['ed1_detail']:''}}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-lg-6">
                    <div class="card">
                      <div class="card-header card bg-secondary text-white">
                        <b> Education Record 2</b>
                      </div>
                      <div class="card-body">
                        <div class="form-row">
                          <div class="form-group col-lg-12">
                            <label class="font-weight-600">Title</label>
                            <input type="text" placeholder="Title" name="ed2_title" class="form-control" value="{{ isset($data)?$education['ed2_title']:''}}">
                            <div class="text-danger"> </div>
                          </div>
                          <div class="form-group col-lg-12">
                            <label class="font-weight-600">Institute</label>
                            <input type="text" placeholder="institute" name="ed2_institute" class="form-control" value="{{ isset($data)?$education['ed2_institute']:''}}">
                            <div class="text-danger"> </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-lg-7">
                            <label class="font-weight-600">Date</label>
                            <input type="text" placeholder="date" name="ed2_date" class="form-control" value="{{ isset($data)?$education['ed2_date']:''}}">
                            <div class="text-danger"> </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Detail:</label>
                          <textarea class="form-control tinyeditor" rows="3" name="ed2_detail">{{ isset($data)?$education['ed2_detail']:''}}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-10 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Services </b>
                    </div>
                    <div class="card-body">
                      <div class="services">
                        <div class="review-rows services-rows">
                          @php
                          $t_srvc = (count($services)==0) ? 0 : count($services) - 1;
                          for ($n=0; $n <=$t_srvc; $n++){
                          $name = (isset($services[$n]["servc_name"])) ? $services[$n]["servc_name"]: "";
                          $icon = (isset($services[$n]["servc_icon"])) ? $services[$n]["servc_icon"]: "";
                          $details = (isset($services[$n]["services_details"])) ? $services[$n]["services_details"]: "";
                          @endphp
                          <div class="new-services border row">
                            <span class="clear-data2">x</span>
                            <div class="col-lg-12">
                              <h4 class="text-center"> <b>Service {{ $n+1 }}</b></h4>
                              <div class="form-row">
                                <div class="form-group col-lg-6">
                                  <label>Name</label>
                                  <input type="text" name="servc_name[]" placeholder="Name" class="form-control" value="{{ $name }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                                <div class="form-group col-lg-6">
                                  <label>Icon</label>
                                  <input type="text" name="servc_icon[]" placeholder="icon" class="form-control" value="{{ $icon }}"/>
                                  <div class="text-danger"> </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Details</label>
                                <textarea rows="3" name="services_details[]" class="form-control tinyeditor" placeholder="Enter Details" > {{ $details }} </textarea>
                                <div class="text-danger"> </div>
                              </div>
                            </div>
                          </div>
                          @php
                          }
                          @endphp
                        </div>
                      </div>
                      <div style="text-align:right;">
                        <a href="" class="btn btn-success add-more-service text-white">Add More</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-lg-10 p-0">
                  <div class="card">
                    <div class="card-header card bg-secondary text-white">
                      <b> Quotes 2 </b>
                    </div>
                    <div class="card-body">
                      <div class="quotes2">
                        <div class="quotes2-rows">
                          @php
                          $t_quotes = (count($quotes2)==0) ? 0 : count($quotes2) - 1;
                          for ($n=0; $n <=$t_quotes; $n++){
                          $quote2 = (isset($quotes2[$n]["quotes"])) ? $quotes2[$n]["quotes"]: "";
                          $auth_name2 = (isset($quotes2[$n]["auth_name"])) ? $quotes2[$n]["auth_name"]: "";
                          @endphp
                          <div class="new-quotes2 border row">
                            <span class="clear-data2">x</span>
                            <div class="col-lg-12">
                              <div style="text-align: center;"><b> Quotes <span class="no">{{ $n+1 }}</span></b> </div> <br>
                              <div class="form-row">
                                <div class="form-group col-lg-12">
                                  <textarea rows="3" name="quotes2[]" class="form-control" placeholder="type Your Quotes heere..." > {{ $quote2 }} </textarea>
                                  <label class="font-weight-600">Author Name</label>
                                  <input type="text" name="auth_name2[]"  class="form-control" value="{{ $auth_name2 }}" placeholder="Author Name">
                                  <div class="text-danger"> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          @php
                          }
                          @endphp
                        </div>
                      </div>
                      <div style="text-align:right;">
                        <a href="" class="btn btn-success add-more-quotes2 text-white">Add More</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Save Record</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')
<script>
var cloneServices =
'<div class="new-services border row">'+
  '<span class="clear-data2">x</span>'+
  '<div class="col-lg-12">'+
    '<h4 class="text-center"> <b>Service <span class="no"></span> </b></h4>'+
    '<div class="form-row">'+
      '<div class="form-group col-lg-6">'+
        '<label>Name</label>'+
        '<input type="text" name="servc_name[]" placeholder="Name" class="form-control" value=""/>'+
        '<div class="text-danger">'+
        '</div>'+
      '</div>'+
      ' <div class="form-group col-lg-6">'+
        '<label>Icon</label>'+
        '<input type="text" name="servc_icon[]" placeholder="icon" class="form-control" value=""/>'+
        '<div class="text-danger"> </div>'+
      '</div>'+
    '</div>'+
    '<div class="form-group">'+
      '<label>Details</label>'+
      '<textarea rows="3" name="services_details[]" class="form-control tinyeditor" placeholder="Enter Details" >  </textarea>'+
      '<div class="text-danger">'+ '</div>'+
    '</div>'+
  '</div>'+
'</div>';
$(".add-more-service").click(function(e) {
e.preventDefault();
var html_obj = cloneServices;
$(".services .services-rows").append(html_obj);
var n = $(".services .services-rows").find(".new-services").length;
var el =  $(".services .services-rows .new-services:nth-child("+n+")");
el.find(".no").text(n);
__tinyEd();
return false;
});
var quotes1Clone1 =
'<div class="new-quotes1 border row">'+
  '<span class="clear-data2">x</span>'+
  '<div class="col-lg-12">'+
    '<div class="form-row">'+
      '<div class="form-group col-lg-12">'+
        '<div style="text-align: center;"><b> Quotes <span class="no"></span></b> </div> <br>'+
        '<textarea rows="3" name="quotes1[]" class="form-control" placeholder="type Your Quotes heere..."  >  </textarea>'+
        '<label class="font-weight-600">Author Name</label>'+
        '<input type="text" name="auth_name1[]"  class="form-control" value="" placeholder="Author Name">'+
      '</div>'+
    '</div>'+
  '</div>'+
'</div>';
$(".add-more-quotes1").click(function() {
var html_obj = quotes1Clone1;
$(".quotes1 .quotes1-rows").append(html_obj);
var n = $(".quotes1 .quotes1-rows").find(".new-quotes1").length;
var el =  $(".quotes1 .quotes1-rows .new-quotes1:nth-child("+n+")");
el.find(".no").text(n);
return false;
});
var cloneSchema =
'<div class="new-schema border row">' +
    '<span class="clear-data2">x</span>' +
    '<div class="col-lg-12">' +
        '<div class="form-row">' +
            '<div class="form-group col-lg-12">' +
                '<div class="flex-center"><b>  <span class="no"> </span> &nbsp; - &nbsp;</b> <input type="text" name="type[]" placeholder="schema name herre" value=""  > </div> <br>' +
                '<textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Schema heere..."  >  </textarea>' +
            '</div>' +
        '</div>' +
    '</div>' +
'</div>';
$(".add-more-schema").click(function() {
var html_obj = cloneSchema;
$(".schema .schema-rows").append(html_obj);
var n = $(".schema .schema-rows").find(".new-schema").length;
var el =  $(".schema .schema-rows .new-schema:nth-child("+n+")");
el.find(".no").text(n);
return false;
});
var quotes1Clone2 =
'<div class="new-quotes2 border row">'+
  '<span class="clear-data2">x</span>'+
  '<div class="col-lg-12">'+
    '<div class="form-row">'+
      '<div class="form-group col-lg-12">'+
        '<div style="text-align: center;"><b> Quotes <span class="no"></span></b> </div> <br>'+
        '<textarea rows="3" name="quotes2[]" class="form-control" placeholder="type Your Quotes heere..."  >  </textarea>'+
        '<label class="font-weight-600">Author Name</label>'+
        '<input type="text" name="auth_name2[]"  class="form-control" value="" placeholder="Author Name">'+
      '</div>'+
    '</div>'+
  '</div>'+
'</div>';
$(".add-more-quotes2").click(function() {
var html_obj = quotes1Clone2;
$(".quotes2 .quotes2-rows").append(html_obj);
var n = $(".quotes2 .quotes2-rows").find(".new-quotes2").length;
var el =  $(".quotes2 .quotes2-rows .new-quotes2:nth-child("+n+")");
el.find(".no").text(n);
return false;
});
$(document).on("click", ".clear-data2", function() {
var v = window.confirm("Do you want to delete data?");
if (v) {
$(this).closest(".row").remove();
}
});
</script>