@php
	$style = ($ad['end'] == "true") ? "id='the-sticky-div'" : "" ;
	$data = getimagesize($ad['img']);
	$width = $data[0];
	$height = $data[1];
@endphp
<div class="sidebar__item" {!! $style !!}> 
<a href="{{ $ad['url'] }}" target="_blank"><img src="{{ $ad['img'] }}" class="img-fluid" alt="{{ $ad['alt'] }}" title="{{ $ad['title'] }}" height="{{ $height }}" width="{{ $width }}"></a>
</div>