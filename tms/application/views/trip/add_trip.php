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
            <h1>Trip Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Trip Add</li>
            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form id="trip_form">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Trips</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus">From </label>
                <select id="from_id" name="from_id" class="form-control select2" onchange="get_route();">
                  <option value="" selected>Select</option>
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
              <div class="form-group">
                <label for="inputStatus">To </label>
                <select id="to_id" name="to_id" class="form-control select2" onchange="get_route();">
                  <option value="" selected>Select</option>
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
              <div class="form-group">
                <label for="inputStatus">Trip </label>
                <input type="text" id="trip" name="trip" readonly class="form-control">
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
          <input type="button" value="Submit" onclick="trip_register();"class="btn btn-success float-right">
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
  function get_route()
  {
    var from = document.getElementById("from_id");
    var from_val = from.options[from.selectedIndex].text;
    var to = document.getElementById("to_id");
    var to_val = to.options[to.selectedIndex].text;
    $('#trip').val(from_val+' - '+to_val);
  }

  function trip_register()
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/trip_register', 
                data: $("#trip_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(result[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>trips";
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
