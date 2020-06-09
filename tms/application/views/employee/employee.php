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
            <h1>Employee List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee Add</li>
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
                <h3 class="card-title">List Of Employees</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                     <a href="<?php echo base_url();?>employee_add"> <button type="button" class="btn btn-primary">Employee Add</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="myTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Employee Name</th>
                      <th>Designation</th>
                      <th>Mobile No</th>
                      <th>DOB</th>
                      <th>Email</th>
                      <th>DOJ</th>
                      <th>Service</th>
                      <?php if($is_admin == 1) { ?>
                      <th>Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=0; 
                      foreach($emplyees as $row1)
                      {
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $row1['emp_name'];?></td>
                      <td><?php echo $row1['role_name'];?></td>
                      <td><?php echo $row1['emp_mobile'];?></td>
                      <td><?php echo $row1['emp_dob'];?></td>
                      <td><?php echo $row1['emp_email'];?></td>
                      <td><?php echo $row1['emp_doj'];?></td>
                      <td><?php 
                      if($row1['emp_role_id'] != 1)
                      {
                        if($row1['is_available'] == 1)
                        {
                          ?>
                          <small class="badge badge-success">Available</small>
                          <?php
                        }
                        else
                        {
                          ?>
                          <small class="badge badge-warning">Working</small>
                          <?php
                        }
                      }
                      else
                      {
                        ?>
                        <small class="badge badge-primary">Admin</small>
                        <?php
                      }
                      ?></td>
                      <?php if($is_admin == 1) { ?>
                      <td>  
                        <a href="<?php echo base_url();?>employee_add/edit/<?php echo $row1['emp_id'];?>">
                          <i class="fas fa-edit"></i> 
                        </a>&nbsp;&nbsp;
                        <a onclick="delete_employee('<?php echo $row1["emp_id"];?>');">
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
  function delete_employee(id=null)
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/delete_employee', 
                data: {emp_id:id},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     window.location = "<?php echo base_url();?>employee";
                  }
                  
                }
          });
  }
</script>


</body>
</html>
