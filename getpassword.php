<?php
/**
 *Name:    XlRequest
 *Author:  Adipati arya
 *aryaadipati2@gmail.com
 *@adipati
 *
 * Added Awesomeness: Adipati arya
 *
 * Created:  11.10.2017
 *
 * Description:  Modified auth system based on Guzzle with extensive customization. This is basically what guzzle should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 * @package		Xlrequest
 * @author		aryaadipati2@gmail.com
 * @link		http://sshcepat.com/xl
 * @filesource	https://github.com/adipatiarya/XLRequest
 */
 
require 'XlRequest.php';

if (isset($_POST['msisdn'])) {
	
	$init  = new XlRequest();
	$pass = $init->getPass($_POST['msisdn']);
	//print_r($pass);
	if (!isset($pass->responseCode)) {
		//print_r($pass);
		echo "Password dikirim ke ". $_POST['msisdn'];
	}
	else {
		foreach($pass as $key=>$value) {
			echo $key . ' : ' . $value . "<br>";
		}
	}
}
else {
	Header("Location:/");
}
?>
