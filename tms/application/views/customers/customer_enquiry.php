<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
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
            <h1>Enquiry List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard">Home</a></li>
              <li class="breadcrumb-item active">Enquiry</li>
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
                <h3 class="card-title">List Of Enquiry <div class="form-group">
                    
                  </div></h3>

                <div class="card-tools">
                  
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-md">
                              Search Customer
                        </button>
                      </div>
                    <div class="input-group-append">
                      <?php if(isset($mobile)) { ?>
                     <a href="<?php echo base_url();?>customer_enquiry_add/<?php echo $mobile;?>"> <button type="button" class="btn btn-primary">Add Enquiry</button></a>
                   <?php } else { ?>
                    <a href="<?php echo base_url();?>customer_enquiry_add"> <button type="button" class="btn btn-primary">Add Enquiry</button></a>
                   <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="modal-md">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Search Customer</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="mob_no">Mobile No</label>
                        <input type="text" id="search_mob" name="search_mob" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="search_enquiry_result();">Show Details</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="enquiryTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Customer Name</th>
                      <th>Mobile No</th>
                      <th>Description</th>
                      <th>Enquiry Type</th>
                      <th>Expected Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i = 0;
                      foreach($customer_enquiry as $row1)
                      {
                        
                    ?>
                    <?php 
                      $i++;?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td>
                         <?php if($row1['cust_id'] != 0)
                         {
                        ?>
                        <a href="<?php echo Base_path;?>profile/cust/<?php echo $row1['cust_id'];?>"><?php echo $row1['cust_name'];?></a>
                        <?php }else{
                            
                            ?>
                            <?php echo $row1['cust_name'];?>
                        <?php
                        }?>
                      </td>
                      <td><?php echo $row1['cust_mobile_no'];?></td>
                      <td><?php echo $row1['enquiry_desc'];?></td>
                      <td><?php echo $row1['enquiry_type'];?></td>
                      <td><?php echo date_format(date_create($row1['expected_date']),'d-m-Y');?>
                        <?php if($this->session->userdata('users')['role'] == 2)
                          {
                             if($row1['enquiry_status'] == '')
                             {
                          ?>
                         <button type="button" class="btn btn-info btn-sm" data-expected-date = "<?php echo $row1['expected_date'];?>" data-id="<?php echo $row1['ce_id'];?>" data-toggle="modal" data-target="#modal-md-<?php echo $row1['ce_id'];?>">
                          <i class="fas fa-pencil-alt"></i> 
                        </button>
                      <?php } } ?>
                        <div class="modal fade" id="modal-md-<?php echo $row1['ce_id'];?>">
                          <div class="modal-dialog modal-md">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Update Followup</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <input type="hidden" id="old_expected_date_<?php echo $row1['ce_id'];?>" name="old_expected_date" class="form-control" value="<?php echo $row1['expected_date'];?>">
                                  <input type="hidden" id="ce_id_<?php echo $row1['ce_id'];?>" name="ce_id" class="form-control" value="<?php echo $row1['ce_id'];?>">
                                <div class="form-group">
                                  <label for="expected_date">Expected Date</label>
                                  <input type="date" id="new_expected_date_<?php echo $row1['ce_id'];?>" name="new_expected_date" class="form-control">
                                </div>
                                <div class="form-group">
                                  <label for="inputDescription">Reason</label>
                                  <textarea id="reason_<?php echo $row1['ce_id'];?>" name="reason" class="form-control" rows="4" ></textarea>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="update_expected_date('<?php echo $row1['ce_id'];?>');">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <?php if($row1['enquiry_status'] != ''):?>
                          <b><?php echo $row1['enquiry_status'];?></b>
                        <?php else :?>
                        <button onclick="update_enquiry_customer_status('<?php echo $row1['ce_id'];?>','<?php echo $row1['cust_id'];?>','<?php echo $row1['cust_name'];?>','<?php echo $row1['cust_mobile_no'];?>','<?php echo $row1['cust_email'];?>');" class="btn btn-primary">Add to Contact</button>
                      <?php endif;?>
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

</div>
<script type="text/javascript">
  function update_enquiry_customer_status(ce_id,cust_id,cust_name,cust_mob_no,cust_email)
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/update_enquiry_customer_status', 
                data: {ce_id:ce_id,cust_id:cust_id,cust_name:cust_name,cust_mob_no:cust_mob_no,cust_email:cust_email},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                     window.location = "<?php echo base_url();?>customer_enquiry";
                  }
                  
                }
          });
  }

  function search_enquiry_result()
  {
    var mob_no = $('#search_mob').val();
    if(mob_no == '')
    {

      alert('Please Enter valid Mobile No !!!');
    }
    else
    {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/search_enquiry_result', 
                data: {mob_no:mob_no},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#modal-md').modal('hide');
                     window.location = "<?php echo base_url();?>customer_enquiry/cust/"+res[1];
                  }
                  else
                  {
                    $('#modal-md').modal('hide');
                    window.location = "<?php echo base_url();?>customer_enquiry_add/"+mob_no;
                  }
                  
                }
          });
    }
  }


  function update_expected_date(ce_id)
  {
    var old_expected_date = $('#old_expected_date_'+ce_id).val();
    var new_expected_date = $('#new_expected_date_'+ce_id).val();
    var reason = $('#reason_'+ce_id).val();

    if(new_expected_date && reason !== '')
    {
       $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/update_expected_date', 
                data: {ce_id:ce_id,old_expected_date:old_expected_date,new_expected_date:new_expected_date,reason:reason},
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#modal-md-'+ce_id).modal('hide');
                     window.location = "<?php echo base_url();?>customer_enquiry";
                  }
                  
                }
          });

    }
    else
    {
      alert('Please Enter Date and Reason !!!');
    }

  }
</script>

</body>
</html>
