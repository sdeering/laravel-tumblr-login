<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | OAuth HTTP Client
    |--------------------------------------------------------------------------
    |
    | Supported: "CurlClient", "StreamClient"
    |
    */

    'client' => 'StreamClient',


    /*
    |--------------------------------------------------------------------------
    | OAuth Consumers
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    |   'Facebook' => array(
    |       'client_id'     => 'your-client-id',
    |       'client_secret' => 'your-client-secret',
    |       'scope'         => array(),
    |   )
    |
    */

    'consumers' => array(

        'tumblr' => array(
          'client_id'     => 'EhYrM8yAshbMjfIGr4CloSAwwvhih5HJg71KgfBXrvCZhFI8yk',
          'client_secret' => 'qJw7fIl7IHRoOhUNi5jKHcFLQOqQTe0ymJ3zoXEs866Hp2d1Qr',
          'scope'         => array()
        )


    )

);
