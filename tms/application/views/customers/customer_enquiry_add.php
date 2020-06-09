<!DOCTYPE html>
<?php
 if (!empty(validation_errors())) {
        ?>
        <div class="content pt0 flashmsg">
            <div class = "alert alert-danger">
                <a class="close" data-dismiss="alert">X</a>
                <strong><?php echo validation_errors(); ?></strong>       
            </div>
        </div>
        <?php
    }
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
            <h1>Add Customer Enquiry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Customer Enquiry</li>
            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form id="enquiry_form">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Customer Enquiry</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body row">
              <!-- <div class="form-group col-md-2">
                <label for="inputStatus">Customer</label>
                <select id="is_customer" class="form-control custom-select" onchange="is_already_exist();">
                 <option value="New" selected>New</option>
                 <option value="Existing">Exist Customer</option>
                </select>
              </div> -->
             <!-- <div class="form-group col-md-2" id="exist_customer" style="display:none;">
                <label for="inputStatus">Select Customer </label>
                <select id="is_customer_id" class="form-control custom-select">
                  <option value="" selected>Select</option>
                  <?php 
                      foreach($customers as $row1)
                      {
                    ?>
                    <option cust_name="<?php echo $row1['cust_name'];?>" cust_mobile_no="<?php echo $row1['cust_mob_no'];?>" cust_email="<?php echo $row1['cust_email'];?>"  value="<?php echo $row1['cust_id'];?>"><?php echo $row1['cust_name'];?></option>
                  <?php } ?>
                  <input type="hidden" id="cust_id" name="cust_id">
                </select>
              </div> -->
              <div class="form-group col-md-2">
                <label for="cust_mobile_no">Customer Mobile No</label>
                <input type="text" id="cust_mobile_no" name="cust_mobile_no" class="form-control" onblur="search_customer_result();" <?php if(isset($mobile)){ ?> value="<?php echo $mobile;?>" <?php } ?>>
                <small>Press Tab (*)</small>
              </div>
              <div class="form-group col-md-2">
                <label for="inputName">Cutomer Name</label>
                <input type="text" id="cust_name" name="cust_name" class="form-control">
              </div>
              <div class="form-group col-md-2">
                <label for="cust_email">Customer Email</label>
                <input type="text" id="cust_email" name="cust_email" class="form-control">
              </div>
              <input type="hidden" id="cust_id" name="cust_id">
              <div class="form-group col-md-2">
                <label for="inputStatus">Enquiry Type</label>
                <select id="enquiry_type" name="enquiry_type" class="form-control custom-select" onclick="choose_employee();">
                 <option value="Direct Visit">Direct Visit</option>
                 <option value="Phone Call">Phone Call</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="inputDescription">Enquiry Description</label>
                <textarea id="enquiry_desc" name="enquiry_desc" class="form-control" rows="4" ></textarea>
              </div>
              <div class="form-group col-md-2">
                <label for="expected_date">Expected Date</label>
                <input type="date" id="expected_date" name="expected_date" class="form-control">
              </div>
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="row">
            <label style="display:none;" id="error_msg" class="text-danger" for="error_msg"></label>
          </div>
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="button" value="Submit" onclick="customer_enquiry_register();"class="btn btn-success float-right">
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

  function choose_employee()
  {
    <?php $users = $this->session->userdata('users'); 
    $users['user_id'];?>
    var enquiry_type = $('#enquiry_type').val();
    if(enquiry_type == 'Direct Visit')
    {
      $('#employee_id').val("<?php echo $users['user_id'];?>");
    }
    else
    {
      $('#employee_section').show();
    }
    
  }

  function search_customer_result()
  {
    var cust_mobile_no = $('#cust_mobile_no').val();
    $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/search_customer_result', 
                data: {cust_mobile_no:cust_mobile_no},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     $('#cust_name').val(res[1]);
                     $('#cust_email').val(res[3]);
                     $('#cust_id').val(res[0]);
                  }
                  else
                  {
                    
                  }
                }
          });
  }

  function is_already_exist()
  {
    var is_customer = $('#is_customer').val();
    if(is_customer == 'New')
    {
      $('#exist_customer').hide();
    }
    else
    {
      $('#exist_customer').show();
    }
  }
  function customer_enquiry_register()
  {
    $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/customer_enquiry_register', 
                data: $("#enquiry_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>customer_enquiry";
                  }
                  else
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                   // window.location = "<?php echo base_url();?>/dashboard";
                  }
                }
          });
    
  }
</script>

</body>
</html>
