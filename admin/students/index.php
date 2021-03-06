<?php           
error_reporting( E_ALL );
ini_set( "display_errors", 1 );
include_once '../../includes/magicquotes.inc.php';
require_once  '../../includes/access.inc.php';

if (!userIsLoggedIn())
{
  include '../login.html.php';
  exit();
}

if (!userHasRole('Class Teacher'))
{
  $error = 'Only Class Teacher can Access this Page.';
  include '../accessdenied.html.php';
  unset($_SESSION['loggedIn']);
  unset($_SESSION['email']);
  unset($_SESSION['password']);
  unset($_SESSION['name']);
   exit(); 
}

try
  {
    include '../../includes/db.inc.php';
    $sql = 'SELECT name, classid FROM users
        WHERE email = :email AND password = :password';
    $s = $pdo->prepare($sql);
    $s->bindValue(':email', $_SESSION['email']);
    $s->bindValue(':password', $_SESSION['password']);
    $s->execute();
    $row = $s->fetch();
  }
  catch (PDOException $e)
  {
		$error = 'Error searching for user name.';
		include 'error.html.php';
		exit();
  }
  $_SESSION['teacher'] = $row['name'];
  $_SESSION['class'] = $row['classid'];
		$welcome = 'Hi';
			if (date("H") <= 12) {
				$welcome = 'Good Morning';
			} else if (date('H') > 12 && date("H") < 18) {
				$welcome = 'Good Afternoon';
				} else if(date('H') > 17) {
					$welcome = 'Good Evening';
					}
				$greeting = $welcome.', '.explode(" ", $_SESSION['teacher'])[0];			
// add class
if (isset($_POST['action']) and $_POST['action'] == 'Add Class')
{
  $action = ''; 
  include '../../includes/db.inc.php';

  // check for class existence
	$sql= 'Select name from class';
    $s = $pdo->prepare($sql);
    
    if ($s->execute()){
        foreach ($s as $row){
            $name = $row['name'];
			
			if($name == $_POST['preference'] ){
			$error = 'Class Already Exist.';
			include 'error.html.php';
			exit();	
			}    
        } 	
    } 
  try
  {
    $sql = 'INSERT INTO class set name=:name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['preference']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding class.';
    include 'error.html.php';
    exit();
  }
   $message= 'Class Addition successful';
  $link='.';
  include 'success.html.php';
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Add Subject')
{
  $action = ''; 
  include '../../includes/db.inc.php';

  // check for class existence
	$sql= 'Select name from subject';
    $s = $pdo->prepare($sql);
    if ($s->execute()){
        foreach ($s as $row){
            $name = $row['name'];
			if($name == $_POST['preference'] ){
			$error = 'Subject Already Exist.';
			include 'error.html.php';
			exit();	
			}
        } 
		
    } 
  try
  {
    $sql = 'INSERT INTO subject set name=:name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['preference']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding class.';
    include 'error.html.php';
    exit();
  }
  $message= 'Suject Addition successful';
  $link='.';
  include 'success.html.php';
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Add Session')
{
    $action = '';
    include '../../includes/db.inc.php';
	$sql= 'Select name from session';
    $s = $pdo->prepare($sql);
    if ($s->execute()){
        foreach ($s as $row){
            $name = $row['name'];
			
			if($name == $_POST['preference'] ){
			$error = 'Session Already Exist.';
			include 'error.html.php';
			exit();
			}
        } 
	} 
  try
  {
    $sql = 'INSERT INTO session set name=:name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['preference']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error Asdding Sesion.'.$e;
    include 'error.html.php';
    exit();
  }
  $message= 'Session Addition successful';
  $link='.';
  include 'success.html.php';
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Add Term')
{ 
  $action = '';
  include '../../includes/db.inc.php';
  // add category
  $sql= 'Select name from term';
    $s = $pdo->prepare($sql);
    if ($s->execute()){
        foreach ($s as $row){
            $name = $row['name'];
			if($name == $_POST['preference'] ){
			$error = 'Term Already Exist.';
			include 'error.html.php';
			exit();
			}    
        } 	
	} 
  try
  {
    $sql = 'INSERT INTO term set name=:name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['preference']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding term.';
    include 'error.html.php';
    exit();
  }
  $message= 'Term Addition successful';
  $link='.';
  include 'success.html.php';
  exit();
}

// add disposition
if (isset($_POST['action']) and $_POST['action'] == 'Add Disposition')
{
    $action = '';
    include '../../includes/db.inc.php';
	$sql= 'Select title from disposition';
    $s = $pdo->prepare($sql);
    if ($s->execute()){
        foreach ($s as $row){
            $title = $row['title'];
			
			if($title == $_POST['preference'] ){
			$error = 'Disposition Already Exist.';
			include 'error.html.php';
			exit();
			}
        } 
	} 
  try
  {
    $sql = 'INSERT INTO disposition set title=:title';
    $s = $pdo->prepare($sql);
    $s->bindValue(':title', $_POST['preference']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error Adding Disposition.'.$e;
    include 'error.html.php';
    exit();
  }
  $message= 'Disposition Addition successful';
  $link='.';
  include 'success.html.php';
  exit();
}
// add skill
if (isset($_POST['action']) and $_POST['action'] == 'Add Skill')
{
    $action = '';
    include '../../includes/db.inc.php';
	$sql= 'Select title from skill';
    $s = $pdo->prepare($sql);
    if ($s->execute()){
        foreach ($s as $row){
            $title = $row['title'];
			
			if($title == $_POST['preference'] ){
			$error = 'Skill Already Exist.';
			include 'error.html.php';
			exit();
			}
        } 
	} 
  try
  {
    $sql = 'INSERT INTO skill SET title=:title';
    $s = $pdo->prepare($sql);
    $s->bindValue(':title', $_POST['preference']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error Adding Skill.'.$e;
    include 'error.html.php';
    exit();
  }
  $message= 'Skill Addition successful';
  $link='.';
  include 'success.html.php';
  exit();
}

// register new student
if (isset($_GET['add']))
{
  include '../../includes/db.inc.php';
  $pageTitle = 'Add New Student';
  $pageHeading ='Enter Student Information and Press Register to Submit';
  $action = 'addform';
  $surname = '';
  $firstname = '';
  $othername = '';
  $regnumber = '';
  $parentphone = '';
  $classid = '';
  $gender = '';
  $dob = '';
  $sessionid = '';
  $termid = '';
  $date = '';
  $id = '';
  $button = 'Register';
  $scores=0;
  $test1s=0;
  $test2s=0;
  $dgrades = 0; //dispositions grades
  $sgrades = 0; //skills grades

  // Build the list of class
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of class.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => FALSE);
  }
  // Build the list of subject
  try
  {
    $result = $pdo->query('SELECT id, name FROM subject order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of subject.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $subjects[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => FALSE);
  }
  
  // Build the list of session
  try
  {
    $result = $pdo->query('SELECT id, name FROM session order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of session.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $sessions[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => FALSE);
  }
  
  // Build the list of term
  try
  {
    $result = $pdo->query('SELECT id, name FROM term order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $terms[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => FALSE);
  }
  
  // Build the list of disposition
  try
  {
    $result = $pdo->query('SELECT id, title FROM disposition order by title');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of disposition.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $dispositions[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => FALSE);
  }
  
  // Build the list of skills
  try
  {
    $result = $pdo->query('SELECT id, title FROM skill order by title');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of skill.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $skills[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => FALSE);
  }
  
  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include '../../includes/db.inc.php';

  try
  {
	  // student image/photo to register
	 $img = $_POST['image'];
    $folderPath = "upload/";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
  
    //echo $file;
    $sql = 'INSERT INTO student SET
        surname = :surname,
		firstname = :firstname,
		othername = :othername,
        parentphone = :parentphone,
		regnumber = :regnumber,
        dob = :dob,
        gender = :gender,
        date = CURDATE(),
		image = :image
        classid = :classid,
		sessionid = :sessionid,
		termid = :termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':surname', $_POST['surname']);
	$s->bindValue(':firstname', $_POST['firstname']);
	$s->bindValue(':othername', $_POST['othername']);
    $s->bindValue(':parentphone', $_POST['parentphone']);
    $s->bindValue(':regnumber', $_POST['regnumber']);
    $s->bindValue(':gender', $_POST['gender']);
    $s->bindValue(':dob', $_POST['dob']);
	$s->bindValue(':image', $file);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':sessionid', $_POST['sessions']);
	$s->bindValue(':termid', $_POST['terms']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error Adding User '.$e;
    include 'error.html.php';
    exit();
  }

  $studentid = $pdo->lastInsertId();
  if (isset($_POST['subjects']) && isset($_POST['score']))
  {
     for ( $i=0; $i < count($_POST['subjects']); $i++)
    {
      try
      {
        $sql = 'INSERT INTO studentsubject SET
           studentid = :studentid,
		   regnumber = :regnumber,
           subjectid = :subjectid,
		   classid = :classid,
		   sessionid = :sessionid,
		   test1 = :test1,
		   test2 = :test2,
		   score = :score,
		   termid = :termid,
		   date = CURDATE()';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid', $studentid);
		   $s->bindValue(':regnumber',  $_POST['regnumber']);
		   $s->bindValue(':subjectid', $subject);
		   $s->bindValue(':classid',  $_POST['classes']);
		   $s->bindValue(':sessionid', $_POST['sessions']);
		   $s->bindValue(':termid', $_POST['terms']);
		   $s->bindValue(':test1', $_POST['test1s'][$i]);
		   $s->bindValue(':test2', $_POST['test2s'][$i]);
		   $s->bindValue(':score', $_POST['scores'][$i]);
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning selected subjects to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
  }
  
 // assign disposition grades
 if (isset($_POST['dispositions']))
  {
     for ( $i=0; $i < count($_POST['dispositions']); $i++)
    {
      try
      {
        $sql = 'INSERT INTO studentdisposition SET
           studentid = :studentid,
		   dispositionid = :dispositionid,
		   grade = :termid';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid', $studentid);
		   $s->bindValue(':dispositionid',  $_POST['dispositions'][$i]);
		   $s->bindValue(':dgrades', $_POST['dgrades'][$i]);
		   
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning disposition grade to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
 
 } 
 
 // assign skill grades
 if (isset($_POST['skills']))
  {
     for ( $i=0; $i < count($_POST['skills']); $i++)
    {
      try
      {
        $sql = 'INSERT INTO studentskill SET
           studentid = :studentid,
		   skillid = :skillid,
		   grade = :termid';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid', $studentid);
		   $s->bindValue(':skillid',  $_POST['skills'][$i]);
		   $s->bindValue(':sgrades', $_POST['sgrades'][$i]);
		   
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning skill grade to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
 
 } 
  //header('Location: .');
  $message = 'Student Registered Successfully';
  $link = '.';
  include 'success.html.php';
  exit();
  }
 
  if (isset($_POST['action']) and $_POST['action'] == 'Update'){ 
  
  include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, parentphone, gender, dob, date, image, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit(); }
  $row = $s->fetch();
  $pageTitle = 'Update Student Information';
  $pageHeading ='Make Your Change(s) and Press Update to Submit ';
  $action = 'updateform';
  $surname = $row['surname'];
  $firstname = $row['firstname'];
  $othername = $row['othername'];
  $parentphone = $row['parentphone'];
  $regnumber = $row['regnumber'];
  $classid = $row['classid'];
  $gender = $row['gender'];
  $date = $row['date'];
  $image = $row['image'];
  $dob = $row['dob'];
  $sessionid = $row['sessionid'];
  $termid = $row['termid'];
  $id = $row['id'];
  $button = 'Update';
  
  // Get list of subject and score assigned to this student
  try { 
  $sql = 'SELECT subjectid, score, test1, test2 FROM studentsubject WHERE studentid = :id and classid=:classid and sessionid=:sessionid and termid=:termid';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $id);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $selectedSubjects = array();
  $scores = array();
  $test1s = array();
  $test2s = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$selectedSubjects[] = $row['subjectid'];
			$scores[] = $row['score'];
			$test1s[] = $row['test1'];
	        $test2s[] = $row['test2'];
			$show = 1;
	  }
	  if($show == 0 ){
	  $scores=0;
	  $test1s=0;
	  $test2s=0;
	  }
	} 
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned subjects.';
  include 'error.html.php';
  exit();
  }
 
  // Get list of disposition and grade assigned to this student
  try { 
  $sql = 'SELECT dispositionid, grade  FROM studentdisposition WHERE studentid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $id);
  $assigneddispositions = array();
  $dgrades = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$assigneddispositions[] = $row['dispositionid'];
			$dgrades[] = $row['grade'];
			$show = 1;
	 }
	 if($show == 0 ){
	  $dgrades = 0;
	  }
	}
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned disposition grade.';
  include 'error.html.php';
  exit();
  }
  // Get list of skill and grade assigned to this student
  try { 
  $sql = 'SELECT skillid, grade  FROM studentskill WHERE studentid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $id);
  $assignedskills = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$assignedskills[] = $row['skillid'];
			$sgrades[] = $row['grade'];
			$show = 1;
	 }
	 if($show == 0 ){
	  $sgrades = 0;
	  }
	}
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned disposition grade.';
  include 'error.html.php';
  exit();
  }
// Build the list of all subjects
  try {  
	   
	   $result = $pdo->query('SELECT id, name FROM subject');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of sujects.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $subjects[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSubjects));
  }
  
  // Build the list of all dispositions
  try {  
	   
	   $result = $pdo->query('SELECT id, title FROM disposition');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of dispositions.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $dispositions[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => in_array($row['id'], $assigneddispositions));
  }
  
  // Build the list of all skills
  try {  
	   
	   $result = $pdo->query('SELECT id, title FROM skill');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of dispositions.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $skills[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => in_array($row['id'], $assignedskills));
  }

// Get list of class assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM class WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $classid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of assigned class.';
    include 'error.html.php';
    exit();
  }
  
  $selectedClass = array();
  foreach ($s as $row)
  {
    $selectedClass[] = $row['id'];
  }

// Build the list of all class
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of classes.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedClass));
  }

  // Get list of session assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM session WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $sessionid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned session.';
    include 'error.html.php';
    exit();
  }
  
  $selectedSession = array();
  foreach ($s as $row)
  {
    $selectedSession[] = $row['id'];
  }

// Build the list of all Session
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM session order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of session.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $sessions[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSession));
  }

  // Get list of term assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM term WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $termid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned term.';
    include 'error.html.php';
    exit();
  }
  
  $selectedTerm = array();
  foreach ($s as $row)
  {
    $selectedTerm[] = $row['id'];
  }

// Build the list of all term
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM term order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $terms[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedTerm));
  }

 include 'form.html.php';
  exit();
}

if (isset($_GET['updateform']))
{
  include '../../includes/db.inc.php';
	
  try
  {
	  // check for student image/photo to register
	$img = $_POST['image'];
	//echo $img;
	$photopath = substr($img,0,7);
	//echo $photopath;
    $folderPath = "upload/";
	if ($photopath == $folderPath){
		$file = $img;
	}else{
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
	}
	//echo $file;
    //print_r($fileName);
    $sql = 'UPDATE student SET
        surname = :surname,
		firstname = :firstname,
		othername = :othername,
        parentphone = :parentphone,
		regnumber = :regnumber,
        dob = :dob,
		image = :image,
        gender = :gender,
        classid = :classid,
		sessionid = :sessionid,
		termid = :termid
		WHERE id =:id';
    $s = $pdo->prepare($sql);
	$s->bindValue(':id', $_POST['id']);
    $s->bindValue(':surname', $_POST['surname']);
	$s->bindValue(':firstname', $_POST['firstname']);
	$s->bindValue(':othername', $_POST['othername']);
    $s->bindValue(':parentphone', $_POST['parentphone']);
    $s->bindValue(':regnumber', $_POST['regnumber']);
    $s->bindValue(':gender', $_POST['gender']);
    $s->bindValue(':dob', $_POST['dob']);
	$s->bindValue(':image', $file);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':sessionid', $_POST['sessions']);
	$s->bindValue(':termid', $_POST['terms']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    //$error = 'Error Making Your Changes';
    $error=$e;
    include 'error.html.php';
    exit();
  }

 // delete assigned subject in order to reset it
   try
  {
    $sql = 'DELETE FROM studentsubject WHERE studentid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing obsolete student subject entries.';
    include 'error.html.php';
    exit();
  }

// delete assigned dispositions in order to reset it
   try
  {
    $sql = 'DELETE FROM studentdisposition WHERE studentid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing ssigned dispositions.';
    include 'error.html.php';
    exit();
  }
// delete assigned skill in order to reset it
   try
  {
    $sql = 'DELETE FROM studentskill WHERE studentid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing assigned skills.';
    include 'error.html.php';
    exit();
  }

  if (isset($_POST['subjects']) && isset($_POST['scores']))
  {
    for ( $i=0; $i < count($_POST['subjects']); $i++)
    {
      try
      {
        $sql = 'INSERT INTO studentsubject SET
           studentid = :studentid,
		   regnumber = :regnumber,
           subjectid = :subjectid,
		   classid = :classid,
		   sessionid = :sessionid,
		   test1 = :test1,
		   test2 = :test2,
		   score = :score,
		   termid = :termid,
		   date = CURDATE()';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid', $_POST['id']);
		   $s->bindValue(':regnumber',  $_POST['regnumber']);
		   $s->bindValue(':subjectid', $_POST['subjects'][$i]);
		   $s->bindValue(':classid',  $_POST['classes']);
		   $s->bindValue(':sessionid', $_POST['sessions']);
		   $s->bindValue(':termid', $_POST['terms']);
		   $s->bindValue(':test1', $_POST['test1s'][$i]);
		   $s->bindValue(':test2', $_POST['test2s'][$i]);
		   $s->bindValue(':score', $_POST['scores'][$i]);
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning selected subjects to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
 } 
  // assign disposition grades
 if (isset($_POST['dispositions']))
  {
     for ( $i=0; $i < count($_POST['dispositions']); $i++)
    {
      try
      {
        $sql = 'INSERT INTO studentdisposition SET
           studentid = :studentid,
		   dispositionid = :dispositionid,
		   grade = :grade';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid',  $_POST['id']);
		   $s->bindValue(':dispositionid',  $_POST['dispositions'][$i]);
		   $s->bindValue(':grade', $_POST['dgrades'][$i]);
		   
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning disposition grade to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
 
 } 
 
 // assign skill grades
 if (isset($_POST['skills']))
  {
     for ( $i=0; $i < count($_POST['skills']); $i++)
    {
      try
      {
        $sql = 'INSERT INTO studentskill SET
           studentid = :studentid,
		   skillid = :skillid,
		   grade = :grade';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid', $_POST['id']);
		   $s->bindValue(':skillid',  $_POST['skills'][$i]);
		   $s->bindValue(':grade', $_POST['sgrades'][$i]);
		   
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning skill grade to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
 
 } 
  //header('Location: .');
  $message = 'Your Change(s) is Successful';
  $link = '.';
  include 'success.html.php';
  exit();
}

//Terminal Report
if (isset($_GET['terminalreport']))
{
	if(isset($_SESSION['theclass']) && isset($_SESSION['thesession']) && isset($_SESSION['theterm'])){
	$theclass = $_SESSION['theclass'];
    $thesession = $_SESSION['thesession'];
    $theterm = $_SESSION['theterm']; 
 }else{
	$theclass = $_SESSION['class'];
	$thesession = 1;
	$theterm = 1;
 }
	  include  '../../includes/db.inc.php';
	  
	  try {   
  
  $sql = 'SELECT id FROM student WHERE classid = :classid  and sessionid = :sessionid and termid = :termid and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':classid', $theclass);
  $s->bindValue(':sessionid', $thesession);
  $s->bindValue(':termid', $theterm);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit();
  }
  include 'reportheader.html.php';
 
 foreach($s as $studentid) {
	 $theid = $studentid['id'];
	 
	 try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, classid, sessionid, termid, image FROM student WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $theid);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching student details.'.$e;
  include 'error.html.php';
  exit(); }
  $row = $s->fetch();
  $surname = $row['surname'];
  $firstname = $row['firstname'];
  $othername = $row['othername'];
  $regnumber = $row['regnumber'];
  $classid = $row['classid'];
  $sessionid = $row['sessionid'];
  $termid = $row['termid'];
  $photo = $row['image'];
  $id = $row['id'];
  
	 
  // Get list of subject and score assigned to this student for current term
  try { 
  //get date
   $sql = 'SELECT date FROM studentsubject WHERE studentsubject.regnumber = :regnumber and classid=:classid and sessionid=:sessionid and termid=:termid';
  $s = $pdo->prepare($sql);
  $s->bindValue(':regnumber', $regnumber);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  $rowdate = $s->fetch();
  $date = $rowdate['date'];
  $sql = 'SELECT subjectid, score, test1, test2, (test1+test2+score) as   total, subject.name as subject FROM studentsubject inner join 
  subject on subject.id = subjectid WHERE studentsubject.regnumber = :regnumber and classid=:classid and 
  sessionid=:sessionid and termid=:termid order by subject ';
  $s = $pdo->prepare($sql);
  $s->bindValue(':regnumber', $regnumber);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned subjects.'.$e;
  include 'error.html.php';
  exit();
  }
  //echo $theid;
 $items = array();
foreach ($s as $row)
{
  $subjects[] = array('subjectid' => $row['subjectid'], 'score' => $row['score'], 'test1' => $row['test1'], 'test2' => $row['test2'], 'total' => $row['total'], 'subject' => $row['subject']);
      array_push($items,$row['subjectid']);
    } 
     //$items = $sale['pid'];
	 //print_r($subjects, false);
     $cart = array();
     $total = 0;
           //$subtotal=0; 
           foreach ($items as $id)
          {
           foreach ($subjects as $subject)
           {
              if ($subject['subjectid'] == $id)
           {
              $cart[] = $subject;
              $total += $subject['total'];
             break;
           }
         }
		 //echo $subject['score'];
       } 
	   
       // get class name
       try{
 $sql = 'SELECT name FROM class WHERE id = :classid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':classid', $classid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching class.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $class = $row['name'];
   
   //get session
    try{
 $sql = 'SELECT name FROM session WHERE id = :sessionid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':sessionid', $sessionid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching session.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $session = $row['name'];
   
   //get term
    try{
 $sql = 'SELECT name FROM term WHERE id = :termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':termid', $termid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching class.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $term = $row['name'];
   
    //get average for this student
	  try { 
  $sql = 'SELECT avg(test1+test2+score) as thisaverage FROM studentsubject WHERE  studentid=:id  ';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $theid);
  $s->execute();
  $row = $s->fetch();
   $thisAverage = round($row['thisaverage'],2);
   //echo 'this average'.$thisAverage.'  ';
  
  }catch (PDOException $e) { 
  $error = 'Error fetching the average for this student.'.$e;
  include 'error.html.php';
  exit();
  }
  
  //get all averages in a class

	  try { 
  $sql = 'SELECT regnumber,  avg(test1+test2+score) as allaverage FROM studentsubject WHERE classid=:classid and sessionid=:sessionid and termid=:termid group by regnumber order by allaverage DESC';
  $s = $pdo->prepare($sql);
  //$s->bindValue(':regnumber', $regnumber);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  $allAverage = Array();
  foreach($s as $row){
  array_push($allAverage, round($row['allaverage'],2));
  }
  $numberInClass = count($allAverage);
  //echo $numberInClass;
  //echo $allAverage[0];
  //echo $allAverage[1];
  
   //get the position
 for($position=0; $position < count($allAverage); $position++){
	 if($allAverage[$position] == $thisAverage){
		  $position += 1;
		  //echo $position;
		 break;
	 }
 }
 }catch (PDOException $e) { 
  $error = 'Error fetching the average for this class.'.$e;
  include 'error.html.php';
  exit();
  }
  
     // Get list of disposition and grade assigned to this student
  try { 
  $sql = 'SELECT dispositionid, grade  FROM studentdisposition WHERE studentid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $theid);
  $assigneddispositions = array();
  $dgrades = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$assigneddispositions[] = $row['dispositionid'];
			$dgrades[] = $row['grade'];
			$show = 1;
	 }
	 if($show == 0 ){
	  $dgrades = 0;
	  }
	}
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned disposition grade.';
  include 'error.html.php';
  exit();
  }
  // Get list of skill and grade assigned to this student
  try { 
  $sql = 'SELECT skillid, grade  FROM studentskill WHERE studentid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $theid);
  $assignedskills = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$assignedskills[] = $row['skillid'];
			$sgrades[] = $row['grade'];
			$show = 1;
	 }
	 if($show == 0 ){
	  $sgrades = 0;
	  }
	}
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned disposition grade.';
  include 'error.html.php';
  exit();
  }
  // Build the list of all dispositions
  try {  
	   
	   $result = $pdo->query('SELECT id, title FROM disposition');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of dispositions.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $dispositions[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => in_array($row['id'], $assigneddispositions));
  }
  
  // Build the list of all skills
  try {  
	   
	   $result = $pdo->query('SELECT id, title FROM skill');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of dispositions.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $skills[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => in_array($row['id'], $assignedskills));
  }
	$back='.';
	// reset the subjects, dispositions and skills after each iteration
	//unset($subjects);
	array_splice($subjects, 0);
	include 'reportdiv.html.php'; 
	// reset the  dispositions and skills after each iteration
	unset($dispositions);
	unset($skills);
 }
   
  include 'reportfooter.html.php';
	exit();
  
}


// See Report
if (isset($_POST['action']) and $_POST['action'] == 'See Report')
{
	  include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, classid, sessionid, termid, image FROM student WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit(); }
  $row = $s->fetch();
  $surname = $row['surname'];
  $firstname = $row['firstname'];
  $othername = $row['othername'];
  $regnumber = $row['regnumber'];
  $classid = $row['classid'];
  $sessionid = $row['sessionid'];
  $termid = $row['termid'];
  $photo = $row['image'];
  $id = $row['id'];
   
  // Get list of subject and score assigned to this student for current term
  try { 
  //get date
	$sql = 'SELECT date FROM studentsubject WHERE studentsubject.regnumber = :regnumber and classid=:classid and sessionid=:sessionid and termid=:termid';
  $s = $pdo->prepare($sql);
  $s->bindValue(':regnumber', $regnumber);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  $rowdate = $s->fetch();
  $date = $rowdate['date'];
  
  $sql = 'SELECT subjectid, score, test1, test2, (test1+test2+score) as   total,  subject.name as subject FROM studentsubject 
  inner join subject on subject.id = subjectid WHERE studentid = :id and classid=:classid and 
  sessionid=:sessionid and termid=:termid order by subject';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $id);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned subjects.';
  include 'error.html.php';
  exit();
  }
  $items = array();
foreach ($s as $row)
{
  $subjects[] = array('subjectid' => $row['subjectid'], 'score' => $row['score'], 'test1' => $row['test1'], 'test2' => $row['test2'], 'total' => $row['total'], 'subject' => $row['subject']);
      array_push($items,$row['subjectid']);
    } 
     //$items = $sale['pid'];
     $cart = array();
     $total = 0;
           //$subtotal=0; 
           foreach ($items as $id)
          {
           foreach ($subjects as $subject)
           {
              if ($subject['subjectid'] == $id)
           {
              $cart[] = $subject;
              $total += $subject['total'];
             break;
           }
         }
       } 
       // get class name
       try{
 $sql = 'SELECT name FROM class WHERE id = :classid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':classid', $classid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching class.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $class = $row['name'];
   
   //get session
    try{
 $sql = 'SELECT name FROM session WHERE id = :sessionid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':sessionid', $sessionid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching session.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $session = $row['name'];
   
   //get term
    try{
 $sql = 'SELECT name FROM term WHERE id = :termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':termid', $termid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching class.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $term = $row['name'];
   
    //get average for this student
	  try { 
  $sql = 'SELECT avg(test1+test2+score) as thisaverage FROM studentsubject WHERE regnumber = :regnumber and classid=:classid and sessionid=:sessionid and termid=:termid ';
  $s = $pdo->prepare($sql);
  $s->bindValue(':regnumber', $regnumber);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  $row = $s->fetch();
   $thisAverage = round($row['thisaverage'],2);
  // echo 'this average'.$thisAverage.'  ';
  
  }catch (PDOException $e) { 
  $error = 'Error fetching the average for this student.'.$e;
  include 'error.html.php';
  exit();
  }
  
  //get all averages in a class

	  try { 
  $sql = 'SELECT regnumber,  avg(test1+test2+score) as allaverage FROM studentsubject WHERE classid=:classid and sessionid=:sessionid and termid=:termid group by regnumber order by allaverage DESC';
  $s = $pdo->prepare($sql);
  //$s->bindValue(':regnumber', $regnumber);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  $allAverage = Array();
  foreach($s as $row){
  array_push($allAverage, round($row['allaverage'],2));
  }
  $numberInClass = count($allAverage);
  //echo $numberInClass;
  //echo $allAverage[0];
  //echo $allAverage[1];
  
   //get the position
 for($position=0; $position < count($allAverage); $position++){
	 if($allAverage[$position] == $thisAverage){
		  $position += 1;
		  //echo $position;
		 break;
	 }
 }
 }catch (PDOException $e) { 
  $error = 'Error fetching the average for this class.'.$e;
  include 'error.html.php';
  exit();
  }
   // Get list of disposition and grade assigned to this student
  try { 
  $sql = 'SELECT dispositionid, grade  FROM studentdisposition WHERE studentid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $assigneddispositions = array();
  $dgrades = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$assigneddispositions[] = $row['dispositionid'];
			$dgrades[] = $row['grade'];
			$show = 1;
	 }
	 if($show == 0 ){
	  $dgrades = 0;
	  }
	}
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned disposition grade.';
  include 'error.html.php';
  exit();
  }
  // Get list of skill and grade assigned to this student
  try { 
  $sql = 'SELECT skillid, grade  FROM studentskill WHERE studentid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $assignedskills = array();
  $show = 0;
  if($s->execute()){
	  foreach ($s as $row) {
			$assignedskills[] = $row['skillid'];
			$sgrades[] = $row['grade'];
			$show = 1;
	 }
	 if($show == 0 ){
	  $sgrades = 0;
	  }
	}
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned disposition grade.';
  include 'error.html.php';
  exit();
  }
  // Build the list of all dispositions
  try {  
	   
	   $result = $pdo->query('SELECT id, title FROM disposition');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of dispositions.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $dispositions[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => in_array($row['id'], $assigneddispositions));
  }
  
  // Build the list of all skills
  try {  
	   
	   $result = $pdo->query('SELECT id, title FROM skill');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of dispositions.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $skills[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => in_array($row['id'], $assignedskills));
  }

	$back='.';
	include 'report.html.php';
	exit();
}

//register student for another term
if (isset($_POST['action']) and $_POST['action'] == 'Register Another Term')
{
   include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, parentphone, gender, dob, date, image, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching student details.'.$e;
  include 'error.html.php';
  exit(); }
  $row = $s->fetch();
  $pageTitle = 'Update Student Information';
  $pageHeading ='Make Your Change(s) and Press Register to Submit ';
  $action = 'anotherterm';
  $surname = $row['surname'];
  $firstname = $row['firstname'];
  $othername = $row['othername'];
  $parentphone = $row['parentphone'];
  $regnumber = $row['regnumber'];
  $classid = $row['classid'];
  $gender = $row['gender'];
  $date = $row['date'];
  $image = $row['image'];
  $dob = $row['dob'];
  $sessionid = $row['sessionid'];
  $termid = $row['termid'];
  $id = $row['id'];
  $scores = 0;
  $test1s = 0;
  $test2s = 0;
  $dgrades = 0; //dispositions grades
  $sgrades = 0; //skills grades
  $button = 'Register';
  
  // Get list of subject and score assigned to this users
  try { 
  $sql = 'SELECT subjectid FROM studentsubject WHERE studentid = :id and classid=:classid and sessionid=:sessionid and termid=:termid';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $id);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  }catch (PDOException $e) { 
  $error = 'Error fetching list of assigned subjects.';
  include 'error.html.php';
  exit();
  }
  $selectedSubjects = array();
  $score = array();
  foreach ($s as $row) {
	  $selectedSubjects[] = $row['subjectid'];
	  //$scores[] = $row['score'];
	  }
	   // Build the list of all subjects
	   try {  
	   
	   $result = $pdo->query('SELECT id, name FROM subject');
	   } catch (PDOException $e)
	   {
		   $error = 'Error fetching list of sujects.';
		   include 'error.html.php';
		   exit();
		   }
		   foreach ($result as $row){  
		   $subjects[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSubjects));
  }

// Get list of class assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM class WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $classid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned class.';
    include 'error.html.php';
    exit();
  }
  
  $selectedClass = array();
  foreach ($s as $row)
  {
    $selectedClass[] = $row['id'];
  }

// Build the list of all class
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of classes.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedClass));
  }

  // Get list of session assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM session WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $sessionid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned session.';
    include 'error.html.php';
    exit();
  }
  
  $selectedSession = array();
  foreach ($s as $row)
  {
    $selectedSession[] = $row['id'];
  }

// Build the list of all Session
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM session order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of session.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $sessions[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSession));
  }

  // Get list of term assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM term WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $termid);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned term.';
    include 'error.html.php';
    exit();
  }
  
  $selectedTerm = array();
  foreach ($s as $row)
  {
    $selectedTerm[] = $row['id'];
  }

// Build the list of all term
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM term order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $terms[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedTerm));
  }
  
  // Build the list of disposition
  try
  {
    $result = $pdo->query('SELECT id, title FROM disposition order by title');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of disposition.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $dispositions[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => FALSE);
  }
  
  // Build the list of skills
  try
  {
    $result = $pdo->query('SELECT id, title FROM skill order by title');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of skill.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $skills[] = array(
      'id' => $row['id'],
      'title' => $row['title'],
      'selected' => FALSE);
  }
  
 include 'form.html.php';
  exit();
}

if (isset($_GET['anotherterm']))
{
  include '../../includes/db.inc.php';
  
   try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, parentphone, gender, dob, date, classid, sessionid, termid FROM student WHERE regnumber = :regnumber and 
		classid=:classid and sessionid=:sessionid and termid=:termid and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':regnumber', $_POST['regnumber']);
  $s->bindValue(':classid', $_POST['classes']);
  $s->bindValue(':sessionid', $_POST['sessions']);
  $s->bindValue(':termid', $_POST['terms']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching students details.'.$e;
  include 'error.html.php';
  exit();
  }
  $row = $s->fetch();
  if($row > 0){
	$error = 'This student has already been registered for this term';
	include 'error.html.php';
	exit();
	  
  }
  try
  {
	  // check for student image/photo to register
	  $img = $_POST['image'];
	//echo $img;
	$photopath = substr($img,0,7);
	//echo $photopath;
    $folderPath = "upload/";
	if ($photopath == $folderPath){
		$file = $img;
	}else{
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
	}
	//echo $file;
    $sql = 'INSERT INTO student SET
        surname = :surname,
		firstname = :firstname,
		othername = :othername,
        parentphone = :parentphone,
		regnumber = :regnumber,
        dob = :dob,
		image= :image,
        gender = :gender,
        date = CURDATE(),
        classid = :classid,
		sessionid = :sessionid,
		termid = :termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':surname', $_POST['surname']);
	$s->bindValue(':firstname', $_POST['firstname']);
	$s->bindValue(':othername', $_POST['othername']);
    $s->bindValue(':parentphone', $_POST['parentphone']);
    $s->bindValue(':regnumber', $_POST['regnumber']);
    $s->bindValue(':gender', $_POST['gender']);
    $s->bindValue(':dob', $_POST['dob']);
	$s->bindValue(':image', $file);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':sessionid', $_POST['sessions']);
	$s->bindValue(':termid', $_POST['terms']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    //$error = 'Error Adding User';
    $error=$e;
    include 'error.html.php';
    exit();
  }

  $studentid = $pdo->lastInsertId();
  if (isset($_POST['subjects']))
  {
    foreach ($_POST['subjects'] as $subject)
    {
      try
      {
        $sql = 'INSERT INTO studentsubject SET
           studentid = :studentid,
		   regnumber =:regnumber,
           subjectid = :subjectid,
		   classid = :classid,
		   sessionid = :sessionid,
		   termid = :termid';     		   
		   $s = $pdo->prepare($sql);
		   $s->bindValue(':studentid', $studentid);
		   $s->bindValue(':regnumber',  $_POST['regnumber']);
		   $s->bindValue(':subjectid', $subject);
		   $s->bindValue(':classid',  $_POST['classes']);
		   $s->bindValue(':sessionid', $_POST['sessions']);
		   $s->bindValue(':termid', $_POST['terms']);
		   $s->execute();
		   } catch (PDOException $e){
			  $error = 'Error assigning selected subjects to student.'.$e;
			  include 'error.html.php';
			  exit();    
			}  
	} 
 } 
  //header('Location: .');
  $message = 'Student Registered Successfully';
  $link = '.';
  include 'success.html.php';
  exit();
  }
  
// delete a student
  if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../../includes/db.inc.php'; 
  // Delete the student
  try  {   
  $sql = 'UPDATE student SET deleted = :deleted WHERE id = :id';      
  $s = $pdo->prepare($sql);      
  $s->bindValue(':deleted', 1);    
  $s->bindValue(':id', $_POST['id']);     
  $s->execute();  
  }	catch (PDOException $e)  {    
	$error = 'Error deleting user.';   
	include 'error.html.php';    
	exit();  
	}
  //header('Location: .');  
  $message= 'Delete successful'; 
  $link='.';  
  include 'success.html.php';  
  exit();
  }
  
  //search for a student
	if (isset($_POST['action']) and $_POST['action'] == 'Search'){ 
	
	include '../../includes/db.inc.php';
	if(isset($_SESSION['theclass']) && isset($_SESSION['thesession']) && isset($_SESSION['theterm'])){
	$regnumber = $_POST['regnumbers'];
	
	// Get list of class assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM class WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_SESSION['theclass']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned class.';
    include 'error.html.php';
    exit();
  }
  
  $selectedClass = array();
  foreach ($s as $row)
  {
    $selectedClass[] = $row['id'];
  }

// Build the list of all class
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of classes.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedClass));
  }

  // Get list of session assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM session WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_SESSION['thesession']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned session.';
    include 'error.html.php';
    exit();
  }
  
  $selectedSession = array();
  foreach ($s as $row)
  {
    $selectedSession[] = $row['id'];
  }

// Build the list of all Session
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM session order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of session.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $sessions[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSession));
  }

  // Get list of term assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM term WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_SESSION['theterm']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned term.';
    include 'error.html.php';
    exit();
  }
  
  $selectedTerm = array();
  foreach ($s as $row)
  {
    $selectedTerm[] = $row['id'];
  }

// Build the list of all term
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM term order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $terms[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedTerm));
  }
  
  //get regnumber
  // Build the list regnumbers
  // Get list of selected student regnumber
 
 try
  {
    $sql = 'SELECT regnumber as name  FROM student WHERE regnumber = :regnumber group by regnumber';
    $s = $pdo->prepare($sql);
    $s->bindValue(':regnumber', $regnumber);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching assigned regnumber.';
    include 'error.html.php';
    exit();
  }
  
  $selectedRegnumber = array();
  foreach ($s as $row)
  {
    $selectedRegnumber[] = $row['name'];
  }

// Build the list of all regnumbers
	
  try
  {
    $result = $pdo->query('SELECT regnumber FROM student group by regnumber');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of regnumbers.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $regnumbers[] = array(
      'name' => $row['regnumber'],
      'selected' => in_array($row['regnumber'], $selectedRegnumber));
  }
 
 //get number of female
  try
  {
	$gender ="Female";
	$sql = 'SELECT count(id) as ngirls FROM student WHERE  classid=:classid AND sessionid=:sessionid AND termid=:termid AND gender =:gender';
    $s = $pdo->prepare($sql);

	$s->bindValue(':classid', $_SESSION['theclass']);
	$s->bindValue(':sessionid', $_SESSION['thesession']);
	$s->bindValue(':termid', $_SESSION['theterm']);
	$s->bindValue(':gender', $gender);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of females. '.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $ngirls = $row['ngirls'];
  }
 
 //get number of males
   try
  {
	$gender ="Male";
	$sql = 'SELECT count(id) as nboys FROM student WHERE gender =:gender AND classid=:classid AND sessionid=:sessionid AND termid=:termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':gender', $gender);
	$s->bindValue(':classid', $_SESSION['theclass']);
	$s->bindValue(':sessionid', $_SESSION['thesession']);
	$s->bindValue(':termid', $_SESSION['theterm']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of males. '.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $nboys = $row['nboys'];
  }
 //get total number of students
  try
  {
    $result = $pdo->query('SELECT count(id) as ntotal FROM student WHERE classid='.$_SESSION['theclass'].' AND sessionid='.$_SESSION['thesession'].' AND termid='.$_SESSION['theterm']);

  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of students.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $ntotal = $row['ntotal'];
  }
 
 
 try {  
	//$result = $pdo->query(');
	$sql = 'SELECT student.id as id, regnumber, surname, firstname, othername, parentphone, gender, class.name as class, session.name as session, 
	term.name as term  FROM student inner join class on class.id = classid inner join session on session.id = sessionid inner join term 
	on term.id = termid WHERE regnumber =:regnumber AND classid =:theclass AND termid =:theterm AND sessionid =:thesession AND  student.deleted = :deleted';
    $s = $pdo->prepare($sql);
    $s->bindValue(':regnumber', $regnumber);
	$s->bindValue(':theclass', $_SESSION['theclass']);
	$s->bindValue(':thesession', $_SESSION['thesession']);
	$s->bindValue(':theterm', $_SESSION['theterm']);
	$s->bindValue(':deleted', 0);
    $s->execute();
	}
	catch (PDOException $e) { 
		$error = 'Error fetching students from the database!'.$e;  
		include 'error.html.php';   
		exit(); 
		}
		foreach ($s as $row) {  
		$students[] = array('id' => $row['id'], 'regnumber' => $row['regnumber'],'surname' => $row['surname'],'firstname' => $row['firstname'], 'othername' => $row['othername'],
		'class' => $row['class'], 'session' => $row['session'], 'term' => $row['term'], 'parentphone' => $row['parentphone'], 'gender' => $row['gender']);
		}
		include 'students.html.php';
		exit();
    
	}else{
		$error = 'Make sure you have load students for the current term or the term you wish to work with.';   
		include 'error.html.php';    
		exit();  
		
	}
	
}
  //Load Students
	if (isset($_POST['action']) and $_POST['action'] == 'Load Students'){ 
	
	include '../../includes/db.inc.php';
	
	$_SESSION['theclass']=$_POST['classes'];
	$_SESSION['thesession']=$_POST['sessions'];
	$_SESSION['theterm']=$_POST['terms'];
	 // Get list of class assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM class WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_SESSION['theclass']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned class.';
    include 'error.html.php';
    exit();
  }
  
  $selectedClass = array();
  foreach ($s as $row)
  {
    $selectedClass[] = $row['id'];
  }

// Build the list of all class
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of classes.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedClass));
  }

  // Get list of session assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM session WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_SESSION['thesession']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned session.';
    include 'error.html.php';
    exit();
  }
  
  $selectedSession = array();
  foreach ($s as $row)
  {
    $selectedSession[] = $row['id'];
  }

// Build the list of all Session
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM session order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of session.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $sessions[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSession));
  }

  // Get list of term assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM term WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_SESSION['theterm']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned term.';
    include 'error.html.php';
    exit();
  }
  
  $selectedTerm = array();
  foreach ($s as $row)
  {
    $selectedTerm[] = $row['id'];
  }

// Build the list of all term
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM term order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $terms[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedTerm));
  }
  
  //get regnumber
  // Build the list regnumbers
 
  try
  {
    $result = $pdo->query('SELECT regnumber as name FROM student WHERE classid='. $_SESSION['theclass'].' group by regnumber');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $regnumbers[] = array(
      'name' => $row['name'],
      'selected' => False);
  }
 //get number of female
  try
  {
	$gender ="Female";
	$sql = 'SELECT count(id) as ngirls FROM student WHERE  classid=:classid AND sessionid=:sessionid AND termid=:termid AND gender =:gender';
    $s = $pdo->prepare($sql);

	$s->bindValue(':classid', $_SESSION['theclass']);
	$s->bindValue(':sessionid', $_SESSION['thesession']);
	$s->bindValue(':termid', $_SESSION['theterm']);
	$s->bindValue(':gender', $gender);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of females. '.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $ngirls = $row['ngirls'];
  }
 
 //get number of males
   try
  {
	$gender ="Male";
	$sql = 'SELECT count(id) as nboys FROM student WHERE gender =:gender AND classid=:classid AND sessionid=:sessionid AND termid=:termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':gender', $gender);
	$s->bindValue(':classid', $_SESSION['theclass']);
	$s->bindValue(':sessionid', $_SESSION['thesession']);
	$s->bindValue(':termid', $_SESSION['theterm']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of males. '.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $nboys = $row['nboys'];
  }
 //get total number of students
  try
  {
    $result = $pdo->query('SELECT count(id) as ntotal FROM student WHERE classid='.$_SESSION['theclass'].' AND sessionid='.$_SESSION['thesession'].' AND termid='.$_SESSION['theterm']);
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of students.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $ntotal = $row['ntotal'];
  }
 
 
 try {  
	$result = $pdo->query('SELECT student.id as id, regnumber, surname, firstname, othername, parentphone, gender, class.name as class, session.name as session, 
	term.name as term  FROM student inner join class on class.id = classid inner join session on session.id = sessionid inner join term 
	on term.id = termid WHERE classid ='.$_SESSION['theclass'].' AND termid ='.$_SESSION['theterm'].' AND sessionid = '.$_SESSION['thesession'].' AND  student.deleted = 0');
	}
	catch (PDOException $e) { 
		$error = 'Error fetching students from the database!'.$e;  
		include 'error.html.php';   
		exit(); 
		}
		foreach ($result as $row) {  
		$students[] = array('id' => $row['id'], 'regnumber' => $row['regnumber'],'surname' => $row['surname'],'firstname' => $row['firstname'], 'othername' => $row['othername'],
		'class' => $row['class'], 'session' => $row['session'], 'term' => $row['term'], 'parentphone' => $row['parentphone'], 'gender' => $row['gender']);
		}
		include 'students.html.php';
		exit();

	}
	
	
// print student list
	if(isset($_GET['studentlist'])){
		include  '../../includes/db.inc.php';
 
		if(isset($_SESSION['theclass']) && isset($_SESSION['thesession']) && isset($_SESSION['theterm'])){
			$theclass = $_SESSION['theclass'];
			$thesession = $_SESSION['thesession'];
			$theterm = $_SESSION['theterm']; 
		}else{
			$theclass = $_SESSION['class'];
			$thesession = 1;
			$theterm = 1;
 }
		try {  
	$result = $pdo->query('SELECT student.id as id, regnumber, surname, firstname, othername  FROM student WHERE classid ='.$theclass.' AND termid ='.$theterm.' AND sessionid = '.$thesession.' AND  student.deleted = 0');
	}
	catch (PDOException $e) { 
		$error = 'Error fetching students from the database!'.$e;  
		include 'error.html.php';   
		exit(); 
		}
		foreach ($result as $row) {  
		$students[] = array('id' => $row['id'], 'regnumber' => $row['regnumber'],'surname' => $row['surname'],'firstname' => $row['firstname'], 'othername' => $row['othername']);
		}
		
	//get total number of students
  try
  {
    $result = $pdo->query('SELECT count(id) as ntotal FROM student WHERE classid='.$_SESSION['theclass'].' AND sessionid='.$_SESSION['thesession'].' AND termid='.$_SESSION['theterm']);
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of students.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $ntotal = $row['ntotal'];
  }
  // get class name
       try{
	$sql = 'SELECT name FROM class WHERE id = :classid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':classid', $theclass);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching class.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $class = $row['name'];
   
   //get session
    try{
	$sql = 'SELECT name FROM session WHERE id = :sessionid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':sessionid', $thesession);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching session.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $session = $row['name'];
   
   //get term
    try{
 $sql = 'SELECT name FROM term WHERE id = :termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':termid', $theterm);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching class.';
    include 'error.html.php';
    exit();
  }
   $row = $s->fetch();
   $term = $row['name'];
		include 'studentlist.html.php';
		exit();
	}
	
 // Display student list
 
 include  '../../includes/db.inc.php';
 
 if(isset($_SESSION['theclass']) && isset($_SESSION['thesession']) && isset($_SESSION['theterm'])){
	$theclass = $_SESSION['theclass'];
    $thesession = $_SESSION['thesession'];
    $theterm = $_SESSION['theterm']; 
 }else{
	$theclass = $_SESSION['class'];
	$thesession = 1;
	$theterm = 1;
 }
 // Get list of class assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM class WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $theclass);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned class.';
    include 'error.html.php';
    exit();
  }
  
  $selectedClass = array();
  foreach ($s as $row)
  {
    $selectedClass[] = $row['id'];
  }

// Build the list of all class
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of classes.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedClass));
  }

  // Get list of session assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM session WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $thesession);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned session.';
    include 'error.html.php';
    exit();
  }
  
  $selectedSession = array();
  foreach ($s as $row)
  {
    $selectedSession[] = $row['id'];
  }

// Build the list of all Session
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM session order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of session.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $sessions[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedSession));
  }

  // Get list of term assigned to this student
 
 try
  {
    $sql = 'SELECT id FROM term WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $theterm);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned term.';
    include 'error.html.php';
    exit();
  }
  
  $selectedTerm = array();
  foreach ($s as $row)
  {
    $selectedTerm[] = $row['id'];
  }

// Build the list of all term
	
  try
  {
    $result = $pdo->query('SELECT id, name FROM term order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $terms[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'selected' => in_array($row['id'], $selectedTerm));
  }

  //get regnumber
  // Build the list regnumbers
 
  try
  {
    $result = $pdo->query('SELECT regnumber as name FROM student WHERE classid='. $theclass.' group by regnumber');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $regnumbers[] = array(
      'name' => $row['name'],
      'selected' => False);
  }
  
 //get number of female
  try
  {
	$gender ="Female";
	$sql = 'SELECT count(id) as ngirls FROM student WHERE  classid=:classid AND sessionid=:sessionid AND termid=:termid AND gender =:gender';
    $s = $pdo->prepare($sql);

	$s->bindValue(':classid', $theclass);
	$s->bindValue(':sessionid', $thesession);
	$s->bindValue(':termid', $theterm);
	$s->bindValue(':gender', $gender);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of females. '.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $ngirls = $row['ngirls'];
  }
 
 //get number of males
   try
  {
	$gender ="Male";
	$sql = 'SELECT count(id) as nboys FROM student WHERE gender =:gender AND classid=:classid AND sessionid=:sessionid AND termid=:termid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':gender', $gender);
	$s->bindValue(':classid', $theclass);
	$s->bindValue(':sessionid', $thesession);
	$s->bindValue(':termid', $theterm);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of males. '.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $nboys = $row['nboys'];
  }
 //get total number of students
  try
  {
    $result = $pdo->query('SELECT count(id) as ntotal FROM student WHERE classid='.$theclass.' AND sessionid='.$thesession.' AND termid='.$theterm);
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching number of students.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $ntotal = $row['ntotal'];
  }
 
 
 try {  
	$result = $pdo->query('SELECT student.id as id, regnumber, surname, firstname, othername, parentphone, gender, class.name as class, session.name as session, 
	term.name as term  FROM student inner join class on class.id = classid inner join session on session.id = sessionid inner join term 
	on term.id = termid WHERE classid ='.$theclass.' AND termid ='.$theterm.' AND sessionid = '.$thesession.' AND  student.deleted = 0');
	}
	catch (PDOException $e) { 
		$error = 'Error fetching students from the database!'.$e;  
		include 'error.html.php';   
		exit(); 
		}
		foreach ($result as $row) {  
		$students[] = array('id' => $row['id'], 'regnumber' => $row['regnumber'],'surname' => $row['surname'],'firstname' => $row['firstname'], 'othername' => $row['othername'],
		'class' => $row['class'], 'session' => $row['session'], 'term' => $row['term'], 'parentphone' => $row['parentphone'], 'gender' => $row['gender']);
		}
		include 'students.html.php';
	
 ?>