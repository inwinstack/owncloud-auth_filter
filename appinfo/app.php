<?php
/**
 * ownCloud - auth_filter
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Duncan Chiang <duncan.c@inwinstack.com>
 * @copyright 2017 inwinSTACK.Inc
 */

namespace OCA\Auth_Filter\AppInfo;

use OCP\AppFramework\App;

$app = new App('auth_filter');
$application = new Application();
$container = $app->getContainer();

$container->registerService("L10N", function($c) {
    return $c->getServerContainer()->getL10N("auth_filter");
});

$request = \OC::$server->getRequest();

$authType = \OCA\Auth_Filter\Util::filterAuthType($request->offsetGet("user"));
    
if ($authType === \OCA\Auth_Filter\Util::MAILEDU){
    $ip = $_SERVER["REMOTE_ADDR"];
    $url = "http://sso.cloud.edu.tw/ORG/service/EduCloud/auth/tokens";
    $data = ["UserId" => $request->offsetGet("user"), "Password" => $request->offsetGet("password"), "UserIP" => $_SERVER["REMOTE_ADDR"]];
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // restore result to var
    $head = curl_exec($ch);
    $head = json_decode($head);
    if ($head->actXML->statusCode == 200) {
    
        $request->setUrlParameters(array('asus' => 1,
                "token1" => $head->actXML->rsInfo->tokenId
        ));
    }
}

else if ($authType === \OCA\Auth_Filter\Util::TANET){

    $request->setUrlParameters(array('tanet' => 1,
                                     'userid' => $request->offsetGet("user"),
    ));
}
