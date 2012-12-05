<?php
require("PHPMailer\class.phpmailer.php");

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("r3", $con);
	
	if( isset( $_POST["approve"] ) or isset( $_POST["deny"] ) )
	{
	
		$status = isset( $_POST["approve"] ) ? 'Approved' : 'Denied';
		$id = $_POST["reservationID"];
		$sql = "UPDATE reservation
				SET approval = '{$status}'
				WHERE ID = {$id}";
		$result = mysql_query( $sql );
		
		//Get User Email
		$sql = "SELECT Email
				FROM reservation, user
				WHERE reservation.user = user.ID AND reservation.ID = {$id}";
		$result = mysql_query( $sql );
		$email = mysql_result( $result, 0 );
		
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->SMTPDebug = 1;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;

		$mail->Username = "mstroomreservationsystem@gmail.com";
		$mail->Password = "cs397group";

		$mail->From = "mstroomreservationsystem@gmail.com";
		$mail->FromName ="Admin";
		$mail->Subject = "Your reservation has been {$status}";
		$mail->AddAddress("$email");
		
		if( isset($_POST["approve"]) ){
			$body = "Congratulations your reservation request has been approved.";
		} else {
			$body = "Sorry your reservation request has been denied.";
		}
		
		if( isset($_POST["reason"]) ){
			$body .= "\n\nAdministrator comments:\n{$_POST["reason"]}";
		}
		$mail->Body = $body;
		
		if(!$mail->Send()){
			echo $mail->ErrorInfo;
		}
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>