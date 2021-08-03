<!DOCTYPE html>
<html lang="en">
	<head>
		@php
			$segment = request()->segment(1);
			$route = $segment;
			$page_name = get_postid("full");
			$page_id = get_postid("page_id");
			$post_id = get_postid("post_id");
			Header("Cache-Control: must-revalidate");
			$offset = 60 * 60 * 24 * 365;
			$ExpStr = "Expires: " . gmdate("D, d M Y H", time() + $offset) . " GMT";
			Header($ExpStr);
		@endphp
		@include('front.layout.meta')

			<link rel="stylesheet" href="{{asset('assets/css/grid.css') }}">
	@if (empty($page_name) || $page_name=="search")
			<link rel="stylesheet" href="{{asset('assets/css/blog-list.min.css') }}">
	@endif
	@if ($page_id == 1)
			<!-- Only Only For List Page -->
			<link rel="stylesheet" href="{{asset('assets/css/blog-list.min.css') }}">
	@endif
	@if ($page_id == 2)
		<!-- Only Detial page -->
		<link rel="stylesheet" href="{{asset('assets/css/blog-detail.min.css') }}">
	@endif
	@if ($segment == "contact")
		<!-- Only Contact page -->
		<link rel="stylesheet" href="{{asset('assets/css/contact.min.css') }}">
	@endif
	@if ($segment == "terms-conditions" || $segment == "privacy-policy" || $segment == "faqs" )
	<!-- Only Detial page -->
		<link rel="stylesheet" href="{{asset('assets/css/blog-detail.min.css') }}">
	@endif
			<script>
				if(/^\?fbclid=/.test(location.search)){
				location.replace(location.href.replace(/\?fbclid.+/, ""));
				}
			</script>
	@if (empty($page_name))
	@php
        $home = \App\Homedata::all()->map->toArray();
        $design = $home[0]['home_design'];
        $design = json_decode($design);
		$sectinos = array();
		foreach ($design as $k => $v) {
			$sectinos[]= "homeSec".$k;
		}
    @endphp
	<template id='___sec'>@json($sectinos)</template>
	<script>
		  var sectinos = JSON.parse(document.getElementById("___sec").innerHTML);
          window.addEventListener("load", (event) => {sectinos.forEach(name =>{
              handleEachCategory(name);
            });
          }, false);

          function handleEachCategory(category) {
            let target = document.getElementById(category);
            let observer;
            let isVis;
            createObserver();

          function createObserver() {
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.25
            }
            observer = new IntersectionObserver(handleIntersect, options);
            observer.observe(target);
          }  

          function handleIntersect(entries, observer) {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                  entry.target.childNodes[1].display = "block";
                  entry.target.classList.remove('isLoading');
              }
          });
        }
      }
    </script>
	@endif
	@if ($page_id == 1)
		<script>
          window.addEventListener("load", (event) => {["catSec0","catSec1","catSec2"].forEach(name =>{
              handleEachCategory(name);
            });
          }, false);

          function handleEachCategory(category) {
            let target = document.getElementById(category);
            let observer;
            let isVis;
            createObserver();

          function createObserver() {
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.25
            }
            observer = new IntersectionObserver(handleIntersect, options);
            observer.observe(target);
          }  

          function handleIntersect(entries, observer) {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                  entry.target.childNodes[1].display = "block";
                  entry.target.classList.remove('isLoading');
              }
          });
        }
      }
    </script>
	@endif
		</head>
	<body>


