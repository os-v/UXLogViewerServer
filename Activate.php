<?php
//
//  @file Activate.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Database.php");
include_once(__DIR__."/UsersInfo.php");
include_once(__DIR__."/UsersRegs.php");

$sUserInfo = "";
$sError = ProcessRequest();

function ProcessRequest()
{

	$sRequest = $_SERVER['QUERY_STRING'];
	if($sRequest == "")
		return "";

	$pReg = new CUsersRegs();
	if(!$pReg->Load("", $sRequest))
		return "invalid user";

	$pUser = new CUsersInfo();
	$pUser->UserInfo = $pReg->UserInfo;
	$pUser->UserPass = $pReg->UserPass;
	$pUser->TimeStamp = date("Y-m-d H:i:s", time());
	$pUser->Save();

	$pReg->Delete();

	return "";
}

?>

<html>
	<head>
  		<title>Activate page</title>
		<link rel="stylesheet" href="styles.css?ver=1">
	</head>
	<body onload=<?php $sError != "" ? print("\"alert('ERROR: ".$sError."');\"") : printf("\"\""); ?>>
		<div align="center" class="login_form">
			<div style=<?php printf("display:".($sError == "" ? "none" : "block"));?>>
			<br><br><br>
				<?php print("'ERROR: ".$sError."'");?><br>
				<a href="Register.php">Register page.</a>
			</div>
			<div style=<?php printf("display:".($sError != "" ? "none" : "block"));?>>
			<br><br><br>
				You account has been activated.<br>
				<a href="Login.php">Login page.</a>
			</div>
		</div>
  	</body>
</html>
