<?php
	
function verifName($string){
	$size = strlen($string);
	for ($i = 0; $i < $size; $i++) {
		if(ord($string[$i])<48 || ord($string[$i])>122){
			echo "1";
			return true;
		}else if (ord($string[$i])<65 && ord($string[$i])>57){
			echo "2";
			return true;
		} else if (ord($string[$i])>90 && ord($string[$i])<97) {
			echo "3";
			return true;
		}
	}
	return false;
}

function verifMail($string)
{
	$res = filter_var($string, FILTER_VALIDATE_EMAIL);
	return $res;
}


?>

