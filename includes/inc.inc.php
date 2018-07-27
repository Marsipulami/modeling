<?php

function dbConnect()
{
	
	$pass  = "Sk9STG9Ld0JHZ1VKUm5pZ2hPRHA=";
	$db  = "paintdatabase";
	
	try {
		$conn = new PDO('mysql:host=localhost;dbname='.$db, $db, base64_decode($pass));
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}


    return $conn;
}

?>