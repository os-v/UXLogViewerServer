<?php
//
//  @file Register.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Database.php");
include_once(__DIR__."/UsersInfo.php");
include_once(__DIR__."/UsersRegs.php");
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

	if($_POST["password"] != $_POST["passconf"])
		return "password confirmation should be same as password";

	$pUser = new CUsersInfo();
	if($pUser->Load($sUserInfo))
		return "user is already registered";

	$pUser = new CUsersRegs();
	$pUser->Load($sUserInfo);

	$pUser->CreateNew($sUserInfo, $_POST["password"]);
	$pUser->Save($sUserInfo);

	$sMailBody  = "<html><body>";
	$sMailBody .= "Your email was used to register account for UXLogViewer.<br>";
	$sMailBody .= "Please click <a href='https://lv.os-v.pw/Activate.php?".$pUser->AuthKey."'>Activate</a> link to activate your account.";
	$sMailBody .= "</body></html>";
	CCommon::SendMail($sUserInfo, "UXLogViewer activation", $sMailBody);

	return "";
}

?>

<html>
	<head>
  		<title>Register new account</title>
		<link rel="stylesheet" href="styles.css?ver=1">
		<script src="Common.js"></script>
	</head>
	<body onload=<?php $sRequest != "" && $sError != "" ? print("\"alert('ERROR: ".$sError."');\"") : printf("\"\""); ?>>
		<div align="center" class="login_form">
			<div style=<?php printf("display:".($sRequest != "" && $sError == "" ? "none" : "block"));?>>
				Fill-in registration data
				<form action="Register.php" method="post" onsubmit="return ValidateRLForm('username', 'password', 'passconf', true, 'Confirmation should match to password');">
					<input name="username" type="text" value=<?php print('"'.$sUserInfo.'"');?> placeholder="Enter email"/>
					<input name="password" type="password" placeholder="Enter password"/>
					<input name="passconf" type="password" placeholder="Confirm password"/>
					<input type="submit" value="Create"/>
				</form>
			</div>
			<div style=<?php printf("display:".($sRequest == "" || $sError != "" ? "none" : "block"));?>>
			<br><br><br>
				Please check <?php printf($sUserInfo);?> email and click on activate link to activate your account.<br>
				<a href="javascript:history.back()">Return to registration.</a>
				<a href="Login.php">Login page.</a>
			</div>
		</div>
  	</body>
</html>
