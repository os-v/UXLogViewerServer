<?php
//
//  @file Actions.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 22.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/UsersInfo.php");

session_start();

$pUser = new CUsersInfo();
if(!$pUser->Load($_SESSION["username"]))
{
	header('Location: Login.php');
	exit();
}

?>

<html>
	<head>
  		<title>User page</title>
		<link rel="stylesheet" href="styles.css?ver=1">
	</head>
	<body>
		<div align="center" class="login_form">
			You are logged in<br><br>
			<input type="submit" value="View Themes" onclick="location.href='ActionsThemes.php'"/><br>
			<input type="submit" value="Change Password" onclick="location.href='ActionsPassword.php'"/><br>
			<input type="submit" value="Logout" onclick="location.href='ActionsLogout.php'"/><br>
		</div>
  	</body>
</html>
