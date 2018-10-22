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
    //include 'error.html.php';
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
	include '../../includes/remotedb.inc.php';
	//insert sales
	/*try{
	
	$fh = fopen("C:/xampp/htdocs/veroyori/backup/sales.csv", "r");
	while ($line = fgetcsv($fh, 1000, ","))
		{
	$id = $line[0];
	$userid = $line[1];
	$customerid = $line[2];
	$productid = $line[3];
	$brandid = $line[4];
	$sourceid = $line[5];
	$categoryid = $line[6];
	$destinationid = $line[7];
	$quantity = $line[8];
	$price = $line[9];
	$saledate = $line[10];
	$saleid = $line[11];
	$credit = $line[12];
	echo $line[10];
	echo $line[11];
	// Insert the data into the sales table
	$query = "INSERT INTO sales SET id='$id',
	userid='$userid', customerid='customerid',
	productid='$productid', brandid='brandid',
	sourceid='$sourceid', categoryid='$categoryid', destinationid='$destinationid',
	quantity='$quantity', price='$price', saledate='$saledate', saleid='$saleid' credit='$credit'";
	$result = $pdo->query($query);
	}
	fclose($fh);
	//$mysqli->close();
	echo 'file upload successful';
	}catch(exception $e){
		$error = 'file cannot be uploaded'.$e;
		include 'error.html.php';
		exit();
	}
	*/
	//create csv file for backup.
	//save all file as an array.
	$files = array("'C:/xampp/htdocs/comradeacademy/backup/subject.csv'","'C:/xampp/htdocs/comradeacademy/backup/student.csv'","'C:/xampp/htdocs/comradeacademy/backup/payment.csv'",
	"'C:/xampp/htdocs/comradeacademy/backup/class.csv'","'C:/xampp/htdocs/comradeacademy/backup/pay.csv'","'C:/xampp/htdocs/comradeacademy/backup/role.csv'",
	"'C:/xampp/htdocs/comradeacademy/backup/session.csv'","'C:/xampp/htdocs/comradeacademy/backup/studentsubject.csv'", 
	"'C:/xampp/htdocs/comradeacademy/backup/userrole.csv'","'C:/xampp/htdocs/comradeacademy/backup/term.csv'","'C:/xampp/htdocs/comradeacademy/backup/users.csv'");
	$unlink = array('C:/xampp/htdocs/comradeacademy/backup/subject.csv','C:/xampp/htdocs/comradeacademy/backup/student.csv','C:/xampp/htdocs/comradeacademy/backup/payment.csv',
	'C:/xampp/htdocs/comradeacademy/backup/class.csv','C:/xampp/htdocs/comradeacademy/backup/pay.csv','C:/xampp/htdocs/comradeacademy/backup/role.csv',
	'C:/xampp/htdocs/comradeacademy/backup/session.csv','C:/xampp/htdocs/comradeacademy/backup/studentsubject.csv', 
	'C:/xampp/htdocs/comradeacademy/backup/userrole.csv','C:/xampp/htdocs/comradeacademy/backup/term.csv','C:/xampp/htdocs/comradeacademy/backup/users.csv');
	$tables = array('subject','student','payment','class','pay','role','session','studentsubject','userrole','term','users');


	 for($i=0; $i<count($files); $i++){
	if (!$file = @ fopen($files[$i], 'x')) {
	// write conten to remote server
	try{
	
	$sql = 'LOAD DATA INFILE '.$files[$i].' REPLACE INTO TABLE '.$tables[$i].' FIELDS TERMINATED BY \',\' LINES TERMINATED BY \'\n\'';
	$s = $pdo->prepare($sql2);
    $s->execute();
	}catch(exception $e){
		$error = 'Unable to connect to the database server.'.$e;
		include 'error.html.php';
		exit();
	}
   }
  }
   echo 'Data Upload Successful';	
}
	
//database Backup	
if(isset($_GET['backup'])){
	include '../../includes/db.inc.php';
	
	//create csv file for backup.
	//save all file as an array.
	$files = array("'C:/xampp/htdocs/comradeacademy/backup/subject.csv'","'C:/xampp/htdocs/comradeacademy/backup/student.csv'","'C:/xampp/htdocs/comradeacademy/backup/payment.csv'",
	"'C:/xampp/htdocs/comradeacademy/backup/class.csv'","'C:/xampp/htdocs/comradeacademy/backup/pay.csv'","'C:/xampp/htdocs/comradeacademy/backup/role.csv'",
	"'C:/xampp/htdocs/comradeacademy/backup/session.csv'","'C:/xampp/htdocs/comradeacademy/backup/studentsubject.csv'", 
	"'C:/xampp/htdocs/comradeacademy/backup/userrole.csv'","'C:/xampp/htdocs/comradeacademy/backup/term.csv'","'C:/xampp/htdocs/comradeacademy/backup/users.csv'");
	$unlink = array('C:/xampp/htdocs/comradeacademy/backup/subject.csv','C:/xampp/htdocs/comradeacademy/backup/student.csv','C:/xampp/htdocs/comradeacademy/backup/payment.csv',
	'C:/xampp/htdocs/comradeacademy/backup/class.csv','C:/xampp/htdocs/comradeacademy/backup/pay.csv','C:/xampp/htdocs/comradeacademy/backup/role.csv',
	'C:/xampp/htdocs/comradeacademy/backup/session.csv','C:/xampp/htdocs/comradeacademy/backup/studentsubject.csv', 
	'C:/xampp/htdocs/comradeacademy/backup/userrole.csv','C:/xampp/htdocs/comradeacademy/backup/term.csv','C:/xampp/htdocs/comradeacademy/backup/users.csv');
	$tables = array('subject','student','payment','class','pay','role','session','studentsubject','userrole','term','users');

	 for($i=0; $i<count($files); $i++){
	if (!$file = @ fopen($files[$i], 'x')) {
	// write the contents
	
	 unlink($unlink[$i]);
		try{
		
	$sql = 'SELECT * INTO OUTFILE '.$files[$i].' FIELDS TERMINATED BY \',\' LINES TERMINATED BY \'\n\' FROM '.$tables[$i].'';
	$s = $pdo->prepare($sql);
    $s->execute();

	}catch(exception $e){
		$error = 'Server Cannot Output File'.$e;
		include 'error.html.php';
		exit();
	}	
	}
  }
   $message = 'Data Backup Successful';
   $link='.';
   include 'success.html.php';
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
    $sql = 'INSERT INTO users SET
        name = :name,
        phone = :phone,
        address = :address,
        gender = :gender,
        date = CURDATE(),
		classid =:classid,
        email = :email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':phone', $_POST['phone']);
    $s->bindValue(':address', $_POST['address']);
    $s->bindValue(':gender', $_POST['gender']);
    $s->bindValue(':email', $_POST['email']);
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
 

  //header('Location: .');
  $message = 'User Added';
  $link = '.';
  include 'success.html.php';
  //exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Update')
{
  include  '../../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, name, phone, address, gender, date, email, classid FROM users WHERE id = :id';
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
    $sql = 'UPDATE users SET
        name = :name,
        phone = :phone,
        address = :address,
        gender = :gender,
        date = :date,
        email = :email,
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
  //exit();
    
  
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
  //exit();
}

// Display user list
include  '../../includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, name, phone, email  FROM users where deleted = 0');
}
catch (PDOException $e)
{
  $error = 'Error fetching users from the database!'.$e;
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $users[] = array('id' => $row['id'], 'name' => $row['name'],'phone' => $row['phone'],'email' => $row['email'] );
}

include 'users.html.php';
