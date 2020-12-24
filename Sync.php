<?php
//
//  @file Sync.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/UsersInfo.php");

$pResponse = ProcessRequest();

$sResponse = json_encode($pResponse);

print($sResponse);

function ProcessRequest()
{

	$pResponse = new stdClass();

	$sRequest = file_get_contents("php://input");
	if($sRequest == "")
	{
		$pResponse->error = "Invalid request";
		return $pResponse;
	}

	$pRequest = json_decode($sRequest);

	$pUser = new CUsersInfo();
	if(!$pUser->Load($pRequest->username, $pRequest->password))
	{
		$pResponse->error = "Invalid username or password";
		return $pResponse;
	}

	if(isset($pRequest->themes))
	{
		$pUser->ThemesDefs = $pRequest->themes;
		$pUser->ActiveTheme = $pRequest->active;
		$pUser->Save();
	}
	else
	{
		$pResponse->themes = $pUser->ThemesDefs;
		$pResponse->active = $pUser->ActiveTheme;
	}

	return $pResponse;
}

?>
