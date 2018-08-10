<?php 

namespace Install\Helper;

class ConfigValues
{
    public static function getAll()
    {
        return [
            'authentication' => 
                [
                    'method' => '',
                    'registration' => '',
                ],
            'crypto' => 
            [
                'options' => 
                [
                    'cost' => '',
                ],
            ],
            'database' => 
            [
                'config' =>
                [
                    'driver' => '',
                    'database' => '',
                    'hostname' => '',
                    'username' => '',
                    'password' => '',
                    'charset' => '',
                ],
                'usertable' => '',
                'password_column' => '',
                'username_column' => '',
            ],
            'ldap' => 
            [
                'config' =>
                [
                    'server1' =>
                    [
                        'host' => '',
                        'port' => '',
                        'accountDomainName' => '',
                        'accountDomainNameShort' => '',
                        'accountCanonicalForm' => '',
                        'username' => '',
                        'password' => '',
                        'baseDn' => '',
                    ],
                    'server2' =>
                    [
                        'host' => '',
                        'port' => '',
                        'accountDomainName' => '',
                        'accountDomainNameShort' => '',
                        'accountCanonicalForm' => '',
                        'username' => '',
                        'password' => '',
                        'baseDn' => '',
                    ],
                ],
            ],
            'ntlm' =>
            [
                'config' => 
                [
                    'host' => '',
                    'port' => '',
                    'accountDomainName' => '',
                    'accountDomainNameShort' => '',
                    'accountCanonicalForm' => '',
                    'username' => '',
                    'password' => '',
                    'baseDn' => '',
                ],
            ],
            'session' =>
            [
                'config' => 
                [
                    'remember_me_seconds' => '',
                    'cookie_domain' => '',
                    'name' => '',
                    'use_cookies' => '',
                    'cache_expire' => '',
                ],
            ],
            'eventhandler' => 
            [
                'classname' => '',
            ],
        ];
    }
}