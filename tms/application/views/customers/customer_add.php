<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
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
            <h1>
              <?php if(isset($customers)){
                ?>
                Customer Edit
              <?php } else { ?>
                Customer Add
              <?php } ?>
              </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer Add</li>
            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <form id="customer_form">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Customer</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus">Customer Type</label>
                <select id="cust_type" name="cust_type" class="form-control custom-select">
                  <?php if(isset($customers)){ 
                      if($customers['cust_type'] == 'Office'){ ?>
                        <option value="Office" selected="">Office</option>
                      <?php } elseif ($customers['cust_type'] == 'Customer_Place') {
                       ?>
                       <option value="Customer_Place" selected="">Customer Place</option>
                       <?php
                      }
                      ?>
                      <option value="Office">Office</option>
                      <option value="Customer_Place">Customer Place</option>
                      <?php
                     } else { ?>
                    <option value="" selected>Select</option>
                    <option value="Office">Office</option>
                    <option value="Customer_Place">Customer Place</option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputName">Customer Name (*)</label>
                <input type="text" id="cust_name" name="cust_name" class="form-control"
                <?php if(isset($customers)){ ?> value = "<?php echo $customers['cust_name'];?>" <?php }?>>
                <?php if(isset($customers)){ ?> <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $customers['cust_id'];?>"> <?php }?>
              </div>
              <div class="form-group">
                <label for="cust_mob_no">Customer Mobile</label>
                <input type="text" id="cust_mob_no" name="cust_mob_no" class="form-control"
                <?php if(isset($customers)){ ?> value = "<?php echo $customers['cust_mob_no'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="cust_whatsapp_mob_no">Customer Whatsapp No</label>
                <input type="text" id="cust_whatsapp_mob_no" name="cust_whatsapp_mob_no" class="form-control"
                <?php if(isset($customers)){ ?> value = "<?php echo $customers['cust_whatsapp_mob_no'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="cust_mob_no">Customer Landline Mobile (*)</label>
                <input type="text" id="cust_land_mob_no" name="cust_land_mob_no" class="form-control"
                <?php if(isset($customers)){ ?> value = "<?php echo $customers['cust_land_mob_no'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="cust_email">Customer Email (*)</label>
                <input type="text" id="cust_email" name="cust_email" class="form-control"
                <?php if(isset($customers)){ ?> value = "<?php echo $customers['cust_email'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="cust_office_email">Customer Office Email (*)</label>
                <input type="text" id="cust_office_email" name="cust_office_email" class="form-control"
                <?php if(isset($customers)){ ?> value = "<?php echo $customers['cust_office_email'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="inputStatus">City </label>
                <select id="city_id" name="city_id" class="form-control select2">
                  <option value="" selected>Select</option>
                     <?php 
                      if(isset($customers))
                      { 
                        foreach($cities as $row)
                        {
                          if($customers['city_id'] == $row['city_id'])
                          {
                            ?>
                            <option value="<?php echo $row['city_id'];?>" selected><?php echo $row['city_name'];?></option>
                            <?php
                          }
                        }
                      }
                      else
                      {
                        foreach($cities as $row)
                        {
                            ?>
                            <option value="<?php echo $row['city_id'];?>"><?php echo $row['city_name'];?></option>
                            <?php
                        }
                      }
                    ?>
                    
                </select>
              </div>
              <div class="form-group">
                <label for="inputDescription">Customer Address</label>
                <div class="row">
                  <?php if(isset($customers)){
                    $cust_address = explode('|', $customers['cust_address']);
                  }
                  ?>
                  <input type="text" id="flat_no" name="flat_no" class="form-control col-4" placeholder="Flat No"
                  <?php if(isset($customers)){ ?> value = "<?php echo $cust_address[0];?>" <?php }else{ ?> value = "" <?php } ?>>
                  <input type="text" id="street" name="street" class="form-control col-8" placeholder="Street"
                  <?php if(isset($customers)){ ?> value = "<?php echo $cust_address[1];?>" <?php }else{ ?> value = "" <?php } ?> >
                 </div>
                <div class="row">
                   <input type="text" id="city" name="city" class="form-control col-12" placeholder="Location & City"
                  <?php if(isset($customers)){ ?> value = "<?php echo $cust_address[2];?>" <?php }else{ ?> value = "" <?php } ?>>
                </div>
                <div class="row">
                  <input type="text" id="pincode" name="pincode" class="form-control col-12" placeholder="Pincode (*)"
                  <?php if(isset($customers)){ ?> value = "<?php echo $cust_address[3];?>" <?php }else{ ?> value = "" <?php } ?>>
                </div>
              </div> 
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div id="success_msg" class="col-6 alert alert-success alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        Customer Added Successfully
      </div>

      <div class="row">
        <div class="col-6">
          <div class="row">
            <label style="display:none;" id="error_msg" class="text-danger" for="error_msg">Enter the valid Name , Valid Email</label>
          </div>
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="button" value="Submit" onclick="customer_register();"class="btn btn-success float-right">
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
  function customer_register()
  {
    <?php if(isset($customers)) 
    {
      ?>
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/customer_register/update', 
                data: $("#customer_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>customers";
                  }
                  else
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                   // window.location = "<?php echo base_url();?>/dashboard";
                  }
                }
          });
    <?php } else { ?>
      $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/customer_register', 
                data: $("#customer_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>customers";
                  }
                  else
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                   // window.location = "<?php echo base_url();?>/dashboard";
                  }
                }
          });
    <?php } ?>
    
  }
</script>

</body>
</html>
