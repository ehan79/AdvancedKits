<?php

namespace AdvancedKits\lang;

use AdvancedKits\Main;
use pocketmine\utils\Config;

class LangManager{

    const LANG_VERSION = 0;

    private $ak;
    private $defaults;
    private $data;

    public function __construct(Main $ak){
        $this->ak = $ak;
        $this->defaults = [
            "lang-version" => 0,
            "in-game" => "Please run this command in game",
            "av-kits" => "Available kits: %0",
            "no-kit" => "Kit %0 does not exist",
            "reload" => "Reloaded kits settings",
            "sel-kit" => "Selected kit: %0",
            "cant-afford" => "You cannot afford kit: %0",
            "one-per-life" => "You can only get one kit per life",
            "cooldown1" => "Kit %0 is in coolDown at the moment",
            "cooldown2" => "You will be able to get it in %0",
            "no-perm" => "You haven't the permission to use kit %0",
            "cooldown-format1" => "%0 minutes",
            "cooldown-format2" => "%0 hours and %1 minutes",
            "cooldown-format3" => "%0 hours",
            "no-sign-on-kit" => "On this sign, the kit is not specified",
            "no-perm-sign" => "You don't have permission to create a sign kit"
        ];
        $this->data = (new Config($this->ak->getDataFolder()."lang.properties", Config::PROPERTIES, $this->defaults))->getAll();
        if($this->data["lang_version"] != self::LANG_VERSION){
            $this->ak->getLogger()->alert("Translation file is outdated. Please delete your lang.properties and restart your server to create an updated file");
        }
    }

    public function getTranslation($dataKey, ...$args){
        if(!isset($this->data[$dataKey])){
            $this->ak->getLogger()->alert("Translation file is incorrect. Missing key: ".$dataKey.", returning default translation");
            $this->ak->getLogger()->alert("Please delete your lang.properties and restart your server to create a valid file");
            return count($args) > 0 ? $this->getDefaultTranslation($dataKey, $args) : $this->getDefaultTranslation($dataKey);
        }
        $str = $this->data[$dataKey];
        if(count($args) > 0){
            foreach($args as $key => $arg){
                $str = str_replace("%".$key, $arg, $str);
            }
        }
        return $str;
    }

    private function getDefaultTranslation($dataKey, ...$args){
        $str = $this->defaults[$dataKey];
        if(count($args) > 0){
            foreach($args as $key => $arg){
                $str = str_replace("%".$key, $arg, $str);
            }
        }
        return $str;
    }

}