@include( 'admin.layout.header' )
<div class="body-content">
  <div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
      <div class="card card-stats statistic-box">
        <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="typcn typcn-device-tablet"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Categories</p>
          <h3 class="card-title fs-18 font-weight-bold">{{ $users = DB::table('blogcats')->count() }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Services </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
      <div class="card card-stats statistic-box">
        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fas fa-th-list"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Blogs</p>
          <h3 class="card-title fs-21 font-weight-bold">{{ $users = DB::table('blogs')->where('status', 'publish')->count() }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Blogs </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
      <div class="card card-stats statistic-box">
        <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out far fa-envelope"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Emails</p>
          <h3 class="card-title fs-21 font-weight-bold">{{ $users = DB::table('contactusers')->count() }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Emails </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
      <div class="card card-stats statistic-box">
        <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
          <div class="card-icon d-flex align-items-center justify-content-center"> <i class="hvr-buzz-out fas fa-eye"></i> </div>
          <p class="card-category text-uppercase fs-10 font-weight-bold">Views</p>
          @php
          $sql = "select sum(views) as views from views";
          $row = DB::select($sql);
          @endphp
          <h3 class="card-title fs-21 font-weight-bold">{{ $row[0]->views }}</h3>
        </div>
        <div class="card-footer p-3">
          <div class="stats"> Total Views </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
  <div class="header bg-white pb-4"> 
    <!-- Body -->
    <script src="{{ asset("admin-assets/dist/js/Chart.min.js")}}"></script>
    @php
      $Extra = new \App\Http\Controllers\AdminController;
      $views = $Extra->adsViews("current_month");
      $views_m = $Extra->adsViews("monthly");
      $views_y = $Extra->adsViews("annually");
    @endphp
    <template class="vw-cr-mn">@json($views)</template>
    <template class="vw-cr-yr">@json($views_m)</template>
    <template class="vw-cr-an">@json($views_y)</template>
    <div class="header-body mb-4">
      <div class="row align-items-end">
        <div class="col"> 
          <!-- Pretitle -->
          <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1"> Overview </h6>
          <!-- Title -->
          <h1 class="header-title fs-21 font-weight-bold"> VIEWS </h1>
        </div>
        <div class="col-auto"> 
          <!-- Nav -->
          <ul class="nav nav-tabs header-tabs c-nav">
            <li class="nav-item"> <a  data-v="daily" id="daily" class="nav-link text-center active ___vw_dsb" data-m="current_month">
              <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1"> Daily </h6>
              <h3 class="mb-0 fs-16 font-weight-bold"> @php
                $today = date( "y-m-d" );
                $sql = "select sum(views) as views from views where view_date like '%$today%'";
                $res = DB::select($sql);
                @endphp
                {{ $res[0]->views }} </h3>
              </a> </li>
            <li class="nav-item"> <a  id="1" data-v="monthly" class="nav-link text-center ___vw_dsb" data-m="monthly">
              <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1"> Monthly </h6>
              <h3 class="mb-0 fs-16 font-weight-bold"> @php
                $today = date( "y-m-" );
                $sql = "select sum(views) as views from views where view_date like '%$today%'";
                $res = DB::select($sql);
                @endphp
                {{ $res[0]->views }} </h3>
              </a> </li>
            <li class="nav-item"> <a  id="1" data-v="yearly" class="nav-link text-center ___vw_dsb" data-m="annually">
              <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1"> Yearly </h6>
              <h3 class="mb-0 fs-16 font-weight-bold"> @php
                $today = date( "y-" );
                $sql = "select sum(views) as views from views where view_date like '%$today%'";
                $res = DB::select($sql);
                @endphp
                {{ $res[0]->views }} </h3>
              </a> </li>
          </ul>
        </div>
      </div>
      <!-- / .row --> 
    </div>
    <!-- / .header-body --> 
    <!-- Footer -->
    <div class="header-footer">

      <div class="col-lg-12">
        <div id="vclear-chart" class="vchartreport">
          <canvas id="vlineChart" height="150" style="display: block; width: 483px; height: 225px;" width="483" class="vchartjs-render-monitor"></canvas>
        </div>
      </div>
      <script>
          function _____vchart(labels, d1){
            var lineData = {
              labels:  labels,
              datasets: [
                {
                  label: "Website Views",
                  fillColor: "rgba(0,128,0,0.2)",
                  pointColor: "rgba(0,128,0,1)",
                  backgroundColor: 'rgba(0,128,0,0.4)',
                  pointBackgroundColor: "rgba(0,128,0,0.9)",
                  data: d1
                }
              ]
            };
            var lineOptions = {
              responsive: true,
              tooltips: {mode: 'index',intersect: false,caretPadding: 20,bodyFontColor: "#000000",bodyFontSize: 14,bodyFontColor: '#FFFFFF',bodyFontFamily: "'Helvetica', 'Arial', sans-serif",footerFontSize: 50,callbacks: {
                  label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    if (label) {
                      label += ': ';
                    }
                    label += tooltipItem.yLabel.toLocaleString();
                    return label;
                  }
                }},
              hover: {mode: 'nearest',intersect: true},
              animation: {
                      duration: 3000,
                  },
              scales: {
                yAxes:[{
                  ticks:{
                    callback:function(value, index, values){
                      return value.toLocaleString();
                    }
                  }
                }]
              }
            };
            $("canvas#vlineChart").remove();
            $("div.vchartreport").append('<canvas id="vlineChart" height="150" style="display: block; width: 483px; height: 225px;" width="483" class="vchartjs-render-monitor"></canvas>');
            var ctx = document.getElementById("vlineChart").getContext("2d");
            let draw = Chart.controllers.line.prototype.draw;
            Chart.controllers.line = Chart.controllers.line.extend({
              draw: function() {
                draw.apply(this, arguments);
                let ctx = this.chart.chart.ctx;
                let _stroke = ctx.stroke;
                ctx.stroke = function() {
                  ctx.save();
                  _stroke.apply(this, arguments)
                  ctx.restore();
                }
              }
            });
            Chart.defaults.LineWithLine = Chart.defaults.line;
            Chart.controllers.LineWithLine = Chart.controllers.line.extend({
               draw: function(ease) {
                Chart.controllers.line.prototype.draw.call(this, ease);
                if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
                 var activePoint = this.chart.tooltip._active[0],
                   ctx = this.chart.ctx,
                   x = activePoint.tooltipPosition().x,
                   topY = this.chart.scales['y-axis-0'].top,
                   bottomY = this.chart.scales['y-axis-0'].bottom;
                 // draw line
                 ctx.save();
                 ctx.beginPath();
                 ctx.moveTo(x, topY);
                 ctx.lineTo(x, bottomY);
                 ctx.lineWidth = 2;
                 ctx.strokeStyle = '#07C';
                 ctx.stroke();
                 ctx.restore();
                }
               }
            });
            chart = new Chart(ctx, {type: 'LineWithLine', data: lineData, options:lineOptions});
          }
          function kFormatter(num) {
              return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k' : Math.sign(num)*Math.abs(num)
          }
          var d = @json($views);
          _____vchart(d["labels"], d["data1"]);
          </script>
    </div>
  </div>
  <div class="col-lg-12"> 
    <!--Basic Tabs-->
    <div class="card mb-4">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fs-17 font-weight-600 mb-0">Views List</h6>
          </div>
          <div class="text-right">
            <div class="actions"> {{-- <a href="#" class="action-item"><i class="ti-reload"></i></a>
              <div class="dropdown action-item" data-toggle="dropdown"> <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item">Refresh</a> <a href="#" class="dropdown-item">Manage Widgets</a> <a href="#" class="dropdown-item">Settings</a> </div>
              </div>
              --}} </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Daily</a> </li>
          <li class="nav-item"> <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Monthly</a> </li>
          <li class="nav-item"> <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Yearly</a> </li>
          <li class="nav-item"> <a class="nav-link" id="pills-total-tab" data-toggle="pill" href="#pills-total" role="tab" aria-controls="pills-total" aria-selected="false">Total</a> </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
              <thead>
                <tr>
                  <td><strong>#</strong></td>
                  <td style="width: 50%;"><strong>Title</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong> Daily Views</strong></td>
                  <td><strong> Monthly Views</strong></td>
                  <td><strong> Yearly Views</strong></td>
                  <td><strong> Total Views</strong></td>
                </tr>
              </thead>
              <tbody>
              
              @php
              $today = date( "y-m-d" );
              
              $sql = "select a.*, sum(b.views) as totalviews from blogs a LEFT JOIN views b   ON a.id = b.post_id where  b.view_date='$today' and b.page_id='2' GROUP BY a.id order by totalviews desc limit 10";
              $data = DB::select($sql);
              
              foreach ( $data as $k => $v ) {
              $v = ( array )$v;
              $id = $v[ 'id' ];
              $month_views = monthly_views($id);
              $year_views = yearly_views($id);
              $total_views = total_views($id);
              $link = route('HomeUrl')."/".$v['slug']."-2".$id;
              $views = $v[ "totalviews" ];
              echo "
              <tr>
                <td>$id</td>
                <td style='width: 50%'><a href='$link' target='_blank'>" . $v[ "title" ] . "</a></td>
                <td>" . date( "d M Y", $v[ "date" ] ) . "</td>
                <td>$views</td>
                <td>$month_views</td>
                <td>$year_views</td>
                <td>$total_views</td>
              </tr>
              ";
              }
              @endphp
                </tbody>
              
            </table>
          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
              <thead>
                <tr>
                  <td><strong>#</strong></td>
                  <td><strong>Title</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong> Daily Views</strong></td>
                  <td><strong> Monthly Views</strong></td>
                  <td><strong> Yearly Views</strong></td>
                  <td><strong> Total Views</strong></td>
                </tr>
              </thead>
              <tbody>
              
              @php
              $start = date( "Y" ) . "-" . date( "m" ) . "-01";
              $today = date( "Y-m-d" );
              $month = date( "m" );
              $year = date( "Y" );
              $sql = "select a.*, sum(b.views) as totalviews from blogs a LEFT JOIN views b   ON a.id = b.post_id where (MONTH(b.view_date) = '$month') and (YEAR(b.view_date) = '$year' and b.page_id='2')GROUP BY a.id order by totalviews desc limit 10";
              $data = DB::select($sql);
              
              foreach ( $data as $k => $v ) {
              $v = ( array )$v;
              $id = $v[ 'id' ];
              $daily_views = daily_views($id);
              $year_views = yearly_views($id);
              $total_views = total_views($id);
              $link = route('HomeUrl')."/".$v['slug']."-2".$id;
              $views = $v[ "totalviews" ];
              echo "
              <tr>
                <td>$id</td>
                <td><a href='$link' target='_blank'>" . $v[ "title" ] . "</a></td>
                <td>" . date( "d M Y", $v[ "date" ] ) . "</td>
                <td>$daily_views</td>
                <td>$views</td>
                <td>$year_views</td>
                <td>$total_views</td>
              </tr>
              ";
              }
              @endphp
                </tbody>
              
            </table>
          </div>
          <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
              <thead>
                <tr>
                  <td><strong>#</strong></td>
                  <td><strong>Title</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong> Daily Views</strong></td>
                  <td><strong> Monthly Views</strong></td>
                  <td><strong> Yearly Views</strong></td>
                  <td><strong> Total Views</strong></td>
                </tr>
              </thead>
              <tbody>
              
              @php
              $start = date( "Y" ) . "-" . date( "m" ) . "-01";
              $today = date( "Y-m-d" );
              $month = date( "m" );
              $year = date( "Y" );
              $sql = "select a.*, sum(b.views) as totalviews from blogs a LEFT JOIN views b   ON a.id = b.post_id where (YEAR(b.view_date) = '$year' and b.page_id='2')GROUP BY a.id order by totalviews desc limit 10";
              $data = DB::select($sql);
              
              foreach ( $data as $k => $v ) {
              $v = ( array )$v;
              $id = $v[ 'id' ];
              $daily_views = daily_views($id);
              $monthly_views = monthly_views($id);
              $total_views = total_views($id);
              $link = route('HomeUrl')."/".$v['slug']."-2".$id;
              $views = $v[ "totalviews" ];
              echo "
              <tr>
                <td>$id</td>
                <td><a href='$link' target='_blank'>" . $v[ "title" ] . "</a></td>
                <td>" . date( "d M Y", $v[ "date" ] ) . "</td>
                <td>$daily_views</td>
                <td>$monthly_views</td>
                <td>$views</td>
                <td>$total_views</td>
              </tr>
              ";
              }
              @endphp
                </tbody>
              
            </table>
          </div>
          <div class="tab-pane fade" id="pills-total" role="tabpanel" aria-labelledby="pills-total-tab">
            <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table">
              <thead>
                <tr>
                  <td><strong>#</strong></td>
                  <td><strong>Title</strong></td>
                  <td><strong>Date</strong></td>
                  <td><strong> Daily Views</strong></td>
                  <td><strong> Monthly Views</strong></td>
                  <td><strong> Yearly Views</strong></td>
                  <td><strong> Total Views</strong></td>
                </tr>
              </thead>
              <tbody>
              
              @php
              $start = date( "Y" ) . "-" . date( "m" ) . "-01";
              $today = date( "Y-m-d" );
              $month = date( "m" );
              $year = date( "Y" );
              $sql = "select a.*, sum(b.views) as totalviews from blogs a LEFT JOIN views b   ON a.id = b.post_id where (YEAR(b.view_date) = '$year' and b.page_id='2')GROUP BY a.id order by totalviews desc limit 10";
              $data = DB::select($sql);
              
              foreach ( $data as $k => $v ) {
              $v = ( array )$v;
              $id = $v[ 'id' ];
              $daily_views = daily_views($id);
              $monthly_views = monthly_views($id);
              $total_views = total_views($id);
              $link = route('HomeUrl')."/".$v['slug']."-2".$id;
              $views = $v[ "totalviews" ];
              echo "
              <tr>
                <td>$id</td>
                <td><a href='$link' target='_blank'>" . $v[ "title" ] . "</a></td>
                <td>" . date( "d M Y", $v[ "date" ] ) . "</td>
                <td>$daily_views</td>
                <td>$monthly_views</td>
                <td>$views</td>
                <td>$total_views</td>
              </tr>
              ";
              }
              @endphp
                </tbody>
              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/.body content--> 
@include('admin.layout.footer')