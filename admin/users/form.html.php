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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
         <a href="."><img src="../../images/back.png" alt="backicon" /></a>
         <ul>
             <li> <?php htmlout($pageHeading); ?></li>
         </ul>
      
        </div>
        
           
    <div class="container border border-secondary rounded">
		
        <div class="showcase-left">
                        
    <form action=?<?php htmlout($action); ?> method="post" >
    <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault01">Name:</label>
      <input type="text" name="name" class="form-control" id="validationDefault01" placeholder="Name"  value="<?php htmlout($name); ?>" required>
    </div>
    <div class="col-md-6 mb-6">
      <label for="validationDefault02">Phone Number:</label>
      <input type="text" name="phone" class="form-control" id="validationDefault02" placeholder="Phone Number" value="<?php htmlout($phone); ?>" required>
    </div>
  </div>
    <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault03">Email:</label>
      <input type="text" name="email" class="form-control" id="validationDefault03" placeholder="Email"  value="<?php htmlout($email); ?>" required>
      <div class="invalid-feedback">
        Please provide a valid email
      </div>
    </div>
    <div class="col-md-6 mb-6">
      <label for="validationDefault04">Password:</label>
      <input type="password" name="password" class="form-control" id="validationDefault04" placeholder="password"  required>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-6">
      <label for="validationDefault05">Address:</label>
      <input type="text" name="address" class="form-control" id="validationDefault05" placeholder="Address" value="<?php htmlout($address); ?>"  required>
      <div class="invalid-feedback">
        Please provide a valid address
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
	<div class="col-md-6 mb-6">
      <label for="validationDefault07">Date:</label>
      <input type="text" name="date" class="form-control" id="validationDefault07" value="<?php htmlout($date); ?>" placeholder="Date" >
    </div>
      </div>
	  <div class="row">
	   <div class="col-md-6 mb-6">
	  
	    </div>
	  <div class="col-md-6 mb-6">
	   <input class="btn btn-success form-control md-6" type="submit" value="<?php htmlout($button); ?>">
	    </div>
	  </div>
    </div><!-- /.showcase-left-->
	<div class="showcase-right">
			

         <legend>Roles:</legend>
        <?php for ($i = 0; $i < count($roles); $i++): ?>
          <div>
            <label for=role<?php echo $i; ?>  ><input type="checkbox" 
              name="roles[]" id=role<?php echo $i; ?>
              value="<?php htmlout($roles[$i]['id']); ?>"<?php
              if ($roles[$i]['selected'])
              {
                echo ' checked';
              }
              ?>><?php htmlout(' '.$roles[$i]['id']); ?></label>
              
                <?php htmlout(' : '.$roles[$i]['description']); ?>
             
          </div>
        <?php endfor; ?>
         </div>
      </fieldset>
        
      
         <div>
        <input type="hidden" name="id" value="<?php
            htmlout($id); ?>">
 

     </div>
   </form>
                   
		</div><!-- /.showcase-right-->
               
                <div class="clr"></div>
    
 </div><!-- Container -->              
        </div><!-- /#wrap -->
      <?php include '../../includes/footer.html.php'?>
        
         <script src="../../js/ie10-viewport-bug-workaround.js"></script>
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
</html>

   