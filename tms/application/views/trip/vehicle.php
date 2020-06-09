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
            <h1>Vehicle List</h1>
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

      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Of Vehicle</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                     <a href="<?php echo base_url();?>vehicle_add"> <button type="button" class="btn btn-primary">Vehicle Add</button></a>
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
                      <th>Vehicle NO</th>
                      <th>Capacity</th>
                      <th>Payment</th>
                      <th>Insurance Expire</th>
                      <th>Insurance Copy</th>
                      <th>RC Book Copy</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i=0;
                      foreach($vehicle as $row1)
                      {
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $row1['vehicle_no'];?></td>
                      <td><?php echo $row1['capacity'].' Tons';?></td>
                      <td><?php echo $row1['payment'];?></td>
                      <td><?php echo $row1['insurance_expire'];?></td>
                      <td><?php 
                       $vehicle_insurance_copy_path = Base_path.'uploads/owners/'.$this->session->userdata('users')['company_id'].'/vehicle/'.$row1['v_id'].'/INSURANCE/';
                       if(isset($row1['insurance_copy']))
                       { 
                       $insurance_copy = explode('.', $row1['insurance_copy']);

                       if($insurance_copy[1] == 'pdf')
                       {
                        ?>
                        <a target="_blank" href="<?php echo 
                        $vehicle_insurance_copy_path.$row1['insurance_copy'];?>"><img width="100" height="100" src='default_pdf.png'></a>
                        <?php
                       }
                       else
                      {
                        ?>
                        <a target="_blank" href="<?php echo 
                        $vehicle_insurance_copy_path.$row1['insurance_copy'];?>"><img width="100" height="100" src="<?php echo 
                        $vehicle_insurance_copy_path.$row1['insurance_copy'];?>"></a>
                        <?php
                      }
                      } ?>
                    </td>
                    <td><?php 
                       $vehicle_rc_copy_path = Base_path.'uploads/owners/'.$this->session->userdata('users')['company_id'].'/vehicle/'.$row1['v_id'].'/RC/';
                       if(isset($row1['rc_book']))
                       { 
                       $rc_book = explode('.', $row1['rc_book']);

                       if($rc_book[1] == 'pdf')
                       {
                        ?>
                        <a target="_blank" href="<?php echo 
                        $vehicle_rc_copy_path.$row1['rc_book'];?>"><img width="100" height="100" src='default_pdf.png'></a>
                        <?php
                       }
                       else
                      {
                        ?>
                        <a target="_blank" href="<?php echo 
                        $vehicle_rc_copy_path.$row1['rc_book'];?>"><img width="100" height="100" src="<?php echo 
                        $vehicle_rc_copy_path.$row1['rc_book'];?>"></a>
                        <?php
                      }
                      } ?></td>
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
<!-- <script type="text/javascript">
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
 --></body>
</html>
