<?php
    session_start();
    require_once('connection.php');
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
  
  <form method="POST" action="esignature.php">

      <h2>Cash on Delivery E-Signature</h2>

      <!-- Add some code here to display cod items with details -->

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
      <button class="btn btn-success">Submit</button>
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