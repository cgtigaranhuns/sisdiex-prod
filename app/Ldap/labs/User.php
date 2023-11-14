<?php

namespace App\Ldap\labs;

use LdapRecord\Models\Model;

class User extends Model
{
   
    public ?string $connection = 'labs';

    public static array $objectClasses = [


    ];
}
