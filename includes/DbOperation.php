<?php

class DbOperation
{
	private $con;

	function __construct()
	{
		require_once dirname(__FILE__) . '/DbConnect.php';
		$db = new DbConnect();
		$this->con = $db->connect();
	}

	// add users
	public function createUsers($name,$email,$password,$confirmPassword)
	{
		$stmt = $this->con->prepare("INSERT INTO `ka_members` (`name`,`email_address`,`password`, `confirm_password`,`status`,`created_date`) VALUES (?,?,?,?,'Not Active',CURDATE());");
		$stmt->bind_param("ssss",$name, $email, $password, $confirmPassword);
		if($stmt->execute())
			return true;
		return false;
	}

    // Get user identity
	public function getUsers()
	{
		$username = $_POST['email_address'];
        $password = $_POST['password'];

		$stmt = $this->con->prepare("SELECT user_id, email_address, password FROM `ka_members` WHERE email_address = '$username' AND password = '$password'");
		$stmt->execute();
		$stmt->bind_result($id, $username, $password);
		$users = array();

		while($stmt->fetch())
		{
			$temp = array();
			$temp['user_id'] = $id;
			$temp['email_address'] = $username;
			$temp['password'] = $password;
			array_push($users, $temp);
		}
		return $users;
	}

	// Get Brands 
	public function getBrands()
	{
		$server_ip = gethostbyname(gethostname());
     
		$stmt = $this->con->prepare("SELECT brand_id, brand_title, brand_desc, brand_img FROM brand");
		$stmt->execute();
		$stmt->bind_result($id, $title, $description, $image);
		$brands = array();


		while($stmt->fetch())
		{
			$temp = array();
			$temp['brand_id'] = $id;
			$temp['brand_title'] = $title;
			$temp['brand_desc'] = $description;
			$temp['brand_img'] = 'http://'.$server_ip.'/kahakishApi/images/'.$image;
			array_push($brands, $temp);
		}
		return $brands;
	}

	// Return slide info 
	public function getRandomItems()
	{
		$server_ip = gethostbyname(gethostname());
     
		$stmt = $this->con->prepare("SELECT id, title, shortdesc, rating, price, discount, shortcode, size, category, image FROM products");
		$stmt->execute();
		$stmt->bind_result($id, $title, $description, $rate, $price, $discount, $shortcode, $size, $cat, $image);
		$products = array();


		while($stmt->fetch())
		{
			$temp = array();
			$temp['id'] = $id;
			$temp['title'] = $title;
			$temp['shortdesc'] = $description;
			$temp['rating'] = $rate;
			$temp['price'] = $price;
			$temp['discount'] = $discount;
            $temp['shortcode'] = $shortcode;
            $temp['size'] = $size;
            $temp['category'] = $cat;
			$temp['image'] = 'http://'.$server_ip.'/kahakishApi/images/'.$image;
			array_push($products, $temp);
		}
		return $products;
	}

}
?>