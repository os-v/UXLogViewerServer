<?php
//
//  @file Config.php
//  @author Sergii Oryshchenko <sergii.orishchenko@gmail.com>
//  @see https://github.com/os-v/UXLogViewerServer/
//
//  Created on 21.12.20.
//  Copyright 2020 Sergii Oryshchenko. All rights reserved.
//

class CConfig
{

    private static $DATA = null;

    public static function GetSection($section = null)
    {
        if ($section === null)
            return self::GetConfig();
        $data = self::GetConfig();
        if (!array_key_exists($section, $data))
            throw new Exception('Unknown config section: ' . $section);
        return $data[$section];
    }

    public static function GetVariable($sSection, $sVariable, $sDefault = "")
    {
        $pSection = CMainConf::GetSection($sSection);
        if(array_key_exists($sVariable, $pSection))
            return $pSection[$sVariable];
        return $sDefault;
    }
    
    private static function GetConfig()
    {
        if (self::$DATA !== null)
            return self::$DATA;
        self::$DATA = parse_ini_file(__DIR__ . '/Config.ini', true);
        return self::$DATA;
    }

}
