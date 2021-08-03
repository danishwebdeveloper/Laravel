@include('front.layout.header')
<div class="wrapper">
    @include('front.layout.topbar')
<section class="content four-section">
	<div class="container">
		<div class="row">
			<div class="col-md-7 mx-auto">
				<img src="{{ asset('assets/images/404.webp') }}" class="img-fluid" alt="404-image">
				<div class="four-text text-center">
					<h4 class="text-lblue">If you want to try something more. Search Here</h4>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Enter Something to Search">
						<button class="btn btn-round">Search</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@include('front.layout.footer')
