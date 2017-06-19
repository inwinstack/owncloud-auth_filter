<?php
namespace OCA\Auth_Filter;

use Exception;

class Util {
    const MAILEDU = "mail.edu";
    const TANET = "tanet";
    
    public static function filterAuthType($userID){
        if (preg_match("/mail\.edu\.tw/i", $userID) &&
            \OC::$server->getAppManager()->isInstalled("singlesignon1")
        ){  
            return self::MAILEDU;
        }
        else if (preg_match("/@/i", $userID) &&
            \OC::$server->getAppManager()->isInstalled("tanet_auth")
        ){
            return self::TANET;
        }
    }

    public static function webDavLogin($userID, $password) {
        $authType = self::filterAuthType($userID);
        
        if ($authType === self::MAILEDU &&
            \OC::$server->getAppManager()->isInstalled("singlesignon")
           ){
            return \OCA\SingleSignOn\Util::webDavLogin($userID,$password);
        }
        else if ($authType === self::TANET &&
            \OC::$server->getAppManager()->isInstalled("tanet_auth")
            ){
            return \OCA\Tanet_Auth\Util::webDavLogin($userID,$password);
        }
        else{
            return \OC_User::login($userID,$password);
        }
    }

}

