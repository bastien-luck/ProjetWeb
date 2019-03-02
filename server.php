<?php
include('session.php') ;
include('check.php');

// initializing variables
$username = "";
$email    = "";
$errors_reg = array(); 
$errors_log = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'projet_web');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $token = mysqli_real_escape_string($db, htmlspecialchars($_POST['token']));
  $username = mysqli_real_escape_string($db, htmlspecialchars($_POST['username']));
  $userFirstname = mysqli_real_escape_string($db, htmlspecialchars($_POST['userFirstname']));
  $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));
  $civ = mysqli_real_escape_string($db, htmlspecialchars($_POST['customer_title']));
  $bday = mysqli_real_escape_string($db, htmlspecialchars($_POST['bday']));
  $password_1 = mysqli_real_escape_string($db, htmlspecialchars($_POST['password_1']));
  $password_2 = mysqli_real_escape_string($db, htmlspecialchars($_POST['password_2']));
  $user_permission = 1;

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if ($token != md5("R9huKhiwbzcxJUETqqnkFZtow2yduqodPFxEjHAAyoNvGs7fnCFKtAtae96MpJxpqeOp0ImgdpegRTXuCJoVQ1GoqHl4QQu7kdvPnyeFzHSL6JaaMC5hGuuoREihfEEZl2n4dL2tG8o8Ax78Jl1qm3vloQLn9WQyFk01qWkaoJk5DQHYMsKGYy7a5kPzfZ1oyJcTYSOPA9wrIGyfgfn1JdQXRPn9AdsF6tUDbcApc45rgL4DAt2DSwAWvCGmYGPWBqkx1NenAFx4ROxZ3iN73nvEleNeNRCnseJfMrwTARUqQP5QyMKQZsAeialN3Ylm4wCzRH3A49thIcu7h12HGwg9JVDDMMXgJHXLGtZ1wnckppR4V6jNcJDicMk70sxdu7ElB3B1UtPGcDY07hqCttvZbRnqpLKV7Sv32a7Db8Tu75bp2hoqR2X5TTCFhRtp5fyiZXhgTYVNlf8M6SeLa3TuC4b5wDAlNSr9KSXYMun8tLfesQTlCZTaAiB1aI9lQAyagWTlglK1qeY0lmuWHsMFF2vZT1Vfn10qZ49DIXvjFP9hl4ZHll37477mZCUGRFisnWGZu8eDgRbc80a8rVFhCgvSrfvwBxr4N6RUeymWlccXrrNYidLfSONCYULd")) { array_push($errors_reg, "ERROR");}
  if (empty($username)) { array_push($errors_reg, "Username is required"); }
  if (empty($userFirstname)) { array_push($errors_reg, "UserFirstname is required"); }
  if (empty($email)) { array_push($errors_reg, "Email is required"); }
  if (empty($civ)) { array_push($errors_reg, "Civ is required"); }
  if (empty($bday)) { array_push($errors_reg, "Bday is required"); }
  if (empty($password_1)) { array_push($errors_reg, "Password is required"); }
  if ($password_1 != $password_2) {
  array_push($errors_reg, "The two passwords do not match");
  }

  if (verifName($username)) { array_push($errors_reg, "Prenom invalide. Utilisez que des Lettres ou/et des Nombres"); }
  if (verifName($userFirstname)) { array_push($errors_reg, "Nom invalide. Utilisez que des Lettres ou/et des Nombres"); }
  if (!verifMail($email)) { array_push($errors_reg, "Mail invalide"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE (Name='$username' AND First_name='$userFirstname' )OR Mail='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if (htmlspecialchars($user['Name']) === htmlspecialchars($username)) {
      array_push($errors_reg, "Username already exists");
    }

    if (htmlspecialchars($user['Mail']) === htmlspecialchars($email)) {
      array_push($errors_reg, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors_reg) == 0) {
    $password = md5(htmlspecialchars($password_1));//encrypt the password before saving in the database

    //$query = "INSERT INTO users (Name, First_name, Mail, psswd, User_permission, User_sex, User_Bday) 
    //      VALUES('$username','$userFirstname', '$email', '$password','$user_permission', '$civ', '$bday')";

    $query = "SELECT AddUser('$username','$userFirstname', '$email', '$password', NULL,'$user_permission', '$civ', '$bday')";

    mysqli_query($db, $query);
	
    $queryIdUser = "SELECT MAX(id_usr) as MaxId from users LIMIT 1";
    $result = mysqli_query($db, $queryIdUser);
    $idUserArray = mysqli_fetch_assoc($result);
    $idUser = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $idUserArray['MaxId'] )); // protection peut-être pas nécessaire mais id_user étant utilisé partout...

    $_SESSION['username'] = $username;
    $_SESSION['user_permission'] = $User_permission;
	$_SESSION['email'] = $email;
    $_SESSION['user_firstname'] =  $userFirstname;
    $_SESSION['id_user'] = $idUser;
    $_SESSION['phone_number'] = "" ;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
  }
}


// LOGIN USER
if (isset($_POST['login_user'])) {
  $mail = mysqli_real_escape_string($db, htmlspecialchars($_POST['mail']));
  $password = mysqli_real_escape_string($db, htmlspecialchars($_POST['password']));

  if (empty($mail)) {
    array_push($errors_log, "Mail is required");
  }
  if (empty($password)) {
    array_push($errors_log, "Password is required");
  }

  if (count($errors_log) == 0) {
    $password = md5(htmlspecialchars($password));
    $query = "SELECT * FROM Users WHERE id_usr = Login('$mail', '$password')";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $row = $results->fetch_array(MYSQLI_ASSOC);
      $_SESSION['username'] = htmlspecialchars($row['Name']);
      $_SESSION['user_permission'] = htmlspecialchars($row['User_permission']);
      $_SESSION['email'] = htmlspecialchars($mail);
      $_SESSION['success'] = "You are now logged in";
	  $_SESSION['user_firstname'] = htmlspecialchars($row['First_name']) ;
	  $_SESSION['id_user'] = htmlspecialchars(preg_replace( '#[^a-zA-Z0-9_/\.]#isU' , '' , $row['id_usr'] )) ;
	  $_SESSION['phone_number'] = htmlspecialchars($row['Telephone']) ;
      header('location: index.php');
    }else {
      array_push($errors_log, "Wrong username/password combination");
    }
  }
}


//Send Email
if (isset($_POST['contact'])) {


$to = 'ant.lefalher@gmail.com';

$subject = htmlspecialchars($_POST['subject']);

if(isset($_POST['email'])) {

$name = htmlspecialchars($_POST['name']);

$email = htmlspecialchars($_POST['email']);

$fields = array(

0 =>array(

'text' => 'Name',

'val' => htmlspecialchars($_POST['name'])

),

1 =>array(

'text' => 'Email address',

'val' => htmlspecialchars($_POST['email'])

),

2 =>array(

'text' => 'Message',

'val' => htmlspecialchars($_POST['message'])

)

);

$message = "";

foreach($fields as $field) {

$message .= htmlspecialchars($field['text']).": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";

}

$headers = '';

$headers .= 'From: ' . $name . ' <' . $email . '>' . "\r\n";

$headers .= "Reply-To: " .  $email . "\r\n";

$headers .= "MIME-Version: 1.0\r\n";

$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port","465");
ini_set("sendmail_from", $email);

if (mail($to, $subject, $message, $headers)){

$arrResult = array ('response'=>'success');

} else{

$arrResult = array ('response'=>'error');

}


} else {

$arrResult = array ('response'=>'error');

}
}

//EDIT USER
if (isset($_POST['edit_user'])) {

  //$_SESSION['success'] = "LA";

  // receive all input values from the form
  $username = mysqli_real_escape_string($db, htmlspecialchars($_POST['username']));
  $userFirstname = mysqli_real_escape_string($db, htmlspecialchars($_POST['userFirstname']));
  $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));
  $civ = mysqli_real_escape_string($db, htmlspecialchars($_POST['customer_title']));
  $bday = mysqli_real_escape_string($db, htmlspecialchars($_POST['bday']));
  $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id']));
  $number = mysqli_real_escape_string($db, htmlspecialchars($_POST['number']));
  $userPermission = mysqli_real_escape_string($db, htmlspecialchars($_POST['userPermission']));

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors_reg, "Username is required"); }
  if (empty($userFirstname)) { array_push($errors_reg, "UserFirstname is required"); }
  if (empty($email)) { array_push($errors_reg, "Email is required"); }
  if (empty($civ)) { array_push($errors_reg, "Civ is required"); }
  if (empty($bday)) { array_push($errors_reg, "Bday is required"); }
  if (empty($userPermission)) { array_push($errors_reg, "userPermission is required"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE (Name='$username' AND First_name='$userFirstname' )OR Mail='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  /*if ($user) { // if user exists
    if ($user['Name'] === $username) {
      array_push($errors_reg, "Username already exists");
    }

    if ($user['Mail'] === $email) {
      array_push($errors_reg, "email already exists");
    }
  }*/

  // Finally, register user if there are no errors in the form
  if (count($errors_reg) == 0) {


    $query = "UPDATE users SET Name='$username', First_name='$userFirstname', Mail='$email', User_sex='$civ', User_Bday='$bday', User_permission='$userPermission', Telephone='$number'
    WHERE id_usr = '$id'";
    mysqli_query($db, $query);
    $_SESSION['success'] = "Edit success";
    header('location: userManage.php');
  }
}

// CREATE USER
if (isset($_POST['create_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, htmlspecialchars($_POST['username']));
  $userFirstname = mysqli_real_escape_string($db, htmlspecialchars($_POST['userFirstname']));
  $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));
  $civ = mysqli_real_escape_string($db, htmlspecialchars($_POST['customer_title']));
  $bday = mysqli_real_escape_string($db, htmlspecialchars($_POST['bday']));
  $number = mysqli_real_escape_string($db, htmlspecialchars($_POST['number']));
  $userPermission = mysqli_real_escape_string($db, htmlspecialchars($_POST['userPermission']));
  $password_1 = mysqli_real_escape_string($db, htmlspecialchars($_POST['password_1']));
  $password_2 = mysqli_real_escape_string($db, htmlspecialchars($_POST['password_2']));
  $user_permission = 1;

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors_reg, "Username is required"); }
  if (empty($userFirstname)) { array_push($errors_reg, "UserFirstname is required"); }
  if (empty($email)) { array_push($errors_reg, "Email is required"); }
  if (empty($civ)) { array_push($errors_reg, "Civ is required"); }
  if (empty($bday)) { array_push($errors_reg, "Bday is required"); }
  if (empty($userPermission)) { array_push($errors_reg, "userPermission is required"); }
  if (empty($password_1)) { array_push($errors_reg, "Password is required"); }
  if ($password_1 != $password_2) {
  array_push($errors_reg, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE (Name='$username' AND First_name='$userFirstname' )OR Mail='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if (htmlspecialchars($user['Name']) === htmlspecialchars($username)) {
      array_push($errors_reg, "Username already exists");
    }

    if (htmlspecialchars($user['Mail']) === htmlspecialchars($email)) {
      array_push($errors_reg, "email already exists");
    }

    if (htmlspecialchars($user['Telephone']) === htmlspecialchars($number)) {
      array_push($errors_reg, "number already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors_reg) == 0) {
    $password = md5(htmlspecialchars($password_1));//encrypt the password before saving in the database


    $query = "SELECT AddUser('$username','$userFirstname', '$email', '$password', '$number','$userPermission', '$civ', '$bday')";
    mysqli_query($db, $query);
    $_SESSION['success'] = "You are now logged in";
    header('location: userManage.php');
  }
}

// CREATE PRODUCT
if (isset($_POST['create_product'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['productName']));
  $price = mysqli_real_escape_string($db, htmlspecialchars($_POST['productPrice']));
  $description = mysqli_real_escape_string($db, htmlspecialchars($_POST['productDescription']));
  if ( preg_replace( '#^[a-zA-Z_0-9]*(.png|.jpg)$#isU' , "ok" , $_FILES['productImage']['name'] ) == "ok" )
  {
    $image = mysqli_real_escape_string($db, $_FILES['productImage']['name']);
  }
  else
  {
    $image = "error" ;
  }

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors_reg, "name is required"); }
  if (empty($price)) { array_push($errors_reg, "price is required"); }
  if (empty($description)) { array_push($errors_reg, "description is required"); }
  if (empty($image)) { array_push($errors_reg, "an image is required"); }
  if ($image == "error") { array_push($errors_reg, "the image is not allowed"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM products WHERE Name='name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $product = mysqli_fetch_assoc($result);
  
  if ($product) { // if product exists
    if (htmlspecialchars($product['Name']) === htmlspecialchars($name)) {
      array_push($errors_reg, "name already exists");
    }
  }

  // Finally, create the product if there are no errors in the form
  if (count($errors_reg) == 0) {

    $query = "INSERT INTO products (Name,Description,Price,Picture) VALUES ('$name','$description','$price','$image')";
    mysqli_query($db, $query);
    $queryIdProd = "SELECT MAX(id_prod) as MaxId from products LIMIT 1";
    $result = mysqli_query($db, $queryIdProd);
    $idProdArray = mysqli_fetch_assoc($result);
    $idProd = htmlspecialchars($idProdArray['MaxId']);
    $queryPC = "INSERT INTO  product_category (Product,Category) VALUES ('$idProd','1')";
    mysqli_query($db, $queryPC);
    header('location: productManage.php');
  }
}

//EDIT PRODUCT
if (isset($_POST['edit_product'])) {


  // receive all input values from the form
  $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['productName']));
  $price = mysqli_real_escape_string($db, htmlspecialchars($_POST['productPrice']));
  $description = mysqli_real_escape_string($db, htmlspecialchars($_POST['productDescription']));
  if ( preg_replace( '#^[a-zA-Z_0-9]*(.png|.jpg)$#isU' , "ok" , $_FILES['productImage']['name'] ) == "ok" )
  {
    $image = mysqli_real_escape_string($db, $_FILES['productImage']['name']);
  }
  else
  {
    $image = "error" ;
  }
  $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id']));

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors_reg, "name is required"); }
  if (empty($price)) { array_push($errors_reg, "price is required"); }
  if (empty($description)) { array_push($errors_reg, "description is required"); }
  if (empty($image)) { array_push($errors_reg, "an image is required"); }
  if ($image == "error") { array_push($errors_reg, "the image is not allowed"); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM products WHERE Name='name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $product = mysqli_fetch_assoc($result);


  // Finally, register user if there are no errors in the form
  if (count($errors_reg) == 0) {

    $query = "UPDATE products SET Name='$name', Price='$price', Description='$description', Picture='$image' WHERE id_prod = '$id'";
    mysqli_query($db, $query);
    $_SESSION['success'] = "Edit success";
    header('location: productManage.php');
  }
}

//CREATE ADDRESSES
if (isset($_POST['create_adr'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['addr_name']));
  $street = mysqli_real_escape_string($db, htmlspecialchars($_POST['street']));
  $additional = mysqli_real_escape_string($db, htmlspecialchars($_POST['additional']));
  $country = mysqli_real_escape_string($db, htmlspecialchars($_POST['country']));
  $city = mysqli_real_escape_string($db, htmlspecialchars($_POST['city']));
  $postcode = mysqli_real_escape_string($db, htmlspecialchars($_POST['postcode']));
  $id_user = mysqli_real_escape_string($db, htmlspecialchars($_POST['user_id']));

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors_reg, "Name is required"); }
  if (empty($street)) { array_push($errors_reg, "Street is required"); }
  if (empty($additional)) { array_push($errors_reg, "Additional is required"); }
  if (empty($country)) { array_push($errors_reg, "Country is required"); }
  if (empty($city)) { array_push($errors_reg, "City is required"); }
  if (empty($postcode)) { array_push($errors_reg, "Postcode is required"); }


  // Finally, register user if there are no errors in the form
  if (count($errors_reg) == 0) {


    $query = "INSERT INTO addresses (Street,Additional,Postcode,City,Country) VALUES ('$street','$additional','$postcode','$city','$country')";
    mysqli_query($db, $query);
    $queryIdAdr = "SELECT MAX(id_addr) as MaxId from addresses LIMIT 1";
    $result = mysqli_query($db, $queryIdAdr);
    $idAdrArray = mysqli_fetch_assoc($result);
    $idAdr = htmlspecialchars($idAdrArray['MaxId']);
    $queryAdr = "INSERT INTO client_addr (Client,Address,Name) VALUES ('$id_user','$idAdr','$name')";
    mysqli_query($db, $queryAdr);

    //$_SESSION['success'] = "You are now logged in";
    header('location: account_user.php');
  }
}


?>
