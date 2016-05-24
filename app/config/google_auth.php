<?php

return array(
    "base_url" => "http://canopus.citriom.com/frontend/public/gauth/auth",
    "providers" => array (
        "Google" => array (
            "enabled" => true,
            "keys"    => array ( "id" => "218871663498-cp8ksbub17ib56ld73ingambscdbdcd6.apps.googleusercontent.com", "secret" => "d1g8AJNmQEFMVicwatys07J4" ),
            "scope"           => "https://www.googleapis.com/auth/userinfo.profile ". // optional
                "https://www.googleapis.com/auth/userinfo.email"

        )));


    // produccion: "base_url" => "http://canopus.citriom.com/frontend/public/gauth/auth",
    // daniel: "base_url" => "http://localhost:8079/operational_reports/public/gauth/auth",