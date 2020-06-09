<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

    /* Force table to not be like tables anymore */
    table, thead, tbody, th, td, tr {
      display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }

    tr {
      margin: 0 0 1rem 0;
    }
      
    tr:nth-child(odd) {
     /* background: #ccc;*/
    }
    
    td {
      /* Behave  like a "row" */
      border: none;
      border-bottom: 1px solid #eee;
      position: relative;
      padding-left: 50%;
    }

    td:before {
      /* Now like a table header */
      position: absolute;
      /* Top/left values mimic padding */
      top: 0;
      left: 6px;
      width: 45%;
      padding-right: 10px;
      white-space: nowrap;
    }
  }
  </style>
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
            <h1>Add Service</h1>
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
        <div class="col-md-12">
          <form id="service_form">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Service</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <?php if(isset($services)){ ?> <input type="hidden" name="ser_id" id="ser_id" value="<?php echo $services['ser_id'];?>"> <?php }?>
            <?php if(isset($services)){ ?> <input type="hidden" name="ser_is_paid" id="ser_is_paid" value="<?php echo $services['is_paid'];?>"> <?php }?>
            <div class="card-body">
             <div class="row">
              <div class="form-group col-lg-2 col-sm-12">
                <label for="inputStatus">Shipper</label>
                <select id="ship_id" name="ship_id" class="form-control select2" onchange="get_cust_address('shipper')">
                  <option value="">Select</option>
                  <option value="new">New</option>
                <?php 
                  if(isset($services))
                  {
                    if(isset($customers))
                    {
                      foreach($customers as $row)
                      {
                        if($services['shipper_id'] == $row['cust_id'])
                        {
                          ?>
                          <option value="<?php echo $row['cust_id'];?>" selected><?php echo $row['cust_name'];?></option>
                          <?php
                        }
                      }
                    }
                  }
                  else
                  {
                    if(isset($customers))
                    {
                      foreach($customers as $row)
                      {
                          ?>
                          <option value="<?php echo $row['cust_id'];?>"><?php echo $row['cust_name'];?></option>
                          <?php
                      }
                    }

                  }
                   
                  ?>
                </select>
              </div>
              <div class="form-group col-lg-2 col-sm-12">
                <label for="inputStatus"> Name</label>
                  <input type="hidden" id="shipper_id" name="shipper_id" class="form-control" readonly placeholder="Name"
                    <?php if(isset($services)){ ?>value = "<?php echo $services['shipper_id'];?>" <?php }else{ ?> value = "" <?php } ?>>
                  <input type="text" id="shipper_name" name="shipper_name" class="form-control" readonly placeholder="Name"
                    <?php if(isset($services)){ ?>value = "<?php echo $services['shipper'];?>" <?php }else{ ?> value = "" <?php } ?>>
              </div>
              <div id="new_shipper_detail" class="row" style="display: none;">
                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus">Name</label>
                  <input type="text" id="shipp_cust_name" name="shipp_cust_name" class="form-control" placeholder="Customer Name"
                    value = "">
                </div>

                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> Mobile</label>
                  <input type="text" id="shipp_cust_mobile" name="shipp_cust_mobile" class="form-control" placeholder="Customer Mobile"
                    value = "">
                </div>


                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> Email</label>
                  <input type="text" id="shipp_cust_email" name="shipp_cust_email" class="form-control" placeholder="Customer Email"
                    value = "">
                </div>

                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> City </label><br>
                  <select id="shipp_city_id" name="shipp_city_id" class="form-control select2">
                    <option value="" selected>Select</option>
                       <?php 
                        
                          foreach($cities as $row)
                          {
                              ?>
                              <option value="<?php echo $row['city_id'];?>"><?php echo $row['city_name'];?></option>
                              <?php
                          }
                        
                      ?>
                      
                  </select>
                </div>
              </div>
              <div class="form-group col-12" id="shipper_detail">
                <label for="inputDescription">Shipper Address</label>
                <?php if(isset($services)){ 
                  $shipp_address = explode('|',$services['shipper_address']);
                }
                 ?>
                <div class="row">
                  <input type="text" id="shipp_flat_no" name="shipp_flat_no" class="form-control col-lg-4 col-sm-12" placeholder="Flat No"
                  <?php if(isset($services)){ ?> value = "<?php echo $shipp_address[0];?>" <?php }else{ ?> value = "" <?php } ?>>
                  <input type="text" id="shipp_street" name="shipp_street" class="form-control col-lg-8 col-sm-12" placeholder="Street"
                  <?php if(isset($services)){ ?> value = "<?php echo $shipp_address[1];?>" <?php }else{ ?> value = "" <?php } ?>>
                 </div>
                <div class="row">
                   <input type="text" id="shipp_city" name="shipp_city" class="form-control col-12" placeholder="Location & City"
                  <?php if(isset($services)){ ?> value = "<?php echo $shipp_address[2];?>" <?php }else{ ?> value = "" <?php } ?>>
                </div>
                <div class="row">
                  <input type="text" id="shipp_pincode" name="shipp_pincode" class="form-control col-12" placeholder="Pincode (*)"
                  <?php if(isset($services)){ ?> value = "<?php echo $shipp_address[3];?>" <?php }else{ ?> value = "" <?php } ?>>
                </div>
              </div>
              <div class="form-group col-12" id="ship_save_det" style="display: none;">
                <input class="col-2 btn btn-primary"  style="left: 80%;" type="button" value="Save Details" onclick="save_customer('shipper');">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-2 col-sm-12">
                <label for="inputStatus">Consignee</label>
                <select id="cons_id" name="cons_id" class="form-control select2" onchange="get_cust_address('consignee')">
                  <option value="">Select</option>
                  <option value="new">New</option>
                <?php 
                  if(isset($services))
                  {
                    if(isset($customers))
                    {
                      foreach($customers as $row)
                      {
                        if($services['consignee_id'] == $row['cust_id'])
                        {
                          ?>
                          <option value="<?php echo $row['cust_id'];?>" selected><?php echo $row['cust_name'];?></option>
                          <?php
                        }
                      }
                    }
                  }
                  else
                  {
                    if(isset($customers))
                    {
                      foreach($customers as $row)
                      {
                          ?>
                          <option value="<?php echo $row['cust_id'];?>"><?php echo $row['cust_name'];?></option>
                          <?php
                      }
                    }

                  }
                   
                  ?>
                </select>
              </div>
              <div class="form-group col-lg-2 col-sm-12">
                <label for="inputStatus"> Name</label>
                  <input type="hidden" id="consignee_id" name="consignee_id" class="form-control" readonly placeholder="Name"
                    <?php if(isset($services)){ ?>value = "<?php echo $services['consignee_id'];?>" <?php }else{ ?> value = "" <?php } ?>>
                  <input type="text" id="consign_name" name="consign_name" class="form-control" readonly placeholder="Name"
                    <?php if(isset($services)){ ?>value = "<?php echo $services['consignee'];?>" <?php }else{ ?> value = "" <?php } ?>>
              </div>
              <div id="new_consignee_detail" class="row" style="display: none;">
                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> Name</label>
                  <input type="text" id="consign_cust_name" name="consign_cust_name" class="form-control" placeholder="Customer Name"
                    value = "">
                </div>

                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> Mobile</label>
                  <input type="text" id="consign_cust_mobile" name="consign_cust_mobile" class="form-control" placeholder="Customer Mobile"
                    value = "">
                </div>


                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> Email</label>
                  <input type="text" id="consign_cust_email" name="consign_cust_email" class="form-control" placeholder="Customer Email"
                    value = "">
                </div>

                <div class="form-group col-lg-3 col-sm-12">
                  <label for="inputStatus"> City </label><br>
                  <select id="consign_city_id" name="consign_city_id" class="form-control select2">
                    <option value="" selected>Select</option>
                       <?php 
                          foreach($cities as $row)
                          {
                              ?>
                              <option value="<?php echo $row['city_id'];?>"><?php echo $row['city_name'];?></option>
                              <?php
                          }
                      ?>
                  </select>
                </div>
              </div>
               <div class="form-group col-12" id="consignee_detail">
                <label for="inputDescription">Consignee Address</label>
                <div class="row">
                  <?php if(isset($services)){ 
                  $cons_address = explode('|',$services['consignee_address']);
                    }
                  ?>
                  <input type="text" id="consign_flat_no" name="consign_flat_no" class="form-control col-lg-4 col-sm-12" placeholder="Flat No"
                  <?php if(isset($services)){ ?>value = "<?php echo $cons_address[0];?>" <?php }else{ ?> value = "" <?php } ?>>
                  <input type="text" id="consign_street" name="consign_street" class="form-control col-lg-8 col-sm-12" placeholder="Street"
                  <?php if(isset($services)){ ?>value = "<?php echo $cons_address[1];?>" <?php }else{ ?> value = "" <?php } ?>>
                 </div>
                <div class="row">
                   <input type="text" id="consign_city" name="consign_city" class="form-control col-12" placeholder="Location & City"
                  <?php if(isset($services)){ ?>value = "<?php echo $cons_address[2];?>" <?php }else{ ?> value = "" <?php } ?>>
                </div>
                <div class="row">
                  <input type="text" id="consign_pincode" name="consign_pincode" class="form-control col-12" placeholder="Pincode (*)"
                  <?php if(isset($services)){ ?>value = "<?php echo $cons_address[3];?>" <?php }else{ ?> value = "" <?php } ?>>
                </div>
              </div>
               <div class="form-group col-12" id="cons_save_det" style="display: none;">
                <input class="col-2 btn btn-primary"  style="left: 80%;" type="button" value="Save Details" onclick="save_customer('consignee');">
              </div>
            </div>
            <div class="form-group col-lg-3 col-sm-12">
              <label for="inputStatus"> Trip </label><br>
              <select id="trip" name="trip" class="form-control select2">
                <option value="" selected>Select</option>
                   <?php 
                  if(isset($services))
                  {
                    if(isset($trips))
                    {
                      foreach($trips as $row)
                      {
                        if($services['trip'] == $row['trip_id'])
                        {
                          ?>
                          <option value="<?php echo $row['trip_id'];?>" selected><?php echo $row['trip'];?></option>
                          <?php
                        }
                      }
                    }
                  }
                  else
                  {
                    if(isset($trips))
                    {
                      foreach($trips as $row)
                      {
                          ?>
                          <option value="<?php echo $row['trip_id'];?>"><?php echo $row['trip'];?></option>
                          <?php
                      }
                    }

                  }
                    
                  ?>
                  
              </select>
            </div>
            <div class="form-group col-lg-3 col-sm-12">
              <label for="inputStatus"> Driver </label><br>
              <select id="emp_id" name="emp_id" class="form-control select2">
                <option value="" selected>Select</option>
                   <?php 
                  if(isset($services))
                  {
                    if(isset($employees))
                    {
                      foreach($employees as $row)
                      {
                        if($services['emp_id'] == $row['emp_id'])
                        {
                          ?>
                          <option value="<?php echo $row['emp_id'];?>" selected><?php echo $row['emp_name'];?></option>
                          <?php
                        }
                      }
                    }
                  }
                  else
                  {
                    if(isset($employees))
                    {
                      foreach($employees as $row)
                      {
                          ?>
                          <option value="<?php echo $row['emp_id'];?>"><?php echo $row['emp_name'];?></option>
                          <?php
                      }
                    }
                  }
                    
                  ?>
                                    
              </select>
            </div>
            <div class="form-group col-lg-3 col-sm-12">
              <label for="inputStatus"> Vehicle No </label><br>
              <select id="vehicle_id" name="vehicle_id" class="form-control select2">
                <option value="" selected>Select</option>
                   <?php 
                  if(isset($services))
                  {
                    if(isset($vehicle))
                    {
                      foreach($vehicle as $row)
                      {
                        if($services['vehicle_id'] == $row['v_id'])
                        {
                          ?>
                          <option value="<?php echo $row['v_id'];?>" selected><?php echo $row['vehicle_no'];?></option>
                          <?php
                        }
                      }
                    }
                  }
                  else
                  {
                    if(isset($vehicle))
                    {
                      foreach($vehicle as $row)
                      {
                          ?>
                          <option value="<?php echo $row['v_id'];?>"><?php echo $row['vehicle_no'];?></option>
                          <?php
                      }
                    }
                  }
                    
                  ?>
                                    
              </select>
            </div>

             <div class="form-group col-lg-3 col-sm-12">
              <label for="inputStatus"> Shipping Date </label><br>
              <input type="date" id="trip_start" name="trip_start" class="form-control"
              <?php if(isset($services)){ ?>value = "<?php echo $services['trip_start'];?>" <?php }else{ ?> value = "" <?php } ?>>
            </div>

             <div class="form-group col-lg-3 col-sm-12">
              <label for="inputStatus"> Delivery Date </label><br>
              <input type="date" id="trip_end" name="trip_end" class="form-control"
              <?php if(isset($services)){ ?>value = "<?php echo $services['trip_end'];?>" <?php }else{ ?> value = "" <?php } ?>>
            </div>
              
              <div class="form-group" id="prod_config">
                <label for="prod_company">Product Description</label>
                <div id='TextBoxesGroup'>
                  <table class="table table-responsive" id="prod_category">
                   <?php 
                  if(isset($services))
                  {
                       $st_id = explode(',',$services['st_id']);
                       $prod_desc_count = count($st_id);
                       $ser_desc = explode(',',$services['description']);
                       $ser_qty = explode(',',$services['qty']);
                       $ser_weight = explode(',',$services['weight']);
                       $ser_price = explode(',',$services['price']);
                        for($j=0; $j <count($st_id); $j++)
                        {
                          ?>
                          <tr id="TextBoxDiv<?php echo $j;?>">
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" <?php if($j == 0){ ?> id='description' <?php }else{?> id='description_<?php echo $j;?>' <?php }?> name='description[]' placeholder="Description" value="<?php echo $ser_desc[$j];?>">
                            </div>
                          </td>
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" <?php if($j == 0){ ?> id='qty' <?php }else{?> id='qty_<?php echo $j;?>' <?php }?> name='qty[]' placeholder="Qty" value="<?php echo $ser_qty[$j];?>">
                            </div>
                          </td>
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" <?php if($j == 0){ ?> id='weight' <?php }else{?> id='weight_<?php echo $j;?>' <?php }?> name='weight[]' placeholder="Weight" value="<?php echo $ser_weight[$j];?>"  onkeyup="calculate_price('<?php echo $j;?>');">
                            </div>
                          </td>
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" <?php if($j == 0){ ?> id='price' <?php }else{?> id='price_<?php echo $j;?>' <?php }?> name='price[]' placeholder="Price" value="<?php echo $ser_price[$j];?>">
                            </div>
                          </td>
                          <?php if($j == 0){ ?>
                          <td>
                            <div class="btn-group">
                             <input class="btn btn-primary" type='button' value='Add' id='productAddButtons' onclick="calculate_desc_count();add_prod_description();">&nbsp;
                            </div>
                          </td>
                           <input type="hidden" id="prod_desc_count" value="<?php echo $prod_desc_count;?>">
                        <?php } ?>
                          <input type="hidden" name="st_id[]" value="<?php echo $st_id[$j];?>">
                        </tr>

                    <?php
                    }
                  }
                  else
                  {
                  ?>
                  <tr id="TextBoxDiv1">
                    <td>
                      <div class="btn-group">
                       <input type='textbox' class="form-control col-lg-12 col-sm-12" id='description' name='description[]' placeholder="Description">
                      </div>
                    </td>
                    <td>
                      <div class="btn-group">
                       <input type='textbox' class="form-control col-lg-12 col-sm-12" id='qty' name='qty[]' placeholder="Qty">
                      </div>
                    </td>
                    <td>
                      <div class="btn-group">
                       <input type='textbox' class="form-control col-lg-12 col-sm-12" id='weight' name='weight[]' placeholder="Weight" onkeyup="calculate_price(0);">
                      </div>
                    </td>
                    <td>
                      <div class="btn-group">
                       <input type='textbox' class="form-control col-lg-12 col-sm-12" id='price' name='price[]' placeholder="Price">
                      </div>
                    </td>
                    <td>
                      <div class="btn-group">
                       <input class="btn btn-primary" type='button' value='Add' id='productAddButton'>&nbsp;
                       <input class="btn btn-danger" type='button' value='Remove' id='ProductRemoveButton'>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
                </table>
                </div>
                
              </div>
              <div class="form-group">
                <label for="inputStatus">Payment</label>
                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="paid" name="is_paid" value="1" <?php if(isset($services)){ if($services['is_paid'] == 1){ ?> checked <?php } }else{ ?> checked <?php } ?> onclick="payment_detail();">
                    <label for="paid">Full Pay
                    </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="pending" name="is_paid" <?php if(isset($services)){ if($services['is_paid'] == '-1'){ ?> checked <?php }else {
                    echo 'disabled'; } } ?> value="-1" onclick="payment_detail();">
                    <label for="pending">Pending
                    </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" id="not_paid" name="is_paid" value="0" <?php if(isset($services)){ if($services['is_paid'] == 0){ ?> checked <?php }else if ($services['is_paid'] == 1) {
                    echo 'disabled'; } } ?>  onclick="payment_detail();">
                    <label for="not_paid">Pay Later
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="inputStatus">Payment Type</label>
                <select id="pay_type" name="pay_type" class="form-control col-lg-3 col-sm-12" onchange="payment_detail();">
                  <option value="">Select</option>
                  <option value="cash">Cash</option>
                  <option value="online">Online</option>
                </select>
              </div>
              <?php if(isset($services)){ if($services['is_paid'] == '-1'){ ?> 
              <div class="form-group" id="balance_det">
                <label for="inputStatus">Balance Amount To Pay</label>
               <input type="text" readonly class="form-control col-lg-3 col-sm-12" value="<?php echo $services['balance_amt'];?>">
              </div>
              <?php } } ?> 
              <div class="row">
                <?php if(isset($services)){ ?>
                <?php $tax_amt = round($services['sub_total']*9.3/100);?>
                <?php $gst_amt = round($services['sub_total']*10/100);?>
                <?php $sub_tot = $services['sub_total'];?>
                <?php $tot_sum = $services['sub_total']+$tax_amt+$gst_amt;?>
                <?php } ?>
                <div class="form-group col-lg-3 col-sm-12">
                  <div class="form-group">
                    <label for="inputStatus">Sub Total : </label>
                    <input type="text" readonly class="form-control col-12" id="sub_tot" <?php if(isset($services)){ ?> value="<?php echo $sub_tot;?>" <?php } ?>>
                  </div>
                </div>
                <div class="form-group col-lg-3 col-sm-12">
                  <div class="form-group">
                    <label for="inputStatus">Tax Amount : </label>
                    <input type="text" readonly class="form-control col-12" id="tax" <?php if(isset($services)){ ?> value="<?php echo $tax_amt;?>" <?php } ?>>
                  </div>
                </div>
                <div class="form-group col-lg-3 col-sm-12">
                  <div class="form-group">
                    <label for="inputStatus">GST Amount : </label>
                    <input type="text" readonly class="form-control col-12" id="gst" <?php if(isset($services)){ ?> value="<?php echo $gst_amt;?>" <?php } ?>>
                  </div>
                </div>
                <div class="form-group col-lg-3 col-sm-12">
                  <div class="form-group">
                    <label for="inputStatus">Total Amount : </label>
                    <input type="text" readonly class="form-control col-12" name="total_sum" id="total_sum" <?php if(isset($services)){ ?> value="<?php echo $tot_sum;?>" <?php } ?>>
                  </div>
                </div>
              </div>
              <div id="payment_detail" style="display: none;">
                <div class="form-group">
                  <label for="inputStatus">Paid Amount</label>
                  <input type="text" id="paid_amt" name="paid_amt" class="form-control col-lg-3 col-sm-12" <?php if(isset($services)){ if($services['is_paid'] == '-1'){ ?> readonly value="<?php  echo $services['paid_amt'];?>" <?php } } ?> onkeyup="calculate_balance();">
                </div>
                <div class="form-group">
                  <label for="inputStatus">Balance Amount</label>
                  <input type="text" id="balance_amt" name="balance_amt" <?php if(isset($services)){ if($services['is_paid'] == '-1'){ ?> value="<?php  echo $services['balance_amt'];?>" <?php } } ?>  class="form-control col-lg-3 col-sm-12">
                </div>
              </div>
              <input type="hidden" name="created_date" id="created_date" value="<?php echo date('Y-m-d');?>">
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </form>
        <div class="row">
          <div class="col-12">
            <div class="row">
              <label style="display:none;margin-left: 20px;" id="error_msg" class="text-danger" for="error_msg">Enter the valid Name</label>
            </div>
            <a href="#" class="btn btn-secondary">Cancel</a>
            <input type="button" value="Submit" class="btn btn-success float-right" onclick="service_register();">
          </div>
        </div>
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


   function payment_detail()
  {

    var values = $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();
     var t = 0;
      for (var i = 0; i < values.length; i++) {
          t += values[i] << 0;
      }
      $('#sub_tot').val(t);
      var tax = Math.round(t*9.3/100);
      var gst = Math.round(t*10/100);
      var tot_sum = Math.round(t+tax+gst);
      $('#tax').val(tax);
      $('#gst').val(gst);
      $('#total_sum').val(tot_sum);
      <?php if(isset($services)){ if($services['is_paid'] == '-1'){ ?> 
        $('#balance_det').show();
        var bal = parseInt(tot_sum)-parseInt($('#paid_amt').val());
        $('#balance_amt').val(bal);
      <?php } } ?>

    if($('#pending').prop('checked'))
    {
      
      $('#payment_detail').show();
    }
    else
    {
      $('#balance_det').hide();
      $('#payment_detail').hide();
    }

  }

  function calculate_balance()
  {
    var tot = $('#total_sum').val();
    var paid = $('#paid_amt').val();
    var bal = tot - paid;
    $('#balance_amt').val(bal);
  }

  function calculate_price(id)
  {
    if(id == 0)
    {
      var total_price = $('#qty').val() * $('#weight').val() * 20;
      $('#price').val(total_price);      
    }
    else
    {
      var total_price = $('#qty_'+id).val() * $('#weight_'+id).val() * 20;
      $('#price_'+id).val(total_price);  
    }
  }

  function generate_serial_no()
  {
    $('#prod_serial_no').val('');
    <?php
      $serial_no = 'tfl_'.substr(md5(mt_rand()),0,9);
    ?>

    $('#prod_serial_no').val('<?php echo $serial_no;?>');

  }

  function prod_config_details()
  {
    var prod_type = $('#prod_type').val();
    if(prod_type == 'A')
    {
      $('#prod_config').show();
    }
    else
    {
      $('#prod_config').hide();
    }
  }

  function service_register()
  {

    <?php if(isset($services)) {
      ?>

     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/service_register/update', 
                data: $("#service_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);
                    window.location = "<?php echo base_url();?>services";
                  }
                  else
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);
                  }
                }
          });

    <?php } else { ?>

       $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/service_register', 
                data: $("#service_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);
                    window.location = "<?php echo base_url();?>services";
                  }
                  else
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);
                  }
                }
          });

    <?php } ?>
  
  }

  function add_prod_category()
  {
    
      
      $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/add_prod_category',
                data: $("#product_category_form").serialize(),
                success : function(result)
                {
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#error_cat_msg').show();
                    $('#error_cat_msg').html(res[1]);
                    window.location = "<?php echo base_url();?>products";
                  }
                  else
                  {
                    $('#error_cat_msg').show();
                    $('#error_cat_msg').html(res[1]);
                    
                  }
                }
          });
    

     
  }

  function get_cust_address(type)
  {
    if(type == 'shipper')
    {
      var cust_id = $('#ship_id').val();
      var cust_name = $('#ship_id option:selected').text();
      if(cust_id != '' && cust_id == 'new')
      {
        $('#shipp_flat_no').val('');
        $('#shipp_street').val('');
        $('#shipp_city').val('');
        $('#shipp_pincode').val('');
        $('#shipper_name').val('');
        $('#new_shipper_detail').show();
        $('#ship_save_det').show();
      }
      else
      {
        $('#shipper_id').val(cust_id);
        $('#shipper_name').val(cust_name);
        $('#new_shipper_detail').hide();
        $('#ship_save_det').hide();
      }
    }
    else if(type == 'consignee')
    {
      var cust_id = $('#cons_id').val();
      var cust_name = $('#cons_id option:selected').text();
      if(cust_id != '' && cust_id == 'new')
      {
        $('#consign_flat_no').val('');
        $('#consign_street').val('');
        $('#consign_city').val('');
        $('#consign_pincode').val('');
        $('#consign_name').val('')
        $('#new_consignee_detail').show();
        $('#cons_save_det').show();
      }
      else
      {
        $('#consignee_id').val(cust_id);
        $('#consign_name').val(cust_name);
        $('#new_consignee_detail').hide();
        $('#cons_save_det').hide();
      }
    }
      
      if(cust_id != 'new' && cust_id != '')
      {
        $.ajax({
                  type: "POST",
                  url: '<?php echo base_url();?>home/get_cust_address',
                  data: {cust_id:cust_id},
                  success : function(result)
                  {
                    var res = result.split('|');
                    if(type == 'shipper')
                    {
                      $('#shipp_flat_no').val(res[0]);
                      $('#shipp_street').val(res[1]);
                      $('#shipp_city').val(res[2]);
                      $('#shipp_pincode').val(res[3]);
                    }
                    else
                    {
                      $('#consign_flat_no').val(res[0]);
                      $('#consign_street').val(res[1]);
                      $('#consign_city').val(res[2]);
                      $('#consign_pincode').val(res[3]);
                    }
                    
                  }
            });
      }
     
  }


  function save_customer(type)
  {
    if(type == 'shipper')
    {
       var cust_id = $('#ship_id').val();
     
        var cust_name = $('#shipp_cust_name').val();
        var cust_mobile = $('#shipp_cust_mobile').val();
        var cust_email = $('#shipp_cust_email').val();
        var city_id = $('#shipp_city_id').val();
        var cust_address = $('#shipp_flat_no').val()+'|'+$('#shipp_street').val()+'|'+$('#shipp_city').val()+'|'+$('#shipp_pincode').val();
       

    }
    else if(type == 'consignee')
    {
      var cust_id = $('#cons_id').val();
      var cust_name = $('#consign_cust_name').val();
      var cust_mobile = $('#consign_cust_mobile').val();
      var cust_email = $('#consign_cust_email').val();
      var city_id = $('#consign_city_id').val();
      var cust_address = $('#consign_flat_no').val()+'|'+$('#consign_street').val()+'|'+$('#consign_city').val()+'|'+$('#consign_pincode').val();

    }
      
      if(cust_id = 'new')
      {
        $.ajax({
                  type: "POST",
                  url: '<?php echo base_url();?>home/save_customer',
                  data: {cust_name:cust_name,cust_mobile:cust_mobile,cust_email:cust_email,city_id:city_id,cust_address:cust_address},
                  success : function(result)
                  {
                    var res = result.split('|');
                    if(type == 'shipper')
                    {
                      $('#shipper_id').val(res[0]);
                      $('#shipper_name').val(res[1]);
                      $('#shipp_flat_no').val(res[2]);
                      $('#shipp_street').val(res[3]);
                      $('#shipp_city').val(res[4]);
                      $('#shipp_pincode').val(res[5]);
                      $('#ship_save_det').hide();
                    }
                    else
                    {
                      $('#consignee_id').val(res[0]);
                      $('#consign_name').val(res[1]);
                      $('#consign_flat_no').val(res[2]);
                      $('#consign_street').val(res[3]);
                      $('#consign_city').val(res[4]);
                      $('#consign_pincode').val(res[5]);
                      $('#cons_save_det').hide();
                    }
                    
                  }
            });
      }
     
  }

<?php if(isset($services)) { ?>
  function calculate_desc_count()
  {
    var prod_desc_count = $('#prod_desc_count').val();

    $('#prod_desc_count').val(parseInt(prod_desc_count)+1);
  }

  function add_prod_description()
  {
    var counter = $('#prod_desc_count').val();
    var newTextBoxDiv = $(document.createElement('tr'))
       .attr("id", 'TextBoxDiv' + counter);
                  
    newTextBoxDiv.after().html('<td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="description[]" id="description_' + counter + '" value="" placeholder="Description"></div></td><td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="qty[]" id="qty_' + counter + '" value="" placeholder="Qty"></div></td><td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="weight[]" id="weight_' + counter + '" value="" placeholder="Weight" onkeyup="calculate_price('+counter+');"></div></td><td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="price[]" id="price_' + counter + '" value="" placeholder="Price"></div></td>');
              
    newTextBoxDiv.appendTo("#prod_category");

          
    counter++;
  }
<?php } ?>
</script>

</body>
</html>
