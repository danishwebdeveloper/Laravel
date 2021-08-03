@include('admin.layout.header')
@php
    tiny_editor();
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Contact us </h6>
                        </div>
                        <div class="text-right">
                            <div class="actions">
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
                    <form method="POST" action="/<?=admin?>/contactus/store" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @php
                                $url = (Request::get('edit')) !="" ? "":"slug";
                                @endphp
                                
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600 req">Meta Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$data->meta_title:''}}" data-count="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_title):'0'}}</span>
                                        </div>
                                    </div>
                                    @error('meta_title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control tcount" id="exampleFormControlTextarea1" rows="3" name="meta_description" data-count="text">{{ isset($data)?$data->meta_description:''}}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_description):'0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Tags</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" data-count="tags" placeholder="TAG1 , TAG2 , TAG3" name="meta_tags" value="{{ isset($data)?$data->meta_tags:''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->meta_tags)):'0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                  <div class="schema">
                                  <div class="schema-rows">
                                    @php
                                    $schema   = (!empty($data->microdata) )? json_decode($data->microdata , true) : array();
                                    $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                                    for ($n=0; $n <=$t_quotes; $n++){
                                     $schema_d = (isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "";
                                     $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                                        $style=( isset($schema[$n]["type"]) and $schema[$n]["type"] !="" ) ? 'style="display: none;"': "" ;
                                        $icon=(isset($schema[$n]["type"]) and $schema[$n]["type"] !="") ? '<i class="fa fa-edit"></i>': '' ;
                                  
                                    @endphp
                                    <div class="new-schema border row p-2">
                                      <span class="clear-data2">x</span>
                                      <div class="col-lg-12">
                                        <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name herre" value="{{ $type }}"  {!! $style !!} >  </div> <br>
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
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Receiving Email <small> Multiple Emails seprated by comma</small></label>
                                    <input type="text" name="r_email" class="form-control" placeholder="email1,email2,email3"  value="{{ isset($data)?$data->r_email:''}}" >
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Contact TItle" value="{{ isset($data)?$data->title:''}}" >
                                </div>
                                <div class="form-group">
                                    <label>Detail:</label>
                                    
                                    <textarea class="form-control tinyeditor" rows="5" name="detail">{{ isset($data)?$data->detail:''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Google Map </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">Google Map </label>
                                                <textarea class="form-control" rows="5" name="google_map" id="oneditor">{{ isset($data)?$data->google_map:''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Emails </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">Email Title</label>
                                                <input type="text" name="email_title" placeholder="Email Title" class="form-control"  value="{{ isset($data)?$data->email_title:''}}" >
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-6 col-md-6 ">
                                                    <label class="font-weight-600">Email 1</label>
                                                    <input type="text" name="email_1" placeholder="example1@gmail.com" class="form-control"  value="{{ isset($data)?$data->email_1:''}}" >
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 ">
                                                    <label class="font-weight-600">Email 2</label>
                                                    <input type="text" name="email_2" placeholder="example2@gmail.com" class="form-control"  value="{{ isset($data)?$data->email_2:''}}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Phones </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">Phone Title</label>
                                                <input type="text" name="phone_title" placeholder="Phone Title" class="form-control"  value="{{ isset($data)?$data->phone_title:''}}" >
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-6 col-md-6 ">
                                                    <label class="font-weight-600">Phone 1</label>
                                                    <input type="text" name="phone_1" placeholder="0300-7861234" class="form-control"  value="{{ isset($data)?$data->phone_1:''}}" >
                                                </div>
                                                <div class="form-group col-lg-6 col-md-6 ">
                                                    <label class="font-weight-600">Phone 2</label>
                                                    <input type="text" name="phone_2" placeholder="0300-7861234" class="form-control"  value="{{ isset($data)?$data->phone_2:''}}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Address </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-md-12 p-0">
                                                <label class="font-weight-600">address Title</label>
                                                <input type="text" name="address_title" placeholder="address Title" class="form-control"  value="{{ isset($data)?$data->address_title:''}}" >
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 col-md-12 ">
                                                    <label class="font-weight-600">address </label>
                                                    <input type="text" name="address" placeholder="block # 14 khanewal" class="form-control"  value="{{ isset($data)?$data->address:''}}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> OG Image </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-6 col-md-6">
                                                   @php
                                            $og_image = (isset($data) !=""  and $data->og_image !="") ? "<img src=".$data->og_image." alt=''>" : "";
                                            @endphp
                                                <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="og_image" value="{{$og_image}}">
                                                  <div id="og_image" class="image_display" style="display:block;">
                                                    {!! $og_image !!}
                                                  </div>
                                                  <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og_image" data-link="og_image">Add Image</a>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Submit Record </b>
                                        </div>
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Publish </button>
                                        </div>
                                    </div>
                                </div>
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
$(document).on("click", ".clear-data2", function() {
var v = window.confirm("Do you want to delete data?");
if (v) {
$(this).closest(".row").remove();
}
});
</script>