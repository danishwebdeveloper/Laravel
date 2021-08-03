@include('admin.layout.header')
@php
full_editor();
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-md-112 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if (request()->has('edit'))
                            <h6 class="fs-17 font-weight-600 mb-0">Edit Blog</h6>
                            @else
                            <h6 class="fs-17 font-weight-600 mb-0">Create New Blog</h6>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <a href="{{url('/'.admin.'/blogs')}}" class="btn {{ Request::segment(2)=='blogs'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Add New</a>
                                <a href="{{url('/'.admin.'/blogs/list')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='list'  ? 'btn-inverse' : 'btn-info' }} pull-right">Blogs List</a>
                                <a href="{{url('/'.admin.'/blogs/category')}}" class="btn {{ Request::segment(2)=='blogs'  && Request::segment(3)=='category'  ? 'btn-inverse' : 'btn-info' }} pull-right">Add Category</a>
                               
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
                    <form method="POST" action="/{{ admin }}/blogs" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                @php
                                //dd($data);
                                @endphp
                                @if (Request::get('edit') !="")
                                    <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
                                @endif
                                <input type="hidden" name="date" value="{{ isset($data)? $data->date : time() }}">
                                <div class="form-group">
                                    <label class="req">Page Title</label>
                                    @php
                                    $url = (Request::get('edit')) !="" ? "":"slug";
                                    @endphp
                                    <input type="text" name="title" class="form-control cslug" value="{{ isset($data)?$data->title:''}}" data-link="{{ $url }}">
                                </div>
                                <div class="form-group">
                                    <label class="req">Slug</label>
                                    <input type="text" name="slug" value="{{ isset($data)?$data->slug:''}}" class="form-control">
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Meta Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control tcount" placeholder="meta title..." name="meta_title" value="{{ isset($data)?$data->meta_title:''}}" data-count="text">
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?strlen($data->meta_title):'0'}}</span>
                                        </div>
                                    </div>
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
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Schema </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="schema">
                                                <div class="schema-rows">
                                                    @php
                                                    $schema = isset($data)? json_decode($data->microdata , true) : array();
                                                    $t_quotes = (count($schema)==0) ? 0 : count($schema) - 1;
                                                    for ($n=0; $n <=$t_quotes; $n++){
                                                    $schema_d=(isset($schema[$n]["schema"])) ? $schema[$n]["schema"]: "" ;
                                                    $type=(isset($schema[$n]["type"])) ? $schema[$n]["type"]: "" ;
                                                    $style=(Request::get('edit') and isset($schema[$n]["type"])  ) ? 'style="display: none;"': "" ;
                                                    $icon=(Request::get('edit') and isset($schema[$n]["type"] )) ? '<i class="fa fa-edit"></i>': '' ;
                                                    @endphp <div class="new-schema border row p-2">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <div class="flex-center"><b><span class="no">{{ $n+1 }} &nbsp; - &nbsp; </span></b> <span class="schma_type">{{ $type }} {!! $icon !!}</span> <input  type="text" name="type[]" placeholder="schema name herre" value="{{ $type }}"  {!! $style !!} >  </div> <br>
                                                            <div class="form-row">
                                                                <div class="form-group col-lg-12">
                                                                    <textarea rows="6" name="schema[]" class="form-control" placeholder="type Your Quotes heere..."> {!! $schema_d !!} </textarea>
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
                                                <a href="" class="btn btn-info add-more-schema text-white"><b>Add More</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Green Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="green">
                                                <div class="form-rows green-rows">
                                                    @php
                                                    $res = (isset($data) and $data->green_text !="" ) ? json_decode($data->green_text , true) : array();
                                                    $g_text = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$g_text; $n++){ $gr_heading=(isset($res[$n]["gr_heading"])) ? $res[$n]["gr_heading"]: "" ; $gr_body=(isset($res[$n]["gr_body"])) ? $res[$n]["gr_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <div class="col-lg-12">
                                                            <p class="mx-auto text-center"><b> Green Text {{ $n+1 }}</b></p>
                                                            <div class="form-group">
                                                                <label>Heading</label>
                                                                <input type="text" name="gr_heading[]" placeholder="Heading text..." class="form-control" value="{{ $gr_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Answer"> {{ $gr_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-green"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Red Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="red">
                                                <div class="form-rows red-rows">
                                                    @php
                                                    $res =  (isset($data) and $data->red_text !="" )? json_decode($data->red_text , true) : array();
                                                    $r_text = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$r_text; $n++){ $red_heading=(isset($res[$n]["red_heading"])) ? $res[$n]["red_heading"]: "" ; $red_body=(isset($res[$n]["red_body"])) ? $res[$n]["red_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Red Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Heading</label>
                                                                <input type="text" name="red_heading[]" placeholder="Heading text..." class="form-control" value="{{ $red_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Answer"> {{ $red_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-red "><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> black Text </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="black">
                                                <div class="form-rows black-rows">
                                                    @php
                                                    $res =  (isset($data) and $data->black_text !="" )? json_decode($data->black_text , true) : array();
                                                    $b_text = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$b_text; $n++){ $black_heading=(isset($res[$n]["black_heading"])) ? $res[$n]["black_heading"]: "" ; $black_body=(isset($res[$n]["black_body"])) ? $res[$n]["black_body"]: "" ; @endphp <div class="new-review border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> Black Text {{ $n+1 }}</b></p>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Heading</label>
                                                                <input type="text" name="black_heading[]" placeholder="Heading text..." class="form-control" value="{{ $black_heading }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Body</label>
                                                                <textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="Answer"> {{ $black_body }} </textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php } @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-black"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-0">
                                    <label class="font-weight-600">Inernal link Tags</label>
                                    <div class="input-group">
                                        <input type="text" name="internal_links" class="form-control tcount tags_input"  data-count="tags"  placeholder="Intternal links tags" name="internal_links" value="{{ isset($data)?$data->internal_links:''}}" data-id="{{ isset($data)?$data->id:''}}" autocomplete="off">
                                        
                                        <div class="input-group-append">
                                            <span class="input-group-text count countshow">{{ isset($data)?count(explode(",",$data->internal_links)):'0'}}</span>
                                        </div>
                                        <div class='search-tags'></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="req">Content:</label>
                                    <div>
                                        <div style="margin-top:10px;"> <a class="insert-media btn btn-danger btn-sm" data-type="image" data-for="editor" data-return="#oneditor" data-link="image" >Add Image</a> <span>&nbsp; Image Size [ width = <small>800px </small> ]</span> <a type="button" class="btn btn-info btn-sm float-right " data-toggle="modal" data-target="#shortcode-model"><i class="fa fa-info"></i> &nbsp; Short Codes Discription</a> </div>
                                    </div>
                                    <textarea class="form-control oneditor" rows="25" name="content" id="oneditor">{{ isset($data)?$data->content:''}}</textarea>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 p-0">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Blog FAQs </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="faqs">
                                                <div class="form-rows faqs-rows">
                                                    @php
                                                    $res = isset($data)? json_decode($data->faqs , true) : array();
                                                    $f_count = (count($res)==0) ? 0 : count($res) - 1;
                                                    for ($n=0; $n <=$f_count; $n++){ $question=(isset($res[$n]["question"])) ? $res[$n]["question"]: "" ; $answer=(isset($res[$n]["answer"])) ? $res[$n]["answer"]: "" ; @endphp <div class="new-faqs border row">
                                                        <span class="clear-data2">x</span>
                                                        <p class="mx-auto text-center"><b> FAQs {{ $n+1 }}</b></p>
                                                        <input type="hidden" name="num[]" value="{{ $n+1 }}">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>Question</label>
                                                                <input type="text" name="question[]" placeholder="Question" class="form-control" value="{{ isset($data)? $question:"" }}" />
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Answer</label>
                                                                <textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer">{{ isset($data)? $answer:"" }}</textarea>
                                                                <div class="text-danger"> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                    }
                                                    @endphp
                                                </div>
                                                <div style="text-align:right;">
                                                    <a href="" class="btn btn-info add-faqs"><b>Add More</b></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Category </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                                @php
                                                $cats = DB::table('blogcats')->select('id','title')->get();
                                                $category = (isset($data)) ? explode("," , $data->category) : array();
                                                @endphp
                                                @foreach ($cats as $ct)
                                                <div class="i-check">
                                                    <input tabindex="17" type="checkbox" value="{{ $ct->id }}" name="category[]" id="line-checkbox-1" {{ (in_array($ct->id, $category))?'checked':''}}>
                                                    <label for="line-checkbox-1">{{ $ct->title }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Author </b>
                                        </div>
                                        <div class="card-body">
                                            <div class="skin-line">
                                                @php
                                                $auth = DB::table('authors')->where('status','publish')->select('id','name')->get();
                                                $author = isset($data->author) ? $data->author : "" ;
                                                $category = (isset($data)) ? explode("," , $data->category) : array();
                                                @endphp
                                                <select name="author" class="form-control">
                                                    <option value="">Please Select Author</option>
                                                    @foreach ($auth as $k => $v)
                                                    @php
                                                    $selected = ($v->id == $author) ? "selected=selected" : "" ;
                                                    @endphp
                                                    <option value="{{ $v->id}}" {{ $selected }}>{{ $v->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span><b> Cover Image [ Exact Size <small> 300 x 200</small>  ] </b> <a  class="text-white float-right" href="" ></a></span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                            $cover = (isset($data) !="" and $data->cover !="") ? "<img class='crop-img' src=".$data->cover." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="cover-image" value="{{ isset($data)? $data->cover :"" }}">
                                                <div id="coover" class="image_display" style="display:block;">
                                                    {!! $cover !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#coover" data-link="cover-image">Add Image</a>
                                                    <a type="button" class="btn btn-info btn-sm float-right " id="cropieimg" data-toggle="modal" data-target="#crop-model">Crop</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <span style="font-weight: 600;"> Social Media Image [ Min Size: <small> 900 x 600 </small>  ] </span>
                                        </div>
                                        <div class="card-body">
                                            @php
                                            $og_image = (isset($data) !=""  and $data->og_image !="") ? "<img src=".$data->og_image." alt=''>" : "";
                                            @endphp
                                            <div class="uc-image" style="width: 97%;">
                                                <input type="hidden" name="og-image" value="{{ isset($data->og_image)?$data->og_image :"" }}">
                                                <div id="og-image" class="image_display" style="display:block;">
                                                    {!! $og_image !!}
                                                </div>
                                                <div style="margin-top:10px;">
                                                    <a class="insert-media btn btn-info btn-sm" data-type="image" data-for="display" data-return="#og-image" data-link="og-image">Add Image</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header card bg-secondary text-white">
                                            <b> Submit Record <span class="float-right"> <b>Updated Date : </b> {{ isset($data)?date("d M Y" , $data->date) : "" }} </span></b>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-12">
                                                <label for="example-date-input" class=" col-form-label font-weight-600">Updated Date</label>
                                                <div class="col-lg-12">
                                                    {{-- <input class="form-control update_date" name="update_date" type="date" value="" > --}}
                                                    <input type="text" class="form-control" name="update_date" placeholder="dd/mm/yyyy" id="datepicker" value="{{ isset($data)?date("d-m-Y" , $data->date) : "" }}"></p>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit" value="draft" class="btn btn-info float-left">Draft </button>
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
<div class="modal fade" id="shortcode-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Description For Short Codes</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th> Short Code</th>
                        <th> Description</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td> Related Post: </td>
                        <td> [[related:2]] </td>
                        <td> [[related : Limits of url / Quantity]] <br> <b>For Example : [[related : 2]] </b> 2 Links will Generate where we use this code </td>
                    </tr>
                    <tr>
                        <td> 2 </td>
                        <td> Ads In Article:</td>
                        <td> [[ads:2]] </td>
                        <td> [[ads : index of Ad that shown in article]] <br> <b>For Example : [[ads : 2]] </b> 2nd Ad will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 3 </td>
                        <td> Table of Content:</td>
                        <td> [[toc]] </td>
                        <td> use this code <b>[[toc]]</b> where u want to show table of content in article</b></td>
                    </tr>
                    <tr>
                        <td> 4 </td>
                        <td> Heading:</td>
                        <td> [[t]] Heading [[/t]] </td>
                        <td> <b>Example</b> Heading no 1 : [[t1]]Heading no 1[[/t1]] <br> Heading no 2 : [[t2]]Heading no 2[[/t2]] </td>
                    </tr>
                    <tr>
                        <td> 5 </td>
                        <td> Sub Heading:</td>
                        <td> [[t1-s1]] Sub Heading of Headin 1 [[/t1-s1]] </td>
                        <td> <b>Example</b> <b>1st Sub Heading of Heading 1 </b>: [[t1-s1]]1st Sub Heading of Heading 1[[/t1-s2]] <br> <b>2nd Sub Heading of Heading 1 </b>: [[t1-s2]]2nd Sub Heading of Heading 1[[/t1-s2]] </td>
                    </tr>
                    <tr>
                        <td> 6 </td>
                        <td> Child of Sub Heading:</td>
                        <td> [[t1-s1-c1]] chlid of1st Sub Heading of Headin 1 [[/t1-s1-c1]] </td>
                        <td> <b>Example</b> <b>Child of 1st Sub Heading of Heading 1 </b>: [[t1-s1-c1]] Child of 1st Sub Heading of Heading 1[[/t1-s1-c1]] </td>
                    </tr>
                    <tr>
                        <td> 7 </td>
                        <td> Green Text:</td>
                        <td> [[green:2]] </td>
                        <td> [[green : index of Green Text that is listed above]] <br> <b>For Example : [[green : 2]] </b> 2nd Green text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 8 </td>
                        <td> Red Text:</td>
                        <td> [[red:2]] </td>
                        <td> [[red : index of Red Text that is listed above]] <br> <b>For Example : [[Red : 2]] </b> 2nd Red text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 9 </td>
                        <td> black Text:</td>
                        <td> [[black:2]] </td>
                        <td> [[black : index of Black Text that is listed above]] <br> <b>For Example : [[Black : 2]] </b> 2nd Green text will shown where we use this code </td>
                    </tr>
                    <tr>
                        <td> 10 </td>
                        <td> Faqs </td>
                        <td> [[faqs:index of FAQs that is listed above]] </td>
                        <td> <b>Example</b> <b>[[faqs:1-4]]</b> place this code if u want to show faqs no 1 2 3 and 4
                        <br> <b>[[faqs:1,3,5,7]]</b> place this code if u want to show randomly faqs for example 1 3 5 7 </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="crop-model" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Image Croping</h4>
                <a href="" class="crpMdlHide"><i class="fa fa-times"></i></a>
            </div>
            <div class="modal-body">
               <div class="row div-flex text-center">
                <div class="col-lg-6 crop-sec">
                    <label>Width</label>
                    <input type="text" id="hfWidth" value="">
                    <label>Height</label>
                    <input type="text" id="hfHeight" value="">
                    <br> <br>
                    <div class="i-bx text-center">
                        <div class="-cp-img">
                            <img src="" id="cropbox" class="img" style="width: 100%;" /><br />
                        </div>
                        
                        <span id="hfX"></span> <span id="hfY"></span>
                        <br> <br>
                        <div class="text-center">
                            <input type='button' id="crop" value='Show Preview'>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="crop-imgbox">
                        <img src="#" id="cropped_img" style="display: none;">
                    </div>
                    <div class="text-center updBtn" style="display: none">
                        <br> <br>
                        <input type='button' id="update" value='Crop & Update'>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')
<script>

$(document).ready(function() {
    var jcrop_api;
$(".crpMdlHide").click(function(e){
    $('#crop-model').modal('hide');
    e.preventDefault();
})
window.crop_path = "";
var sizes;
 var jcrop_api;
$("#cropieimg").click(function(){
    $(".crop-imgbox").css("border" , "none");
    $(".crop-imgbox img").css("display" , "none");
    $(".updBtn").css("display" , "none");
    $('#hfHeight').val("");
    $('#hfWidth').val("");
    _path = $("#coover img").attr("src");
    window.crop_path = _path;
    $(".-cp-img").html('<img src="" id="cropbox" class="img" style="width: 100%;" /><br />');
    $(".crop-sec img").attr("src" , window.crop_path);  
    $('#cropbox').Jcrop({
      aspectRatio: 3/2,
      boxWidth: 500,   //Maximum width you want for your bigger images
      boxHeight: 400,
        allowSelect: true,
        allowMove: true,
        allowResize: true,
      onChange: updateCoords,
      onSelect: function(c){
       sizes = {x:c.x,y:c.y,w:c.w,h:c.h};
       $("#crop").css("visibility", "visible");     
      }
    }
    , function () {
            jcrop_api = this;
        });
    function updateCoords(c) {
        $('#hfX').text(c.x1);
        $('#hfY').text(c.y1);
        $('#hfHeight').val(parseInt(c.h));
        $('#hfWidth').val(parseInt(c.w));
    }
});
$('#hfWidth , hfHeight ').change(function (e) {
    var x = parseInt($('#hfWidth').val());
    var y = parseInt($('#hfHeight').val());
    jcrop_api.setSelect([0,0, x, y]);
}); 

    $("#crop").click(function(){
        var img = $("#cropbox").attr('src');
        $(".crop-imgbox").css("border" , "2px solid black");
        $(".updBtn").css("display" , "block");
        $("#cropped_img").show();

        $("#cropped_img").attr('src','{{ route('cropie') }}?x='+sizes.x+'&y='+sizes.y+'&w='+sizes.w+'&h='+sizes.h+'&img='+img);
    });
    $(".updBtn").click(function(){
        var img = $("#cropbox").attr('src');
        $("#cropped_img").attr('src','{{ route('cropie') }}?x='+sizes.x+'&y='+sizes.y+'&w='+sizes.w+'&h='+sizes.h+'&img='+img+"&sv=true");
        $.ajax({
          type: "GET",
          url: '{{ route('cropie') }}?x='+sizes.x+'&y='+sizes.y+'&w='+sizes.w+'&h='+sizes.h+'&img='+img+"&ret=true",
          data: {},
          cache: false,
          success: function(data){
            $("#coover img").attr('src', data);
            $('input[name=cover-image]').val(data);
            $(".updBtn").css("display" , "none");
          }
        });      
    });
var cloneg = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Green Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Heading</label>' +
            '<input type="text" name="gr_heading[]" placeholder="Heading text..." class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        '<div class="form-group">' +
            '<label>Body</label>' +
            '<textarea rows="3" name="gr_body[]" class="form-control oneditor" placeholder="Body text..." ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-green").click(function(e) {
e.preventDefault();
var html_obj = cloneg;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".green .form-rows").append(html_obj);
var n = $(".green .form-rows").find(".new-review").length;
var el = $(".green .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
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
var el = $(".schema .schema-rows .new-schema:nth-child(" + n + ")");
el.find(".no").text(n);
return false;
});
var cloner = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Red Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Heading</label>' +
            '<input type="text" name="red_heading[]" placeholder="Heading text...." class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        '<div class="form-group">' +
            '<label>Body</label>' +
            '<textarea rows="3" name="red_body[]" class="form-control oneditor" placeholder="Body text..." ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-red").click(function(e) {
e.preventDefault();
var html_obj = cloner;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".red .form-rows").append(html_obj);
var n = $(".red .form-rows").find(".new-review").length;
var el = $(".red .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
var cloneb = '<div class="new-review border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> Black Text <span class="no"></span> </b></p>' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Heading</label>' +
            '<input type="text" name="black_heading[]" placeholder="Heading text..." class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        '<div class="form-group">' +
            '<label>Body</label>' +
            '<textarea rows="3" name="black_body[]" class="form-control oneditor" placeholder="body tex...t" ></textarea>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
    '</div>' +
'</div>'
$(".add-black").click(function(e) {
e.preventDefault();
var html_obj = cloneb;
var ln = $(".form-rows .row").length;
$(html_obj).find("input").each(function() {
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function() {
$(this).text("");
});
$(html_obj).find("img").remove();
$(".black .form-rows").append(html_obj);
var n = $(".black .form-rows").find(".new-review").length;
var el = $(".black .form-rows .new-review:nth-child(" + n + ")");
el.find(".no").text(n);
_full_Ed();
return false;
});
var clonefaqs = '<div class="new-faqs border row">' +
    '<span class="clear-data2">x</span>' +
    '<p class="mx-auto text-center"><b> FAQs <span class="no"></span> </b></p>' +
    '<input type="hidden" name="num[]" value="">' +
    '<div class="col-lg-12">' +
        '<div class="form-group">' +
            '<label>Question</label>' +
            '<input type="text" name="question[]" placeholder="Question" class="form-control" value=""/>' +
            '<div class="text-danger"> </div>' +
        '</div>' +
        ' <div class="form-group">' +
            '<label>Answer</label>' +
            '<textarea rows="3" name="answer[]" class="form-control oneditor" placeholder="Answer" ></textarea>' +
            '<div class="text-danger"> </div>' +
        ' </div>' +
    '</div>' +
'</div>';
$(".add-faqs").click(function(e) {
e.preventDefault();
var html_obj = clonefaqs;
$(".faqs .faqs-rows").append(html_obj);
var n = $(".faqs .faqs-rows").find(".new-faqs").length;
var el = $(".faqs .faqs-rows .new-faqs:nth-child(" + n + ")");
el.find(".no").text(n);
el.find('input[name="num[]"]').val(n);
_full_Ed();
return false;
});
$(document).on("click", ".clear-data2", function() {
var v = window.confirm("Do you want to delete data?");
if (v) {
$(this).closest(".row").remove();
}
});
});
</script>