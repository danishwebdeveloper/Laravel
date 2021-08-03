
@if (count($data) > 0)
@php
  $n =rand(0,35);
@endphp
 
 <div class="title-head">
  <h4 class="text-lblue">Frequently Asked Questions</h4>
</div>
<div class="row">
  <div class="col-md-12">
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
  </div>
</div>
@endif



