<?php

$cache_s3 = array(
    'css'       => 'http://cache.kadabra.me/themes/adminica/styles',
    'images'    => 'http://cache.kadabra.me/themes/adminica/images',
    'js'        => 'http://cache.kadabra.me/themes/adminica/scripts',
    'bootstrap' => 'http://cache.kadabra.me/bootstrap',
    'jquery'    => 'http://cache.kadabra.me/jquery',
    
    'profile'   => 'http://service.kadabra.local/images/profile', // temporário, pois o padrão será do Kadabra
);

return array(
    'api' => array(
        'end_point' => 'http://api.service.kadabra.me',
        'email'     => '',
        'token'     => ''
    ),
    'cache_s3' => $cache_s3
);
