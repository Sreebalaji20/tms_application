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
            <h1>Employee Add</h1>
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
      <form id="employee_form">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Employee</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Employee Name</label>
                <input type="text" id="emp_name" name="emp_name" class="form-control" onblur="is_already_exist();"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_name'];?>" <?php }?>>
                <?php if(isset($employee)){ ?> <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $employee['emp_id'];?>"> <?php }?>
                <div id="is_already_exist" class="form-group" style="display:none;"></div>
                <input type="hidden" id="emp_alias" name="emp_alias">
                
              </div>
              <div class="form-group">
                <label for="inputDescription">Employee Address</label>
                <textarea id="emp_address" name="emp_address" class="form-control" rows="4" ><?php if(isset($employee)){  echo $employee['emp_address'];  }?></textarea>
              </div>
              <div class="form-group">
                <label for="emp_dob">Employee Date Of Birth</label>
                <input type="date" id="emp_dob" name="emp_dob" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_dob'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="emp_mobile">Employee Official Mobile</label>
                <input type="text" id="emp_mobile" name="emp_mobile" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_mobile'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="emp_mobile">Employee Persnol Mobile</label>
                <input type="text" id="emp_persnol_mobile" name="emp_persnol_mobile" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_persnol_mobile'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="emp_alter_mobile">Employee Alter Mobile</label>
                <input type="text" id="emp_alter_mobile" name="emp_alter_mobile" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_alter_mobile'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="emp_email">Employee Email</label>
                <input type="text" id="emp_email" name="emp_email" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_email'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="emp_password">Employee Password</label>
                <input type="password" id="emp_password" name="emp_password" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_password'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="inputStatus">Role</label>
                <select id="emp_role_id" name="emp_role_id" class="form-control custom-select">
                  <?php if(isset($employee)) 
                  {
                    foreach($roles as $row)
                      {
                        if($row['rol_id'] == $employee['emp_role_id'])
                        {
                        ?>
                        <option value="<?php echo $employee['emp_role_id'];?>" selected><?php echo $row['role_name'];?></option>
                        <?php
                      }
                      }
                   
                  } ?>
                  
                    <?php 
                      foreach($roles as $row)
                      {
                        ?>
                        <option value="<?php echo $row['rol_id'];?>"><?php echo $row['role_name'];?></option>
                        <?php
                      }
                      ?>
                  
                </select>
              </div>
              <div class="form-group">
                <label for="emp_doj">Employee Date Of Join</label>
                <input type="date" id="emp_doj" name="emp_doj" class="form-control"
                <?php if(isset($employee)){ ?> value = "<?php echo $employee['emp_doj'];?>" <?php }?>>
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
            <label style="display:none;" id="error_msg" class="text-danger" for="error_msg"></label>
          </div>
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="button" value="Submit" onclick="employee_register();"class="btn btn-success float-right">
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
  function is_already_exist()
  {
    var emp_name = $('#emp_name').val();

    var emp_alias = emp_name.replace(/[^\w\s]/gi, '')
    emp_alias = emp_alias.toLowerCase();
    emp_alias = emp_alias.replace(/#|_/g,'-')
    emp_alias = emp_alias.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, ' ');
    emp_alias = emp_alias.replace(/\s{1,}/g,'-');

     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/is_emp_already_exist',
                data: {emp_alias: emp_alias},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#is_already_exist').show();
                    $('#is_already_exist').html(res[1]);
                  }
                  else
                  {
                    $('#is_already_exist').hide();
                    $('#emp_alias').val(emp_alias);
                  }
                  
                  
                }
          });

  }
  function employee_register()
  {

    <?php if(isset($employee)) {
      ?>
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/employee_register/update', 
                data: $("#employee_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>employee";
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
                url: '<?php echo base_url();?>home/employee_register', 
                data: $("#employee_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>employee";
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
