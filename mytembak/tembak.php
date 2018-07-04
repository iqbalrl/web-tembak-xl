<?php
 
require 'XlRequest.php';

function service($str) {
	
	switch ((int) $str) {
		
		case 1: return 8110577;
		break;
		
		case 2: return 8210882;
		break;
		
		case 3: return 8210883;
		break;
		
		case 4: return 8210884;
		break;
		
		case 5: return 8210885;
		break;
		
		case 6: return 8210886;
		break;
		
		case 7: return 8110624;
		break;
		
		case 8: return 8211010;
		break;
		
		case 9: return 8211011;
		break;
		
		case 10: return 8211012;
		break;
		
		case 11: return 8211013;
		break;
		
		case 12: return 8211014;
		break;




		default:
		
	}
}

if (isset($_POST['msisdn']) && isset($_POST['passwd']) && isset($_POST['reg']))
{
	$msisdn = $_POST['msisdn'];
	$passwd = $_POST['passwd'];
	$idService = service($_POST['reg']);
	
	if( !empty($_POST['manual']) )
	{
		$idService = $_POST['manual'];
	}
	try
	{
		$request = new XlRequest();
		$session = $request->login($msisdn,$passwd);
		if ($session !== false) {
			$fil = fopen('count_file.txt', 'r');
		    $dat = fread($fil, filesize('count_file.txt')); 
		    $dat+1;
		    fclose($fil);
		    $fil = fopen('count_file.txt', 'w');
		    fwrite($fil, $dat+1);
		    fclose($fil);
		    $register = $request->register($msisdn,$idService,$session);
		    if (!isset($register->responseCode)) {
				
				echo 'Terimakasih pembelian sedang diproses silahkan tunggu sms konfirmasi';
		    }
			else
			{
				print_r($register->message);
			}
		}
		else {
			
			echo "Login failed try againt";
			return;
		}
			
	}
	catch(Exception $e) {}
		
} else {
	   header("Location:/");
}
?>
