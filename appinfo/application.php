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
use OCA\Auth_Filter\Middleware\TanetAuthMiddleware; 

class Application extends App {
    /**
     * Define your dependencies in here
     */
    public function __construct(array $urlParams=array()){
        parent::__construct('auth_filter', $urlParams);

        $container = $this->getContainer();
    }
}
