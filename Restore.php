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

	$pUser->CreateRestoreKey();

	$sMailBody  = "<html><body>";
	$sMailBody .= "Your UXLogViewer account was requested for password reset.<br>";
	$sMailBody .= "Please click <a href='https://os-v.pw/lv/RestoreChange.php?username=".$pUser->UserInfo."&restorekey=".$pUser->RestoreKey."'>Restore</a> link to change your password.";
	$sMailBody .= "</body></html>";
	CCommon::SendMail($sUserInfo, "UXLogViewer password reset", $sMailBody);

	header('Location: RestoreResult.php');

	return "";
}

?>

<html>
	<head>
  		<title>Restore password page</title>
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
