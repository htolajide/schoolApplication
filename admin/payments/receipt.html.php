<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Invoice Detail</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css" />
        <link rel="stylesheet" href="../../css/style.css" type="text/css" />
        <link rel="icon" href="../../images/favicon.ico">
        <script language="JavaScript1.2"> 
            function printFunc() {
       var divToPrint = document.getElementById('printarea');
       var htmlToPrint = '' +
        '<style type="text/css">' +
        'table thead, table tfoot td, table tr {' +
        'border:1px solid #000;' +
        'padding;0.2em;' +
        '}' +
        'table thead th  {' +
        'border-top:1px solid #000;' +
        'border-bottom:1px solid #000;' +
        'padding;0.2em;' +
        '}' +
        '.pull-right {' +
        ' float:right;' +
        '}' +
        '.pull-left {' +
        ' float:left;' +
        '}' +
        'H5 {' +
        ' margin-top:0.2em;' +
		' margin-bottom:0.2em;' +
        '}' +
        'H4 {' +
        ' text-align:center;' +
        ' margin-top:0.2em;' +
		' margin-bottom:0.2em;' +
        '}' +    
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    //newWin.document.write("<h3 align='center'>Print Page</h3>");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
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
                       <ul> 
							<li><a class="active" href="#">Student Receipt</a></li>
                            <li><a href=".">Back To Control Panel</a></li>
							<li><a href="<?php echo $back; ?>">Back</a></li>
                            <li><input type='button' class='btn btn-primary' id="btn" value='Print' onclick='printFunc();'></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
            <div class="container">
            
        <div id='printarea'>  
            <?php if (count($cart) > 0): ?>
			
                    <h4>Comrade Academy, Agbado, Ogun State <br>08062247210, 08162082226.</h4>
					<h4>Student Official Receipt</h4>
               <div class="pull-left">
                     <h5><?php
                    echo ' Student Name: ';
                    htmlout($surname.' '.$firstname);?><br>
                    <?php echo ' Secretary: ';
                     htmlout($_SESSION['teacher']); ?><br>
					 <?php echo ' Class: ';
                     htmlout($class); ?></h5>   
                </div>
                <div class="pull-right">
				  <h5><?php echo 'Reg No: ';
                     htmlout($regnumber); ?><br>
					  <?php echo ' Term: ';
                     htmlout($term); ?><br>
				 <?php echo 'Date: '.$date; ?></h5>  
               </div>
               
               <table class="table table-sm table-striped ">
  <thead>
    <tr>
      <th scope="col">Description</th>
      <th scope="col">Amount Due(&#8358;)</th>
	  <th scope="col">Amount Paid(&#8358;)</th>
	  <th scope="col">Balance(&#8358;)</th>
    </tr>
  </thead>
  <tfoot>
<tr>
<td colspan=2> Total Paid:</td>
<td>&#8358;<?php echo number_format($total,2); ?></td>
<td></td>
</tr>
</tfoot>
  <tbody>
      <?php for($i=0; $i<count($cart); $i++): ?>
      <tr>
      <td><?php htmlout($cart[$i]['description']); ?></td>
      <td><?php htmlout($cart[$i]['amountdue']); ?></td>
	  <td><?php htmlout($cart[$i]['amountpaid']); ?></td>
	  <td><?php htmlout($balance[$i]); ?></td>
	</tr>
      <?php  endfor; ?>
         </tbody>
       </table>
                <?php else: ?>
			<p>Your receipt is empty!</p>
		<?php endif; ?>
		<H4><?php echo date('Y-m-d H:i:s', strtotime('-1 hour'));?></H4>
	</div>	<!-- Print area -->
		
	
  </div><!-- Container -->
          
</div><!-- /#wrap -->
      
</html>

