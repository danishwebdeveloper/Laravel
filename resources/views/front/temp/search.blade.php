@include('front.layout.header')

<div class="wrapper">

@include('front.layout.topbar')

<div class="breadcrumb">

  <div class="bd-container">

    <ul class="nav d-flex">

      <li><a href="{{ route('HomeUrl') }}">Home</a></li>

      <li class="active"><a href="">Search</a></li>

    </ul>

  </div>

</div>



<div class="bd-container">

<section class="search-section quotes-section">

@if ($data)

 <h1>Search Result for <span>{{ $where }}</span></h1>

@endif

<div class="row">

  <div class="col-md-12">

    @if (!$data)

      <div class="search-box w-75 mx-auto">

        <form role="search" class="form--search" action="/search">

        <div class="form-group">

          <input type="search" name="search" class="form-control" placeholder="Enter Something to Search">

          <a type="submit" ><span class="icon-search"></span></a> 

        </div>

      </form>

        <div class="norecord-box">

          <h2><span class="text-lblue">Sorry !!</span> There is No Record Found Related to Your Search</h2>

        </div>

    </div>

    @endif

    @if ($data)

    <div class="row my-2x">

       @foreach ($data as $v)

              @php

                  $title = unslash( $v->title );

                  $short_title = ( strlen( $title ) > 60 ) ? substr( $title, 0, 160 ) . "...": $title;

                  $content = trim(trim_words( html_entity_decode($v->content), 35 ));

                  $content = clean_short_code(html_entity_decode($content));

                  $image = $v->cover;

                  $date = date("d M Y", $v->date );

                  $views =  $v->views;

                  $url = route('HomeUrl')."/".$v->slug."-2".$v->id;

                @endphp

      <article class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-1x wow animate__animated animate__bounceInUp">
        <div class="article__column"> <a href="{{ $url }}" class="quote-image"> <img src="{{ get_post_mid($image) }}"  width="300" height="200"  class="img-fluid" alt="{{ $title }}"> </a>
        <div class="quote-body">
          <div class="quote-title">
            <h3><a href="{{ $url }}">{{ $short_title }}</a></h3>
          </div>
          <div class="d-flex justify-content-between">
            <div class="quote-date d-flex pt-1x"> <i class="icon-calendar"></i> <span class="quote-dt-value">{{ $date }}</span> </div>
            <div class="quote-views d-flex pt-1x"> <i class="icon-eye"></i> <span class="quote-dt-value">{{ $views }}</span> </div>
          </div>
        </div>
      </div>
    </article>

              @endforeach

    </div>

     @endif

  </div>

  </section>

</div>

@include('front.layout.footer') 