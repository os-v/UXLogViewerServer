<?php
//
//  @file Database.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

include_once(__DIR__."/Common/Config.php");

class CDatabase
{

    const EQueryResult = 0;
    const EQueryFetch = 1;
    const EQueryStatement = 2;

    private $m_pDB = null;

    public static function Instance()
    {
        static $pInstance = null;
        if(!$pInstance)
        {
            $pInstance = new CDatabase();
            $pInstance->Connection();
        }
        return $pInstance;
    }
    
    public function Connection()
    {

        if($this->m_pDB)
            return $this->m_pDB;

        $pConfig = CConfig::GetSection('db');

        try
        {
            $this->m_pDB = new PDO($pConfig['dsn'], $pConfig['username'], $pConfig['password']);
        }
        catch (Exception $ex)
        {
            throw new Exception('DB connection error: ' . $ex->getMessage());
        }

        return $this->m_pDB;
    }
    
    public function Query($sQuery, $eQueryType)
    {
        $pRow = $this->m_pDB->query($sQuery, PDO::FETCH_OBJ);
        if(!$pRow)
            return null;
        if($eQueryType == self::EQueryFetch)
            return $pRow->fetch();
        if($eQueryType == self::EQueryStatement)
            return $pRow;
        return true;
    }

    public function QueryDelete($sTable, $sCondition)
    {
        $sQuery = "DELETE FROM ".$sTable." WHERE ".$sCondition;
        return $this->Query($sQuery, self::EQueryResult);
    }

    public function QuerySelect($sTable, $sCondition)
    {
        $sQuery = "SELECT * FROM ".$sTable.($sCondition != "" ? " WHERE ".$sCondition : "");
        return $this->Query($sQuery, self::EQueryFetch);
    }

    public function QueryInsertObject($sTable, $pObject)
    {
        $sFields = "";
        $pFields = get_object_vars($pObject);
        foreach($pFields as $sField => $sValue)
        {
            if($sFields != "")
                $sFields .= ",";
            $sFields .= $sField;
        }
        return $this->QueryInsertFields($sTable, $pObject, $sFields);
    }

    public function QueryInsertFields($sTable, $pObject, $sFields)
    {
        $pFields = explode(",", $sFields);
        $sValues = "";
        foreach($pFields as $sField)
        {
            if($sValues != "")
                $sValues .= ",";
            $sValues .= "'".$pObject->{$sField}."'";
        }
        $sQuery = "INSERT INTO ".$sTable." (".$sFields.") VALUES(".$sValues.")";
        return $this->Query($sQuery, self::EQueryResult);
    }

    public function QueryUpdateObject($sTable, $pObject, $sCondition)
    {
        $sFields = "";
        $pFields = get_object_vars($pObject);
        foreach($pFields as $sField => $sValue)
        {
            if($sFields != "")
                $sFields .= ",";
            $sFields .= $sField;
        }
        return $this->QueryUpdateFields($sTable, $pObject, $sFields, $sCondition);
    }

    public function QueryUpdateFields($sTable, $pObject, $sFields, $sCondition)
    {
        $pFields = explode(",", $sFields);
        $sValues = "";
        foreach($pFields as $sField)
        {
            if($sValues != "")
                $sValues .= ",";
            $sValues .= $sField."='".$pObject->{$sField}."'";
        }
        $sQuery = "UPDATE ".$sTable." SET ".$sValues." WHERE ".$sCondition;
        return $this->Query($sQuery, self::EQueryResult);
    }

}
