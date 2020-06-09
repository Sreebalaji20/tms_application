<!DOCTYPE html>
<html>
<head>
  <?php
   $user_data = $this->session->userdata('users');
   $is_admin = $user_data['role'];
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS | User Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo Base_path;?>assets/dist/img/avatar5.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $profile_name;?></h3>

                <p class="text-muted text-center"><?php echo $profile_mob_no;?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Services</b> <a class="float-right"><?php echo count($services);?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Incomes</b> <a class="float-right"><?php echo $total_incomes;
                    ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Expenses</b> <a class="float-right"><?php echo $total_expense;
                    ?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">
                <?php 
                echo str_replace('|','<br>',$profile_address);
                ?>
                  
                </p>

                <hr>

                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <?php if(count($services) > 0) { ?>
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Services</a></li>
                  <?php } ?>
                  <?php if(count($incomes) > 0) { ?>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Incomes</a></li>
                  <?php } ?>
                   <?php if(count($expenses) > 0) { ?>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Expenses</a></li>
                  <?php } ?>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <?php if(count($services) > 0) { ?>
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="card">
                        <div class="card-header border-0">
                          <h3 class="card-title">Services</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                          <table class="table table-striped table-valign-middle">
                            <thead>
                            <tr>
                              <th>Id</th>
                              <th>Shipper</th>
                              <th>Consignee</th>
                              <th>Description</th>
                              <th>Date</th>
                              <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $i=0;
                                foreach($services as $row1)
                                {
                                  $i++;
                              ?>
                            <tr>
                              <td>
                                <?php echo $i; ?>
                              </td>
                              <td> <?php echo $row1['shipper']; ?></td>
                              <td><?php echo $row1['consignee'];?></td>
                              <td>
                                  <?php echo $row1['description']; ?>
                               </td>
                              <td>
                                <?php echo $row1['trip_start']; ?>
                              </td>
                              <td>
                                <?php echo $row1['total_price'];?>
                              </td>
                            </tr>
                            <?php
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <?php if($profile_type == 'customer'):?>
                      <a href="<?php echo base_url();?>services" class="btn btn-primary btn-block"><b>View All</b></a>
                    <?php endif;?>
                  </div>
                <?php } ?>
                  <!-- /.tab-pane -->
                <?php if(count($incomes) > 0) { ?>
                  <div class="tab-pane" id="timeline">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                              <th>Id</th>
                              <th>Shipper</th>
                              <th>Consignee</th>
                              <th>Date</th>
                              <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $j=0;
                                foreach($incomes as $row2)
                                {
                                  $j++;
                              ?>
                            <tr>
                              <td>
                                <?php echo $j; ?>
                              </td>
                              <td> <?php echo $row2['shipper']; ?></td>
                              <td><?php echo $row2['consignee'];?></td>
                              <td>
                                <?php echo date_format(date_create($row2['trip_start']),'d-m-Y');?>
                              </td>
                              <td><?php echo $row2['income'];?></td>
                              
                            </tr>
                            <?php
                              }
                              ?>
                            </tbody>
                          </table>
                          <?php if($profile_type == 'customer'):?>
                            <a href="<?php echo base_url();?>incomes" class="btn btn-primary btn-block"><b>View All</b></a>
                          <?php endif;?>
                    </div>
                  <!-- /.tab-pane -->
                <?php } ?>

                <?php if(count($expenses) > 0) { ?>
                  <div class="tab-pane" id="settings">
                   <div class="card">
                        <div class="card-header border-0">
                          <h3 class="card-title">Expenses</h3>
                          
                        </div>
                        <div class="card-body table-responsive p-0">
                          <table class="table table-striped table-valign-middle">
                            <thead>
                            <tr>
                              <th>Trip</th>
                              <th>Date</th>
                              <th>Type</th>
                              <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $k=0;
                                foreach($expenses as $row3)
                                {
                                  $k++;
                              ?>
                            <tr>
                              <td>
                                <?php echo $row3['trip_name'];?>
                              </td>
                              <td><?php echo $row3['ship_date'];?></td>
                              <td>
                                <?php echo $row3['type'];?>
                              </td>
                              <td>
                                <?php echo $row3['amount'];?>
                              </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php if($profile_type == 'customer'):?>
                        <a href="<?php echo base_url();?>expenses" class="btn btn-primary btn-block"><b>View All</b></a>
                      <?php endif;?>
                  </div>
                <?php } ?>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
   <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>
</body>
</html>
