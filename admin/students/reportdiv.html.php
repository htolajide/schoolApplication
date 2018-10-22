			<div id="repot">
            <?php  if (count($cart) > 0): ?>
			
                    <h4>Comrade Academy<br>
                    10, Olaoluwa Street, Oluwo Bus Stop, Opelu, Ijoko Road, Agbado, Ogun State.<br>
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
				 <h5><?php echo 'Date: '.$date; ?></h5>
                  
                   
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
<td>
	<?php 
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
	?>
</td>
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
		</div>
	<br><br><br><br><br><br>