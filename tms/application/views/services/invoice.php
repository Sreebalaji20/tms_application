<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS | Invoice</title>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> TMS
                    <small class="float-right">Date: <?php echo date('d-m-Y',strtotime($services['created_date']));?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong><?php echo $services['shipper'];?></strong><br>
                    <?php 
                    $service = explode('|',$services['shipper_address']);
                    echo $service[0].','.$service[1];
                    ?><br>
                    <?php echo $service[2].','.$service[3]; ?><br>
                    Phone: <?php echo $services['shipper_mobile'];?><br>
                    Email: <?php echo $services['shipper_email'];?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php echo $services['consignee'];?></strong><br>
                    <?php 
                    $service = explode('|',$services['consignee_address']);
                    echo $service[0].','.$service[1];
                    ?><br>
                    <?php echo $service[2].','.$service[3]; ?><br>
                    Phone: <?php echo $services['consignee_mobile'];?><br>
                    Email: <?php echo $services['consignee_email'];?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #<?php echo str_pad($services['ser_id'],4,0,STR_PAD_LEFT);?></b><br>
                  <br>
                  <b>Order ID: </b> <?php echo $services['order_id'];?><br>
                  <?php if ($services['is_paid'] != 1) { ?>
                  <b>Payment Due:</b> <?php echo date('d-m-Y',strtotime('-1 days', strtotime($services['trip_start'])));?><br>
                  <?php } ?>
                  <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Description</th>
                      <th>Weight</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $desc =  explode(',',$services['description']);
                      $qty =  explode(',',$services['qty']);
                      $weight =  explode(',',$services['weight']);
                      $price =  explode(',',$services['price']);
                      $sub_total = 0;
                      for($i=0; $i < count($desc); $i++)
                      {
                        ?>
                        <tr>
                          <td><?php echo $qty[$i];?></td>
                          <td><?php echo $desc[$i];?></td>
                          <td><?php echo $weight[$i];?></td>
                          <td><?php echo $price[$i];?></td>
                        </tr>
                        <?php
                        $sub_total += $price[$i];
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <h3>Payment Transaction</h3>
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Payment Type</th>
                      <th>Amount</th>
                     </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $i=1;
                      if(isset($payment_transaction))
                      {
                        foreach ($payment_transaction as $row)
                        {
                          ?>
                          <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row['pay_type'];?></td>
                            <td><?php echo $row['amt'];?></td>
                           </tr>
                          <?php
                          $i++;
                        }
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Delivery On <?php echo date('d-m-Y',strtotime('-1 days', strtotime($services['trip_end'])));?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>₹ <?php echo $sub_total;?></td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>₹ <?php echo $tax_amt = round($sub_total*9.3/100);?></td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>₹ <?php echo $ship_amt = round($sub_total*10/100);?></td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td><strong>₹ <?php echo $services['total_price'];?></strong></td>
                      </tr>
                      <?php if($services['is_paid'] == '-1')
                      {
                      ?>
                      <tr>
                        <th>Paid Amount:</th>
                        <td>₹ <?php echo $services['paid_amt'];?></td>
                      </tr>
                      <tr>
                        <th>Balance Amount:</th>
                        <td><strong>₹ <?php echo $services['balance_amt'];?></strong></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <th>Pay Status:</th>
                      <td><?php 
                      if($services['is_paid'] == 1)
                      {
                        echo "<span class='right badge badge-success'>Paid</span>";
                      }
                      elseif ($services['is_paid'] == '-1') {
                        echo "<span class='right badge badge-warning'>Pending</span>";
                        ?>
                        <a href="<?php echo Base_path;?>service_add/edit/<?php echo $services['ser_id'];?>#pay_type" target="_blank" class="btn btn-primary float-right">Pay Now</a>
                        <?php
                      }
                      else
                      {
                        echo "<span class='right badge badge-danger'>Not Paid</span>";
                        ?>
                        <a href="<?php echo Base_path;?>service_add/edit/<?php echo $services['ser_id'];?>#pay_type" target="_blank" class="btn btn-primary float-right">Pay Now</a>
                        <?php
                      }
                      ?></td>
                    </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="<?php echo base_url();?>" class="btn btn-primary"><i class="fas fa-home"></i> Go Home</a>

                  <a href="<?php echo $services['ser_id'];?>/invoice_print" target="_blank" class="btn btn-primary float-right"><i class="fas fa-print"></i> Print</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>
