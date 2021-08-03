@include('admin.layout.header')
<div class="body-content">
  <div class="row">
    <div class="col-md-12 col-lg-10">
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="fs-17 font-weight-600 mb-0">General Settings</h6>
            </div>
            <div class="text-right">
              <div class="actions">
                <!-- <a href="#" class="action-item"><i class="ti-reload"></i></a>
                <a href="#" class="action-item"><i class="ti-reload"></i></a>
                <div class="dropdown action-item" data-toggle="dropdown">
                  <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">Refresh</a>
                    <a href="#" class="dropdown-item">Manage Widgets</a>
                    <a href="#" class="dropdown-item">Settings</a>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          @if (Session::has('flash_message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session('flash_message') !!}</strong>
          </div>
          @endif
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-7">
              <label class="req">Admin Slug</label>
              <input type="text" name="path" value="{{ _decrypt($admin_info->slug)}}" class="form-control">
            </div>
            <div class="form-group col-md-7">
              <label class="req">Username</label>
              <input type="text" name="email" value="{{ _decrypt($admin_info->email)}}" class="form-control">
            </div>
            <div class="form-group col-md-7">
              <label class="req">Old Password</label>
              <input type="password" name="old_password" value=""  class="form-control">
              <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
            </div>
            <div class="form-group col-md-7">
              <label class="req">New Password</label>
              <input type="password" name="password" value="" class="form-control">
              <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
            </div>
            <div class="form-group col-md-7">
              <label class="req">Confirm Password</label>
              <input type="password" name="password_confirmation" value="" class="form-control">
              <span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
            </div>
            <div class="form-group col-md-7">
              <input type="submit" name="submit" value="Update" class="btn btn-success float-right">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.layout.footer')