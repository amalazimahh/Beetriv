<?php

ob_start();
session_start();
require_once "../connection.php";
$email = $_SESSION['email'];

$today = date('Y-m-d');
$thisYear = date('Y');
if(isset($_GET['year'])){
  $thisYear = $_GET['year'];
}

$select = "SELECT * FROM users WHERE email = 'admin@beetriv.com' ";
$statement = $conn->prepare($select);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

$salesData = $conn->prepare("SELECT * FROM order_details WHERE sales_date=:sales_date");
$salesData->execute();
$salesRow=$salesData->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .bg-gradient{
            background-color: #ffcd39;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-6">Admin Dashboard</div>
            </a>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider my-0"> -->

            <!-- Heading -->
            <div class="sidebar-heading">
                Reports
            </div>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="sales.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Sales</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manage
            </div>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Users</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Products</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage : </h6>
                        <a class="collapse-item" href="productlist.php">Product List</a>
                        <a class="collapse-item" href="category.php">Category</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <?php foreach($row as $admin){?>
                                    <img class="img-profile rounded-circle"
                                    src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($admin['img']);?>">
                                <?php }?>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Sales Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Sales</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                $stmt = $conn->prepare("SELECT * FROM order_details LEFT JOIN product ON product.prd_id=order_details.prd_id WHERE stat='completed' AND payment_stat='paid' ");
                                                $stmt->execute();

                                                $total = 0;
                                                foreach($stmt as $srow){
                                                $subtotal = $srow['prd_price']*$srow['prd_qty'];
                                                $total += $subtotal;
                                                }

                                                echo "$".number_format($total, 2);
                                            ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Sales Today -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Sales Today</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                $stmt = $conn->prepare("SELECT * FROM order_details WHERE sales_date=:sales_date");
                                                $stmt->execute(['sales_date'=>$today]);
                                
                                                $rtotal = 0;
                                                foreach($stmt as $trow){
                                                  $subtotal = $trow['prd_price']*$trow['prd_qty'];
                                                  $rtotal += $subtotal;
                                                }
                                
                                                echo "$".number_format($rtotal, 2);
                                            ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Deliveries Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Deliveries</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php

                                                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM order_details WHERE stat ='pending' ");
                                                    $stmt->execute();
                                                    $urow =  $stmt->fetch();

                                                    echo $urow['numrows'];
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-truck fa-2x text-gray-300"></i>
                                            <!-- <i class="fas fa-comments "></i> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php

                                                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numuser FROM users WHERE email != 'admin@beetriv.com'");
                                                    $stmt->execute();
                                                    $urow =  $stmt->fetch();

                                                    echo $urow['numuser'];
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-user fa-2x text-gray-300"></i>
                                            <!-- <i class="fas fa-comments "></i> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <!-- Content Row -->

                        <div class="box-body">
                            <div class="chart">
                                <br>
                                <div id="legend" class="text-center"></div>
                                <canvas id="beetrivChart" style="height:350px"></canvas>
                            </div>
                        </div>
                        
                        <!-- Beetriv Chart Data retrieve from order details-->
                        <?php
                            $monthSales = array();
                            $sales = array();
                            //to display total sales in current year only
                            for( $mth = 1; $mth <= 12; $mth++ ) {
                                try{
                                $stmt = $conn->prepare("SELECT * FROM order_details WHERE MONTH(sales_date)=:month AND YEAR(sales_date)=:year");
                                $stmt->execute(['month'=>$mth, 'year'=>$thisYear]);
                                $total = 0;
                                foreach($stmt as $srow){
                                    $subtotal = $srow['prd_price']*$srow['prd_qty'];
                                    $total += $subtotal;    
                                }
                                array_push($sales, round($total, 2));
                                }
                                catch(PDOException $e){
                                echo $e->getMessage();
                                }

                                //str pad to pad a string to new length
                                $num=str_pad( $mth, 2, 0, STR_PAD_LEFT );
                                $month=date('M', mktime(0, 0, 0, $mth, 1));
                                array_push($monthSales, $month);
                            }

                            $monthSales = json_encode($monthSales);
                            $sales = json_encode($sales);

                        ?>
                        
                        <!-- End Chart Data -->
                    
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Beetriv 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- ChartJS -->
    <!-- import bower chart -->
    <script src="../js/chart.js/Chart.js"></script>
    <script>
        $(function(){
        var barChartBeetriv = $('#beetrivChart').get(0).getContext('2d')
        var chart = new Chart(barChartBeetriv)
        var chartData = {
            labels  : <?php echo $monthSales; ?>,
            datasets: [
            {
                label               : 'SALES',
                fillColor           : '#ffcd39',
                strokeColor         : '#000',
                pointColor          : '#3b8bba',
                pointStrokeColor    : '#ffcd39',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : <?php echo $sales; ?>
            }
            ]
        }
        var chartOpt          = {
            scaleBeginAtZero        : true,
            //show grid lines across chart
            scaleShowGridLines      : true,
            //grid lines color
            scaleGridLineColor      : 'rgba(0,0,0,.05)',
            //grid lines width
            scaleGridLineWidth      : 1,
            //show horizontal lines, no X-axis
            scaleShowHorizontalLines: true,
            //show vertical lines, no Y-axis
            scaleShowVerticalLines  : true,
            //true for stroke on each bar
            barShowStroke           : true,
            //width of bar stroke
            barStrokeWidth          : 2,
            //space between each x value sets
            barValueSpacing         : 5,
            //space between data sets within x values
            barDatasetSpacing       : 1,
            //legend template from bower components
            legendTemplate          : '<class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%><%}%>',
            //make the chart responsive or not using boolean
            responsive              : true,
            maintainAspectRatio     : true
        }

        chartOpt.datasetFill = false
        var beetrivChart = chart.Bar(chartData, chartOpt)
        document.getElementById('legend').innerHTML = beetrivChart.generateLegend();
        });
    </script>

</body>

</html>