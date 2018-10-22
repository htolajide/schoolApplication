
<!DOCTYPE html>
<html>
    <head>
        <title>Veroyori Homepage</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="css/reset.css" type="text/css" />
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <script src="js/jquery.js"></script> 
         <link rel="icon" href="images/favicon.ico">
        <script type="text/javascript">
            
            var show_width = 1;
            if(show_width == 1){
                $(document).ready(function(){
                    $(window).resize(function(){
                        var screen_width = $(window).width();
                        document.getElementById('screen_width').innerHTML = 'Window Width: ' +screen_width.toString();
                    });   
                });
            }
        </script>
    </head>
    <body>
        <div id="wrap">
            <div id="screen_width"></div>
            <header class="main-header">
                <div class="container">
                   <div class="logo">
  <script language="JavaScript1.2">                   
  
var myimages=new Array();
var delay = 500;
var number;

  myimages[1]="images/verologo00.png";
  myimages[2]="images/verologo01.png";
  myimages[3]="images/verologo02.png";
 
  number=1;
     
  function animate(){
      
   
   for(i=1; i<3; i++){ document.image_rotate.src = myimages[number];
     number++;
     if (number > 3) number=1;
   }
    
}

</script>
     
          
                
             <img name="image_rotate" src="images/verologo00.png" onLoad="setTimeout('animate()', delay);" alt="verologo" />
                    </div><!-- /.logo -->   
                    <nav class="main-nav">
                        <ul>
                            <li><a class="active" href="index.php">Home</a></li>
                            <li><a href="admin">Admin</a></li>
                          <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </nav>
                </div><!-- /.container-->
            </header> 
            <div id="showcase">
                <div class="container">
                    <div class="showcase-right">
                        
                    </div><!-- /.showcase-right-->
                    <div style="color:#000000"class="showcase-left">
                        <h3>Your long search for a perfect school for your wards stop here</h3>
                        <p>Comrade academy is day and boarding school established for excellence . We are poised to receive your wards and give the much required trainning both academic and morally for them to became the crop leader that we can be proud of. We strongly believe that ‘education is life’ which quaranteed the growth and development of our great nation. </p>
                        <br />
                        <a href="#"><img src="images/readmore.png" alt="Rad More" /></a>
                    </div><!-- /.showcase-left-->
                </div><!-- /.container-->
            </div><!-- /#showcase -->
            <div class="container">
                <div class="box3">
                    <img src="images/student.png" alt="Day School" />
                    <h3>Day School</h3>
                    <p>Day school is available for all category of classes</p>
                </div><!-- /.box3-->
                 <div class="box3">
                    <img src="images/hostel.png" alt="Hostel Accomodation" />
                    <h3>Hostel Accommodation</h3>
                    <p>Standard hostel accommodation is available for all category of students</p>
                </div><!-- /.box3-->
                 <div class="box3">
                    <img src="images/holiday.png" alt="Holiday Coachin" />
                    <h3>Holiday Coaching</h3>
                    <p>We also organise holiday coaching for all classes during holidays</p>
                </div><!-- /.box3-->
                <div class="clr"></div>
                <div id="content">
                    
                </div><!-- /.content -->
               
                <div class="clr"></div>
            </div><!-- /.container-->                
        </div><!-- /#wrap -->
        <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
          <?php include 'includes/footer.html.php'?>
    </body>
</html>