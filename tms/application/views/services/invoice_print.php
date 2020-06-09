<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
     <div class="row">
      <div class="col-12">
        <h4>
          <i class="fas fa-globe"></i> TMS
          <small class="float-right">Date: <?php echo $services['created_date'];?></small>
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
        <b>Invoice #007612</b><br>
        <br>
        <b>Order ID:</b> 4F3S8J<br>
        <b>Payment Due:</b> <?php echo date('d-m-Y',strtotime('-1 days', strtotime($services['trip_start'])));?><br>
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
              <td><?php echo $sub_total;?></td>
            </tr>
            <tr>
              <th>Tax (9.3%)</th>
              <td><?php echo $tax_amt = round($sub_total*9.3/100);?></td>
            </tr>
            <tr>
              <th>Shipping:</th>
              <td><?php echo $ship_amt = round($sub_total*10/100);?></td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><?php echo $services['total_price'];?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>
</body>
</html>
