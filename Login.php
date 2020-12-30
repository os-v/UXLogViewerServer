<?php
//
//  @file Login.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Database.php");
include_once(__DIR__."/UsersInfo.php");
include_once(__DIR__."/UsersRegs.php");

session_start();

$_SESSION["username"] = "";

$sError = "";
$sUserInfo = "";
$sRequest = file_get_contents("php://input");
if($sRequest != "")
	$sError = ProcessRequest();

function ProcessRequest()
{

	$sUserInfo  = $_POST['username'];
	$sUserInfo = filter_var($sUserInfo, FILTER_SANITIZE_EMAIL);
	if(!filter_var($sUserInfo, FILTER_VALIDATE_EMAIL))
		return "invalid email address";

	$pUser = new CUsersInfo();
	if($_POST["password"] == "" || !$pUser->Load($sUserInfo, $_POST["password"]))
		return "invalid username or password";

	$_SESSION["username"] = $sUserInfo;

	header('Location: Actions.php');

	return "";
}

?>

<html>
	<head>
  		<title>Login page</title>
		<link rel="stylesheet" href="styles.css?ver=1">
		<script src="Common.js"></script>
	</head>
	<body onload=<?php $sRequest != "" && $sError != "" ? print("\"alert('ERROR: ".$sError."');\"") : printf("\"\""); ?>>
		<div align="center" class="login_form">
			<div style=<?php printf("display:".($sRequest != "" && $sError == "" ? "none" : "block"));?>>
				Enter your username/password to login
				<form action="Login.php" method="post" onsubmit="return ValidateRLForm('username', 'password', '', true, '');">
					<input name="username" type="text" value=<?php print('"'.$sUserInfo.'"');?> placeholder="Enter email"/>
					<input name="password" type="password" placeholder="Enter password"/>
					<input type="submit" value="Login"/>
				</form>
				<a href="Register.php">Register account.</a>
				<a href="Restore.php">Forget password?</a>
			</div>
		</div>
  	</body>
</html>
