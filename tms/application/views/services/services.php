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
            <h1>Service List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Service Add</li>
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
                <h3 class="card-title">List Of Services</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 450px;">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation" style="height: 40px;">
                    &nbsp;&nbsp;&nbsp;
                     <button type="button" class="btn btn-primary" onclick="search_by_date();">Search</button>
                    &nbsp;&nbsp;&nbsp;
                    <div class="input-group-append">
                     <a href="<?php echo base_url();?>service_add"> <button type="button" class="btn btn-primary">Service Add</button></a>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <?php if($this->uri->segment(2) != '')
                    {
                      $date = $this->uri->segment(3);
                      ?>
                      <a href="<?php echo base_url();?>home/exportCSV/filter/<?php echo $date;?>"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Export</button></a>
                      <?php
                    }
                    else
                    {
                    ?>
                    <a href="<?php echo base_url();?>home/exportCSV"><button type="button" class="btn btn-primary"  onclick="export_search_by_date();"><i class="fas fa-download"></i> Export</button></a>
                    <?php
                    }
                    ?>
                    
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="serviceTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Trip</th>
                      <th>Shipper</th>
                      <th>Consignee</th>
                      <th>Description</th>
                      <th>Weight</th>
                      <th>Ship Date</th>
                      <th>Status</th>
                      <?php if($is_admin == 1) { ?>
                      <th>Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i=0;
                    if(isset($services))
                    {
                      foreach($services as $row1)
                      {
                        
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $row1['trip_name'];?></td>
                      <td><?php echo $row1['shipper'];?></td>
                      <td><?php echo $row1['consignee'];?></td>
                      <td><?php echo $row1['description'];?></td>
                      <td><?php 
                      $weight = explode(',',$row1['weight']);
                      echo array_sum($weight);
                      ?></td>
                      <td><?php echo $row1['trip_start'];?></td>
                      <td><?php 
                      if($row1['is_paid'] == 1)
                      {
                        echo "<span class='right badge badge-success'>Paid</span>";
                      }
                      elseif ($row1['is_paid'] == '-1') {
                        echo "<span class='right badge badge-warning'>Pending</span>";
                      }
                      else
                      {
                        echo "<span class='right badge badge-danger'>Not Paid</span>";
                      }
                      ?></td>
                      <?php if($is_admin == 1) { ?>
                      <td>  
                        <a href="<?php echo base_url();?>service_add/edit/<?php echo $row1['ser_id'];?>">
                          <i class="fas fa-edit"></i> 
                        </a>&nbsp;&nbsp;
                        <!-- <a onclick="delete_product('<?php echo $row1["ser_id"];?>');">
                          <i class="fas fa-trash"></i> 
                        </a>&nbsp;&nbsp; -->
                        <a href='<?php echo base_url();?>services/<?php echo $row1["ser_id"];?>'>
                          <i class="fas fa-eye"></i> 
                        </a>
                      </td>
                      <?php } ?>
                    </tr>
                   <?php }
                   } ?>
                    
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
  function search_by_date()
  {
    var date_filter = $('#reservation').val();
    var date = date_filter.split('-');
    console.log(date_filter);
    console.log(date[0]);
    console.log(date[1]);
    var start = encodeURIComponent(btoa(date[0]));
    var end = encodeURIComponent(btoa(date[1]));
    console.log(start);
    console.log(end);
    var dates = start+'-'+end;
    window.location = "<?php echo base_url();?>services/filter/"+dates;
  }

  function export_search_by_date()
  {
    var date_filter = $('#reservation').val();
    var date = date_filter.split('-');
    console.log(date_filter);
    console.log(date[0]);
    console.log(date[1]);
    var start = encodeURIComponent(btoa(date[0]));
    var end = encodeURIComponent(btoa(date[1]));
    console.log(start);
    console.log(end);
    var dates = start+'-'+end;
    window.location = "<?php echo base_url();?>home/exportCSV/filter/"+dates;
  }
</script>
<!-- <script type="text/javascript">
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
                     window.location = "<?php echo base_url();?>services";
                  }
                  
                }
          });
  }
</script> -->
</body>
</html>
