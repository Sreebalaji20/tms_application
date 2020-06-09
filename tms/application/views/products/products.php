<!DOCTYPE html>
<html>
<head>
  <?php
   $user_data = $this->session->userdata('users');
   $is_admin = $user_data['role'];
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRM</title>
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
            <h1>Product List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Add</li>
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
                <h3 class="card-title">List Of Products</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                     <a href="<?php echo base_url();?>product_add"> <button type="button" class="btn btn-primary">Product Add</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Product Type</th>
                      <th>Product Name</th>
                      <th>Product Description</th>
                      <th>Serial No</th>
                      <th>Product Company</th>
                      <th>Product Category</th>
                      <?php if($is_admin == 1) { ?>
                      <th>Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i=0;
                      foreach($products as $row1)
                      {
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php 
                      if($row1['prod_type'] == 'A')
                      {
                        echo 'Assembled';
                      }
                      else if($row1['prod_type'] == 'B')
                      {
                        echo 'Brand';
                      }
                      ?></td>
                      <td><?php echo $row1['prod_name'];?></td>
                      <td><?php echo $row1['prod_desc'];?></td>
                      <td><?php echo $row1['prod_serial_no'];?></td>
                      <td><?php echo $row1['prod_company'];?></td>
                      <td><?php echo $row1['prod_category_name'];?></td>
                      <?php if($is_admin == 1) { ?>
                      <td>  
                        <a href="<?php echo base_url();?>product_add/edit/<?php echo $row1['prod_id'];?>">
                          <i class="fas fa-edit"></i> 
                        </a>&nbsp;&nbsp;
                        <a onclick="delete_product('<?php echo $row1["prod_id"];?>');">
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
  function delete_product(id=null)
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/delete_product', 
                data: {prod_id:id},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     window.location = "<?php echo base_url();?>products";
                  }
                  
                }
          });
  }
</script>
</body>
</html>
