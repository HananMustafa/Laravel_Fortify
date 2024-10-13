<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class linkedin extends Controller
{
    // public function index(){
    //     $repsonse = Http::get('https://www.linkedin.com/oauth/v2/authorization?',[
    //         'response_type' => 'code',
    //         'client_id' => '77qogskkj6bgop',
    //         'redirect_uri' => 'http://127.0.0.1:8000/linkedin/code',
    //         'state' => 'Hello404',
    //         'scope' => 'openid email profile'

    //     ]);

    //     $jsonData = $repsonse->json();
    //     dd($jsonData);

    // }

    public function redirectToLinkedin(){

        $client_id= '77qogskkj6bgop';
        $redirected_uri= 'http://127.0.0.1:8000/linkedin/auth/callback';
        $state= 'Hello01';
        $url= 'https://www.linkedin.com/oauth/v2/authorization?' .http_build_query([
            'response_type' => 'code',
            'client_id' => $client_id,
            'redirect_uri' => $redirected_uri,
            'state' => $state,
            'scope' => 'openid email profile'
        ]);

        return redirect($url);
    }


    public function handleLinkedinCallback (Request $request){

        $code = $request->get('code');
        $state = $request->get('state');

        if($state !== 'Hello01'){
            abort(403, 'Invalid state Parameter');
        }

        $client_id = '77qogskkj6bgop';
        $client_secret = 'WPL_AP1.A5qTtZgedWOq32vV.l1ci1w==';
        $redirectUri = 'http://127.0.0.1:8000/linkedin/auth/callback';

        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken',[
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ]);

        $tokenData = $response->json();

        dd($tokenData);
        // dd($tokenData['access_token']);

    }
}
