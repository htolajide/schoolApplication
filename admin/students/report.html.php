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
		WinPrint.document.write('</head><body onload="print();close();">');
		WinPrint.document.write('<style type="text/css">' +
        'table thead, tbody td {' +
        'border:1px solid #000;' +
        'padding;0.2em;' +
		'font-size: 24px'+
        '}' + 
		'table tfoot {' +
        'padding;0.2em;' +
		'font-size: 24px'+
        '}' + 
		'body {' + 
		'line-height:1.5em;' +
		'font-size: 22px'+
		'}' +
		'table thead, legend, h4 { ' +
		'font-weight: bold' +
		'}' +
		'legend {' +
		'font-size: 32px' +
		'marging-bottom: 5px' +
		'}'+
		'h4 {' +
		'font-size: 38px'+
		'marging-bottom: 5px' +
		'}'+
		'h5 {' +
		'font-size: 38px'+
		'font-weight: bold' +
		'}'+
		'div.result-photo { '+
        'margin: auto 8.0em;'+
		'float: left;'+
		'}'+
		'.report-upper{' +
		'border-top:1px solid #000;' +
		'}'+
		'.report-lower{' +
		'border-top:1px solid #000;' +
		'}'+
        '</style>');
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
			<div class = "report-header">
            <?php  if (count($cart) > 0): ?>
			        <img id="logo" src="../../images/comradelogo.jpg" />
                    <h4> 10, Olaoluwa Street, Oluwo Bus Stop, Opelu, Ijoko Road, Agbado, Ogun State.<br>
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
				<div class="result-photo">
					<img src="<?php if ($photo == ""){htmlout('https://via.placeholder.com/150');}else{ htmlout($photo);} ?>" />
				</div>
                <div class="pull-right">
				  <h5><?php echo 'Reg No: ';
                     htmlout($regnumber); ?></h5>
					  <h5><?php echo 'Term: ';
                     htmlout($term); ?></h5>
				 <h5><?php echo 'Date: '.date('d-m-Y');?></h5>   
               </div>
			   </div>
              <div class="report-upper">
			   <legend>Cognitive Ability</legend>
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
	<td><?php echo round($total/count($cart),2); ?></td>
</tr>
<tr>
<tr>
	<td >Number in Class:</td>
	<td><?php htmlout($numberInClass); ?></td>
	<td colspan=5></td>
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
	   </div>
                <?php else: ?>
			<p>Your report is empty!</p>
		<?php endif; ?>
	<div class = "report-lower">
		<div class = "lower-right">
			<legend>Psychomonous Skills</legend>
		<table class="table table-sm">
  <thead>
    <tr>
      <td scope="col">S/No</td>
	  <td scope="col">Title</td>
	  <td scope="col">A</td>
      <td scope="col">B</td>
	  <td scope="col">C</td>
	  <td scope="col">D</td>
	  <td scope="col">E</td>  
    </tr>
  </thead>
  <tbody>
<?php $sn_count = 1 ?>
   <?php for ($i = 0; $i < count($skills); $i++): ?>
    <tr>
	  <td><?php htmlout($sn_count); ?></td>
	  <input type="hidden"  name = "skills[]" value="<?php htmlout($skills[$i]['id']); ?>" />
      <td><?php htmlout($skills[$i]['title']); ?></td>
      <?php for ($j = 1; $j < 6; $j++): ?>
            <td><input type="checkbox" 
              name="sgrades[]" id=grade<?php echo $j; ?> 
			  value="<?php htmlout($j); ?>" <?php
              if ($j == $sgrades[$i])
              {
                echo 'checked';
              }
              ?>></td> 
			<?php endfor; ?>
	</tr>
  <?php $sn_count++; endfor; ?>
         </tbody>
       </table>
			</div>
			<div class = "lower-left">
					<legend>Affective Disposition </legend>
		<table class="table table-sm table-striped ">
  <thead>
    <tr>
      <td scope="col">S/No</td>
	  <td scope="col">Title</td>
	  <td scope="col">A</td>
      <td scope="col">B</td>
	  <td scope="col">C</td>
	  <td scope="col">D</td>
	  <td scope="col">E</td>  
    </tr>
  </thead>
  <tbody>
   <?php for ($i = 0; $i < count($dispositions); $i++):  ?>
    <tr>
	  <td><?php htmlout($sn_count); ?></td>
	  <input type="hidden" name = "dispositions[]" value="<?php htmlout($dispositions[$i]['id']); ?>" />
      <td><?php htmlout($dispositions[$i]['title']); ?></td>
      <?php for ($j = 1; $j < 6; $j++): ?>
            <td><input type="checkbox" 
              name="dgrades[]" id=grade<?php echo $j; ?> 
			  value="<?php htmlout($j); ?>" <?php
              if ($j == $dgrades[$i])
              {
                echo 'checked';
              }
              ?>></td> 
			<?php endfor; ?>
	</tr>
  <?php $sn_count++; endfor; ?>
         </tbody>
       </table>
			</div>
		</div>
		<div class="report-lower">
			<div class="comment-title">Class Teacher's Comment:</div>
			<div class="comment-sign">Signature & Date:</div>
			<div class="comment-title">Principal's Comment:</div>
			<div class="comment-sign">Signature & Date:</div>
		</div>
		<H4><?php echo date('Y-m-d H:i:s', strtotime('-1 hour'));?></H4>
	</div>	<!-- Print area -->
		<H4><a href=".">Back</a></H4>
	
  </div><!-- Container -->
          
</div><!-- /#wrap -->
      <?php include '../../includes/footer.html.php'?> 
</html>

