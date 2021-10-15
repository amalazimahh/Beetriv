<?php
ob_start();
session_start();
$email=$_SESSION['email'];
// echo $email;
require_once "connection.php";


//make sure login first, so that can fetch email, echo email to see if you logged in
$email = $_SESSION['email'];
// echo $email;


$select = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$statement = $conn->prepare($select);
$statement->execute();
$row = $statement->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['save'])){
        // Get the file info
        $fileName = basename($_FILES['img']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    // $userId  = $_POST['userId'];
    $fname      = $_POST['fname'];
    $lname      = $_POST['lname'];
    $username   = $_POST['username'];
    $emailEdit  = $_POST['email'];
    $phone      = $_POST['phone'];
    $bio        = $_POST['bio'];
    $address    = $_POST['address'];
    $province   = $_POST['province'];
    $postcode   = $_POST['postcode'];
    $disclaimer = $_POST['disclaimer'];
    $policies   = $_POST['policies'];
    $shipping   = $_POST['shipping'];
    $currentPwd = $_POST['currentPwd'];
    $newPwd     = $_POST['newPwd'];                             
    $confirmPwd = $_POST['confirmPwd'];

    //Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');
    if(in_array($fileType, $allowTypes)){
        $image = $_FILES['img']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
    
    
        foreach($row as $userStatement){
            if($userStatement['type'] == 'customer'){
                $pdoQuery = ("UPDATE users SET email = '$emailEdit', username = '$username', phone_number = '$phone', 
                fname = '$fname', lname = '$lname', bio = '$bio', img = '$imgContent', address = '$address', province = '$province', postcode = '$postcode' WHERE email = '$email' ");
                $pdoQuery_run = $conn->prepare($pdoQuery);
                $pdoQuery_run->execute();
                header('location: edit-profile.php');
            }
            if($userStatement['type'] == 'seller'){
                $updateSeller = ("UPDATE users SET email='$emailEdit', username= $username', phone_number='$phone', fname='$fname', lname='$lname', bio='$bio', img='$imgContent', disclaimer='$disclaimer', policies='$policies', shipping='$shipping' WHERE email='$email' ");
                $updateSeller_run = $conn->prepare($updateSeller);
                $updateSeller_run->execute();
                header('location: seller-profile.php');
            }
        }
    
    }
    //notify function not yet

    // Save address
    // $insertAddress=$conn->query("INSERT INTO user_address (user_id, address, province, postcode) VALUES ('$userId','$address','$province', '$postcode')");

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit-profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
<!-- Navigation-->
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light" style='color:black' > 
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="store.php">Beetriv</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="store.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bid</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Active Bid</a></li>
                                <li><a class="dropdown-item" href="#!">Ending Soon</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav justify-content-end">
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="wishlist.php">
                    <i class="bi bi-heart" style='color:black'><?php echo (isset($_SESSION['wish_items']) && count($_SESSION['wish_items'])) > 0 ? count($_SESSION['wish_items']):''; ?></i>
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="cart.php">
                    <i class="bi bi-cart4" style='color:black'><?php echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):''; ?></i>
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="user-profile.php"><i class="bi-person-circle"></i></a></li>
                    <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="login.php"><i class="bi bi-box-arrow-right"></i></a></li>
                    </a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Edit Profile -->
        <!-- <?php foreach($row as $user){ ?> -->
            <form action="edit-profile.php" method="post" enctype="multipart/form-data">
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img class="rounded-circle mt-5" width="150px" id="output" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($user['img']);?>" onerror="this.src='img/profile-img.png';"><br><label for="image">Select Profile Image: </label><input type="file" name="img" accept="image/*" onchange="loadFile(event)" class="form-control"><span> </span></div>
            <script>
                var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
                }
            };
            </script>
        </div>
        <div class="col-md-9 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Edit Profile</h4>
                </div>
                <hr>
                <!-- <form action="edit-profile.php" method="post" enctype="multipart/form-data"> -->
                <div class="row mt-2">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" name="userId" value="<?php echo $user['user_id']; ?>">
                    <div class="col-md-6"><label class="labels">Firstname</label><input type="text" class="form-control" placeholder="Firstname" id="fname" name="fname" pattern="[a-zA-Z]{1,}" placeholder="First Name" required></div>
                    <div class="col-md-6"><label class="labels">Lastname</label><input type="text" class="form-control" placeholder="Lastname" id="lname" name="lname" pattern="[a-zA-Z]{1,}" placeholder="Last Name" required></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Display Name</label><input type="text" class="form-control" placeholder="Display Name" id="username" name="username" pattern="[a-zA-Z]{1,}" placeholder="Username" required></div>
                    <div class="col-md-12"><label class="labels">Email Address (*can use previous email)</label><input type="email" class="form-control" id="exampleInputEmail" name="email" placeholder="<?php echo $email; ?>" required></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">IC Number</label><input type="text" class="form-control" id="ic" name="icNum" placeholder="<?php echo $user['ic_number']; ?>" disabled></div>
                    <div class="col-md-6"><label class="labels">IC Colour</label><input type="text" class="form-control" list="ic2" name="icCol" list="ic2" placeholder="<?php echo $user['ic_color']; ?>" disabled>
                    <datalist id="ic2">
                                        <option value = "Yellow">
                                        <option value = "Red">
                                        <option value = "Purple">
                                        <option value = "Green">
                    </datalist>
                    </div>
                </div>
                <div class="row mt-3 pb-3">
                    <div class="col-md-12"><label class="labels">Phone Number</label><input type="tel" class="form-control" id="phone" name="phone" placeholder="<?php echo $user['phone_number']; ?>" required></div>
                    <div class="col-md-12"><label class="labels">Add Bio</label><input type="textarea" class="form-control form-control-user" placeholder= "Bio" id="bio" name="bio" placeholder= "Bio" required/></div><br>
                </div>
                <?php if($user['type'] == 'customer'){?>
                <h4 class="text-right">Shipping Address</h4><hr>
                <div class="row mt-2">
                    <div class="col-md-6"><label class="labels">Address</label><input type="text" class="form-control" id="address" name="address" placeholder="Enter your address.." required></div>
                    <div class="col-md-6"><label class="labels">Province</label><input type="text" class="form-control" list="province" name="province" placeholder="Select province" required>
                    <datalist id="province">
                                        <option value = "Bandar Seri Begawan">
                                        <option value = "Tutong">
                                        <option value = "Kuala Belait">
                                        <option value = "Temburong">
                    </datalist>
                    </div>
                    <div class="col-md-6"><label class="labels">Postcode</label><input type="text" class="form-control" id="postcode" name="postcode" placeholder="Enter your postcode.." required></div>
                </div>
                <?php }?>
                <?php if($user['type'] == 'seller'){?>
                <h4 class="text-right">Extra Fields</h4><hr>
                    <div class="col-md-12"><label class="labels">Disclaimer</label><textarea type="text" class="form-control" id="disclaimer" name="disclaimer" placeholder="Enter disclaimer" required></textarea></div>
                    <div class="col-md-12"><label class="labels">Policies</label><textarea type="text" class="form-control" id="policies" name="policies" placeholder="Enter policies" required></textarea>
                    </div>
                    <div class="col-md-12"><label class="labels">Shipping Information</label><textarea type="text" class="form-control" id="shipping" name="shipping" placeholder="Enter your shipping information" required></textarea></div>
                <?php }?>
                <div class="row mt-3">
                <h4 class="text-right">Change Password</h4><hr>
                <div class="col-md-12"><label class="labels">Current Password</label><input type="password" class="form-control" placeholder="Current Password" id="currentpwd" name="currentPwd" pattern=".{8,25}" title="Required atleast 8 to 25 characters" placeholder= "Current Password" ></div>
                    <div class="col-md-12"><label class="labels">New Password</label><input type="password" class="form-control" placeholder="New Password" id="newpwd" name="newPwd" pattern=".{8,25}" title="Required atleast 8 to 25 characters" placeholder= "New Password" ></div>
                    <div class="col-md-12"><label class="labels">Confirm Password</label><input type="password" class="form-control" placeholder="Confirm Password" id="confirmpwd" name="confirmPwd" pattern=".{8,25}" title="Required atleast 8 to 25 characters" placeholder= "Confirm Password"></div>
                </div>
                <div class="mt-5 text-center"><input class="btn btn-warning profile-button" type="submit" value="Save Profile" name="save"></div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<?php } ?>

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
</body>
</html>