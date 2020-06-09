
<!-- jQuery -->
<script src="<?php echo Base_path;?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo Base_path;?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo Base_path;?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Base_path;?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo Base_path;?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo Base_path;?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo Base_path;?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo Base_path;?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo Base_path;?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANcFLir8TX3vDCQj1LI2GMKOxTT5hk9FU&callback=initMap"
  type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo Base_path;?>assets/dist/js/demo.js"></script>
<script type="text/javascript">
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
</script>
<script type="text/javascript">
  $(document).ready( function () {

//****  Employee   ****/////

      $('.select2').select2();
      $("#myTable").DataTable();
      // $('#myTable').DataTable({
      //   "paging": true,
      //   "lengthChange": false,
      //   "searching": false,
      //   "ordering": true,
      //   "info": true,
      //   "autoWidth": false,
      // });



  //****  Employee   ****/////



  } );
</script>
<script type="text/javascript">

$(document).ready(function(){


//****  Product Category ****/////
    var counter = 2;
    
    $("#productAddButton").click(function () {
        
  if(counter>10){
    return false;
  }   
  var newTextBoxDiv = $(document.createElement('tr'))
       .attr("id", 'TextBoxDiv' + counter);
                
  newTextBoxDiv.after().html('<td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="description[]" id="description_' + counter + '" value="" placeholder="Description"></div></td><td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="qty[]" id="qty_' + counter + '" value="" placeholder="Qty"></div></td><td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="weight[]" id="weight_' + counter + '" value="" placeholder="Weight" onkeyup="calculate_price('+counter+');"></div></td><td><div class="btn-group"><input type="textbox" class="form-control col-sm-12" name="price[]" id="price_' + counter + '" value="" placeholder="Price"></div></td>');
            
  newTextBoxDiv.appendTo("#prod_category");

        
  counter++;
     });

    $("#ProductRemoveButton").click(function () {
    if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
        
      counter--;
      if(counter != 1)
      {
        $("#TextBoxDiv" + counter).remove();
      }
      
     });



//****  Product Category ****/////

//****  Enquiry ****/////

    

    $("#is_customer_id").change(function () {
    $('#cust_name').val($(this).find('option:selected').attr("cust_name"));
    $('#cust_mobile_no').val($(this).find('option:selected').attr("cust_mobile_no"));
    $('#cust_email').val($(this).find('option:selected').attr("cust_email"));
    $('#cust_id').val($(this).find('option:selected').attr("value"));
    
    });
    
     $("#enquiryTable").DataTable();

     $("#customerTable").DataTable();

     $('#incomesTable').DataTable();

     $('#serviceTable').DataTable();

     $('#serviceRequestTable').DataTable();

     $('#serviceResponseTable').DataTable();

     $('#reservation').daterangepicker({
      dateFormat: 'yy-mm-dd'
     });

//****  Enquiry ****/////


  
  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true


  var income_month_chart = [];
  var income_count_chart = [];
  var expense_month_chart = [];
  var expense_count_chart = [];
  <?php
  $total_income = 0;
  if(isset($incomes_chart))
  {
    foreach ($incomes_chart as $row) {
      ?>
      income_month_chart.push("<?php echo $row['income_month'];?>");
      income_count_chart.push("<?php echo $row['income'];?>");
      <?php
      $total_income += $row['income'];
    }

  }
  ?>
  document.getElementById("total_income_amount_for_chart").innerHTML = "₹ <?php echo $total_income;?>";
  console.log(income_month_chart);
  console.log(income_count_chart);

  var $salesChart = $('#sales-chart')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : income_month_chart,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
          data           : income_count_chart
         }
        // {
        //   backgroundColor: '#ced4da',
        //   borderColor    : '#ced4da',
        //   data           : [700, 1700, 2700, 2000, 1800, 1500, 2000]
        // }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              // if (value >= 1000) {
              //   value /= 1000
              //   value += 'k'
              // }
              return '₹' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  });

  var service_month_chart = [];
  var service_count_chart = [];
  <?php
  if(isset($services_chart))
  {
    foreach ($services_chart as $row) {
      ?>
      service_month_chart.push("<?php echo $row['service_month'];?>");
      service_count_chart.push("<?php echo $row['service_count'];?>");
      <?php
    }
  }
  ?>
  var $visitorsChart = $('#visitors-chart')
  var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      labels  : service_month_chart,
      datasets: [{
        type                : 'line',
        data                : service_count_chart,
        backgroundColor     : 'transparent',
        borderColor         : '#007bff',
        pointBorderColor    : '#007bff',
        pointBackgroundColor: '#007bff',
        fill                : false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero : true,
            suggestedMax: 10
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  });

  });

  
</script>
