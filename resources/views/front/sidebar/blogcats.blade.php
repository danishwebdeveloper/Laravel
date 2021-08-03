@php
  $cats = DB::table("blogcats")->orderBy("tb_order")->get();
@endphp
@if (isset($cats))
@if (count($cats) > 0)
<div class="sidebar__item">
    <div class="section-head">
        <div class="text-center d-flex justify-content-between">
            <h3>Categories</h3>
        </div>
    </div>
    <ul class="nav flex-column bg-sliver category">
        @foreach ($cats as $k => $v)
        @php
        $id = $v->id;
        $slug = $v->slug;
        $title = $v->title;
        $url  = route('HomeUrl')."/".$slug."-1".$id;
        @endphp
        <li class="nav-item">
            <i class="icon-left"></i><a class="nav-link" href="{{ $url }}">{{ $title }} </a> <span class="post_count float-right">({{ _getCatPostCount($id) }})</span></li>
        @endforeach
    </ul>
</div>
@endif
@endif