<?php
//
//  @file RestoreChange.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 28.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Database.php");
include_once(__DIR__."/UsersInfo.php");
include_once(__DIR__."/UsersRegs.php");

session_start();

$sRequest = file_get_contents("php://input");
if($sRequest != "")
	$sError = ProcessRequest($_POST["npassword"], $_POST["cpassword"]);
else
	$sError = ProcessRequest(null, null);

function ProcessRequest($sNPassword, $sCPassword)
{

	if($sNPassword != null && $sCPassword != null)
	{
		$pUser = new CUsersInfo();
		if(!$pUser->Load($_SESSION["username"]))
			return "invalid user";
		if($sNPassword != $sCPassword)
			return "Confirmation should match new  password";
		$pUser->SetPassword($sNPassword);
		$pUser->Save();
		header('Location: Actions.php');
		return "";
	}

	$_SESSION["username"] = "";

	$sUserInfo = $_GET['username'];
	if($sUserInfo == "")
		return "invalid user info";

	$pUser = new CUsersInfo();
	if(!$pUser->Load($sUserInfo))
		return "invalid user";

	if(!$pUser->CheckRestoreKey($_GET['restorekey']))
		return "invalid restore key:".$_GET['restorekey'].", ".$pUser->RestoreKey;

	$_SESSION["username"] = $pUser->UserInfo;

	return "";
}

?>

<html>
	<head>
  		<title>Restore password page</title>
		<link rel="stylesheet" href="styles.css?ver=1">
		<script src="Common.js"></script>
	</head>
	<body onload=<?php $sError != "" ? print("\"alert('ERROR: ".$sError."');\"") : printf("\"\""); ?>>
		<div align="center" class="login_form">
			<div style=<?php printf("display:".($sError != "" ? "none" : "block"));?>>
				Enter your new password
				<form action="RestoreChange.php" method="post" onsubmit="return ValidatePCForm('', 'npassword', 'cpassword', true);">
					<input name="npassword" type="password" placeholder="Enter new password"/>
					<input name="cpassword" type="password" placeholder="Enter confirmation"/>
					<input type="submit" value="Change"/>
				</form>
				<a href="Register.php">Register account.</a>
				<a href="Restore.php">Forget password?</a>
			</div>
		</div>
  	</body>
</html>
