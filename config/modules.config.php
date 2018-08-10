<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
include "C:/wwwroot/zend_login_template/vendor/zendframework/zend-authentication/src/AuthenticationService.php";

return [
    'Zend\Hydrator',
    'Zend\InputFilter',
    'Zend\Filter',
    'Zend\I18n',
    'Zend\Router',
    'Zend\Validator',
    'Meiko\Authentication'
];
