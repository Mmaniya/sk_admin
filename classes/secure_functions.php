<?php
class functions 
{
static function input($value)
  { 
	$strips = strip_tags(trim($value));
	$html = htmlentities($strips);
	$input = mysqli_real_escape_string($con,$html);
	return $input;
  }	
	
}

?>