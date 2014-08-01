<?php

//https://github.com/jenssegers/laravel-oauth
// use Jenssegers\OAuth\OAuth;
// use Jenssegers\OAuth\OAuthServiceProvider;

use \Illuminate\Support\ServiceProvider;
use \OAuth\ServiceFactory;
use OAuth\OAuth1\Service\Tumblr;
use OAuth\Common\Consumer\Credentials;
use \OAuth\Common\Storage\Session;
use \OAuth\Common\Storage\SymfonySession;

//https://github.com/tumblr/tumblr.php
// use Tumblr\API\Client;

// session_start();


class JESSENGERSController extends BaseController {

  public function test() {

    //https://github.com/Lusitanian/PHPoAuthLib/blob/master/examples/tumblr.php

    $credentials = new Credentials(
        Config::get('oauth::consumers.tumblr.client_id'),
        Config::get('oauth::consumers.tumblr.client_secret'),
        Config::get('oauth::consumers.tumblr.callback_url')
    );


    // $oauth = new OAuth(new \OAuth\ServiceFactory(), new Session());
    // $consumer = $oauth->service('tumblr');

    $serviceFactory = new \OAuth\ServiceFactory();
    $storage = new Session();
    $tumblrService = $serviceFactory->createService('tumblr', $credentials, $storage);
    $tumblr = OAuth::consumer('tumblr');

    if ($code = Input::has('oauth_token')) {

        $result = json_decode($tumblr->request('user/info'), true);
        dd($result);

    } else {

        $token = $tumblrService->requestRequestToken();
        // Session::put('tumblr.oauth_token', $token);
        return Redirect::away((string) $tumblr->getAuthorizationUri(array('oauth_token' => $token->getRequestToken())));

    }

    // $storage = new Session();
    // $serviceFactory = new \OAuth\ServiceFactory();
    // $tumblrService = $serviceFactory->createService('tumblr', $credentials, $storage);

    // if (Input::has('oauth_token')) {
    //     $token = $storage->retrieveAccessToken('tumblr');

    //     // This was a callback request from tumblr, get the token
    //     $tumblrService->requestAccessToken(
    //         Input::get('oauth_token'),
    //         Input::get('oauth_verifier'),
    //         $token->getRequestTokenSecret()
    //     );

    //     // Send a request now that we have access token
    //     $result = json_decode($tumblrService->request('user/info'));
    //     dd($result);

    // } elseif (Input::has('go')) {
    //     // extra request needed for oauth1 to request a request token :-)
    //     $token = $tumblrService->requestRequestToken();
    //     // Log::info($token);
    //     $url = $tumblrService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
    //     Log::info(urldecode($url));
    //     return Redirect::to(urldecode($url));
    // } else {
    //     $url = Request::url() . '?go=go';
    //     Log::info($url);
    //     return Redirect::to($url);
    // }

  }

}
