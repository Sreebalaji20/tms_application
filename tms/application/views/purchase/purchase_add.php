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
            <h1>Sales Add</h1>
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
      <form id="purchase_form">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Sales</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus">Customer Name <?php echo $cust_id;?></label>
                <select id="cust_id" name="cust_id" class="form-control select2">
                  <option value="" selected>Select</option>
                     <?php 

                      foreach($customers as $row)
                      {
                        if($cust_id != '')
                        {
                          if($cust_id == $row['cust_id'])
                          {
                          ?>
                          <option value="<?php echo $row['cust_id'];?>" selected><?php echo $row['cust_name'];?></option>
                          <?php
                        }

                        }
                        else
                        {
                    ?>
                    <option value="<?php echo $row['cust_id'];?>"><?php echo $row['cust_name'];?></option>
                    <?php
                      }
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputStatus">Product </label>
                <select id="prod_id" class="form-control select2" onchange="get_product();">
                  <option value="" selected>Select</option>
                  <?php 
                      foreach($products as $row1)
                      {
                    ?>
                    <option value="<?php echo $row1['prod_id'];?>"><?php echo $row1['prod_name'];?></option>
                  <?php } ?>
                </select>
              </div>
              <!-- <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="text" id="quantity" name="quantity" class="form-control">
              </div> -->
              <div id="product_detail" style="display:none;">
                <div class="form-group">
                  <label for="prod_desc">Product Description</label>
                  <input type="text" id="prod_desc" disabled class="form-control">
                </div>
                <div class="form-group">
                  <label for="prod_company">Product Company</label>
                  <input type="text" id="prod_company" disabled class="form-control">
                </div>
                <div class="form-group">
                  <label for="prod_cat">Product Category</label>
                  <input type="text" id="prod_cat" disabled class="form-control">
                </div>
                <div class="form-group">
                  <label for="prod_cat">Configuration</label>
                  <table class="table" id="config">
                    <th>
                      Name
                    </th>
                    <th>
                      Size
                    </th>
                    <th>
                      Brand
                    </th>
                  </table>
                </div>
              </div>
               <div class="form-group">
                <label for="inputStatus">Assign To </label>
                <select id="emp_id" name="emp_id" class="form-control select2">
                  <option value="" selected>Select</option>
                  <?php 
                      foreach($employees as $row2)
                      {
                    ?>
                    <option value="<?php echo $row2['emp_id'];?>"><?php echo $row2['emp_name'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Details</h3>
              
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <div id="productData">
                </div>
              </div>             
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <div class="row">
            <label style="display:none;" id="error_msg" class="text-danger" for="error_msg">Please Select Customer , Product</label>
          </div>
          <a href="#" class="btn btn-secondary">Cancel</a>
          <input type="button" value="Submit" onclick="purchase_register();"class="btn btn-success float-right">
        </div>
      </div>
    </form>
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
  function purchase_register()
  {
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/purchase_register', 
                data: $("#purchase_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(result[0] > 0)
                  {
                     $('#error_msg').show();
                     $('#error_msg').html(res[1]);
                     window.location = "<?php echo base_url();?>purchase";
                  }
                  else
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);                  
                  }
                }
          });
    
  }

  function get_product()
  {

    $('#config').empty();
    var prod_id = $('#prod_id').val();
    var prod_name = $("#prod_id option:selected").html();

    if($('#TextBoxDiv'+prod_id).length == 0)
    {
      var newTextBoxDiv = $(document.createElement('div'))
         .attr("id", 'TextBoxDiv' + prod_id);

      newTextBoxDiv.after().html('<div class="form-group"><div class="btn-group"><input type="hidden" class="form-control col-sm-12" name="prod_id[]" id="prod_id_' + prod_id + '" value="'+prod_id+'" placeholder="Name"><input type="text" readonly class="form-control col-sm-12" id="product_' + prod_id + '" value="'+prod_name+'" placeholder="Name"></div><div class="btn-group"><input type="text" class="form-control col-sm-12" name="quantity[]" id="quantity_' + prod_id + '" value="" placeholder="Quantity"></div><div class="btn-group"><button class="btn btn-primary" onclick="removeProducts('+prod_id+');">Remove</button></div></div>');

      newTextBoxDiv.appendTo("#productData");

    }

    
     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/get_product', 
                data: {prod_id:prod_id},
                success : function(result){
                  $('#product_detail').show(1000);
                  var res = result.split('|');
                  $('#prod_desc').val(res[0]);
                  $('#prod_company').val(res[1]);
                  $('#prod_cat').val(res[2]);
                  var cat_names = res[3].split(',');
                  var cat_sizes = res[4].split(',');
                  var cat_brands = res[5].split(',');

                  for(i=0; i< cat_names.length;i++)
                  {
                    var newTextBoxDiv = $(document.createElement('tr'))
                    .attr("id", 'config_' + i);
                    console.log(cat_names[i]+ ' - '+cat_sizes[i]);
                    newTextBoxDiv.after().html("<td><div class='btn-group'>"+cat_names[i]+"</td><td><div class='btn-group'>"+cat_sizes[i]+"</div></td><td><div class='btn-group'>"+cat_brands[i]+"</div></td>");
                    newTextBoxDiv.appendTo("#config");
                  }

                }
          });
    
  }

  function removeProducts(id)
  {
    $("#TextBoxDiv" + id).remove();
  }
</script>

</body>
</html>
