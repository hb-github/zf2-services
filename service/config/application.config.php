<?php
return array(
    'modules' => array(
        'Service',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
            'config/autoload/'.getenv('APPLICATION_ENV').'.config.php'
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    'translateAdapter' => array (
        'parameters' => array (
            'options' => array(
                'locale' => 'pt_BR',
                'content' => 'langs',
                'scan' => 'modulo',
                'disableNotices' => true
            )
        )
    ),
);
