<!DOCTYPE html>
<html>
<head>
  <?php
   $user_data = $this->session->userdata('users');
   $is_admin = $user_data['role'];
  ?>
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
            <h1>Customer List</h1>
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

      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Of Customers</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                     <a href="<?php echo base_url();?>customer_add"> <button type="button" class="btn btn-primary">Customer Add</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="customerTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Customer Name</th>
                       <th>Address</th>
                      <th>Mobile No</th>
                      <th>Email</th>
                      <th>Customer Type</th>
                      <?php if($is_admin == 1) { ?>
                      <th>Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i=0;
                      foreach($customers as $row1)
                      {
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><a href="<?php echo base_url();?>profile/customer/<?php echo $row1['cust_id'];?>"><?php echo $row1['cust_name'];?></a></td>
                      <td><?php echo str_replace("|",",",$row1['cust_address']);;?></td>
                      <td><?php echo $row1['cust_mob_no'];?></td>
                      <td><?php echo $row1['cust_email'];?></td>
                      <td><?php echo $row1['cust_type'];?></td>
                      <?php if($is_admin == 1) { ?>
                      <td>  
                        <a href="<?php echo base_url();?>customer_add/edit/<?php echo $row1['cust_id'];?>">
                          <i class="fas fa-edit"></i>
                        </a>&nbsp;&nbsp;
                        <a onclick="delete_customer('<?php echo $row1["cust_id"];?>');">
                          <i class="fas fa-trash"></i> 
                        </a>
                      </td>
                      <?php } ?>
                    </tr>
                   <?php } ?>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
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
<script type="text/javascript">
  function delete_customer(id=null)
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/delete_customer', 
                data: {cust_id:id},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     window.location = "<?php echo base_url();?>customers";
                  }
                  
                }
          });
  }
</script>
</body>
</html>
