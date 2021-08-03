<div class="sidebar__item">

    <div class="section-head">

        <div class="text-center latest-bottom">

            <h3>Popular Quotes</h3>

        </div>

    </div>

    <ul class="nav latest-entries">

        @php

             $blogs = \App\Blogs::where('status' , 'publish')->orderBy('views', 'desc')->take(4)->get();

        @endphp

        @foreach ($blogs as $v)

        @php

          $title = unslash( $v->title );

          $short_title = ( strlen( $title ) > 60 ) ? substr( $title, 0, 160 ) . "...": $title;

          $content = trim(trim_words( html_entity_decode($v->content), 35 ));

          $content = clean_short_code(html_entity_decode($content));

          $image = $v->cover;

          $date = date("d M Y", $v->date );

          $views =  total_views($v->id);

          $url = route('HomeUrl')."/".$v->slug."-2".$v->id;

        @endphp

        <li class="list-item">

            <div class="row">

                <div class="col-3 col-lg-4 col-xl-3 pr-0 align-self-center">
						<a href="{{ $url }}"> <img src="{{ get_post_thumbnail($image) }}" class="img-fluid" alt="{{ $short_title  }} width="100" height="70"> </a>
                </div>

                <div class="col-9 col-lg-8 col-xl-9">

                   <a href="{{ $url }}">{{ $title }}</a>

                    <div class="latest-bottom">

                        <div class="quote-date d-flex">

                            <i class="icon-calendar"></i>

                            <span class="quote-dt-value">{{ $date }}</span>

                        </div>

                        <div class="quote-views d-flex">

                            <i class="icon-eye"></i>

                            <span class="quote-dt-value">{{ $views }}</span>

                        </div>

                    </div>

                </div>

            </div>

        </li>

        @endforeach

        

    </ul>

</div>