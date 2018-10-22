<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Report Detail</title>
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
                       <ul> <li><a class="active" href=".">Student Report</a></li>
							<li><a href=".">Back To Control Panel</a></li>
                            <li><input type='button' class='btn btn-primary' id="btn" value='Print' onclick='printFunc();'></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
            <div class="container">
            
        <div id='printarea'>  
            <?php  if (count($cart) > 0): ?>
			
                    <h4>Comrade Academy<br>
                    10, Olaoluwa Street, Oluwo Bus Stop, Opelu, Ijoko Road, Agbado, Ogun State<br>
					08062247210, 08162082226</h4>
					<h4>Report Sheet For <?php htmlout($term.' '.$session); ?> Session</h4>
               <div class="pull-left">
                     <h5><?php
                    echo 'Name: ';
                    htmlout($surname.' '.$firstname.' '.$othername);?></h5>
                    <h5><?php echo 'Class Teacher: ';
                     htmlout($_SESSION['teacher']); ?></h5>
					  <h5><?php echo 'Class: ';
                     htmlout($class); ?></h5>
                    
                </div>
                <div class="pull-right">
				  <h5><?php echo 'Reg No: ';
                     htmlout($regnumber); ?></h5>
					  <h5><?php echo 'Term: ';
                     htmlout($term); ?></h5>
				 <h5><?php
				  $today=new DateTime;
                    echo 'Date: '.$date; ?></h5>
                  
                   
               </div>
               
               <table class="table table-sm table-striped ">
  <thead>
    <tr>
      <th colspan=5>Subject</th>
      <th scope="col">1st Test(20)</th>
	  <th scope="col">2nd Test(20)</th>
	  <th scope="col">Exam(60)</th>
	  <th scope="col">Total</th>
	 
	  
    </tr>
  </thead>
  <tfoot>
<tr>
<td>overall Total:</td>
<td colspan=7 ></td>
<td><?php echo $total; ?></td>
</tr>
<tr>
<td colspan=7 >Average:</td>
<td></td>
<td><?php echo $total/count($cart); ?></td>
</tr>
<tr>
<tr>
<td colspan=5>Number in Class:</td>
<td></td>
<td><?php htmlout($numberInClass); ?></td>
<td>Position:</td>
<td><?php 
	if($position==0){
		htmlout('No Position Yet');
	}else{
    if(($position>3 && $position<20) || $position{strlen($position)-2} == 1){
      //return nstring + "th";
	  htmlout($position. "th");
    }
    else if($position==1 || $position{strlen($position)-1} == 1){
      //return nstring + "st";
	  htmlout($position. "st");
    }
    else if($position==2 || $position{strlen($position)-1} == 2){
      //return nstring + "nd";
	  htmlout($position. "nd");
    }
    else if($position==3 || $position{strlen($position)-1} == 3){
      //return nstring + "rd";
	  htmlout($position. "rd");
    }
    else{
       //return nstring + "th";
	   htmlout($position. "th");
    }
	}
	?></td>
</tr>
<tr>
<td colspan=2>Class Teacher's Comment:</td>
<td colspan=5 ></td>
<td>Sign:</td>
<td></td>
</tr>
<tr>
<td colspan=2>Principal's Comment:</td>
<td colspan=5 ></td>
<td>Sign:</td>
<td></td>
</tr>

</tfoot>
  <tbody>
      <?php foreach ($cart as $report): ?>
 
      <tr>
      <td colspan=5><?php htmlout($report['subject']); ?></td>
      <td><?php htmlout($report['test1']); ?></td>
      <td><?php htmlout($report['test2']); ?></td>
      <td><?php htmlout($report['score']); ?></td>
	  <td><?php htmlout($report['total']); ?></td>
	 
	</tr>
  
      <?php endforeach; ?>
         </tbody>
       </table>
                <?php else: ?>
			<p>Your report is empty!</p>
		<?php endif; ?>
		<H4><?php echo date('Y-m-d H:i:s', strtotime('-1 hour'));?></H4>
	</div>	<!-- Print area -->
		<H4><a href=".">Back</a></H4>
	
  </div><!-- Container -->
          
</div><!-- /#wrap -->
      <?php include '../../includes/footer.html.php'?> 
</html>

