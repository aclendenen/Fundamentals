<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($fname,$lname,$pos,$email,$pass,$gen,$dob)
	{
		$pos = strtolower($pos);
		$email_code = md5( rand(0,1000) );
		try
		{
			$new_password = password_hash($pass, PASSWORD_DEFAULT);
			$stmt = $this->conn->prepare("INSERT INTO users(first_name,last_name,gender,dob,position,email,password,email_code) 
		                                               VALUES(:fname,:lname,:gender,:dob,:pos,:email, :pass,:email_code)");
			//$stmt = $this->conn->prepare("INSERT INTO users(first_name,last_name,position,email,password) 
		     //                                          VALUES(:fname,:lname,:pos,:email, :pass)");
												  
			$stmt->bindparam(":fname", $fname);
			$stmt->bindparam(":lname", $lname);
			$stmt->bindparam(":gender", $gen);
			$stmt->bindparam(":dob", $dob);
			$stmt->bindparam(":pos", $pos);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":pass", $new_password);
			$stmt->bindparam(":email_code", $email_code);	
												  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	public function saveChanges($fname,$lname,$pos,$gen,$dob,$address)
	{
		$pos = strtolower($pos);
		try
		{
		$stmt = $this->conn->prepare("INSERT INTO users(first_name,last_name,gender,dob,position,address) 
		                                               VALUES(:fname,:lname,:gender,:dob,:pos,:address)");
		$stmt->bindparam(":fname", $fname);
		$stmt->bindparam(":lname", $lname);
		$stmt->bindparam(":gender", $gen);
		$stmt->bindparam(":dob", $dob);
		$stmt->bindparam(":pos", $pos);  
		$stmt->bindparam(":address",$address);
		
		$stmt->execute();
		
		return $stmt;  
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				                                          
	}
	
	public function login_user($email,$pass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email ");
			//$stmt = $this->conn->prepare("SELECT user_id,first_name,last_name,position,email, password FROM users WHERE email=:email ");
			$stmt->execute(array(':email'=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($pass, $userRow['password']) && $userRow['email_verify'] && $this->approveCheck($userRow['position'],$userRow['approved']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					$_SESSION['first_name'] = $userRow['first_name'];
					$_SESSION['last_name'] = $userRow['last_name'];
					$_SESSION['gender'] = $userRow['gender'];
					$_SESSION['dob'] = $userRow['dob'];
					$_SESSION['position'] = $userRow['position'];
					$_SESSION['email'] = $userRow['email'];
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function redirect_with_flash($url, $msg)
	{
		header("Location: $url?flash_msg=$msg");
	}
	
	public function logout_user()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['gender']);
		unset($_SESSION['dob']);
		unset($_SESSION['position']);
		unset($_SESSION['email']);
		return true;
	}
	
	public function pos_code_check($pos, $pos_code)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM positions WHERE position_code=:pos_code");
			$stmt->execute(array(':pos_code'=> $pos_code));
			$posRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if($posRow['position_type'] == strtolower($pos))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function verify_email($email, $email_code)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email AND email_code=:email_code");
			$stmt->execute(array(':email'=> $email, ':email_code' => $email_code));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				$stmt = $this->conn->prepare("UPDATE users SET email_verify='1' WHERE email=:email AND email_code=:email_code");
				$stmt->execute(array(':email'=> $email, ':email_code' => $email_code));
				return true;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function get_email_code($email)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
			$stmt->execute(array(':email'=> $email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				return $userRow['email_code'];

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function new_email_code($email)
	{
		try
		{
			$new_code = md5( rand(0,1000) );
			$stmt = $this->conn->prepare("UPDATE users SET email_code=:new_code WHERE email=:email");
			$stmt->execute(array(':new_code' => $new_code,':email'=> $email));
			//$stmt->execute();	
			return true;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function update_password($email,$password)
	{
		try
		{	
			$reset_password = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $this->conn->prepare("UPDATE users SET password=:reset_password WHERE email=:email");
			$stmt->execute(array(':reset_password' => $reset_password,':email'=> $email));
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function getItems($num_of_items, $offset)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM items ORDER BY name LIMIT $num_of_items OFFSET $offset");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				return $results;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function searchItemByName($name, $num_of_items, $offset)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM items WHERE name LIKE '%$name%' ORDER BY name LIMIT $num_of_items OFFSET $offset");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				return $results;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function nextItemsCheck($num_of_items, $offset)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM items ORDER BY name LIMIT $num_of_items OFFSET $offset");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				return true;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function getItemById($id)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM items WHERE item_id=$id");
			$stmt->execute();
			$item=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				return $item;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function editItemInStock($itemId,$in_stock)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE items SET in_stock=$in_stock WHERE item_id=$itemId");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function isItemInCart($userId, $itemId)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id=$userId AND item_id=$itemId");
			$stmt->execute();
			$item=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				return $item;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function createCartItem($userId, $itemId, $quantity)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO cart(user_id,item_id,quantity) VALUES($userId,$itemId,$quantity)");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function deleteCartItem($cartId)
	{
		try
		{
			$stmt = $this->conn->prepare("DELETE FROM cart WHERE cart_id=$cartId");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function editCartItem($cartId,$quantity)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE cart SET quantity=$quantity WHERE cart_id=$cartId");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function getCart($userId)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM cart c JOIN items i ON c.item_id = i.item_id WHERE user_id=$userId ORDER BY name");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount() > 0)
			{
				return $results;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function deleteCart($userId)
	{
		try
		{
			$stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id=$userId");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function orderCart($userId)
	{
		$cart = $this->getCart($userId);
		if($cart != false)
		{
			$orderId = $this->createOrder($userId);
			$order = $this->getOrderById($orderId);
			if($order != false)
			{
				for($i = 0; $i < count($cart); $i++)
				{
					if($cart[$i]["quantity"]<= $cart[$i]["in_stock"])
					{
						$success = $this->editItemInStock($cart[$i]["item_id"],$cart[$i]["in_stock"] - $cart[$i]["quantity"]);
						if($success != false)
						{
							$check = $this->addOrderItem($order["order_id"], $cart[$i]["item_id"],$cart[$i]["quantity"]);
						}
						
					}
					
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		$this->deleteCart($userId);
		return $order;
		
	}
	public function createOrder($userId)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO `order`(`user_id`) VALUES($userId)");
			$stmt->execute();	
			$orderId = $this->conn->lastInsertId();
			return $orderId;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function getOrderById($orderId)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM `order` WHERE order_id=$orderId");
			$stmt->execute();
			$order=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				return $order;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	public function addOrderItem($orderId, $itemId, $quantity)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO order_item(order_id,item_id,quantity) VALUES($orderId,$itemId,$quantity)");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	
	public function addItem($itemName,$itemCategory,$itemSupplier,$itemColor,$itemDimensions,$itemPrice,$itemStock,$leadTime,$itemDescription)
	{
	    try {
	    
	    //TODO: more inpute cleaning and privilege check(?)...because uh, i trust nothing
	    
		$stmt = $this->conn->prepare("INSERT INTO items(name,category,supplier,color,dimensions,price,in_stock,lead_time,description) VALUES(:itemName,:itemCategory,:itemSupplier,:itemColor,:itemDimensions,:itemPrice,:itemStock,:leadTime,:itemDescription)");
	    	$stmt->bindparam(":itemName", $itemName);
	    	$stmt->bindparam(":itemCategory", $itemCategory);
	    	$stmt->bindparam(":itemSupplier", $itemSupplier);
	    	$stmt->bindparam(":itemColor",$itemColor);
	    	$stmt->bindparam(":itemDimensions", $itemDimensions);
	    	$stmt->bindparam(":itemPrice", $itemPrice);
	    	$stmt->bindparam(":itemStock", $itemStock);
	    	$stmt->bindparam(":leadTime", $leadTime);
	    	$stmt->bindparam(":itemDescription", $itemDescription);
	    	
	    	$stmt->execute(); // hopefully
	    	
	    	return true;
	    } catch(PDOException $noE) {
		
	        return false;  // hmm, another error, false, i tells you, and that's all...
	    }
	    
	}
	
	public function updateItem($itemId,$itemName,$itemCategory,$itemSupplier,$itemColor,$itemDimensions,$itemPrice,$itemStock,$leadTime,$itemDescription)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE items SET name = '$itemName', category = '$itemCategory', supplier ='$itemSupplier', color= '$itemColor', dimensions = $itemDimensions, price = $itemPrice, in_stock = $itemStock, lead_time=$leadTime, description= $itemDescription WHERE item_id= $itemId")
			    or die(mysql_error());
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	
	public function searchPersonByName($name, $num_of_people, $offset)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE Last_name LIKE '%$name%' OR First_name LIKE '%$name%' ORDER BY Last_name LIMIT $num_of_people OFFSET $offset");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				return $results;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function getPeople($num_of_people, $offset)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users ORDER BY Last_name LIMIT $num_of_people OFFSET $offset");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				return $results;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function nextPeopleCheck($num_of_people, $offset)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM users ORDER BY Last_name LIMIT $num_of_people OFFSET $offset");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				return true;

			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}
	}
	
	public function managerPromote($user_id)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE users SET position='administrator' WHERE user_id=$user_id");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	
	public function managerAccepted($user_id)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE users SET approved=1 WHERE user_id=$user_id");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	
	public function managerDenied($user_id)
	{
		try
		{
			$stmt = $this->conn->prepare("DELETE FROM users WHERE user_id=$user_id");
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return false;
		}
	}
	public function approveCheck($position, $status)
	{
		if($position == "manager" && !$status)
		{
			return false;
		}
		else
		{
			return true;
		}
	
	}
	public function emailAdmin($manager_name)
	{
	
		try
		{
			$stmt = $this->conn->prepare("SELECT * from users WHERE position='administrator'");
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
			if($stmt->rowCount()> 0)
			{
				for($i = 0; $i < count($results); $i++)
				{
					 $to      = $results[$i]['email']; // Send email to our user
					 $subject = 'New Manager Signup'; // Give the email a subject 
					 $message = '
					 
					 '.$manager_name.' has signed up and is waiting for an administrators approval.

					 '; // Our message above including the link
		 
					 $headers = 'From: slogteam11@gmail.com' . "\r\n"; // Set from headers
					 mail($to, $subject, $message, $headers);
				
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e)
		{
			return false;
			//echo $e->getMessage();
		}	
	}
}
?>
