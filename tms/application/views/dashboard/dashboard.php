<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="assets/plugins/jqvmap/jqvmap.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.css">
  <?php
  $username = $this->session->userdata('username');
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php if(empty($roles_count)){ if($roles_count == 0){ ?><a class="nav-link" href="<?php echo base_url();?>roles">
          <button class="btn btn-primary">
            Add Roles
          </button>
        </a> <?php } } ?>
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $services_count;?></h3>

                <p>Services</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo base_url();?>services" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <?php if($this->session->userdata('users')['role'] == 1):?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $employee_count;?></h3>

                <p>Employees</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo base_url();?>employee" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $customer_count;?></h3>
                <p>Customers</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo base_url();?>customers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php endif;?>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $total_enquiry_count;?></h3>
                Enquries<br>
                Daily : <?php echo $daily_visit_enquiry_count;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone Call : <?php echo $phone_visit_enquiry_count;?>
               </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?php echo base_url();?>customer_enquiry" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Info boxes -->
          <div class="col-lg-6 col-6">
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Service Report</h3>
                    <a href='services'>View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg"><?php echo $services_count;?></span>
                      <span>Services Over Time</span>
                    </p>
                    <!-- <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 12.5%
                      </span>
                      <span class="text-muted">Since last week</span>
                    </p> -->
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="visitors-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> Month Wise
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-6">
            <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Incomes Report</h3>
                    <a href='incomes'>View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg" id="total_income_amount_for_chart"></span>
                      <span>Incomes Over Time</span>
                    </p>
                    <!-- <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 12.5%
                      </span>
                      <span class="text-muted">Since last week</span>
                    </p> -->
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> Month wise
                    </span>

                    <!-- <span>
                      <i class="fas fa-square text-gray"></i> Last Week
                    </span> -->
                  </div>
                </div>
              </div>
            </div>
          <!-- /.row -->
          <div class="col-lg-6 col-6">
           <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Partial Pending Payments</h3>
                <div class="card-tools">
                  <!-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <span class='right badge badge-warning'>Pending</span>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Shipper</th>
                      <th>Date</th>
                      <th>Balance</th>
                      <th>Contact</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i=0;
                      foreach($pending_services as $row1)
                      {
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $row1['shipper'];?></td>
                      <td><?php echo $row1['trip_start'];?></td>
                      <td><?php echo $row1['balance_amt'];?></td>
                      <td><?php echo $row1['shipper_mobile'];?></td>
                    </tr>
                   <?php } ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-6">
           <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Full Pending Payments </h3>
                <div class="card-tools">
                  <!-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <span class='right badge badge-danger'>Not Paid</span>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Shipper</th>
                      <th>Date</th>
                      <th>Balance</th>
                      <th>Contact</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i=0;
                      foreach($full_pending_services as $row1)
                      {
                        $i++;
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $row1['shipper'];?></td>
                      <td><?php echo $row1['trip_start'];?></td>
                      <td><?php echo $row1['total_price'];?></td>
                      <td><?php echo $row1['shipper_mobile'];?></td>
                    </tr>
                   <?php } ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
            <!-- /.card -->
          </div>
          
          <?php 
          if($this->session->userdata('users')['role'] == 1)
          {
          if(count($logs)>0)
          {
          ?>
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Followup Updates</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button> -->
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Update</th>
                    <!-- <th>Reason</th> -->
                  </tr>
                  </thead>
                  <tbody>

                  <?php 
                         $i=0;
                            foreach($logs as $row)
                            {
                              $i++;
                        ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $row['log'];?></td>
                         <!--  <td>  
                            <?php echo $row['log_desc'];?>
                          </td> -->
                        </tr>
                        <?php
                       }
                        ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div> -->
            <!-- /.card-footer -->
          </div>
          <?php 
           }
          }
           ?>
         </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
          </div><!-- /.container-fluid -->
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
</body>
</html>
