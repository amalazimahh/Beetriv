<?php
session_start();
require_once "connection.php";

$email = $_SESSION['email'];
//echo $email;

$id = $_GET['id'];
// echo $id;

date_default_timezone_set("Asia/Brunei");
$today = date("Y-m-d H:i:s"); 

// Fetch user id from email
$result1 = $conn->prepare("SELECT * FROM users WHERE email = '$email'");
$result1->execute();
$row1 = $result1->fetchAll(PDO::FETCH_ASSOC);

// $queryOrder = $conn->query("SELECT * FROM order_details LEFT JOIN product ON product.prd_id=order_details.prd_id WHERE id ='$id' ");
// $rowOrder = $queryOrder->fetch(PDO::FETCH_ASSOC);
$result = "SELECT * FROM product WHERE prd_id = '$id' ";
$handle = $conn->prepare($result);
$handle->execute();
$rowOrder = $handle->fetchAll(PDO::FETCH_ASSOC);

$statusMsg = '';
if(isset($_POST["submit"])){
      $userId       = $_POST['user_id'];
      $prd_id       = $_POST['prd_id'];
      $rate         = $_POST['rate'];
      $rate2        = $_POST['rate2'];
      $rate3        = $_POST['rate3'];
      $rate4        = $_POST['rate4'];
      $feedback     = $_POST['feedback'];
    if(!empty($_FILES["prd_img"]["name"])) {
      // Get the file info
      $fileName = basename($_FILES["prd_img"]["name"]);
      $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

      // Allow certain file formats
      $allowTypes = array('jpg','png','jpeg','gif');
        if(in_array($fileType, $allowTypes)){
            $image = $_FILES['prd_img']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
           
            //Select from Database 
            $select = "SELECT * FROM seller_review WHERE 1";
                            
            // Insert image content into database
            $insert = $conn->query("INSERT INTO seller_review(prd_id,user_id,prd_quality,seller_service,runner_service,overall_rate,feedback,prd_img,time) VALUES ('$prd_id','$userId','$rate','$rate2','$rate3','$rate4','$feedback','$imgContent','$today')");
                
            if($insert){
                echo '<script>updated</script>';
                header('location: purchase.php');
            }else{
                echo '<script>failed</script>';
            }
            // $status  = '<script>updated</script>';
            // $statusMsg = "<script>updated</script>";
        } else {
          $statusMsg = "Only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    } else { 
      
      $statusMsg = "Select a file.";
    //   echo $prd_id;
    //   echo $rate;
    //   echo $rate2;
    //   echo $rate3;
    //   echo $rate4;
    //   echo $feedback;
    //   echo $imgContent;
    }
  }
  echo $statusMsg;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Review</title>
    <!-- <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/footer.css"> -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/user-profile.css">
        <!-- <link rel="stylesheet" href="css/feedback-form.css"> -->
    <style>
        /*//////////////////////////////////////////////////////////////////

 
      
[ Contact ]*/

  #nnv{
        text-align: center;
        font-size: 24px;
        color: #000000;
        width: 100%;
        padding: 15px;
        border:0px;
        outline: none;
        cursor: pointer;
        margin-top: 5px;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
        }       

.container-contact100 {
  width: 100%;  
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  
}

.wrap-contact100 {
  width: 920px;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  padding: 62px 55px 90px 55px;
}



/*------------------------------------------------------------------
[  ]*/

.contact100-form {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.contact100-form-title {
  display: block;
  width: 100%;
  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 39px;
  color: #333333;
  line-height: 1.2;
  text-align: center;
  padding-bottom: 59px;
}



/*------------------------------------------------------------------
[  ]*/

.wrap-input100 {
  width: 100%;
  position: relative;
  border: 1px solid #e6e6e6;
  border-radius: 13px;
  padding: 10px 30px 9px 22px;
  margin-bottom: 20px;
}

.rs1-wrap-input100 {
  width: calc((100% - 30px) / 2);
}

.label-input100 {
  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 12px;
  color: #393939;
  line-height: 1.5;
  text-transform: uppercase;
}

.input100 {
  display: block;
  width: 100%;
  background: transparent;
  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 18px;
  color: #555555;
  line-height: 1.2;
  padding-right: 15px;
}


/*---------------------------------------------*/
input.input100 {
  height: 20px;
}


textarea.input100 {
  min-height: 90px;
  padding-top: 9px;
  padding-bottom: 13px;
  border: none;
  outline: none;
}


.input100:focus + .focus-input100::before {
  width: 100%;
}

.has-val.input100 + .focus-input100::before {
  width: 100%;
}


/*------------------------------------------------------------------
[ Button ]*/
.container-contact100-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding-top: 20px;
  width: 100%;
}

.contact100-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  width: 100%;
  height: 50px;
  background-color: #333333;
  border-radius: 25px;

  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 16px;
  color: #fff;
  line-height: 1.2;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.contact100-form-btn i {
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.contact100-form-btn:hover {
  background-color: #ffcd39;
}

.contact100-form-btn:hover i {
  -webkit-transform: translateX(10px);
  -moz-transform: translateX(10px);
  -ms-transform: translateX(10px);
  -o-transform: translateX(10px);
  transform: translateX(10px);
}

/*------------------------------------------------------------------
[ Responsive ]*/

@media (max-width: 768px) {
  .rs1-wrap-input100 {
    width: 100%;
  }

}

@media (max-width: 576px) {
  .wrap-contact100 {
    padding: 62px 15px 90px 15px;
  }

  .wrap-input100 {
    padding: 10px 10px 9px 10px;
  }
}



/*------------------------------------------------------------------
[ Alert validate ]*/

.validate-input {
  position: relative;
}

.alert-validate::before {
  content: attr(data-validate);
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  position: absolute;
  width: 100%;
  min-height: 40px;
  background-color: #f7f7f7;
  top: 35px;
  left: 0px;
  padding: 0 45px 0 22px;
  pointer-events: none;

  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 18px;
  color: #fa4251;
  line-height: 1.2;
}

.btn-hide-validate {
  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 18px;
  color: #fa4251;
  cursor: pointer;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 40px;
  height: 40px;
  top: 35px;
  right: 12px;
}

.rs1-alert-validate.alert-validate::before {
  background-color: #fff;
}

.true-validate::after {
  content: "\f26b";
  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 18px;
  color: #00ad5f;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 40px;
  height: 40px;
  top: 35px;
  right: 10px;
}

/*---------------------------------------------*/
@media (max-width: 576px) {
  .alert-validate::before {
    padding: 0 10px 0 10px;
  }

  .true-validate::after,
  .btn-hide-validate {
    right: 0px;
    width: 30px;
  }
}

.rating-star{
  padding: 10px 10px;
}

.rate {
  /* position: absolute; 
  right: 35%; */
  /* left: 70px; */
  /* height: 20px; */
  /* padding: 0 60px; */
  
}
.rate:not(:checked) > input {
  position:absolute;
  top:-9999px; 
} 
.rate:not(:checked) > label {
  float:right;
  width:30px;
  overflow:hidden;
  white-space:nowrap;
  cursor:pointer;
  font-size:30px;
  color:#ccc;
}
.rate:not(:checked) > label:before {
  content: '★ ';
}
.rate > input:checked ~ label {
  color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
  color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
  color: #c59b08;
}

/* Star 2 */
.rate2 {
  /* position: absolute; 
  right: 35%; */
  /* left: 70px; */
  /* height: 20px; */
  /* padding: 0 60px; */
  
}
.rate2:not(:checked) > input {
  position:absolute;
  top:-9999px; 
} 
.rate2:not(:checked) > label {
  float:right;
  width:30px;
  overflow:hidden;
  white-space:nowrap;
  cursor:pointer;
  font-size:30px;
  color:#ccc;
}
.rate2:not(:checked) > label:before {
  content: '★ ';
}
.rate2 > input:checked ~ label {
  color: #ffc700;    
}
.rate2:not(:checked) > label:hover,
.rate2:not(:checked) > label:hover ~ label {
  color: #deb217;  
}
.rate2 > input:checked + label:hover,
.rate2 > input:checked + label:hover ~ label,
.rate2 > input:checked ~ label:hover,
.rate2 > input:checked ~ label:hover ~ label,
.rate2 > label:hover ~ input:checked ~ label {
  color: #c59b08;
}

/* Star 3 */
.rate3 {
  /* position: absolute; 
  right: 35%; */
  /* left: 70px; */
  /* height: 20px; */
  /* padding: 0 60px; */
  
}
.rate3:not(:checked) > input {
  position:absolute;
  top:-9999px; 
} 
.rate3:not(:checked) > label {
  float:right;
  width:30px;
  overflow:hidden;
  white-space:nowrap;
  cursor:pointer;
  font-size:30px;
  color:#ccc;
}
.rate3:not(:checked) > label:before {
  content: '★ ';
}
.rate3 > input:checked ~ label {
  color: #ffc700;    
}
.rate3:not(:checked) > label:hover,
.rate3:not(:checked) > label:hover ~ label {
  color: #deb217;  
}
.rate3 > input:checked + label:hover,
.rate3 > input:checked + label:hover ~ label,
.rate3 > input:checked ~ label:hover,
.rate3 > input:checked ~ label:hover ~ label,
.rate3 > label:hover ~ input:checked ~ label {
  color: #c59b08;
}

/* Star 4 */
.rate4 {
  /* position: absolute; 
  right: 35%; */
  /* left: 70px; */
  /* height: 20px; */
  /* padding: 0 60px; */
  
}
.rate4:not(:checked) > input {
  position:absolute;
  top:-9999px; 
} 
.rate4:not(:checked) > label {
  float:right;
  width:30px;
  overflow:hidden;
  white-space:nowrap;
  cursor:pointer;
  font-size:30px;
  color:#ccc;
}
.rate4:not(:checked) > label:before {
  content: '★ ';
}
.rate4 > input:checked ~ label {
  color: #ffc700;    
}
.rate4:not(:checked) > label:hover,
.rate4:not(:checked) > label:hover ~ label {
  color: #deb217;  
}
.rate4 > input:checked + label:hover,
.rate4 > input:checked + label:hover ~ label,
.rate4 > input:checked ~ label:hover,
.rate4 > input:checked ~ label:hover ~ label,
.rate4 > label:hover ~ input:checked ~ label {
  color: #c59b08;
}

/* Input Submit style */
input[type=submit] {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  width: 100%;
  height: 50px;
  background-color: #333333;
  border-radius: 25px;

  font-family: Roboto,Helvetica,Arial,sans-serif;
  font-size: 16px;
  color: #fff;
  line-height: 1.2;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

input[type=submit]:hover {
  background-color: #ffcd39;
}

    </style>
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
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
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
                    <form action = "store.php" method = "post">
                        <ul class="nav justify-content-end">
                    <!-- <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="wishlist.php"> -->
                    <li><button id="nnv" type="submit" name="wishlist" class="bi bi-heart" style='color:black;background-color:transparent'><?php echo (isset($_SESSION['wish_items']) && count($_SESSION['wish_items'])) > 0 ? count($_SESSION['wish_items']):''; ?></i></li>
                    <!-- <li><a class="nav-item nav-link" style='color:black' aria-current="page" href="cart.php"> -->
                    <li><button id="nnv" type="submit" name="cart" class="bi bi-cart4" style='color:black;background-color:transparent'><?php echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):''; ?></i></button></li>
                    <li><button id="nnv" type="submit" name="profile" class="nav-item" style='background-color:transparent'><i class="bi-person-circle"></i></button></li>
                    <li><button id="nnv" type="submit" name="logout" class="nav-item" style='background-color:transparent'><i class="bi bi-box-arrow-right"></i></button></li>
                    </ul>
                    </form>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="container px-4 px-lg-5 my-5">
          <!-- product details and status -->
            <table class="table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php foreach($rowOrder as $prdPurchase){?>
                    <td>
                      <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($prdPurchase['prd_img']); ?>" class="rounded img-thumbnail mr-2" style="width:90px;">   
                    </td>
                    <td>
                      <?php echo $prdPurchase['prd_name'];?>        
                    </td>
                    <td>
                      $<?php echo $prdPurchase['prd_price'];?>
                    </td>
                    <td>
                      <?php echo $prdPurchase['prd_qty']; ?>
                    </td>
                    <td>
                      $<?php $totalSum = $prdPurchase['prd_price'] * $prdPurchase['prd_qty']; 
                            echo $totalSum; ?>
                    </td>
                  <?php }?>
                </tr>
                        
              </tbody>
            </table>

            <!-- insert leave feedback form -->
            <div class="container-contact100">
		        <div class="wrap-contact100">
                    <form action="" method="post" enctype="multipart/form-data">
                        <span class="contact100-form-title">
                            Leave Your Feedback
                        </span>

                        <span class="label-input100"><b>Select a star based on your experience</b></span>
                        <input type="hidden" name="prd_id" value="<?php foreach($rowOrder as $prdPurchase){ 
                                                                          echo $prdPurchase['prd_id'];
                                                                    } ?>">
                        <?php foreach($row1 as $user){?>
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        <?php }?>
                        

                        <div class="rating-star">
                                <!-- star rating code here -->
                            <div class="rate">
                                <span class="label-input100">Product Quality</span>
                                    <input type="radio" id="star55" name="rate" value="5" />
                                    <label for="star55" title="text">5 stars</label>
                                    <input type="radio" id="star54" name="rate" value="4" />
                                    <label for="star54" title="text">4 stars</label>
                                    <input type="radio" id="star53" name="rate" value="3" />
                                    <label for="star53" title="text">3 stars</label>
                                    <input type="radio" id="star52" name="rate" value="2" />
                                    <label for="star52" title="text">2 stars</label>
                                    <input type="radio" id="star51" name="rate" value="1" />
                                    <label for="star51" title="text">1 star</label>
                            </div>
                        </div>

                                <br>
                        <div class="rating-star">
                            
                            <!-- star rating code here -->
                                <div class="rate2">
                                <span class="label-input100">Seller Service</span>
                                    <input type="radio" id="star45" name="rate2" value="5" />
                                      <label for="star45" title="text">5 stars</label>
                                    <input type="radio" id="star44" name="rate2" value="4" />
                                      <label for="star44" title="text">4 stars</label>
                                    <input type="radio" id="star43" name="rate2" value="3" />
                                    <label for="star43" title="text">3 stars</label>
                                    <input type="radio" id="star42" name="rate2" value="2" />
                                    <label for="star42" title="text">2 stars</label>
                                    <input type="radio" id="star41" name="rate2" value="1" />
                                    <label for="star41" title="text">1 star</label>
                                </div>
                        </div>
                                <br>

                        <div class="rating-star">
                            
                            <!-- star rating code here -->
                                <div class="rate3">
                                <span class="label-input100">Runner Service</span>
                                    <input type="radio" id="star35" name="rate3" value="5" />
                                        <label for="star35" title="text">5 stars</label>
                                    <input type="radio" id="star34" name="rate3" value="4" />
                                        <label for="star34" title="text">4 stars</label>
                                    <input type="radio" id="star33" name="rate3" value="3" />
                                        <label for="star33" title="text">3 stars</label>
                                    <input type="radio" id="star32" name="rate3" value="2" />
                                        <label for="star32" title="text">2 stars</label>
                                    <input type="radio" id="star31" name="rate3" value="1" />
                                        <label for="star31" title="text">1 star</label>
                                </div>
                        </div>

                                <br>
                        <div class="rating-star">
                            
                            <!-- star rating code here -->
                                <div class="rate4">
                                <span class="label-input100">Overall Rate</span>
                                    <input type="radio" id="star25" name="rate4" value="5" />
                                        <label for="star25" title="text">5 stars</label>
                                    <input type="radio" id="star24" name="rate4" value="4" />
                                        <label for="star24" title="text">4 stars</label>
                                    <input type="radio" id="star23" name="rate4" value="3" />
                                        <label for="star23" title="text">3 stars</label>
                                    <input type="radio" id="star22" name="rate4" value="2" />
                                        <label for="star22" title="text">2 stars</label>
                                    <input type="radio" id="star21" name="rate4" value="1" />
                                        <label for="star21" title="text">1 star</label>
                                </div>
                                <br>
                        </div>

                        <div class="wrap-input100 validate-input bg0 rs1-alert-validate" data-validate = "Please leave your feedback for this seller">
                            <span class="label-input100">Feedback</span>
                            <textarea class="input100" name="feedback" placeholder="Your feedback here..."></textarea>
                        </div>

                        <div class="wrap-input100 validate-input bg0 rs1-alert-validate">
                            <span for="image" class="label-input100">Upload an image of the product</span>
                            <br>
                            <input type="file" name="prd_img"><br>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                              <script>
                                $(function() {
                                  // Multiple images preview in browser
                                  var imagesPreview = function(input, placeToInsertImagePreview) {

                                      if (input.files) {
                                          var filesAmount = input.files.length;

                                          for (i = 0; i < filesAmount; i++) {
                                              var reader = new FileReader();

                                              reader.onload = function(event) {
                                                  $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                                              }

                                              reader.readAsDataURL(input.files[i]);
                                          }
                                      }

                                  };

                                  $('#gallery-photo-add').on('change', function() {
                                      imagesPreview(this, 'div.gallery');
                                  });
                              });
                              </script>
                        </div>

                        <div class="container-contact100-form-btn">
                          <input type="submit" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>

        </section>
    
        <!-- Footer-->
        <footer class="site-footer">

            <div class="container">
                <div class="row">
                <!-- first section -->
                <div class="col-xs-6 col-md-3">
                    <h6>CORPORATE</h6>
                    <ul class="footer-links">
                        <li><a href="about.php">About Beetriv</a></li>
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
                        <li><a href="footer/buy-guides.php">How to Buy on Beetriv</a></li>
                        <li><a href="footer/sell-guides.php">How to Sell on Beetriv</a></li>
                        <li><a href="footer/bid-guides.php">How Bidding Works</a></li>
                        <li><a href="footer/customer-protection.php">Customer Protection</a></li>
                        <li><a href="footer/faq.php">FAQ</a></li>
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

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</body>
</html>