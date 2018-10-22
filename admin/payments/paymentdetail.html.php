
<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Students</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css" />
        <link rel="stylesheet" href="../../css/style.css" type="text/css" />
         <link rel="icon" href="../../images/favicon.ico">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    
    <link href="../../css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript">
         <!--
            function getConfirmation(){
               var retVal = confirm("Are sure to delete ?");
               if( retVal == true ){
                  //document.write ("User wants to continue!");
                  return true;
               }
               else{
                  //document.write ("User does not want to continue!");
                  return false;
               }
            }
         //-->
      </script>
    </head>
    <body>
        <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
        <div id="wrap">
            <header class="main-header">
                <div class="container">
                    <div class="logo">
                       <script language="JavaScript1.2">                   
  
var myimages=new Array();
var delay = 500;
var number;

  myimages[1]="../../images/verologo00.png";
  myimages[2]="../../images/verologo01.png";
  myimages[3]="../../images/verologo02.png";
 
  number=1;
     
  function animate(){
      
   
   for(i=1; i<3; i++){ document.image_rotate.src = myimages[number];
     number++;
     if (number > 3) number=1;
   }
    
}

</script>
     <img name="image_rotate" src="../../images/verologo00.png" onLoad="setTimeout('animate()', delay);" alt="verologo" />
             
                    </div><!-- /.logo -->
                     <span class="greeting"><?php echo $greeting; ?></span>
                    <nav class="main-nav">
                        <ul>
							 
							 <li><a class="active" href="?todaypayments">Payment Record</a></li>
							 <li><a class="" href="?correctedpayments">Corrected Payments</a></li>
							 <li><a class="" href="?deletedpayments">Deleted Payments</a></li>
                             <li> <a class="" href="." >Back To Control Panel</a></li>
                             <li><?php include '../logout.inc.html.php';$sn_count = 1; ?></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
            <div class="container">
	<h4><?php echo $header; ?></h4>
    <table class="table table-sm table-striped ">
  <thead>
    <tr>
      <th scope="col">S_NO</th>
	  <th scope="col">Payment Type</th>
	  <th scope="col">Amount Paid</th>
	  <th scope="col">Date</th>
      <th scope="col">Action <a class="" href="?todaypayments" >Back</a> </th>
    </tr>
  </thead>
  <tbody>
      <?php if ( $payments == '' ){ echo '<tr><td>No Record Found</td></tr>'; } else{ foreach ($payments as $payment): ?>
      
    
       <form action="" method="post" >
    <tr>
	  <td><?php htmlout($sn_count); ?></td>
	  <td><?php htmlout($payment['paymenttype']); ?></td>
      <td>&#8358;<?php htmlout(number_format($payment['amount'],2)); ?></td>
	   <td><?php htmlout($payment['date']); ?></td>
      <td> <div class="listuser">
             
              <input type="hidden" name="studentid" value="<?php
                  echo $payment['studentid']; ?>">
				  <input type="hidden" name="id" value="<?php
                  echo $payment['id']; ?>">
				  <input type="hidden" name="payid" value="<?php
                  echo $payment['payid']; ?>">
				  <input type="hidden" name="amount" value="<?php
                  echo $payment['amount']; ?>">
				   <input type="hidden" name="date" value="<?php
                  echo $payment['date']; ?>">
				<input class="btn btn-sm btn-success " type="submit" name="action" value="Correction">
				<input class="btn btn-sm btn-danger " type="submit" name="action" value="Delete Payment">
            </div></td>
     
    
    </tr>
    </form>
      <?php $sn_count++;
	  endforeach; } ?>
  </tbody>
</table>

 </div><!-- Container -->              
        </div><!-- /#wrap -->
      <?php include '../../includes/footer.html.php'?>
        
        
     <script src="../../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="../../js/popover.js"></script>
	<script src="../../js/jquery-3.2.1.slim.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
  
    </body>
</html>