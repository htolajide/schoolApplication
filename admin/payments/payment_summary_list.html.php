<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Payment Summary</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css" />
        <link rel="stylesheet" href="../../css/style.css" type="text/css" />
        <link rel="icon" href="../../images/favicon.ico">
        <script language="JavaScript1.2"> 
            function printFunc() {
		var prtContent = document.getElementById('printarea');
		var WinPrint = window.open('');
		WinPrint.document.write('<html><head>');
		WinPrint.document.write('<link href="../../css/bootstrap.min.css" rel="stylesheet">');
		WinPrint.document.write('<link rel="stylesheet" href="../../css/style.css" type="text/css" />');
		WinPrint.document.write(' <link rel="stylesheet" href="../../css/reset.css" type="text/css" />');
		WinPrint.document.write('<style type="text/css">' +
        'table thead td, table td {' +
        'border:1px solid #000;' +
        'padding;0.2em;' +
        '}' +
        '</style>');
		WinPrint.document.write('</head><body onload="print();close();">');
		WinPrint.document.write(prtContent.innerHTML);
		WinPrint.document.write('</body></html>');
		WinPrint.document.close();
		WinPrint.focus();
    }
        </script>

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
             
                    </div><!-- /.logo-->
                    <nav class="main-nav">
                       <ul> <li><a class="active" href=".">Payment Summary</a></li>
							<li><a href=".">Back To Control Panel</a></li>
                            <li><input type='button' class='btn btn-primary' id="btn" value='Print' onclick='printFunc();'></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
            <div class="container">
            
        <div id='printarea'>  
            <?php  $sn_count = 1;  if (count($payments) > 0): ?>
			
                    <h4>Comrade Academy<br>
                    10, Olaoluwa Street, Oluwo Bus Stop, Opelu, Ijoko Road, Agbado, Ogun State<br>
					08062247210, 08162082226</h4>
					<h4>List of Students Payment Summary</h4>
				<div class="pull-left">
                     <h5><?php
                    echo 'Class: ';
                    htmlout($class);?></h5>
                    <h5><?php echo 'Term: ';
                     htmlout($term); ?></h5>
						</h5>
                </div>
                <div class="pull-right">
					<h5><?php echo 'Session: ';
                     htmlout($session); ?></h5>
					  <h5><?php echo 'Number of students: ';
                     htmlout($ntotal); ?></h5>				 
               </div>
               
               <table class="table table-sm table-striped ">
  <thead>
    <tr>
      <td scope="col">S/No</td>
	  <td scope="col">Student No</td>
	  <td scope="col">Student Name</td>
	  <td scope="col">Date</td>
      <td scope="col">Amount Due(&#8358;)</td>
	  <td scope="col">Amount Paid(&#8358;)</td>
	  <td scope="col">Balance(&#8358;)</td>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($payments as $payment): ?>
 
    <tr>
	  <td><?php htmlout($sn_count); ?></td>
      <td><?php htmlout($payment['regnumber']); ?></td>
      <td><?php htmlout($payment['surname'].' '.$payment['firstname'].' '.$payment['othername']); ?></td>
	  <td><?php htmlout($payment['date']); ?></td>
      <td><?php htmlout(number_format($amountdue,2)); ?></td>
      <td><?php htmlout(number_format($payment['amountpaid'],2)); ?></td>
	  <td><?php htmlout(number_format($amountdue - $payment['amountpaid'],2)); ?></td>
	</tr>
  
      <?php $sn_count++; endforeach; ?>
         </tbody>
       </table>
                <?php else: ?>
			<p>Your list is empty!</p>
		<?php endif; ?>
		<H4><?php echo date('Y-m-d H:i:s');?></H4>
	</div>	<!-- Print area -->
		<H4><a href=".">Back</a></H4>
	
  </div><!-- Container -->
          
</div><!-- /#wrap -->
      <?php include '../../includes/footer.html.php'?> 
</html>

