<?php

return array(
    "base_url" => "http://canopus.citriom.com/frontend/public/gauth/auth",
    "providers" => array (
        "Google" => array (
            "enabled" => true,
            "keys"    => array ( "id" => "663940279934-g1sdcvh5hdmc8fh0g5selvn4vr1fktbn.apps.googleusercontent.com", "secret" => "03DgqjJ45XE6Tibvo9w5KNww" ),
            "scope"           => "https://www.googleapis.com/auth/userinfo.profile ". // optional
                "https://www.googleapis.com/auth/userinfo.email"

        )));
