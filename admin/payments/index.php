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

if (!userHasRole('Secretary'))
{
  $error = 'Only Secretary can Access this Page.';
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
    //include 'error.html.php';
    exit();
  }
  $_SESSION['teacher'] = $row['name'];
  $_SESSION['class'] = $row['classid'];
  $_SESSION['paymentid'] = session_id();

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
if (isset($_POST['action']) and $_POST['action'] == 'Submit')
{
    $action = '';
    
  include '../../includes/db.inc.php';

  // check for payment type existence
	$sql= 'Select name, classid, amount from pay';
    $s = $pdo->prepare($sql);
    
    if ($s->execute()){
        foreach ($s as $row){
            $name = $row['name'];
			$class = $row['classid'];
			$amount = $row['amount'];
			
			if($name == $_POST['name'] && $class == $_POST['classes'] && $amount == $_POST['amount'] ){
			$error = 'This Payment Already Exist you can only modify/change it.';
			include 'error.html.php';
			exit();
			
		}
            
        } 
		
    } 
  try
  {
    $sql = 'INSERT INTO pay set name=:name, classid=:classid, amount=:amount';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':amount', $_POST['amount']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding payment type.'.$e;
    include 'error.html.php';
    exit();
  }
   $message= 'Payment Type successfully Added';
  $link='.';
  include 'success.html.php';
  //exit();
}

// make changes to the expenses
if (isset($_POST['action']) and $_POST['action'] == 'Update')
{
  include '../../includes/db.inc.php';
  try
  {
    $sql = 'SELECT id, beneficiary, purpose, amount, date FROM expenses where id=:id';
    $s = $pdo->prepare($sql);
	$s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error getting expenses'.$e;
    include 'error.html.php';
    exit();
  }
    $row = $s->fetch();
    $pageTitle = 'Expenses Update Form';
	$pageHeading = 'Please Carefully Make Your Changes';
	$action = 'updateform';
	$id = $row['id'];
	$amount = $row['amount'];
	$beneficiary = $row['beneficiary'];
	$purpose = $row['purpose'];
	$date = $row['date'];
	$button = 'Submit';
	include 'expensesform.html.php';
	exit();
}

//Load Expenses changes to database 
if(isset($_GET['updateform'])){
	include '../../includes/db.inc.php';
	try
  {
    $sql = 'UPDATE expenses SET
		beneficiary = :beneficiary,
        date = :date,
		purpose = :purpose,
        amount = :amount
		Where id=:id';
    $s = $pdo->prepare($sql);
	$s->bindValue(':id', $_POST['id']);
	$s->bindValue(':beneficiary', $_POST['beneficiary']);
	$s->bindValue(':purpose', $_POST['purpose']);
	$s->bindValue(':amount', $_POST['amount']);
	$s->bindValue(':date', $_POST['date']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error making changes'.$e;
    include 'error.html.php';
    exit();
  }
  //header('Location: .');
  $message = 'Change Successfully Added';
  $link = '?expensesdetail';
  include 'success.html.php';
  //exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Print')
{
  include '../../includes/db.inc.php';
	try
  {
    $sql = 'SELECT id, beneficiary, purpose, amount, date FROM expenses where id=:id';
    $s = $pdo->prepare($sql);
	$s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error getting expenses'.$e;
    include 'error.html.php';
    exit();
  }
  foreach($s as $row){
	$expenses[] = array('id'=>$row['id'],'beneficiary'=>$row['beneficiary'],'purpose'=>$row['purpose'],'date'=>$row['date'],'amount'=>$row['amount']);  
  }
  $back='?expensesdetail';
  include 'expensessheet.html.php';
  exit();
}
  
  if (isset($_POST['action']) and $_POST['action'] == 'Make Payment'){ 
  
  include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, regnumber, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit(); }
  $row = $s->fetch();
  $pageTitle = 'Make Payment';
  $pageHeading ='Select Payment Type, Enter Amount to be Paid and Press Submit';
  $action = 'paymentform';
  $regnumber = $row['regnumber'];
  $classid = $row['classid'];
  $sessionid = $row['sessionid'];
  $termid = $row['termid'];
  $id = $row['id'];
  $button = 'Submit';
  
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
  
  // Build the list of all pay
	
  try
  {
    $result = $pdo->query('SELECT id, name, amount FROM pay where classid ='.$classid.'  and deleted=0 order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of terms.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $ptypes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
	  'amount' => $row['amount'],
      'selected' => False);
  }

 include 'form.html.php';
  exit();
}

if (isset($_GET['paymentform']))
{
  include '../../includes/db.inc.php';
   $_SESSION['cart'][] = $_POST['ptype'];
  try
  {
    $sql = 'INSERT INTO payment SET
		regnumber = :regnumber,
        date = CURDATE(),
		studentid = :studentid,
		payid = :payid,
        classid = :classid,
		sessionid = :sessionid,
		termid = :termid,
		paymentid = :paymentid,
		amount =:amount';
    $s = $pdo->prepare($sql);
	$s->bindValue(':payid', $_POST['ptype']);
    $s->bindValue(':regnumber', $_POST['regnumber']);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':studentid', $_POST['id']);
	$s->bindValue(':sessionid', $_POST['sessions']);
	$s->bindValue(':termid', $_POST['terms']);
	$s->bindValue(':paymentid',$_SESSION['paymentid']);
	$s->bindValue(':amount', $_POST['amount']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    //$error = 'Error Making Your Changes';
    $error=$e;
    include 'error.html.php';
    exit();
  }
  //header('Location: .');
  $message = 'Payment is Successful';
  $link = '.';
  include 'success.html.php';
  //exit();
}

// See Report
if (isset($_POST['action']) and $_POST['action'] == 'Payment Summary')
{
	  include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
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
  $id = $row['id'];
  
	 
  // Get payments
  try { 
  $sql = 'SELECT payid, payment.amount as amountpaid,  pay.amount as amountdue, sum(payment.amount) as total, (pay.amount-sum(payment.amount)) as balance, 
  pay.name as description FROM payment inner join pay on pay.id = payid WHERE payment.studentid = :id and payment.classid=:classid and 
  payment.sessionid=:sessionid and payment.termid=:termid and payment.deleted=0 group by payid';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $id);
  $s->bindValue(':classid', $classid);
  $s->bindValue(':sessionid', $sessionid);
  $s->bindValue(':termid', $termid);
  $s->execute();
  }catch (PDOException $e) { 
  $error = 'Error fetching list of payments.';
  include 'error.html.php';
  exit();
  }
   
 $items = array();
foreach ($s as $row)
{
  $payments[] = array('payid' =>$row['payid'], 'amountpaid' => $row['amountpaid'], 'amountdue' => $row['amountdue'], 'total' => $row['total'], 'balance' => $row['balance'], 'description' => $row['description']);
      array_push($items,$row['payid']);
    } 
     //$items = $sale['pid'];
     $cart = array();
     $total = 0;
           //$subtotal=0; 
           foreach ($items as $id)
          {
           foreach ($payments as $payment)
           {
              if ($payment['payid'] == $id)
           {
              $cart[] = $payment;
              $total += $payment['total'];
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
   
	$back='.';
	session_regenerate_id();
	include 'summary.html.php';
	exit();	  
  
}

// See Report
if (isset($_POST['action']) and $_POST['action'] == 'See Receipt')
{
	  include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
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
  $id = $row['id'];
  
	 
  // Get payment details
  try { 
  $sql = 'SELECT payid, payment.amount as amountpaid,  pay.amount as amountdue, pay.name as description FROM payment inner join pay on pay.id = payid WHERE paymentid = :paymentid AND date = CURDATE() AND payment.deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':paymentid', $_SESSION['paymentid']);
  //$s->bindValue(':date', 'CURDATE()');
  $s->execute();
  }catch (PDOException $e) { 
  $error = 'Error fetching payment detail.'.$e;
  include 'error.html.php';
  exit();
  }
  
 $items = array();
 $balance = array();
foreach ($s as $row)
{
  $payments[] = array('payid' =>$row['payid'], 'amountpaid' => $row['amountpaid'], 'amountdue' => $row['amountdue'], 'description' => $row['description']);
      array_push($items,$row['payid']);
	  
	  //get balance for each payment
	   try { 
  $sql = 'SELECT (pay.amount-sum(payment.amount)) as balance FROM payment inner join pay on pay.id = payid WHERE payid = :payid AND studentid=:studentid and payment.deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':payid', $row['payid']);
  $s->bindValue(':studentid', $id);
  $s->execute();
  $balancerow = $s->fetch();
  array_push($balance, $balancerow['balance']);
  }catch (PDOException $e) { 
  $error = 'Error fetching balance for this payment.'.$e;
  include 'error.html.php';
  exit();
  }
    } 
     //$items = $sale['pid'];
     $cart = array();
     $total = 0;
           //$subtotal=0; 
           foreach ($items as $id)
          {
           foreach ($payments as $payment)
           {
              if ($payment['payid'] == $id)
           {
              $cart[] = $payment;
              $total += $payment['amountpaid'];
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
   
	$back='.';
	$date=date('Y-m-d');
	unset ($_SESSION['cart']);
	session_regenerate_id();
	include 'receipt.html.php';
	exit();	  
  
}
// session cart
if(!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}
// See Report
if (isset($_POST['action']) and $_POST['action'] == 'ReCheck Receipt')
{
	  include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, surname, firstname, othername, regnumber, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
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
  $id = $row['id'];
  
	 
  // Get list payments
  try { 
  $sql = 'SELECT payid, payment.amount as amountpaid,  pay.amount as amountdue, pay.name as description FROM payment inner join pay on pay.id = payid WHERE paymentid = :paymentid AND date = :date AND payment.deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':paymentid', $_POST['paymentid']);
  $s->bindValue(':date', $_POST['date']);
  $s->execute();
  }catch (PDOException $e) { 
  $error = 'Error fetching payment detail.'.$e;
  include 'error.html.php';
  exit();
  }
  
 $items = array();
 $balance = array();
foreach ($s as $row)
{
  $payments[] = array('payid' =>$row['payid'], 'amountpaid' => $row['amountpaid'], 'amountdue' => $row['amountdue'], 'description' => $row['description']);
      array_push($items,$row['payid']);
	  
	    //get balance for each payment
	   try { 
  $sql = 'SELECT (pay.amount-sum(payment.amount)) as balance FROM payment inner join pay on pay.id = payid WHERE payid = :payid AND studentid=:studentid AND payment.deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':payid', $row['payid']);
  $s->bindValue(':studentid', $id);
  $s->execute();
  $balancerow = $s->fetch();
  array_push($balance, $balancerow['balance']);
  }catch (PDOException $e) { 
  $error = 'Error fetching balance for this payment.'.$e;
  include 'error.html.php';
  exit();
  }
    } 
     //$items = $sale['pid'];
     $cart = array();
     $total = 0;
           //$subtotal=0; 
           foreach ($items as $id)
          {
           foreach ($payments as $payment)
           {
              if ($payment['payid'] == $id)
           {
              $cart[] = $payment;
              $total += $payment['amountpaid'];
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
   
	$back='?todaypayments';
	$date=$_POST['date'];
	include 'receipt.html.php';
	exit();	  
  
}

//Add pay type for another class
// Change pay information
  if (isset($_POST['action']) and $_POST['action'] == 'Add Another Class')
{
   include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, name, amount, classid FROM pay WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit(); 
  }
  $row = $s->fetch();
  $pageTitle = 'Register This Pay Type For Another Class';
  $pageHeading ='Choose the Class, Enter Amount and Press Add to Submit';
  $action = 'addtypeform';
  $name = $row['name'];
  $amount = $row['amount'];
  $classid = $row['classid'];
  $id = $row['id'];
  $button = 'Add';
  	   
// Get list of class assigned to this paytype
 
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
  include 'payform.html.php';
  exit();
  }
  
  if (isset($_GET['addtypeform']))
{
	 include '../../includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO pay SET
		name = :name,
		classid = :classid,
		amount =:amount';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':amount', $_POST['amount']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding the pay type for the selected class'.$e;
    include 'error.html.php';
    exit();
  }
  //header('Location: .');
  $message = 'Pay Type is Successfully Added';
  $link = '?paytype';
  include 'success.html.php';
  //exit();
	
}

// Change pay information
  if (isset($_POST['action']) and $_POST['action'] == 'Change')
{
   include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, name, amount, classid FROM pay WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit(); 
  }
  $row = $s->fetch();
  $pageTitle = 'Update Pay Information';
  $pageHeading ='Make Your Change(s) and Press Change to Submit';
  $action = 'changeform';
  $name = $row['name'];
  $amount = $row['amount'];
  $classid = $row['classid'];
  $id = $row['id'];
  $button = 'Change';
  	   
// Get list of class assigned to this paytype
 
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
  include 'payform.html.php';
  exit();
  }
  
  if (isset($_GET['changeform']))
{
	 include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE pay SET
		name = :name,
		classid = :classid,
		amount =:amount
		where id=:id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':id', $_POST['id']);
	$s->bindValue(':amount', $_POST['amount']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    //$error = 'Error Making Your Changes';
    $error=$e;
    include 'error.html.php';
    exit();
  }
  //header('Location: .');
  $message = 'Change is Successful';
  $link = '?paytype';
  include 'success.html.php';
  //exit();
	
}

//Expenses profile
if (isset($_POST['action']) and $_POST['action'] == 'Expenses Profile')
{
	if (isset($_POST['edate']) && $_POST['edate'] ==''){
		$error = 'Please Enter Date';
		include 'error.html.php';
		exit();
	}
   //get total payments
   try
  {
	$day = explode('-', $_POST['edate'])[2];
	$month = explode('-', $_POST['edate'])[1];
	$year = explode('-', $_POST['edate'])[0];
	// day total
	$sql = 'SELECT sum(amount) as daytotal FROM expenses WHERE day(date)=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $day);
    $s->execute();
	$row = $s->fetch();
	$daytotal = $row['daytotal'];
	// month total
	$sql = 'SELECT sum(amount) as monthtotal FROM expenses WHERE month(date)=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $month);
    $s->execute();
	$row = $s->fetch();
	$monthtotal = $row['monthtotal'];
	// year total
	$sql = 'SELECT sum(amount) as yeartotal FROM expenses WHERE year(date)=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $year);
    $s->execute();
	$row = $s->fetch();
	$yeartotal = $row['yeartotal'];
	$message = 'The total expenses for day '.$day.' is '.$daytotal.'| The total expenses for month '.$month.' is '.$monthtotal.'| The total expenses for Year '.$year.' is '.$yeartotal.'.';
	$link = '?expensesdetail';
	include 'success.html.php';
 
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching expense total.'.$e;
    include 'error.html.php';
    exit();
  }
}

//get revenue profile
if (isset($_POST['action']) and $_POST['action'] == 'Revenue Profile')
{
	if (isset($_POST['pdate']) && $_POST['pdate'] ==''){
		$error = 'Please Enter Date';
		include 'error.html.php';
		exit();
	}
   //get total payments
   try
  {
	$day = explode('-', $_POST['pdate'])[2];
	$month = explode('-', $_POST['pdate'])[1];
	$year = explode('-', $_POST['pdate'])[0];
	// day total
	$sql = 'SELECT sum(amount) as daytotal FROM payment WHERE day(date)=:date and deleted=0';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $day);
    $s->execute();
	$row = $s->fetch();
	$daytotal = $row['daytotal'];
	// month total
	$sql = 'SELECT sum(amount) as monthtotal FROM payment WHERE month(date)=:date and deleted=0';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $month);
    $s->execute();
	$row = $s->fetch();
	$monthtotal = $row['monthtotal'];
	// year total
	$sql = 'SELECT sum(amount) as yeartotal FROM payment WHERE year(date)=:date and deleted=0';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $year);
    $s->execute();
	$row = $s->fetch();
	$yeartotal = $row['yeartotal'];
	$message = 'The total revenue for day '.$day.' is '.$daytotal.'| The total revenue for month '.$month.' is '.$monthtotal.'| The total revenue for Year '.$year.' is '.$yeartotal.'.';
	$link = '?todaypayments';
	include 'success.html.php';
 
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching payment total.'.$e;
    include 'error.html.php';
    exit();
  }

  
}
//get detail of payment
if (isset($_POST['action']) and $_POST['action'] == 'Detail')
{
	
  include '../../includes/db.inc.php';

  try
  {
	$sql = 'SELECT payment.id as id, payid, studentid, payment.amount as amount, payment.date as date, pay.name as paymenttype FROM payment inner join
	pay on pay.id=payid WHERE paymentid =:paymentid AND date =:date and payment.deleted=0' ;
	$s = $pdo->prepare($sql);
    $s->bindValue(':paymentid', $_POST['paymentid']);
	$s->bindValue(':date', $_POST['date']);
    $s->execute();

  foreach ($s as $row)
  {
    $payments[] = array(
      'id' => $row['id'],
      'payid' => $row['payid'],
	  'studentid' => $row['studentid'],
	  'amount' => $row['amount'],
	  'paymenttype' => $row['paymenttype'],
	  'date' => $row['date']);
  }
	}catch (PDOException $e)
  {
    $error = 'Error fetching payments'.$e;
    //$error=$e;
    include 'error.html.php';
    exit();
  }
  $header ='Detail of Payments';
  include 'paymentdetail.html.php';
  exit();
	
}

//get corrected payments
//get deleted  payment
if (isset($_GET['correctedpayments']))
{
	
  include '../../includes/db.inc.php';

  try
  {
	$sql = 'SELECT payment.id as id, payid, studentid, surname, firstname, othername, class.name as class, session.name as session, term.name as term,  payment.amount as amount, payment.date as date, pay.name as paymenttype FROM payment inner join
	pay on pay.id=payid inner join student on student.id = studentid inner join class on class.id = payment.classid
	inner join session on session.id=payment.sessionid inner join term on term.id=payment.termid WHERE payment.corrected=1 order by id DESC' ;
	$s = $pdo->prepare($sql);
    $s->execute();

  foreach ($s as $row)
  {
    $payments[] = array(
      'id' => $row['id'],
      'payid' => $row['payid'],
	  'surname' => $row['surname'],
	  'firstname' => $row['firstname'],
	  'othername' => $row['othername'],
	  'class' => $row['class'],
	  'session' => $row['session'],
	  'term' => $row['term'],
	  'amount' => $row['amount'],
	  'paymenttype' => $row['paymenttype'],
	  'date' => $row['date']);
  }
	}catch (PDOException $e)
  {
    $error = 'Error fetching payments'.$e;
    //$error=$e;
    include 'error.html.php';
    exit();
  }
  $header ='List of Corrected payments';
  include 'deleteddetail.html.php';
  exit();
	
}

//get deleted  payment
if (isset($_GET['deletedpayments']))
{
	
  include '../../includes/db.inc.php';

  try
  {
	$sql = 'SELECT payment.id as id, payid, studentid, surname, firstname, othername, class.name as class, session.name as session, term.name as term,  payment.amount as amount, payment.date as date, pay.name as paymenttype FROM payment inner join
	pay on pay.id=payid inner join student on student.id = studentid inner join class on class.id = payment.classid
	inner join session on session.id=payment.sessionid inner join term on term.id=payment.termid WHERE payment.deleted=1 order by id DESC' ;
	$s = $pdo->prepare($sql);
    $s->execute();

  foreach ($s as $row)
  {
    $payments[] = array(
      'id' => $row['id'],
      'payid' => $row['payid'],
	  'surname' => $row['surname'],
	  'firstname' => $row['firstname'],
	  'othername' => $row['othername'],
	  'class' => $row['class'],
	  'session' => $row['session'],
	  'term' => $row['term'],
	  'amount' => $row['amount'],
	  'paymenttype' => $row['paymenttype'],
	  'date' => $row['date']);
  }
	}catch (PDOException $e)
  {
    $error = 'Error fetching payments'.$e;
    //$error=$e;
    include 'error.html.php';
    exit();
  }
  $header ='List of deleted payments';
  include 'deleteddetail.html.php';
  exit();
	
}

//Do correction on a payment
if (isset($_POST['action']) and $_POST['action'] == 'Correction')
{
	include  '../../includes/db.inc.php';
  
  try {   
  
  $sql = 'SELECT id, regnumber, classid, sessionid, termid FROM student WHERE id = :id and deleted=0';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['studentid']);
  $s->execute(); 
  }catch (PDOException $e){ 
  $error = 'Error fetching users details.'.$e;
  include 'error.html.php';
  exit(); }
  $row = $s->fetch();
  $pageTitle = 'Correction Page';
  $pageHeading ='Enter changes make your corrections and Press Submit';
  $action = 'correctionform';
  $regnumber = $row['regnumber'];
  $classid = $row['classid'];
  $sessionid = $row['sessionid'];
  $termid = $row['termid'];
  $id = $_POST['id'];
  //$sid = $_POST['studentid'];
  $amount = $_POST['amount'];
  $date = $_POST['date'];
  $button = 'Submit';
  
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

  // Get list of payment type assigned to this payment
 
 try
  {
    $sql = 'SELECT id FROM pay WHERE classid =:classid and id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':classid', $classid);
	$s->bindValue(':id', $_POST['payid']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of asigned payment type.';
    include 'error.html.php';
    exit();
  }
  
  $selectedType = array();
  foreach ($s as $row)
  {
    $selectedType[] = $row['id'];
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
  
  // Build the list of all pay
	
  try
  {
    $result = $pdo->query('SELECT id, name, amount FROM pay where classid='.$classid.' and deleted=0 order by name');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of pay.'.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
    $ptypes[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
	  'amount' => $row['amount'],
      'selected' => in_array($row['id'], $selectedType));
  }

 include 'form.html.php';
  exit();
}
//load correction to database
if(isset($_GET['correctionform'])){
	include '../../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE  payment SET
		regnumber = :regnumber,
        date = :date,
		payid = :payid,
        classid = :classid,
		sessionid = :sessionid,
		termid = :termid,
		amount =:amount,
		corrected = 1
		WHERE id = :id';
    $s = $pdo->prepare($sql);
	$s->bindValue(':id', $_POST['id']);
	$s->bindValue(':payid', $_POST['ptype']);
    $s->bindValue(':regnumber', $_POST['regnumber']);
	$s->bindValue(':classid', $_POST['classes']);
	$s->bindValue(':sessionid', $_POST['sessions']);
	$s->bindValue(':termid', $_POST['terms']);
	$s->bindValue(':amount', $_POST['amount']);
	$s->bindValue(':date', $_POST['date']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    //$error = 'Error Making Your Changes';
    $error=$e;
    include 'error.html.php';
    exit();
  }
  //header('Location: .');
  $message = 'Correction is Successful';
  $link = '?todaypayments';
  include 'success.html.php';
  //exit();
}

//Load Expenses form 
if(isset($_GET['expenses'])){
	include '../../includes/db.inc.php';
	$pageTitle = 'Expenses Form';
	$pageHeading = 'Please Carefully Fill the Form';
	$action = 'expensesform';
	$id ='';
	$amount ='';
	$beneficiary ='';
	$purpose='';
	$button='Submit';
	include 'expensesform.html.php';
}

//Load Expenses to database 
if(isset($_GET['expensesform'])){
	include '../../includes/db.inc.php';
	try
  {
    $sql = 'INSERT INTO expenses SET
		beneficiary = :beneficiary,
        date = :date,
		purpose = :purpose,
        amount = :amount';
    $s = $pdo->prepare($sql);
	$s->bindValue(':beneficiary', $_POST['beneficiary']);
	$s->bindValue(':purpose', $_POST['purpose']);
	$s->bindValue(':amount', $_POST['amount']);
	$s->bindValue(':date', date('Y-m-d'));
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error Adding expenses'.$e;
    include 'error.html.php';
    exit();
  }
  //header('Location: .');
  $message = 'Expenses Successfully Added';
  $link = '?expenses';
  include 'success.html.php';
  //exit();
}

// load expenses detail
//Load Expenses to database 
if(isset($_GET['expensesdetail'])){
	include '../../includes/db.inc.php';
	try
  {
    $sql = 'SELECT id, beneficiary, purpose, amount, date FROM expenses where date=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $_SESSION['date']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error getting expenses'.$e;
    include 'error.html.php';
    exit();
  }
  foreach($s as $row){
	$expenses[] = array('id'=>$row['id'],'beneficiary'=>$row['beneficiary'],'purpose'=>$row['purpose'],'date'=>$row['date'],'amount'=>$row['amount']);  
  }
  
  try
  {
    $sql = 'SELECT sum(amount)as expensestotal  FROM expenses where date=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $_SESSION['date']);
    $s->execute();
	$row = $s->fetch();
	$expensestotal = $row['expensestotal'];
  }
  catch (PDOException $e)
  {
    $error = 'Error getting expenses'.$e;
    include 'error.html.php';
    exit();
  }
  
  $pageheader = 'Expenses on '.$_SESSION['date'];
  $search = 'Load Expenses';
  include 'expensesdetail.html.php';
  exit();
}

// delete a student
  if (isset($_GET['restoreall']))
{
  include '../../includes/db.inc.php';
  try
  {
    $result = $pdo->query('SELECT count(id) as itemstorestore FROM pay where deleted=1');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching items to restore.';
    include 'error.html.php';
    exit();
  }

  foreach ($result as $row)
  {
   if($row['itemstorestore']<1){
	$message = 'No item(s) to restore.';
	$link='?paytypes'; 
    include 'success.html.php';
   }else{
	   // Restore the student
  try  {   
  $sql = 'UPDATE pay SET deleted = :deleted';      
  $s = $pdo->prepare($sql);      
  $s->bindValue(':deleted', 0);    
  //$s->bindValue(':id', $_POST['id']);     
  $s->execute();  
  }	catch (PDOException $e)  {    
	$error = 'Error restoring payment.';   
	include 'error.html.php';    
	exit();  
	}
  //header('Location: .');  
  $message= 'Restore successful'; 
  $link='?paytypes';  
  include 'success.html.php';  
  //exit();
	   
   }
  }
  
  }
// delete a payment type
  if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../../includes/db.inc.php';
  try  {   
  $sql = 'UPDATE pay SET deleted = :deleted WHERE id = :id';      
  $s = $pdo->prepare($sql);      
  $s->bindValue(':deleted', 1);    
  $s->bindValue(':id', $_POST['id']);     
  $s->execute();  
  }	catch (PDOException $e)  {    
	$error = 'Error deleting payment.';   
	include 'error.html.php';    
	exit();  
	}
  //header('Location: .');  
  $message= 'Delete Successful'; 
  $link='?paytypes';  
  include 'success.html.php';  
  //exit();
  }
  // delete a payment type
  if (isset($_POST['action']) and $_POST['action'] == 'Delete Payment')
{
  include '../../includes/db.inc.php';
  try  {   
  $sql = 'UPDATE payment SET deleted = :deleted WHERE id = :id';      
  $s = $pdo->prepare($sql);      
  $s->bindValue(':deleted', 1);    
  $s->bindValue(':id', $_POST['id']);     
  $s->execute();  
  }	catch (PDOException $e)  {    
	$error = 'Error deleting payment.';   
	include 'error.html.php';    
	exit();  
	}
  //header('Location: .');  
  $message= 'Delete Successful'; 
  $link='?todaypayments';  
  include 'success.html.php';  
  //exit();
  }
  // get expenses for other days
  if (isset($_POST['action']) and $_POST['action'] == 'Load Expenses')
{
	include '../../includes/db.inc.php';
	if (isset($_POST['edate']) && $_POST['edate'] ==''){
		$error = 'Please Enter Date';
		include 'error.html.php';
	}
	$_SESSION['date'] = $_POST['edate'];
	try
  {
    $sql = 'SELECT id, beneficiary, purpose, amount, date FROM expenses where date=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $_SESSION['date']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error getting expenses'.$e;
    include 'error.html.php';
    exit();
  }
  foreach($s as $row){
	$expenses[] = array('id'=>$row['id'],'beneficiary'=>$row['beneficiary'],'purpose'=>$row['purpose'],'date'=>$row['date'],'amount'=>$row['amount']);  
  }
  
  try
  {
    $sql = 'SELECT sum(amount)as expensestotal  FROM expenses where date=:date';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $_SESSION['date']);
    $s->execute();
	$row = $s->fetch();
	$expensestotal = $row['expensestotal'];
  }
  catch (PDOException $e)
  {
    $error = 'Error getting expenses'.$e;
    include 'error.html.php';
    exit();
  }
  
  $pageheader = 'Expenses on '.$_SESSION['date'];
  $search = 'Search Expenses';
  include 'expensesdetail.html.php';
  exit();
		
	}
  // get payments for previous days
 if (isset($_POST['action']) and $_POST['action'] == 'Load Payments')
{
	include '../../includes/db.inc.php';
	if (isset($_POST['pdate']) && $_POST['pdate'] ==''){
		$error = 'Please Enter Date';
		include 'error.html.php';
		
	}
	$_SESSION['date'] = $_POST['pdate'];
  try
  {
	
	$sql = 'SELECT paymentid, sum(amount) as amount, count(payment.id) as npayment, studentid, payment.regnumber as regnumber, payment.date as date, student.surname as surname, student.firstname as firstname, 
	student.othername as othername, class.name as class, term.name as term FROM payment inner join student on student.id = studentid inner join class on class.id = payment.classid inner join term on term.id = payment.termid 
	WHERE payment.date=:date and payment.deleted=0 group by paymentid order by payment.id DESC ';
    $s = $pdo->prepare($sql);
    $s->bindValue(':date', $_SESSION['date']);
	
    $s->execute();
  foreach ($s as $row)
  {
    $payments[] = array(
      'studentid' => $row['studentid'],
      'surname' => $row['surname'],
	  'firstname' => $row['firstname'],
	  'othername' => $row['othername'],
	  'npayment' => $row['npayment'],
	  'paymentid' => $row['paymentid'],
	  'regnumber' => $row['regnumber'],
	  'amount' => $row['amount'],
	  'date' => $row['date'],
	  'term' => $row['term'],
	  'class' => $row['class']);
  }
	}catch (PDOException $e)
  {
    $error = 'Error fetching payments';
    //$error=$e;
    include 'error.html.php';
    exit();
  }
  
   //get total payments
   try
  {
	
	$sql = 'SELECT sum(amount) as paymenttotal FROM payment WHERE date=:date and deleted=0';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $_SESSION['date']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching payment total.'.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $paymenttotal = $row['paymenttotal'];
  }
  
  $pageheader = 'List of Payments for '.$_POST['pdate'];
  $search = 'Load Payments';
  include 'payments.html.php';
  exit();
}

if (isset($_GET['paytypes']))
{
  include '../../includes/db.inc.php';

  try
  {
	$result = $pdo->query('SELECT pay.id as id, pay.name as payname, amount, class.name as classname FROM pay inner join class on class.id = classid where pay.deleted=0 order by payname');

  foreach ($result as $row)
  {
    $pays[] = array(
      'id' => $row['id'],
      'payname' => $row['payname'],
	  'classname' => $row['classname'],
	  'amount' => $row['amount']);
  }
	}catch (PDOException $e)
  {
    $error = 'Error fetching pay types';
    //$error=$e;
    include 'error.html.php';
    exit();
  }
  include 'pay.html.php';
  exit();
  }
  
  if (isset($_GET['todaypayments']))
{
  include '../../includes/db.inc.php';
  if(!isset($_SESSION['date'])){
	  $_SESSION['date'] = date('Y-m-d');
  }
  try
  {
	$sql = 'SELECT paymentid, sum(amount) as amount, count(payment.id) as npayment, studentid, payment.regnumber as regnumber, payment.date as date, student.surname as surname, student.firstname as firstname, 
	student.othername as othername, class.name as class, term.name as term FROM payment inner join student on student.id = studentid inner join class on class.id = payment.classid inner join term on term.id = payment.termid 
	where payment.date=:date and payment.deleted=0 group by paymentid order by payment.id DESC ';
	$s = $pdo->prepare($sql);
    $s->bindValue(':date', $_SESSION['date']);
	$s->execute();

  foreach ($s as $row)
  {
    $payments[] = array(
      'studentid' => $row['studentid'],
      'surname' => $row['surname'],
	  'firstname' => $row['firstname'],
	  'othername' => $row['othername'],
	  'npayment' => $row['npayment'],
	  'paymentid' => $row['paymentid'],
	  'regnumber' => $row['regnumber'],
	  'amount' => $row['amount'],
	  'date' => $row['date'],
	  'term' => $row['term'],
	  'class' => $row['class']);
  }
	}catch (PDOException $e)
  {
    $error = 'Error fetching payments'.$e;
    //$error=$e;
    include 'error.html.php';
    exit();
  }
  
  //get total payments
   try
  {
	
	$sql = 'SELECT sum(amount) as paymenttotal FROM payment WHERE date =:date and deleted=0';
    $s = $pdo->prepare($sql);
	$s->bindValue(':date', $_SESSION['date']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching payment total.'.$e;
    include 'error.html.php';
    exit();
  }

  foreach ($s as $row)
  {
    $paymenttotal = $row['paymenttotal'];
  }
  $pageheader = 'List of Payments for '.$_SESSION['date'];
  $search = 'Load Payments';
  include 'payments.html.php';
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
		$error = 'Error fetching students from the database!';  
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