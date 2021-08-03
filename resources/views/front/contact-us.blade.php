  @include('front.layout.header')
  <div class="wrapper">
      @include('front.layout.topbar')
      <div class="breadcrumb">
          <div class="bd-container">
              <ul class="nav d-flex">
                  <li><a href="{{ route('HomeUrl') }}">Home</a></li>
                  <li class="active"><a href="{{ route('HomeUrl') }}/contact">Contact Us</a></li>
              </ul>
          </div>
      </div>
      @php
      $title = ($data['title'] !="") ? '<h3>'.$data['title'].'</h3>' : "";
      $detail = ($data['detail'] !="") ? '<p>'.str_replace(['<p>', '</p>'], '', $data['detail'] ).'</p>' : "";
      $email_title = ($data['email_title'] !="") ? '<h4>'.$data['email_title'].'</h4>' : "";
      $phone_title = ($data['phone_title'] !="") ? '<h4>'.$data['phone_title'].'</h4>' : "";
      $address_title = ($data['address_title'] !="") ? '<h4 class="text-sm-center text-md-left">'.$data['address_title'].'</h4>' : "";
      $email_1 = ($data['email_1'] !="") ? '<p >'.$data['email_1'].'</p>' : "";
		$email_2 = ($data['email_2'] !="") ? '<p >'.$data['email_2'].'</p>' : "";
      $phone_1 = ($data['phone_1'] !="") ? '<p >'.$data['phone_1'].'</p>' : "";
		$phone_2 = ($data['phone_2'] !="") ? '<p>'.$data['phone_2'].'</p>' : "";
      $address = ($data['address'] !="") ? '<p >'.$data['address'].'</p>' : "";
	@endphp
	  <div class=" bd-container">
          <section class="contact__box my-2x">
              <div class="row">
                  <div class="col-md-12 col-lg-6 contact__col-1">
                      <div class="bd_contact_col">
                          {!! $title !!}
                          {!! $detail !!}
                          <div class="row contact__item">
                              <div class="col-4 col-sm-3 px-0">
                                  <div class="icon">
                                      <i class="icon-marker"></i>
                                  </div>
                              </div>
                              <div class="col-8 col-sm-9">
                                  <div class="contact_detail">
                                      {!! $address_title !!}
                                      {!! $address !!}
                                  </div>
                              </div>
                          </div>

                          <div class="row contact__item">
                              <div class="col-4 col-sm-3 px-0">
                                  <div class="icon">
                                      <i class="icon-email"></i>
                                  </div>
                              </div>
                              <div class="col-8 col-sm-9">
                                  <div class="contact_detail">
                                      {!! $email_title !!}
                                      {!! $email_1 !!}
                                      {!! $email_2 !!}
                                  </div>
                              </div>
                          </div>

                          <div class="row contact__item">
                              <div class="col-4 col-sm-3 px-0">
                                  <div class="icon">
                                      <i class="icon-phone"></i>
                                  </div>
                              </div>
                              <div class="col-8 col-sm-9">
                                  <div class="contact_detail">
                                      {!! $phone_title !!}
                                      {!! $phone_1 !!}
                                      {!! $phone_2 !!}
                                  </div>
                              </div>
                          </div>
                          @php
                          $d = \App\Homedata::select("social_links")->first();
                          $s = ( $d[ 'social_links' ] != "" ) ? json_decode( $d[ 'social_links' ], true ) : array();
                          @endphp
                          <div class="row">
                              <div class="col-md-12">
                                  <ul class="nav contact_nav">
                                      @foreach ($s as $k)
                                      <li class="{{ $k['icon'] }}"> <a href="{{ $k['link']}}" target="_blank"><i class="{{ $k['icon'] }}"></i></a> </li>
                                      @endforeach
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6 contact__col-2">
                      <div class="bd_contact_col bd_form-col">
                          <h3>Stay in Touch </h3>
                          <div id="errors"></div>
                          <form  id="contactform">
                              <div class="form-group">
                                  <label>Name</label>
                                  <input type="text" name="name" placeholder="Enter Your Full Name" class="form-control">
                              </div>
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" name="email" placeholder="Enter Your Name" class="form-control">
                              </div>
                              <div class="form-group">
                                  <label>Subject</label>
                                  <input type="text" name="subject" placeholder="Enter Your Subject" class="form-control">
                              </div>
                              <div class="form-group">
                                  <label>Message</label>
                                  <textarea class="form-control" placeholder="Enter Your Details Here" name="message" rows="8"></textarea>
                              </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-contact contactform">Send</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-md-12 my-2x">
                      <div class="map" id="map-canvas">
                      </div>
                  </div>
              </div>
          </section>
      </div>
  </div>
  @php
  $row = \App\ContactUs::select('views')->first();
  refresh_views($row['views'] , 0 , 5 , get_postid('full'));
  @endphp
<script>
      function loadMap() {
          $("#map-canvas").html('@php echo $data['google_map']; @endphp');
      }
      setTimeout(loadMap, 3000);

  </script>
  @include('front.layout.footer')
  
