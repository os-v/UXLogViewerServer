<?php
//
//  @file ActionsPassword.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 22.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/UsersInfo.php");

session_start();

$sError = "";
$sUserInfo = "";
$sRequest = file_get_contents("php://input");
if($sRequest != "")
	$sError = ProcessRequest();

function ProcessRequest()
{

	$pUser = new CUsersInfo();
	if(!$pUser->Load($_SESSION["username"]))
		return "invalid username or password";

	if(!$pUser->CheckPassword($_POST["password"]))
		return "Invalid current password";
	if($_POST["npassword"] != $_POST["cpassword"])
		return "Confirmation should match new  password";

	$pUser->SetPassword($_POST["npassword"]);
	$pUser->Save();

	header('Location: Actions.php');

	return "";
}

?>

<html>
	<head>
  		<title>Change password page</title>
		<link rel="stylesheet" href="styles.css?ver=1">
		<script src="Common.js"></script>
	</head>
	<body onload=<?php $sRequest != "" && $sError != "" ? print("\"alert('ERROR: ".$sError."');\"") : printf("\"\""); ?>>
		<div align="center" class="login_form">
			Provide your old and new password
			<form action="ActionsPassword.php" method="post" onsubmit="return ValidatePCForm('password', 'npassword', 'cpassword', true);">
				<input name="password" type="password" placeholder="Enter current password"/>
				<input name="npassword" type="password" placeholder="Enter new password"/>
				<input name="cpassword" type="password" placeholder="Confirm new password"/>
				<input type="submit" value="Change"/>
			</form>
		</div>
  	</body>
</html>
