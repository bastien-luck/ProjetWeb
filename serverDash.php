<?php
	include('server_objet_a_vendre.php') ;
// initializing variables
$username = "";
$email    = "";
$errors_reg = array(); 
$errors_log = array();

// connect to the database
$GLOBALS['$db'] = mysqli_connect('localhost', 'root', '', 'projet_web');


function getUser()
{
	$user_check_query = "SELECT * FROM users";
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

function getUserId($id)
{
	$user_check_query = "SELECT * FROM users where id_usr = ".htmlspecialchars($id);
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

function deleteUser($id)
{
	$user_check_query = "DELETE FROM users where id_usr = ".htmlspecialchars($id);
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

function getProduct()
{
	$user_check_query = "SELECT * FROM products";
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

function getProductId($id)
{
	$user_check_query = "SELECT * FROM products where id_prod = ".htmlspecialchars($id);
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

function deleteProduct($id)
{
	$user_check_query = "DELETE FROM products where id_prod = ".htmlspecialchars($id);
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

function countUser()
{
	$user_check_query = "SELECT count(*) as count FROM users";
	$result = mysqli_query($GLOBALS['$db'], $user_check_query);
	return $result;
}

?>