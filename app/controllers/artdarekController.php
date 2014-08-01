<?php

//https://github.com/artdarek/oauth-4-laravel

class artdarekController extends BaseController {

  //TESTING FACEBOOK OAUTH 2
  public function testfb() {

    // get data from input
    $code = Input::get( 'code' );

    // get fb service
    $fb = OAuth::consumer( 'Facebook' );

    // check if code is valid

    // if code is provided get user data and sign in
    if ( !empty( $code ) ) {

        // This was a callback request from facebook, get the token
        $token = $fb->requestAccessToken( $code );

        // Send a request with it
        $result = json_decode( $fb->request( '/me' ), true );

        $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
        echo $message. "<br/>";

        //Var_dump
        //display whole array().
        dd($result);

    }
    // if not ask for permission first
    else {
        // get fb authorization
        $url = $fb->getAuthorizationUri();

        // return to facebook login url
         return Redirect::to( (string)$url );
    }

  }

  //TESTING TUMBLR OAUTH 1.0a
  public function testtumblr() {

    //check for token
    $oauth_token = \Input::get( 'oauth_token' );
    $oauth_verifier = \Input::get( 'oauth_verifier' );

    // get service (2nd param you can pass callback override)
    $tumblr = OAuth::consumer( 'Tumblr', 'http://local.laravel.com/test3' );

    // check if code is valid

    // if code is provided get user data and sign in
    if ( !empty( $oauth_token ) && !empty( $oauth_verifier ) ) {

        // This was a callback request, get the token
        $token = $tumblr->getStorage()->retrieveAccessToken('Tumblr');
        $tumblr->requestAccessToken( $oauth_token, $oauth_verifier, $token->getRequestTokenSecret() );

        // Send a request with it
        $result = json_decode( $tumblr->request( '/user/info' ), true );

        // Var_dump
        dd($result);

    }
    // if not ask for permission first
    else {

        // extra request needed for oauth1 to request a request token :-)
        $token = $tumblr->requestRequestToken();

        // get authorization
        $url = $tumblr->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
        // dd((string)$url);

        // return to facebook login url
        return Redirect::to( (string)$url );
    }

  }

}
