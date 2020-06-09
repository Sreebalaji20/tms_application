<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
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
            <h1>Sales List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Add</li>
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
                <h3 class="card-title">List Of Sales</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                     <a href="<?php echo base_url();?>purchase_add"> <button type="button" class="btn btn-primary">Sales Add</button></a>
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
                      <th>Customer Name</th>
                      <th>Product Name</th>
                      <th>Description</th>
                      <th>Product Category</th>
                      <th>Product Company</th>
                      <th>Sales Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     $i = 0;
                      foreach($purchase as $row1)
                      {
                         $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td>
                        <a href="<?php echo Base_path;?>profile/cust/<?php echo $row1['cust_id'];?>"><?php echo $row1['cust_name'];?></a>
                      </td>
                      <td><?php echo $row1['prod_name'];?></td>
                      <td><?php echo $row1['prod_desc'];?></td>
                      <td><?php echo $row1['prod_category_name'];?></td>
                      <td><?php echo $row1['prod_company'];?></td>
                      <td><?php echo date_format(date_create($row1['purchase_date']),'d-m-Y');?></td>
                      <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-md-<?php echo $row1['purchase_id'];?>"> View </button>
                         <div class="modal fade" id="modal-md-<?php echo $row1['purchase_id'];?>">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Sales Details</h4>
                                 </div>
                                <div class="modal-body">
                                   <div class="form-group">
                                    <table class="table table-hover">
                                      <th>Product</th>
                                      <th>Quantity</th>
                                    <?php 
                                    $prod_name = explode(',',$row1['prod_name']);
                                    $prod_qty = explode(',',$row1['prod_qty']);
                                    for($j=0;$j < count($prod_name); $j++)
                                    {
                                    ?>
                                    <tr>
                                      <td><?php echo $prod_name[$j];?></td>
                                      <td><?php echo $prod_qty[$j];?></td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </td>
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

</body>
</html>
