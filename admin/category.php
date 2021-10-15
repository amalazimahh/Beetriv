<?php

ob_start();
session_start();
require_once "../connection.php";
    $email = $_SESSION['email'];

$select = "SELECT * FROM users WHERE email = 'admin@beetriv.com' ";
$statement = $conn->prepare($select);
$statement->execute();
$rowAdmin = $statement->fetchAll(PDO::FETCH_ASSOC);

$result = "SELECT * FROM category";
$handle = $conn->prepare($result);
$handle->execute();
$row = $handle->fetchAll(PDO::FETCH_ASSOC);

$reqCat = "SELECT * FROM reqcategory LEFT JOIN users ON users.user_id=reqcategory.user_id";
$reqCatRun = $conn->prepare($reqCat);
$reqCatRun->execute();
$reqCategory = $reqCatRun->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Category</title>

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
            <li class="nav-item">
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

                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <?php foreach($rowAdmin as $admin){?>
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

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Requested Category</h1>
                    </div>

                    <div class="box-body">
                            <div class="card shadow mb-4">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Tool</th>
                                    </tr>
                                </thead>
                                <?php foreach($reqCategory as $newCat){?>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo $newCat['category_name']; ?></th>
                                        <td><?php echo $newCat['username']; ?></td>
                                        <td><?php echo $newCat['reason']; ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" value="<?php echo $newCat['id']; ?>" name="id">
                                                <button type="submit" class="btn btn-outline-danger" name="delete"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php if( isset($_POST['delete']) ) {
                                            $id = $_POST['id'];
                                            $del = $conn->prepare("DELETE FROM reqcategory WHERE id = '$id'");
                                            $del->execute();

                                            echo "<meta http-equiv='refresh' content='0'>";
                                         }
                                    } 
                                    ?>
                                </tbody>
                                
                                </table>
                            </div>
                        </div>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Category</h1>
                    </div>

                    <!-- Content Row -->
                        <div class="box-body">
                            <div class="card shadow mb-4">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Tools</th>
                                    </tr>
                                </thead>
                                <?php foreach($row as $product){?>
                                <tbody>
                                    <tr>
                                    <th scope="row"><?php echo $product['name']; ?></th>
                                    <td>
                                    <form method="post">
                                    <input type="hidden" value="<?php echo $product['id']; ?>" name="id">
                                    <button type="submit" class="btn btn-outline-danger" name="delete"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg></button>
                                    </form>
                                    </td>
                                    </tr>
                                    <?php 
                                    if( isset($_POST['delete']) ) {
                                        $id = $_POST['id'];
                                        // $id = $conn->prepare("SELECT id FROM category WHERE 1");
                                        // $id->execute();
                                
                                        // $result = $id->fetch(PDO::FETCH_ASSOC);
                                        // // $delete_name = $product['name'];
                        
                                        // $sql = "DELETE FROM category WHERE id = '".$result['id']."' ";
                                        // $conn->exec($sql);
                        
                                        // $count=$conn->prepare("DELETE FROM category WHERE id= $id");
                                        // $count->bindParam(":id",$id,PDO::PARAM_INT);
                                        // $count->execute();

                                        $del = $conn->prepare("DELETE FROM category WHERE id = '$id'");
                                        $del->execute();

                                        echo "<meta http-equiv='refresh' content='0'>";
                                    }
                                    
                                                        }  
    
                                    ?>

                                    <tr>
                                    <td colspan="2" class="text-center">

                                    <div class="form-inline">
                                    <form method="post">
                                    <?php if( isset($_POST['add']) ): ?>
                                    <input type="text" name="name" class="form-control" >
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-outline-success" name="add">Add Category <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg></button>
                                    </form>
                                    </div>

                                    </td>
                                    </tr>
                                </tbody>
                                
                                </table>
                            </div>
                        </div>
            </div>
            <!-- End of Main Content -->

            <?php 
            if( isset($_POST['add']) && isset($_POST['name']) ) {

                $name = $_POST['name'];

                $select = "SELECT * FROM category WHERE 1";

                $insert = $conn->query ("INSERT INTO category ( name ) VALUES ('$name')");

                echo "<meta http-equiv='refresh' content='0'>";

            }
            ?>

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

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>