@include('front.layout.header')
<div class="wrapper">
    @include('front.layout.topbar')
    <div class="breadcrumb">
        <div class="bd-container">
            <ul class="nav d-flex">
                <li><a href="{{ route('HomeUrl') }}">Home</a></li>
                <li class="active"><a href="{{ route('HomeUrl') }}faqs">FAQs</a></li>
            </ul>
        </div>
    </div>
    <div class="bd-container">
        <div class="privacy-policy row m-0">
            <main class="col-lg-8 quote-main__col mt-2x">
                   @foreach ($data as $k =>  $v)
                    @php
                      $num = $k+1 . ".";
                      $visible = ($k==0) ? "visible" : "" ;
                      $icon = ($k==0) ? "minus-icon" : "plus-icon" ;
                    @endphp
                      <div class="ex-faqs-item {{ $visible }}">
                      <div class="ex-faqs-header">
                        <h4>
                          <span class="count">{{ $num }}</span>
                          <span class="faqs-text">{{ $v['question'] }}</span>
                          <span class="faqs-icon"><i class="{{ $icon }}"></i></span>
                        </h4>
                      </div>
                      <div class="ex-faqs-body">
                        {!! $v['answer'] !!}
                      </div>
                    </div>
                    @endforeach
            </main>
            @include('front.sidebar.common')
        </div>
    </div>
    @include('front.layout.footer')
