<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session',

    /**
     * Consumers
     */
    'consumers' => array(

        /**
         * Facebook oAuth 2
         */
        'Facebook' => array(
            'client_id'     => '266958276828575',
            'client_secret' => 'c25fcaaa4dff2f8d16a2916096af4b50',
            'scope'         => array(),
            //'scope'         => array('email','read_friendlists','user_online_presence'),
        ),

        /**
         * Tumblr oAuth 1.0a
         */
        'Tumblr' => array(
            'client_id'     => 'EhYrM8yAshbMjfIGr4CloSAwwvhih5HJg71KgfBXrvCZhFI8yk',
            'client_secret' => 'qJw7fIl7IHRoOhUNi5jKHcFLQOqQTe0ymJ3zoXEs866Hp2d1Qr',
            'scope'         => array(),
        ),

    )

);

?>