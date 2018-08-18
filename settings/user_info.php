<?php 

   // $_SESSION['user_id'] = 118;
   $user = 118;
    $my_details=$con->prepare("SELECT a.surname,a.firstname,a.phoneNo,a.email,b.username,b.admin,b.privilege from user_profile a left join user_auth b on a.user_id = b.user_id where a.user_id = ?") or die($con->error);
	$my_details->bind_param("s",$user);
	$my_details->execute();
	$my_details->bind_result($my_surname,$my_firstname,$my_phone,$my_email,$my_username,$my_admin_status,$my_privilege);
	$my_details->fetch();
	$my_details->close();


?>


