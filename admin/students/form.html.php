<?php include_once '../../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Users</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="../../css/reset.css" type="text/css" />
        <link rel="stylesheet" href="../../css/style.css" type="text/css" />
          <link rel="stylesheet" href="../../css/zebra_datepicker.min.css" type="text/css" />
         <link rel="icon" href="../../images/favicon.ico">
         

    <title><?php htmlout($pageTitle); ?></title>


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
	<script src="../../js/webcam.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    
    <link href="../../css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../js/ie-emulation-modes-warning.js"></script>
     <script src="../../js/zebra_datepicker.min.js"></script>

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
							<li><a class="active" href="#"><?php htmlout($pageTitle); ?></a></li>
							<li><a class="" href=".">Back to Control Panel</a></li>
                            <li><?php include '../logout.inc.html.php'; ?></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
			<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
				<?php htmlout($pageHeading); ?>
			</div>
    <div class="container">
		
    <div class="showcase-left">
	<div class="upper-content">
      <legend>Student Info </legend> 
		<div class="content">
    <form action=?<?php htmlout($action); ?> method="post" >
    <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault01">Surname:</label>
      <input type="text" name="surname" class="form-control" id="validationDefault01" placeholder="Surname"  value="<?php htmlout($surname); ?>" required>
    </div>
    <div class="col-md-6 mb-6">
      <label for="validationDefault02">Firstname:</label>
      <input type="text" name="firstname" class="form-control" id="validationDefault02" placeholder="Firstname" value="<?php htmlout($firstname); ?>" required>
    </div>
  </div>
    <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault03">Other Names:</label>
      <input type="text" name="othername" class="form-control" id="validationDefault03" placeholder="Other name"  value="<?php htmlout($othername); ?>" >
    </div>
    <div class="col-md-6 mb-6">
      <label for="validationDefault04">Reg Number:</label>
      <input type="text" name="regnumber" class="form-control" id="validationDefault04" placeholder="Reg Number" value="<?php htmlout($regnumber); ?>"  required>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault05">Parent Phone:</label>
      <input type="text" name="parentphone" class="form-control" id="validationDefault05" placeholder="Parent Phone" value="<?php htmlout($parentphone); ?>"  required>
      <div class="invalid-feedback">
        Please provide a valid phone number
      </div>
    </div>
    <div class="col-md-6 mb-6">
      <label for="validationDefault06">Gender:</label>
     
    <select name ="gender"id="inputState" class="form-control md-6" value="<?php htmlout($gender); ?>" required>
    <option value="Male"<?php if ($gender == 'Male') echo 'selected = "selected"'; ?>>Male</option>
    <option value="Female"<?php if ($gender == 'Female') echo 'selected = "selected"'; ?>>Female</option>
    
    </select> 
    </div>
  </div>
   <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault07">Date of Birth:</label>
      <input type="text" name="dob" class="form-control" id="validationDefault07" value="<?php htmlout($dob); ?>" placeholder="YYYY-MM-DD" >
    </div>
    <div class="col-md-6 mb-6">
	   <label for="class">Class:</label>
	   
        <select name="classes"  id="inputState" class="form-control md-3">
          <option value="">Select one</option>
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
        
    </div>
      </div>
	   <div class="row">
    <div class="col-md-6 mb-6">
    <label for="session">Session:</label>
        <select name="sessions"  id="inputState" class="form-control md-3">
          <option value="">Select one</option>
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
        
    </div>
    <div class="col-md-6 mb-6">
	 <label for="term">Term:</label>
        <select name="terms"  id="irmsnputState" class="form-control md-3">
          <option value="">Select one</option>
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
        
    </div>
      </div>
  <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault07">Date:</label>
      <input type="text" name="date" class="form-control" id="validationDefault07" value="<?php htmlout($date); ?>" placeholder="YYYY-MM-DD" >
    </div>
    <div class="col-md-6 mb-6">
	 <label for="validationDefault09">Press:</label>
         <input class="btn btn-success form-control md-6" type="submit" value="<?php htmlout($button);  $sn_count=1; ?>">
    </div>
   </div>
   </div>
   </div>
   <div class="lower-content">
		<legend>Affective Disposition </legend>
		<div class="content">
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
    </div><!-- /.showcase-left-->
	<div class="showcase-right">
	<div class="upper-content">
	<legend>Photo & Subjects </legend>
	<div class="content">
	<div class="student-photo">
    <img src="<?php if ($image == ""){htmlout('https://via.placeholder.com/150');}else{ htmlout($image);} ?>" />
    </div> 
	<button type="button" class="btn btn-secondary btn-sm" id="photo-btn" data-toggle="modal" data-target="#exampleModal">
			Capture Student Photo
	</button>
		
		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Capture Student Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
            </div>
            <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
		<input type=button id="capture-btn" class="btn btn-secondary btn-sm" value="Take Snapshot" onClick="take_snapshot()">
         <input type="hidden" name="image" value="<?php htmlout($image); ?>" class="image-tag"> 
      </div>
         </div>
       </div>
       </div>
         <legend>Subjects: 1st Test:  2nd Test:  Exam: </legend>
		 <div class="content">
        <?php for ($i = 0; $i < count($subjects); $i++): ?>
            <label for=role<?php echo $i; ?>  ><input type="checkbox" 
              name="subjects[]" id=subject<?php echo $i; ?>
              value="<?php htmlout($subjects[$i]['id']); ?>"<?php
              if ($subjects[$i]['selected'])
              {
                echo ' checked';
              }
              ?>></label>
                <?php htmlout(' '.$subjects[$i]['name']); ?>
		<input type="number" class="customtest1" name="test1s[]" value="<?php htmlout($test1s[$i]); ?>">
		<input type="number" class="customtest2" name="test2s[]" value="<?php htmlout($test2s[$i]); ?>">
		<input type="number" class="customscore" name="scores[]" value="<?php htmlout($scores[$i]); ?>">
        <?php endfor; ?>
		</div>
      </fieldset>
	   </div>
	   </div>
	   <div class="lower-content">
		<legend>Psychomonous Skills</legend>
		<div class="content">
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
	</div> 
   </div>	
		<input type="hidden" name="id" value="<?php
            htmlout($id); ?>">
	</form>
                   
	</div><!-- /.showcase-right-->
               
                <div class="clr">
				</div>
    
	</div><!-- BodyContainer -->              
    </div><!-- /#wrap -->
      <?php include '../../includes/footer.html.php'?>
        <!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 450,
        height: 300,
        image_format: 'jpeg',
        jpeg_quality: 120
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
         <script src="../../js/ie10-viewport-bug-workaround.js"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="../../js/popover.js"></script>
	<script src="../../js/jquery-3.2.1.slim.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>
    </body>
</html>

   