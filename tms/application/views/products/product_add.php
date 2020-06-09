<!DOCTYPE html>
<html>
<head>
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
            <h1>Add Product</h1>
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
        
        <div class="col-md-6">
          <form id="product_form">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
             
              <div class="form-group">
                <label for="inputStatus">Product Category</label>
                <select id="prod_cat_id" name="prod_cat_id" class="form-control custom-select">
                  
                <?php 
                  if(isset($products)) 
                  {
                    foreach($categories as $row)
                    {
                      if($row['prod_cat_id'] == $products['prod_cat_id'])
                      {
                        ?>
                        <option value="<?php echo $row['prod_cat_id'];?>" selected><?php echo $row['prod_category_name'];?></option>
                        <?php
                      }
                    }
                  }
                 
                  foreach($categories as $row)
                  {
                      ?>
                      <option value="<?php echo $row['prod_cat_id'];?>"><?php echo $row['prod_category_name'];?></option>
                      <?php
                  }
                  ?>
                  
                </select>

              </div>
              <div class="form-group">
                <label for="inputName">Product Name</label>
                <input type="text" id="prod_name" name="prod_name" class="form-control"
                <?php if(isset($products)){ ?> value="<?php echo $products['prod_name'];?>" <?php }?>>
                <?php if(isset($products)){ ?> <input type="hidden" name="prod_id" id="prod_id" value="<?php echo $products['prod_id'];?>"> <?php }?>
              </div>
              <div class="form-group">
                <label for="prod_company">Product Company</label>
                <input type="text" id="prod_company" name="prod_company" class="form-control"
                 <?php if(isset($products)){ ?> value = "<?php echo $products['prod_company'];?>" <?php }?>>
              </div>
              <div class="form-group">
                <label for="prod_serial_no">Product Serial No</label>
                <input type="text" id="prod_serial_no" name="prod_serial_no" class="form-control"
                 <?php if(isset($products)){ ?> value = "<?php echo $products['prod_serial_no'];?>" <?php }?>>
                 <input class="btn btn-primary" type="button" value="Generate Serial No" onclick="generate_serial_no();">
              </div>
              <div class="form-group" id="prod_config">
                <label for="prod_company">Add Configuration</label>
                <div id='TextBoxesGroup'>
                  <table class="table" id="prod_category">
                  <?php 
                  if(isset($products))
                  {
                       $configuration_name = explode(',',$products['cat_name']);
                       $configuration_size = explode(',',$products['cat_size']);
                       $configuration_brand = explode(',',$products['cat_brand']);
                       $configuration_pt_id = explode(',',$products['pt_id']);
                        for($j=0; $j <count($configuration_name); $j++)
                        {
                          ?>
                          <tr id="TextBoxDiv"<?php echo $j;?>>
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" value="<?php echo $configuration_name[$j];?>" name='name[]' placeholder="Name">
                            </div>
                          </td>
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" value="<?php echo $configuration_size[$j];?>" name='size[]' placeholder="Size">
                            </div>
                          </td>
                          <td>
                            <div class="btn-group">
                             <input type='textbox' class="form-control col-md-12" value="<?php echo $configuration_brand[$j];?>" name='brand[]' placeholder="Brand">
                            </div>
                          </td>
                          <input type="hidden" name="pt_id[]" value="<?php echo $configuration_pt_id[$j];?>">
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
                       <input type='textbox' class="form-control col-md-12" id='prod_name' name='name[]' placeholder="Name">
                      </div>
                    </td>
                    <td>
                      <div class="btn-group">
                       <input type='textbox' class="form-control col-md-12" id='prod_size' name='size[]' placeholder="Size">
                      </div>
                    </td>
                    <td>
                      <div class="btn-group">
                       <input type='textbox' class="form-control col-md-12" id='prod_brand' name='brand[]' placeholder="Brand">
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
                <label for="inputDescription">Product Description</label>
                <textarea id="prod_desc" name="prod_desc" class="form-control" rows="4"><?php if(isset($products)){ ?><?php echo $products['prod_desc'];?>  <?php }?></textarea>
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
            <input type="button" value="Submit" onclick="add_product();"class="btn btn-success float-right">
          </div>
        </div>
        </div>
        
        <div class="col-md-6">
          <form id="product_category_form">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Category</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Product Category Name</label>
                <input type="text" id="prod_cat_name" name="prod_cat_name" class="form-control">
              </div>
            </div>
            
          <!-- /.card -->
        </div>
      </form>
          <div class="row">
              <div class="col-12">
              <label style="display:none;margin-left: 20px;" id="error_cat_msg" class="text-danger" for="error_msg">Enter the valid Name</label>
                <input type="button" value="Submit" onclick="add_prod_category();"class="btn btn-success float-right">
              </div>
            </div>
            <!-- /.card-body -->
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
  function generate_serial_no()
  {
    $('#prod_serial_no').val('');
    <?php
      $serial_no = 'mano_'.substr(md5(mt_rand()),0,9);
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

  function add_product()
  {

    <?php if(isset($products)) {
      ?>

     $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>home/add_product/update', 
                data: $("#product_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);
                    window.location = "<?php echo base_url();?>products";
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
                url: '<?php echo base_url();?>home/add_product', 
                data: $("#product_form").serialize(),
                success : function(result){
                  var res = result.split('|');
                  if(res[0] > 0)
                  {
                    $('#error_msg').show(1000);
                    $('#error_msg').html(res[1]);
                    window.location = "<?php echo base_url();?>products";
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
</script>

</body>
</html>
