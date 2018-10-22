
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
							 <li><a href="../">Home</a></li>
                             <li> <a class="active" href="." >Control</a></li>
                             <li><a class="" href="?add">New Student </a></li>
							  <li><a class="" href="?terminalreport">Terminal Report </a></li>
                             <li><?php include '../logout.inc.html.php';$sn_count = 1; ?></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
            <div class="container">
              
	<div class="pull-left">
	<h5>Use this button to add subject or class or session or term
	</h5>
	<h5>
	
			<form action="" method="post">
	   <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
			Click to add your preference
			</button>
        <select name="regnumbers"  id="inputState" class="custominput">
          <option value="">Select Reg_No</option>
          <?php foreach ($regnumbers as $regnumber): ?>
            <option value="<?php htmlout($regnumber['name']); ?>"<?php
               if ($regnumber['selected'])
              {
                echo 'selected';
              }
                ?>>
                    <?php htmlout($regnumber['name']); ?></option>
          <?php endforeach; ?>
        </select>
		 <input class="btn btn-sm btn-success " type="submit" name="action" value="Search">
           
        </form>
	</h5>
	</div>
	 <div class="pull-right">
	 <h5>Total Number of Students: <?php htmlout($ntotal); ?> | Male: <?php htmlout($nboys); ?> | Female: <?php htmlout($ngirls); ?>
	</h5>
	   <h5>
	   <form action="" method="post">
	   
        <select name="classes"  id="inputState" class="custominput">
          <option value="">Select Class</option>
          <?php foreach ($classes as $class): ?>
            <option value="<?php htmlout($class['id']); ?>"<?php
               if ($class['selected'])
              {
                echo 'selected';
              }
                ?>>
                    <?php htmlout($class['name']); ?></option>
          <?php endforeach; ?>
        </select>
        
        <select name="sessions"  id="inputState" class="custominput">
          <option value="">Select Session</option>
          <?php foreach ($sessions as $session): ?>
            <option value="<?php htmlout($session['id']); ?>"<?php
               if ($session['selected'])
              {
                echo 'selected';
              }
                ?>>
                    <?php htmlout($session['name']); ?></option>
          <?php endforeach; ?>
        </select>
        
        <select name="terms"  id="irmsnputState" class="custominput">
          <option value="">Select Term</option>
          <?php foreach ($terms as $term): ?>
            <option value="<?php htmlout($term['id']); ?>"<?php
               if ($term['selected'])
              {
                echo 'selected';
              }
                ?>>
                    <?php htmlout($term['name']); ?></option>
          <?php endforeach; ?>
        </select>
	 <input class="btn btn-sm btn-success" id="searchclas" type="submit" name="action"   value="Load Students">
	</form>
      </h5> 
</div>	  
	<div class="row">
        <div class="col-md-6 mb-6">
               
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
       <form action="" method="post" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter your input</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
     
      <input type="text" name="preference" class="form-control" id="validationDefault01" required>
      </div>
      <div class="modal-footer">
       
		<input class="btn btn-sm btn-success " type="submit" name="action" value="AddSubject">
        <input class="btn btn-sm btn-success " type="submit" name="action" value="AddClass">
        <input class="btn btn-sm btn-success " type="submit" name="action" value="AddSession">
        <input class="btn btn-sm btn-success " type="submit" name="action" value="AddTerm">
            </div>
         </div>
        </form>
       </div>
       </div>
     </div>
  </div>
     
    <table class="table table-sm table-striped ">
  <thead>
    <tr>
      <th scope="col">S_NO</th>
	  <th scope="col">Reg_No</th>
	  <th scope="col">Name</th>
	  <th scope="col">Class</th>
	  <th scope="col">Session</th>
	  <th scope="col">Term</th>
	  <th scope="col">Parent Phone</th>
      <th scope="col">Gender</th>
      <th scope="col">Action  
		</th>
    </tr>
  </thead>
  <tbody>
      <?php if ( $students == '' ){ echo '<tr><td>No Record Found</td></tr>'; } else{ foreach ($students as $students): ?>
      
    
       <form action="" method="post" >
    <tr>
	  <td><?php htmlout($sn_count); ?></td>
	  <td><?php htmlout($students['regnumber']); ?></td>
      <td><?php htmlout($students['surname'].' '.$students['firstname'].' '.$students['othername']); ?></td>
      <td><?php htmlout($students['class']); ?></td>
	  <td><?php htmlout($students['session']); ?></td>
	  <td><?php htmlout($students['term']); ?></td>
	  <td><?php htmlout($students['parentphone']); ?></td>
      <td><?php htmlout($students['gender']); ?></td>
      <td> <div class="listuser">
             
              <input type="hidden" name="id" value="<?php
                  echo $students['id']; ?>">
              <input class="btn btn-sm btn-success " type="submit" name="action" value="Update">
              <input class="btn btn-sm btn-primary" id="userdelete" type="submit" name="action"   value="Register Another Term">
			  <input class="btn btn-sm btn-danger" type="submit" name="action" value="See Report">
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