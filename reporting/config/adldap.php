<?php
// Example adldap.php file.
return [
    'account_suffix' => env('LDAP_ACCOUNT_SUFFIX'),

    'domain_controllers' => explode(',',env('LDAP_DOMAIN_CONTROLLERS','')),

    'base_dn' => env('LDAP_BASE_DN'),

    'admin_username' => env('LDAP_USERNAME'),

    'admin_password' => env('LDAP_PASSWORD'),

    'real_primary_group' => true, // Returns the primary group (an educated guess).

    'recursive_groups' => true,

];