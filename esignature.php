<?php
    session_start();
    require_once('connection.php');
    $id = $_GET['id'];
    //select single data
    //select email
    $result1 = $conn->query("SELECT * FROM order_details WHERE id ='$id'");
    $row1 = $result1->fetch(PDO::FETCH_ASSOC);
    $name = $row1['stat'];
    if(($name) == 'pending'){
    //add code to save details to receipt table
        if(isset($_POST['submit'])){
            $prdID          =$_POST['product_id'];
            $prdName        =$_POST['product_name'];
            $prdQty         =$_POST['product_qty'];
            $prdPrice       =$_POST['product_price'];
            $prdStat        =$_POST['product_stat'];
            $paymentMthd    =$_POST['payment_mthd'];

            //insert into receipt table
            $insert =$conn->query("INSERT INTO receipts (prd_id,prd_name,prd_qty,prd_price,prd_stats,payment_mthd)
            VALUE ('$prdID','$prdName','$prdQty','$prdPrice','$prdStat','$paymentMthd')");

            //update order_details table
            $update = "UPDATE order_details SET stat='completed' WHERE id='$id'";
            $runUpdate = $conn->prepare($update);
            $runUpdate->execute();

            $update1 = "UPDATE order_details SET payment_stat='paid' WHERE id='$id'";
            $runUpdate1 = $conn->prepare($update1);
            $runUpdate1->execute();


            // $result = "DELETE FROM order_details where id='$id'";
            // $statement = $conn->prepare($result);
            // $statement->execute();

            header('location: runner-order.php');
        }
    }else{
        header('location: runner-order.php');
    }

    //add code to update receipt table



    //add code to delete data form order_details
    // $result = "DELETE FROM order_details where id='$id'";
    // $statement = $conn->prepare($result);
    // $statement->execute();
    // $row = $statement->fetchAll(PDO::FETCH_ASSOC);  

    //$email = $_SESSION['email'];
    // echo $email;

    //add code to save signature as PNG and upload to database 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
    <link type="text/css" href="jquerysignature/css/jquery.signature.css" rel="stylesheet"> 
    <script type="text/javascript" src="jquerysignature/js/jquery.signature.js"></script>
    <title>Digital Signature for Cash on Delivery</title>

    <style>
        .kbw-signature { width: 400px; height: 200px;}
        #sigCust canvas{
            width: 100% !important;
            height: auto;
        }
        #sigRun canvas{
            width: 100% !important;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container">
  
  <form method="POST" action="">

      <h2>Cash on Delivery E-Signature</h2>

      <!-- Add some code here to display cod items with details -->
        <!-- Hidden input type to sotre data inside database -->
        <input type="hidden" name="product_id" value="<?php echo $row1['prd_id']?>">
        <input type="hidden" name="product_name" value="<?php echo $row1['prd_name']?>">
        <input type="hidden" name="product_qty" value="<?php echo $row1['prd_qty']?>">
        <input type="hidden" name="product_price" value="<?php echo $row1['prd_price']?>">
        <input type="hidden" name="product_mthd" value="<?php echo $row1['payment_mthd']?>">
        <input type="hidden" name="product_stat" value="Completed">

      <!-- Retrieve customer's signature -->
      <div class="col-md-12">
          <label class="" for="">Customer Signature:</label>
          <br/>
          <div id="sigCust" ></div>
          <br/>
          <button id="erase">Clear Signature</button>
          <textarea id="signature64" name="signed" style="display: none"></textarea>
      </div>

      <!-- Retrieve runner's signature -->
      <div class="col-md-12">
          <label class="" for="">Runner Signature:</label>
          <br/>
          <div id="sigRun" ></div>
          <br/>
          <button id="erase">Clear Signature</button>
          <textarea id="signature64" name="signed" style="display: none"></textarea>
      </div>

      <br>
      <button name="submit">Submit</button>
  </form>

</div>

<script type="text/javascript">
    // for customer
    var sig = $('#sigCust').signature({
        syncField: '#signature64', 
        syncFormat: 'PNG'
    });
    $('#erase').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });

    //for runner
    var sigRun = $('#sigRun').signature({
        syncField: '#signature64', 
        syncFormat: 'PNG'
    });
    $('#erase').click(function(e) {
        e.preventDefault();
        sigRun.signature('clear');
        $("#signature64").val('');
    });
</script>
    
</body>
</html>