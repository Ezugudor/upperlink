<?php 
    $systemInfo=$con->prepare("SELECT session_expires,site_name,site_title,slogan,contact,can_login,can_send,can_cashout from settings LIMIT 1 ") or die($con->error);
	$systemInfo->execute() or die($con->error);
	$systemInfo->bind_result($systemSessionExpires,$systemSiteName,$systemSiteTitle,$systemSiteSlogan,$systemSiteContact,$systemLogin,$systemSend,$systemCashout) or die($con->error);
	$systemInfo->fetch();
	$systemInfo->close();
?>