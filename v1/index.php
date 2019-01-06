<?php


require_once '../includes/DbOperation.php';

$response = array();

if(isset($_GET['op']))
{
	switch ($_GET['op']) {
		    case 'adduser':
			 if(isset($_POST['name']) && isset($_POST['email_address']) && isset($_POST['password']) && isset($_POST['confirm_password']))
			 {
				$db = new DbOperation();
				if($db->createUsers($_POST['name'], $_POST['email_address'], $_POST['password'], $_POST['confirm_password']))
				{
					$response['code'] = 200;
					$response['error'] = false;
					$response['message'] = 'Registered successfully';
				}
				else
				{
					$response['code'] = 400;
					$response['error'] = true;
					$response['message'] = 'User already exist';
				}
			 }
			 else
			 {
			     $response['code'] = 500;
				 $response['error'] = true;
				 $response['message'] = 'Required Parameters are missing';	
			 }
			break;

		    case 'getuser':

		    if(isset($_POST['email_address']) && isset($_POST['password']))
			 {
				$db = new DbOperation();
				$kahkishuser = $db->getUsers();
				if(count($kahkishuser)<=0)
					{
					$response['code'] = 400;
					$response['error'] = true;
					$response['message'] = 'Not exist user!';
					}
				else
					{
					$response['code'] = 200;
					$response['error'] = false;
					$response['message'] = 'Login successfully';
					}
				}
			else
			 {
			     $response['code'] = 500;
				 $response['error'] = true;
				 $response['message'] = 'Required Parameters are missing';	
			 }
			break;

			case 'getbrands':

				$db = new DbOperation();
				$kahkishbrand = $db->getBrands();
				if(count($kahkishbrand)<=0)
					{
					$response['code'] = 400;
					$response['error'] = true;
					$response['message'] = 'No Brands Found';
					}
				else
					{
					$response['code'] = 200;
					$response['error'] = false;
					$response['brand'] = $kahkishbrand;
					}
				
			break;

			case 'getrandomitems':

				$db = new DbOperation();
				$kahkishrandom = $db->getRandomItems();
				if(count($kahkishrandom)<=0)
					{
					$response['code'] = 400;
					$response['error'] = true;
					$response['message'] = 'No Items Found';
					}
				else
					{
					$response['code'] = 200;
					$response['error'] = false;
					$response['products'] = $kahkishrandom;
					}
				
			break;
		
		    default:
			$response['code'] = 501;
			$response['error'] = true;
			$response['message'] = 'No operation to perform';
	}
}
else
{
		$response['code'] = 504;
		$response['error'] = false;
		$response['message'] = 'Invalid Request';
}

	echo json_encode($response);
?>