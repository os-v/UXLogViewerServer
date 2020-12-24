<?php
//
//  @file UsersInfo.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Database.php");

class CUsersInfo
{

    	public $ID = -1;
	public $UserInfo = "";
	public $UserPass = "";
	public $ThemesDefs = "";
	public $ActiveTheme = 0;
	public $TimeStamp = "";

	public function Load($sUserInfo, $sUserPass = "")
	{
    	    	$pRow = CDatabase::Instance()->QuerySelect("UsersInfo", "UserInfo='".$sUserInfo."'".($sUserPass != "" ? " AND UserPass='".$sUserPass."'" : ""));
		if(!$pRow)
			return null;
		foreach($this as $key => $value)
			$this->{$key} = $pRow->{$key};
		return $pRow;
	}

	public function Save($sUserInfo = "")
	{
		if($sUserInfo == "")
			$sUserInfo = $this->UserInfo;
		$fExists = $this->ID != -1;
		$this->UserInfo = $sUserInfo;
		$nID = $this->ID;
		unset($this->ID);
		if($fExists)
			CDatabase::Instance()->QueryUpdateObject("UsersInfo", $this, "UserInfo='".$sUserInfo."'");
		else
			CDatabase::Instance()->QueryInsertObject("UsersInfo", $this);
		$this->ID = $nID;
	}

	public function Delete($sUserInfo = "")
	{
		if($sUserInfo == "")
			$sUserInfo = $this->UserInfo;
		CDatabase::Instance()->QueryDelete("UsersInfo", "UserInfo='".$sUserInfo."'");
	}
    
}

