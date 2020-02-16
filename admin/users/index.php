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

if (!userHasRole('Admin Officer'))
{
  $error = 'Only Admin Officer can access this page.';
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
    $sql = 'SELECT name FROM users
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

                $welcome = 'Hi';
					if (date("H") <= 12) {
						$welcome = 'Good Morning';
					} else if (date('H') > 12 && date("H") < 18) {
						$welcome = 'Good Afternoon';
					} else if(date('H') > 17) {
						$welcome = 'Good Evening';
					}
				$greeting = $welcome.', '.explode(" ",$row['name'])[0];
				
if(isset($_GET['upload'])){
	upLoad();
	$message = 'Data Upload Successful';
	$link='.';
	include 'success.html.php';
	exit();
}
	
//database Backup	
if(isset($_GET['backup'])){
	backUp();
	$message = 'Data Backup Successful, Please copy the BackUp folder inside disk C: to an external disk and keep save';
	$link='.';
	include 'success.html.php';
	exit();
}

//delete student
  if (isset($_POST['action']) and $_POST['action'] == 'Delete Student')
{
  include '../../includes/db.inc.php';

  
  // Delete the user
  try
  {
    $deletestdsql = 'DELETE from student WHERE id = :id';
    $s1 = $pdo->prepare($deletestdsql);
    $s1->bindValue(':id', $_POST['id']);
    $s1->execute();
	$deletesubsql = 'DELETE from studentsubject WHERE studentid = :id';
    $s2 = $pdo->prepare($deletesubsql);
    $s2->bindValue(':id', $_POST['id']);
    $s2->execute();
	
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting student.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'student deleted successfully';
  $link='?students';
  include 'success.html.php';
  exit();
 }
// Update subject
if (isset($_POST['action']) and $_POST['action'] == 'Update Subject')
{
  include '../../includes/db.inc.php';

  
  // Delete the user
  try
  {
    $sql = 'UPDATE subject SET
          name = :name
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating subject.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'Subject successfully updated';
  $link='?preferences';
  include 'success.html.php';
  exit();
 }
 // Update Class
if (isset($_POST['action']) and $_POST['action'] == 'Update Class')
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE class SET
          name = :name
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating class.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'Class successfully updated';
  $link='?preferences';
  include 'success.html.php';
  exit();
 }
 
 // Update Disposition
if (isset($_POST['action']) and $_POST['action'] == 'Update Disposition')
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE disposition SET
          title = :title
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':title', $_POST['title']);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating Disposition.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'Disposition successfully updated';
  $link='?preferences';
  include 'success.html.php';
  exit();
 }
 
 // Update Skill
if (isset($_POST['action']) and $_POST['action'] == 'Update Skill')
{
  include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE skill SET
          title = :title
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':title', $_POST['title']);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating skill.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'Skill successfully updated';
  $link='?preferences';
  include 'success.html.php';
  exit();
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
	
// manage preferences
if (isset($_GET['preferences']))
{
  include '../../includes/db.inc.php';
  
   // Build the list of all classes
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of branch.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name']);
      //'selected' => in_array($row['id'], $selectedSources));
  }
  // Build the list of all subjects
  try
  {
    $result = $pdo->query('SELECT id, name FROM subject order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of branch.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $subjects[] = array(
      'id' => $row['id'],
      'name' => $row['name']);
      //'selected' => in_array($row['id'], $selectedSources));
  }
	
	// Build the list of all skills
  try
  {
    $result = $pdo->query('SELECT id, title FROM disposition order by title');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of branch.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $dispositions[] = array(
      'id' => $row['id'],
      'title' => $row['title']);
      //'selected' => in_array($row['id'], $selectedSources));
  }
  
  // Build the list of all skills
  try
  {
    $result = $pdo->query('SELECT id, title FROM skill order by title');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of branch.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $skills[] = array(
      'id' => $row['id'],
      'title' => $row['title']);
      //'selected' => in_array($row['id'], $selectedSources));
  }
  include 'preferences.html.php';
  exit();
}


if (isset($_GET['add']))
{
  include '../../includes/db.inc.php';
  $pageTitle = 'Add New User';
  $pageHeading ='Enter User Information and Press Add User to Submit';
  $action = 'addform';
  $name = '';
  $email = '';
  $phone = '';
  $address = '';
  $gender = '';
  $date = '';
  $classid='';
  $id = '';
  $button = 'Add User';
  
   // Build the list of all classes
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of branch.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $classes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
	  'selected' => FALSE);
      //'selected' => in_array($row['id'], $selectedSources));
  }

  // Build the list of roles
  try
  {
    $result = $pdo->query('SELECT id, description FROM role');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of roles.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $roles[] = array(
      'id' => $row['id'],
      'description' => $row['description'],
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
  
    $sql = 'INSERT INTO users SET
        name = :name,
        phone = :phone,
        address = :address,
        gender = :gender,
        date = CURDATE(),
		classid =:classid,
        email = :email,
		photo = :photo,';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':phone', $_POST['phone']);
    $s->bindValue(':address', $_POST['address']);
    $s->bindValue(':gender', $_POST['gender']);
    $s->bindValue(':email', $_POST['email']);
	$s->bindValue(':photo', $file);
	$s->bindValue(':classid', $_POST['classes']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    //$error = 'Error Adding User';
    $error=$e;
    include 'error.html.php';
    exit();
  }

  $userid = $pdo->lastInsertId();

  if ($_POST['password'] != '')
  {
    $password = md5($_POST['password'] . 'school');

    try
    {
      $sql = 'UPDATE users SET
          password = :password
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':password', $password);
      $s->bindValue(':id', $userid);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Error setting users password.';
      include 'error.html.php';
      exit();
    }
  }

  if (isset($_POST['roles']))
  {
    foreach ($_POST['roles'] as $role)
    {
      try
      {
        $sql = 'INSERT INTO userrole SET
           userid = :userid,
            roleid = :roleid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userid', $userid);
        $s->bindValue(':roleid', $role);
        $s->execute();
      }
      catch (PDOException $e)
      {
       // $error = 'Error assigning selected role to user.';
          $error=$e;
        include 'error.html.php';
        exit();
      }
    }
  }
  $message = 'User Added';
  $link = '.';
  include 'success.html.php';
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Update')
{
  include  '../../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, name, phone, address, gender, date, email, photo, classid FROM users WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching users details.'.$e;
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Update Users';
  $pageHeading ='Make Your Change(s) and Press Update to Submit';
  $action = 'updateform';
  $name = $row['name'];
  $phone = $row['phone'];
  $address = $row['address'];
  $gender = $row['gender'];
  $date = $row['date'];
  $email = $row['email'];
  $classid = $row['classid'];
  $photo = $row['photo'];
  $id = $row['id'];
  $button = 'Update';
  
  // Get list of class assigned to this users
  try
  {
    $sql = 'SELECT classid FROM users WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $id);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of assigned roles.';
    include 'error.html.php';
    exit();
  }

  $selectedClass = array();
  foreach ($s as $row)
  {
    $selectedClass[] = $row['classid'];
  }
  // Build the list of all class
  try
  {
    $result = $pdo->query('SELECT id, name FROM class order by name ');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of roles.';
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

  // Get list of roles assigned to this users
  try
  {
    $sql = 'SELECT roleid FROM userrole WHERE userid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $id);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of assigned roles.';
    include 'error.html.php';
    exit();
  }

  $selectedRoles = array();
  foreach ($s as $row)
  {
    $selectedRoles[] = $row['roleid'];
  }


  // Build the list of all roles
  try
  {
    $result = $pdo->query('SELECT id, description FROM role');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of roles.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $roles[] = array(
      'id' => $row['id'],
      'description' => $row['description'],
      'selected' => in_array($row['id'], $selectedRoles));
  }

  include 'form.html.php';
  exit();
}

if (isset($_GET['updateform']))
{
  include  '../../includes/db.inc.php';

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
    $sql = 'UPDATE users SET
        name = :name,
        phone = :phone,
        address = :address,
        gender = :gender,
        date = :date,
        email = :email,
		photo = :photo,
		classid = :classid
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':phone', $_POST['phone']);
    $s->bindValue(':address', $_POST['address']);
    $s->bindValue(':gender', $_POST['gender']);
    $s->bindValue(':date', $_POST['date']);
	$s->bindValue(':classid', $_POST['classes']);
    $s->bindValue(':email', $_POST['email']);
	$s->bindValue(':photo', $file);
    $s->execute();
  }
  catch (PDOException $e)
  {
      $error = 'Error updating the user. '.$e;
      //$error= $e;
    include 'error.html.php';
    exit();
  }

  if ($_POST['password'] != '')
  {
    $password = md5($_POST['password'] . 'school');

    try
    {
      $sql = 'UPDATE users SET
          password = :password
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':password', $password);
      $s->bindValue(':id', $_POST['id']);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Error setting user password.';
      include 'error.html.php';
      exit();
    }
  }

  try
  {
    $sql = 'DELETE FROM userrole WHERE userid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing obsolete user role entries.';
    include 'error.html.php';
    exit();
  }

  if (isset($_POST['roles']))
  {
    foreach ($_POST['roles'] as $role)
    {
      try
      {
        $sql = 'INSERT INTO userrole SET
            userid = :userid,
            roleid = :roleid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userid', $_POST['id']);
        $s->bindValue(':roleid', $role);
        $s->execute();
      }
      catch (PDOException $e)
      {
        //$error = 'Error assigning selected role to users.';
        $error=$e;
        include 'error.html.php';
        exit();
      }
    }
  }
 
     //header('Location: .');
    $message = 'Update Successful';
    $link = '.';
    include 'success.html.php';
    //echo $message;
    exit();
}

//dele all Users
 if (isset($_GET['deleteAll']))
{
  include '../../includes/db.inc.php'; 
  // Delete the author
  try
  {
    $sql = 'UPDATE users SET
          deleted = :deleted';
      $s = $pdo->prepare($sql);
      $s->bindValue(':deleted', 1);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting users.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'Delete successful';
  $link='.';
  include 'success.html.php';
  exit();
}

//display students list for admin

  if(isset($_GET['students'])){
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
			exit();
  }
  
  //delete user
  if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../../includes/db.inc.php';

  
  // Delete the user
  try
  {
    $sql = 'UPDATE users SET
          deleted = :deleted
          WHERE id = :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':deleted', 1);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting user.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'delete successful';
  $link='.';
  include 'success.html.php';
  exit();
}


if (isset($_POST['action']) and $_POST['action'] == 'realDelete')
{
  include '../../includes/db.inc.php';

  // Delete role assignments for this author
  try
  {
    $sql = 'DELETE FROM userrole WHERE userid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing role the user.';
    include 'error.html.php';
    exit();
  }
    
 
  // Delete the author
  try
  {
    $sql = 'DELETE FROM users WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting author.';
    include 'error.html.php';
    exit();
  }

  //header('Location: .');
  $message= 'delete successful';
  $link='.';
  include 'success.html.php';
  exit();
}

// Display user list
include  '../../includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, name, phone, email, photo  FROM users where deleted = 0');
}
catch (PDOException $e)
{
  $error = 'Error fetching users from the database!'.$e;
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $users[] = array('id' => $row['id'], 'name' => $row['name'],'phone' => $row['phone'],'email' => $row['email'], 'photo' => $row['photo'] );
}

include 'users.html.php';
