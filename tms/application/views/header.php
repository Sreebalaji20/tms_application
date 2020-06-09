<head>
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/select2/css/select2.min.css">
 
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> -->
 <link rel="stylesheet" href="<?php echo Base_path;?>assets/plugins/daterangepicker/daterangepicker.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 <!--  <style type="text/css">
    .bs-example {
      font-family: sans-serif;
      position: relative;
      margin: 100px;
    }
    .typeahead, .tt-query, .tt-hint {
      border: 2px solid #CCCCCC;
      border-radius: 8px;
      font-size: 22px; /* Set input font size */
      height: 30px;
      line-height: 30px;
      outline: medium none;
      padding: 8px 12px;
      width: 396px;
    }
    .typeahead {
      background-color: #FFFFFF;
    }
    .typeahead:focus {
      border: 2px solid #0097CF;
    }
    .tt-query {
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    }
    .tt-hint {
      color: #999999;
    }
    .tt-menu {
      background-color: #FFFFFF;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      margin-top: 12px;
      padding: 8px 0;
      width: 422px;
    }
    .tt-suggestion {
      font-size: 22px;  /* Set suggestion dropdown font size */
      padding: 3px 20px;
    }
    .tt-suggestion:hover {
      cursor: pointer;
      background-color: #0097CF;
      color: #FFFFFF;
    }
    .tt-suggestion p {
      margin: 0;
    }
    </style> -->
</head>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

     <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <span>Welcome <b><?php echo $this->session->userdata('users')['username'];?></b></span>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>logout">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
   
  </nav>
  <!-- /.navbar -->

    <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>" class="brand-link">
      <img src="<?php echo Base_path;?>assets/dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">TMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

           <?php 
           $permissions = explode(',',$this->session->userdata('users')['permissions']);
            foreach($modules as $row)
            {
              if(in_array($row['mod_id'], $permissions))
              {
              ?>
              <li class="nav-item">
                <a href="<?php echo base_url();?><?php echo $row['mod_link'];?>" class="nav-link">
                  <i class="nav-icon <?php echo $row['mod_icon'];?>"></i>
                  <p>
                    <?php echo $row['mod_name'];?>
                  </p>
                </a>
              </li>
          <?php 
            }
          }
          ?>      
          <!-- <li class="nav-item">
            <a href="<?php echo base_url();?>dashboard" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>roles" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Roles
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>employee" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Employee
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>products" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Products
              </p>
            </a>
          </li>
         <li class="nav-item">
            <a href="<?php echo base_url();?>customers" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Customers
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?php echo base_url();?>purchase" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Purchase
              </p>
            </a>
          </li>
         <li class="nav-item">
            <a href="<?php echo base_url();?>service_request" class="nav-link">
              <i class="nav-icon fas fa-plus-square"></i>
              <p>
                Service Request
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?php echo base_url();?>service_response" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Service Response
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?php echo base_url();?>customer_enquiry" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Enquiry
              </p>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>