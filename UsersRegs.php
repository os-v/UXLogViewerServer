<?php
//
//  @file UsersRegs.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Database.php");

class CUsersRegs
{

    	public $ID = -1;
	public $UserInfo = "";
	public $UserPass = "";
	public $AuthKey = "";
	public $TimeStamp = "";

	public function Load($sUserInfo, $sAuthKey = "")
	{
		if($sUserInfo != "")
	    	    	$pRow = CDatabase::Instance()->QuerySelect("UsersRegs", "UserInfo='".$sUserInfo."'");
		else if($sAuthKey != "")
	    	    	$pRow = CDatabase::Instance()->QuerySelect("UsersRegs", "AuthKey='".$sAuthKey."'");
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
			CDatabase::Instance()->QueryUpdateObject("UsersRegs", $this, "UserInfo='".$sUserInfo."'");
		else
			CDatabase::Instance()->QueryInsertObject("UsersRegs", $this);
		$this->ID = $nID;
	}

	public function Delete($sUserInfo = "")
	{
		if($sUserInfo == "")
			$sUserInfo = $this->UserInfo;
		CDatabase::Instance()->QueryDelete("UsersRegs", "UserInfo='".$sUserInfo."'");
	}

	public function CreateNew($sUserInfo, $sUserPass)
	{
		$this->UserPass = md5($sUserPass);
		$this->TimeStamp = date("Y-m-d H:i:s", time());
		$this->AuthKey = md5($sUserInfo.$this->TimeStamp).$this->TimeStamp;
		for($iCycle = 0; $iCycle < 8; $iCycle++)
		    $this->AuthKey .= sprintf('%02x', mt_rand(0, 255));
		$this->AuthKey = base64_encode($this->AuthKey);
	}
    
}

