<?php ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRM | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/select2/css/select2.min.css">
 
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>CRM</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new Company</p>

      <form id="company_form">
        <div class="input-group mb-3">
          <input type="text" id="company_name" name="company_name" class="form-control" onblur="set_company_alias();" placeholder="Company Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="hidden" id="company_alias" name="company_alias" class="form-control" >
          <input type="text" id="user_email" name="user_email" class="form-control" placeholder="Company Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="retype_password" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" id="user_mobile" name="user_mobile" class="form-control" placeholder="Contact No">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
              <input type="radio" id="basic" name="membership" value="1" checked>
              <label for="basic">Basic
              </label>
            </div>
            <div class="icheck-primary d-inline">
              <input type="radio" id="std" name="membership" value="2">
              <label for="std">Standard
              </label>
            </div>
            <div class="icheck-primary d-inline">
              <input type="radio" id="premium" name="membership" value="3">
              <label for="premium">Premium
              </label>
            </div>
          </div>
        </div> 
        <div class="input-group mb-3">
          <select id="city_id" name="city_id" class="form-control select2">
            <option value="" selected>Select City</option>
               <?php 

                foreach($cities as $row)
                {
                    ?>
                    <option value="<?php echo $row['city_id'];?>"><?php echo $row['city_name'];?></option>
                    <?php
                }
              ?>
              
          </select>
        </div> 
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="button" value="Register" onclick="company_register();"class="btn btn-primary btn-block">
          </div>
          <div class="row">
              <label style="display:none;" id="error_msg" class="text-danger" for="error_msg">Please Select Customer , Product</label>
            </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login.html" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="<?php echo Base_path;?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo Base_path;?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo Base_path;?>assets/dist/js/adminlte.min.js"></script>

<script src="<?php echo Base_path;?>assets/plugins/select2/js/select2.full.min.js"></script>

<script type="text/javascript">
  function set_company_alias()
  {
    var company_name = $('#company_name').val();
    
    var company_alias = company_name.replace(/[^\w\s]/gi, '')
    company_alias = company_alias.toLowerCase();
    company_alias = company_alias.replace(/#|_/g,'-')
    company_alias = company_alias.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, ' ');
    company_alias = company_alias.replace(/\s{1,}/g,'-');
    $('#company_alias').val(company_alias);
  }

  function company_register()
  {
    $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/company_register', 
                data: $("#company_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(result[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>";
                  }
                  else
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);                  
                  }
                }
          });
    
  }
</script>
</body>
</html>
<?php ?>