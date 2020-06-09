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
            <h1>Roles Master</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard">Home</a></li>
              <li class="breadcrumb-item active">Roles Master</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Roles</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus">Role</label>
                <select name="role" id="role" class="form-control custom-select" onchange="show_role_name();">
                  <option value="0" selected>New</option>
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
              <div class="form-group" id="role_section">
                <label for="role_name">Role Name</label>
                <input type="text" id="role_name" name="role_name" class="form-control" required="Enter Valid Name" onblur="is_already_exist();">
                <div id="is_already_exist" class="form-group" style="display:none;"></div>
                <input type="hidden" id="role_alias" name="role_alias">
              </div>
              <div class="form-group">
                <label for="inputSpentBudget">Modules</label>
                <div class="form-group">
                  <?php 
                  foreach($modules as $row)
                  {
                    ?>
                    <div class="form-check">
                      <input id="modules_<?php echo $row['mod_id'];?>" class="form-check-input" name="modules" type="checkbox" class="modules" value="<?php echo $row['mod_id'];?>">
                      <label class="form-check-label"><?php echo $row['mod_name'];?></label>
                    </div>
                    <?php
                  }?>                
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

        <div class="col-md-6">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">List Of Roles</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-fixed">
                  <thead>
                    <tr>
                      <th>Sl Id</th>
                      <th>Role Name</th>
                      <?php if($is_admin == 1) { ?>
                      <th>Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $i=0;
                        foreach($roles as $row)
                        {
                          $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $row['role_name'];?></td>
                      <?php if($is_admin == 1) { ?>
                      <td>  
                        <a onclick="delete_role('<?php echo $row["rol_id"];?>');">
                          <i class="fas fa-trash"></i> 
                        </a>
                      </td>
                      <?php } ?>
                    </tr>
                    <?php
                   }
                    ?>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
      
      </div>
      <div id="success_msg" class="col-6 alert alert-success alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        Roles Added Successfully
      </div>

      <div id="failure_msg" class="col-6 alert alert-danger alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5> Failure!</h5>
        Enter the Valid Role
      </div>
      <div class="row">
        <div class="col-6">
          <!-- <a href="#" class="btn btn-secondary ">Cancel</a> -->
          <input type="submit" value="Submit" onclick="add_roles()" class="btn btn-success float-right">
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
<!-- ./wrapper -->

<script type="text/javascript">

  function is_already_exist()
  {
    var role_name = $('#role_name').val();

    var role_alias = role_name.replace(/[^\w\s]/gi, '')
    role_alias = role_alias.toLowerCase();
    role_alias = role_alias.replace(/#|_/g,'-')
    role_alias = role_alias.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, ' ');
    role_alias = role_alias.replace(/\s{1,}/g,'-');

     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/is_role_already_exist',
                data: {role_alias: role_alias},
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
                    $('#role_alias').val(role_alias);
                  }
                  
                  
                }
          });

  }

  function add_roles()
  {
    var role = $('#role').val();
    var role_name = $('#role_name').val();
    var role_alias = $('#role_alias').val();
    var modules = [];
    $.each($("input[name='modules']:checked"), function(){
        modules.push($(this).val());
    });    

  if(role == 0)
  {
    if(role_name == '')
    {
      $('#failure_msg').show(1000);
      setTimeout(function(){
           $('#failure_msg').hide(1000);
       }, 3000);
    }
  }

   
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>add_roles',
                 dataType: 'JSON', 
                data: {role: role,role_name:role_name,role_alias:role_alias,modules:modules},
                success : function(result){
                  if(result > 0)
                  {
                    $('#success_msg').show(1000);
                      setTimeout(function(){
                         $('#success_msg').hide(1000);
                     }, 3000);
                    // window.location = "<?php echo base_url();?>roles";
                  }
                  else
                  {
                    $('#failure_msg').show();
                    setTimeout(function(){
                         $('#failure_msg').hide(1000);
                     }, 3000);
                    // window.location = "<?php echo base_url();?>roles";
                  }
                }
          });
   
  }


  function show_role_name()
  {

    <?php 
      foreach($modules as $row)
      {
        ?>
        $('#modules_'+<?php echo $row['mod_id'];?>).prop('checked', false);
    <?php

      }
      ?>
    var role = $('#role').val();

    if(role == 0)
    {
      $('#role_section').show();
    }
    else
    {
      $('#role_section').hide(); 
    }


    if(role !== 0)
    {
    
        $.ajax({
                    type: "POST",
                    url: '<?php echo base_url();?>home/get_modules',
                    dataType: 'JSON', 
                    data: {role: role},
                    success : function(result){
                      var res = result.split('|');
                     

                      for(var i=0; i<res.length;i++)
                      {
                         $('#modules_'+res[i]).prop('checked', true);
                          console.log('#modules_'+res[i]);
                      }
                      //  $('#modules_1').prop('checked', true);
                      // alert(result);
                    }
              });

    }
     
   
  }

  function delete_role(id=null)
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/delete_role', 
                data: {rol_id:id},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     window.location = "<?php echo base_url();?>roles";
                  }
                  
                }
          });
  }
  
</script>
</body>
</html>
