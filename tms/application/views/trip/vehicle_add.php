<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vehicle Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Vehicle Add</li>
            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form method="post" id="vehicle_form" action="<?php echo base_url();?>home/vehicle_register" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Vehicle</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus">Vehicle No </label>
                <input type="text" id="vehicle_no" name="vehicle_no" class="form-control" required="">
              </div>
              <div class="form-group">
                <label for="inputStatus">Capacity (TONS) </label>
                <input type="number" id="capacity" name="capacity" class="form-control" required="">
              </div>
              <div class="form-group">
                <label for="inputStatus">Insurance Expirey Date </label>
                <input type="date" id="insurance_expire" name="insurance_expire" class="form-control" required="">
              </div>
              <div class="form-group">
                <label for="inputStatus">Payment Type </label>
                <select id="payment" name="payment" class="form-control select2" required>
                  <option value="" selected>Select</option>
                  <option value="Fastack">Fastack</option>
                  <option value="Cash">Cash</option>
                  <option value="Card">Card</option>
                </select>
              </div>
              <div class="form-group">
                  <label for="rc_book">RC Book Copy</label><br>
                  <input type="file" name="rc_book" id="rc_book">
              </div>
              <div class="form-group">
                  <label for="insurance_copy">Insurance Copy</label><br>
                  <input type="file" name="insurance_copy" id="insurance_copy">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="row">
            <label style="display:none;" id="error_msg" class="text-danger" for="error_msg">Please Select Customer , Product</label>
          </div>
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Submit" class="btn btn-success float-right">
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">

  function vehicle_register()
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/vehicle_register', 
                data: $("#vehicle_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(result[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>vehicle";
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
