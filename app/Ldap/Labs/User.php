<?php

namespace App\Ldap\Labs;

use LdapRecord\Models\Model;

class User extends Model
{
   
    public ?string $connection = 'labs';

    public static array $objectClasses = [


    ];
}
