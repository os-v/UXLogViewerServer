<?php
//
//  @file Restore.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/UsersInfo.php");
include_once(__DIR__."/Common/Common.php");

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
	if(!$pUser->Load($sUserInfo))
		return "invalid username";

	$sNewPassword = "";
	for($iChar = 0; $iChar < 8; $iChar++)
	    $sNewPassword .= mt_rand('0', '9');
	$pUser->UserPass = md5($sNewPassword);
	$pUser->Save();

	$sMailBody  = "<html><body>";
	$sMailBody .= "Your new password for UXLogViewer account is ".$sNewPassword."<br>";
	$sMailBody .= "Please click <a href='https://lv.os-v.pw/Login.php'>Login</a> link to login to your account.";
	$sMailBody .= "</body></html>";
	CCommon::SendMail($sUserInfo, "UXLogViewer password reset", $sMailBody);

	header('Location: RestoreResult.php');

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
			<br><br><br>
				Enter your email to restore password
				<form action="Restore.php" method="post" onsubmit="return !ValidateEmail(document.getElementsByName('username')[0].value, true).length;">
					<input name="username" type="text" value=<?php print('"'.$sUserInfo.'"');?> placeholder="Enter email"/>
					<input type="submit" value="Restore"/>
				</form>
			</div>
		</div>
  	</body>
</html>
