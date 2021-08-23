<?php
ob_start();
session_start();
require_once "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <link rel="stylesgeet" href="https://rawgit.com/creativetimofficial/material-kit/master/assets/css/material-kit.css">
    <link rel="stylesheet" href="css/user-profile.css">
    <link rel="stylesheet" href="css/footer.css">
</head>

<body class="profile-page">
    <nav class="navbar navbar-color-on-scroll navbar-transparent fixed-top  navbar-expand-lg "  color-on-scroll="100"  id="sectionsNav">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="https://demos.creative-tim.com/material-kit/index.html" target="_blank">Material Kit </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="dropdown nav-item">
                      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                          <i class="material-icons">apps</i> Components
                      </a>
                      <div class="dropdown-menu dropdown-with-icons">
                        <a href="../index.html" class="dropdown-item">
                            <i class="material-icons">layers</i> All Components
                        </a>
                        
                        <a href="https://demos.creative-tim.com/material-kit/docs/2.0/getting-started/introduction.html" class="dropdown-item">
                            <i class="material-icons">content_paste</i> Documentation
                        </a>
                      </div>
                    </li>
      				<li class="nav-item">
      					<a class="nav-link" href="javascript:void(0)">
      						<i class="material-icons">cloud_download</i> Download
      					</a>
      				</li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="page-header header-filter" data-parallax="true" style="background-image:url('http://wallpapere.org/wp-content/uploads/2012/02/black-and-white-city-night.png');"></div>
    <div class="main main-raised">
		<div class="profile-content">
            <div class="container">
                <div class="row">
	                <div class="col-md-6 ml-auto mr-auto">
        	            <!-- <div class="profile">
	                         <div class="avatar">
	                            <img src="https://www.biography.com/.image/ar_1:1%2Cc_fill%2Ccs_srgb%2Cg_face%2Cq_auto:good%2Cw_300/MTU0NjQzOTk4OTQ4OTkyMzQy/ansel-elgort-poses-for-a-portrait-during-the-baby-driver-premiere-2017-sxsw-conference-and-festivals-on-march-11-2017-in-austin-texas-photo-by-matt-winkelmeyer_getty-imagesfor-sxsw-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
	                        </div> 
	                    </div> -->
                        <div class="text-center name" >
	                            <h3 class="title">EDIT PROFILE INFORMATION</h3>
	                        </div>
                        <div class="avatar">
	                        <img src="https://www.biography.com/.image/ar_1:1%2Cc_fill%2Ccs_srgb%2Cg_face%2Cq_auto:good%2Cw_300/MTU0NjQzOTk4OTQ4OTkyMzQy/ansel-elgort-poses-for-a-portrait-during-the-baby-driver-premiere-2017-sxsw-conference-and-festivals-on-march-11-2017-in-austin-texas-photo-by-matt-winkelmeyer_getty-imagesfor-sxsw-square.jpg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
	                    </div>

                        <form action="edit-profile.php" method="post">

                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                        <label for="image"></label>
                                        <input type="file" name="image" value="Select Image File">
                            
                                    <div class="description text-center">
                                        <p>Acceptable formats are .jpg, .jpeg and .png only</p>
                                        <p>Maximum file size is 500kb</p>
                                    </div>
                                </div>
                            </div>
    	                </div>
                    </div>

				<div class="row">
					<div class="col-md-6 ml-auto mr-auto">
                        
                    <h5>ACCOUNT INFORMATION</h5>

                        <div class="form-group row">
                            <!-- First Name -->
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="fname" name="fname" pattern="[a-zA-Z]{1,}" placeholder="First Name" required/>
                            </div>

                            <!-- Last Name -->
                            <div class="col-sm-6 ">
                                <input type="text" class="form-control form-control-user" id="lname" name="lname" pattern="[a-zA-Z]{1,}" placeholder="Last Name" required/>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="username" name="username" pattern="[a-zA-Z]{1,}" placeholder="Username" required/>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" placeholder="Email Address" required/>
                        </div>

                        <!-- IC Number -->
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="ic" name="icNum" placeholder="IC Number" required/> 
                            </div>
                                
                            <!-- IC Colour -->
                            <div class="col-sm-6 " >
                                <input type="text" class="form-control form-control-user" name="icCol" list="ic2" placeholder="IC Colour" required/>
                                    <datalist id="ic2">
                                        <option value = "Yellow">
                                        <option value = "Purple">
                                        <option value = "Green">
                                    </datalist>
                            </div>
                        </div>

                        <!-- Phone number -->
                        <div class="form-group">
                            <input type="tel" class="form-control form-control-user" id="phone" name="phone" placeholder= "Phone Number" required/>
                        </div>

                        <!-- Bio -->
                        <div class="form-group">
                            <input type="textarea" class="form-control form-control-user" id="bio" name="bio" placeholder= "Bio"/>
                        </div>
                        
                        <br>

                    <h5>CHANGE PASSWORD</h5>

                        <!-- Current Password -->
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="currentpwd" name="currentPwd" pattern=".{8,25}" title="Required atleast 8 to 25 characters" placeholder= "Current Password" required/>
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="newpwd" name="newPwd" pattern=".{8,25}" title="Required atleast 8 to 25 characters" placeholder= "New Password" required/>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="confirmpwd" name="confirmPwd" pattern=".{8,25}" title="Required atleast 8 to 25 characters" placeholder= "Confirm Password" required/>
                        </div>

                        <br>

                        <div class="text-center">
                        <input type="submit" value="SAVE" name="save" class="btn btn-outline-dark mt-auto">
                        </div>

                        <?php
                        if(isset($_POST['save'])){
                            $fname = $_POST['fname'];
                            $lname = $_POST['lname'];
                            $username = $_POST['username'];
                            $email = $_POST['email'];
                            $icNum = $_POST['icNum'];
                            $icCol = $_POST['icCol'];
                            $phone = $_POST['phone'];
                            $bio = $_POST['bio'];
                            $currentPwd = $_POST['currentPwd'];
                            $newPwd = $_POST['newPwd'];
                            $confirmPwd = $_POST['confirmPwd'];

                            // $sql = "UPDATE users SET email = :email, username = :usernmae, icNum = :Ic_no, icCol = :Ic_color, phone = :Phone_Number, newPwd = :Password, fname = :Firstname, lname = :Lastname, bio = :Bio WHERE email = :email";
                            // $stmt= $pdo->prepare($sql);
                            // $stmt->execute([$email, $username, $icNum, $icCol, $phone, $newPwd, $fname, $lname, $bio]);

                            $sql = $conn->prepare("UPDATE users set email = :email,
                                        username = :username, 
                                        icNum = :Ic_no,
                                        icCol = :Ic_color, 
                                        phone = :Phone_Number,
                                        newPwd = :Password, 
                                        fname = :Firstname,
                                        lname = :Lastname,
                                        bio = :Bio");
                            
                            $sql->bindParam(':email', $email, PDO::PARAM_STR,25);
                            $sql->bindParam(':username', $username, PDO::PARAM_STR,25);
                            $sql->bindParam(':Ic_no', $icNum, PDO::PARAM_STR,25);
                            $sql->bindParam(':Ic_color', $icCol, PDO::PARAM_STR,25);
                            $sql->bindParam(':Phone_Number', $phone, PDO::PARAM_STR,25);
                            $sql->bindParam(':Password', $newPwd, PDO::PARAM_STR,25);
                            $sql->bindParam(':Firstname', $fname, PDO::PARAM_STR,25);
                            $sql->bindParam(':Lastname', $lname, PDO::PARAM_STR,25);
                            $sql->bindParam(':Bio', $bio, PDO::PARAM_STR,25);

                            if($sql->execute()){
                                echo "Successfully updated Profile";
                                }// End of if profile is ok 
                                else{
                                print_r($sql->errorInfo()); // if any error is there it will be posted
                                $msg=" Database problem, please contact site admin ";
                                }
                        }
                        
                        ?>
                        
                    </form>

                    <!-- php- update into database -->
                    <?php
                        // if(isset($_POST["save"])){
                        //     if(!empty($_FILES['image']['name'])) {
                        //         $fileName = basename($_FILES['image']['name']);
                        //         $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                        //         $fname = $_POST['fname'];
                        //         $lname = $_POST['lname'];
                        //         $username = $_POST['username'];
                        //         $email = $_POST['email'];
                        //         $icNum = $_POST['icNum'];
                        //         $icCol = $_POST['icCol'];
                        //         $phone = $_POST['phone'];
                        //         $bio = $_POST['bio'];
                        //         $currentPwd = $_POST['currentPwd'];
                        //         $newPwd = $_POST['newPwd'];
                        //         $confirmPwd = $_POST['confirmPwd'];

                        //         // allow certain formats
                        //         $allowTypes = array('jpg','png','jpeg','gif');
                        //         if(in_array($fileType, $allowTypes)){
                        //             $image = $_FILES['image']['tmp_name'];
                        //             $imgContent = addslashes(file_get_contents($image));

                        //             //select table from database
                        //             //update & insert data in db 

                        //         }
                        //     }
                        // }
                    ?>
    	    	</div>
            </div>

            </div>
        </div>
	</div>
	
	<!-- Footer-->
    <footer class="site-footer">

        <div class="container">
            <div class="row">
                <!-- first section -->
                <div class="col-xs-6 col-md-3">
                    <h6>CORPORATE</h6>
                    <ul class="footer-links">
                        <li><a href="footer/about.php">About Beetriv</a></li>
                        <li><a href="footer/privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="footer/termsco.php">Terms and Conditions</a></li>
                    </ul>
                </div>

                <!-- second section -->
                <div class="col-xs-6 col-md-3">
                    <h6>DEALS, PAYMENT & DELIVERY</h6>
                    <ul class="footer-links">
                        <li><a href="footer/deals.php">Our Deals</a></li>
                        <li><a href="footer/delivery.php">Delivery Services</a></li>
                        <li><a href="footer/payment.php">Payment</a></li>
                    </ul>
                </div>

                <!-- third section -->
                <div class="col-xs-6 col-md-3">
                    <h6>CUSTOMER CARE</h6>
                    <ul class="footer-links">
                        <li><a href="footer/be-seller.php">Become Our Seller</a></li>
                        <li><a href="footer/faq.php">FAQ</a></li>
                        <li><a href="footer/buy-guides.php">How to Buy on Beetriv</a></li>
                        <li><a href="footer/sell-guides.php">How to Sell on Beetriv</a></li>
                        <li><a href="footer/bid-guides.php">How Bidding Works</a></li>
                        <li><a href="footer/customer-protection.php">Customer Protection</a></li>
                    </ul>
                </div>

                <!-- fourth section -->
                <div class="col-xs-6 col-md-3">
                    <h6>CONTACT US</h6>
                    <p>Phone: 257 3663</p>
                    <p>Email: beetrivteam@gmail.com</p>
                    <p>Instagram: @beetriv</p>
                    <p>Facebook: @beetriv</p>
                </div>
            </div>
        </div>
    </footer>
  
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>


   

</body>
</html>