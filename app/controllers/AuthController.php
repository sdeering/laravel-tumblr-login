<?php

// use TumblrOAuth\TumblrOAuth;
// use Tumblr\API\Client;

// session_start();

include_once('../vendor/sdeering/tumblr-oauth/src/TumblrOAuth.php');

//https://github.com/jenssegers/laravel-oauth
// use Jenssegers\OAuth\OAuth;
// use OAuth\Common\Storage\Memory;

class AuthController extends BaseController {

  /*

    Tumblr oAuth 1.0a process steps

    1. get login url for tumblr api
      - a) build auth object using consumer keys
      - b) get temporary credentials (request token)
      - c) save temporary credentials in session
      - d) build authorise url using temporary credentials

    2. authorise with tumblr api
      - a) authorise if required (or use stored access_token in session)
      - b) rebuild auth object using consumer keys & temporary credentials
      - c) get access token from tumblr api
      - d) store access_token for future use
      - e) build tumblr object using consumer keys & access token
      - f) use oauth object (access token) to query tumblr

  */

  // STEP 1 - get login url for tumblr api
  public function doTumblrAuthStep1() {

    //* if request_token is stored then we can skip step 1

    //get tumblr config
    $tconfig = Config::get('tumblr');

    //a) build auth object using consumer keys
    $connection = new TumblrOAuth($tconfig["consumer_key"], $tconfig["consumer_secret"]);

    //b) get request token (temporary credentials)
    $request_token = $connection->getRequestToken($tconfig["callback_url"]);

    dd($request_token);

    //c) save temporary credentials in session
    Session::put('session.request_token', $request_token['oauth_token']);
    Session::put('session.request_token_secret', $request_token['oauth_token_secret']);

    //check we have a valid request with tumblr
    if ( $connection->http_code == 200 ) {
      //d) build authorise url and redirect
      return Redirect::away( $connection->getAuthorizeURL( $request_token['oauth_token'] ) );
    } else {
      Log::info('Tumblr Request Token Error', array("context", $connection->http_code));
    }

  }

  //STEP 2 - authorise with tumblr api
  public function doTumblrAuthStep2() {

    //* if access_token is stored then we can skip step 2
      //* we need to check if the stored token is still valid

    //get tumblr config
    $tconfig = Config::get('tumblr');

    //a) authorise with tumblr


    //b) rebuild auth object using consumer keys & temporary credentials
    $connection = new TumblrOAuth($tconfig["consumer_key"], $tconfig["consumer_secret"], Session::get('session.request_token'), Session::get('session.oauth_token_secret'));

    //c) get access token from tumblr api
    $access_token = $connection->getAccessToken(Input::get('oauth_verifier'));

    //check we have a valid request with tumblr
    if ( $connection->http_code == 200 ) {

      // d) store access_token in database auths table
      Log::info($access_token);
      Session::put('session.access_token', $access_token);
      Session::put('session.verified', time());

      // e) build tumblr object using consumer keys & access token
      $client = new Tumblr\API\Client($tconfig["consumer_key"], $tconfig["consumer_secret"]);
      $client->setToken($oauth_token, $oauth_secret);

      // f) use oauth object (access token) to query tumblr
      $data = $client->getUserInfo();
      dd($data->user);
      // Log::info( $data->user->name );

      return Redirect::away( '/' );

    } else {
      Log::info('Tumblr Access Token Error', array("context", $connection->http_code));
    }


  }


      //   //uncomment when testing to remove all records
      //   User::truncate();
      //   UserAuth::truncate();

      //   //does user already exist?
      //   $user = DB::table('users')->where('email', $api_data["email"])->first();

      //   if (empty($user)) {

      //     //create a new user
      //     $user = User::create(array(
      //         'email' => $api_data["email"],
      //         'first_name' => $api_data["first_name"],
      //         'last_name' => $api_data["last_name"],
      //         'bio' => $api_data["bio"],
      //         'gender' => $api_data["gender"],
      //         'pic_url' => 'https://graph.facebook.com/'.strtolower(str_replace(" ",".",$api_data["name"])).'/picture?type=large',
      //         'location' => $api_data["location"]->name,
      //         'locale' => $api_data["locale"],
      //         'timezone' => $api_data["timezone"],
      //         'social_links' => $api_data["link"],
      //         'email_verified' => $api_data["verified"]
      //     ));
      //     Log::info($user);

      //   }
      //   else {

      //     //update user last logged in (updated_at)
      //     $user = User::find($user->id);
      //     $user->touch();
      //     $user->save();

      //   }

      //   //get the full user data
      //   $user = User::find($user->id)->first();

      //   //update auth table
      //   $auth = DB::table('auths')
      //     ->where('network', "facebook")
      //     ->where('network_id', $api_data["id"])
      //     ->first();

      //   if (empty($auth)) {

      //     //create a new auth
      //     $auth = UserAuth::create(array(
      //         'user_id' => $user->id,
      //         'network_id' => $api_data["id"],
      //         'network' => "facebook"
      //     ));

      //   }

      //   //update access token
      //   $auth = UserAuth::find($auth->id);
      //   $auth->access_token = $session->getToken();
      //   $auth->save();

      //   //create new session
      //   Session::put('session.user_id', $user->id);
      //   Session::put('session.network', 'facebook');
      //   Session::put('session.network_id', $auth->network_id);
      //   Session::put('session.access_token', $session->getToken());
      //   Session::put('session.logout_url', $this->getLogoutURL($session));

      //   //manually login user
      //   Auth::login($user);
      //   Session::flash('message', 'logged in as '.$user->email);
      //   return Redirect::to('/');

      // } catch(FacebookRequestException $e) {

      //   Session::flash('message', 'Exception occured, code: ' . $e->getCode() . ' with message: ' . $e->getMessage());
      //   return Redirect::to('login');

      // }


  //logout/clear the session
  public function doLogout() {

    //Removing All Items From The Session
    Session::flush();
    return Redirect::to('/');

  }

}
