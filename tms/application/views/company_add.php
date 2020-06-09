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
            <h1>Company Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Company Add</li>
            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form id="company_form">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Company</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus">Campany Name</label>
                <input type="text" id="company_name" name="company_name" class="form-control" onblur="set_company_alias();">
              </div>
              <div class="form-group">
                <label for="inputStatus">Company Alias </label>
                <input type="text" id="company_alias" name="company_alias" class="form-control">
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
          <input type="button" value="Submit" onclick="company_register();"class="btn btn-success float-right">
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
    var company_name = $('#company_name').val();
    var company_alias = $('#company_alias').val();

     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/company_register', 
                data: {company_name:company_name,company_alias:company_alias},
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
