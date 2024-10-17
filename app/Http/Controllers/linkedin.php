<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class linkedin extends Controller
{
    //Function to call the Linkedin Login Form
   public function redirectToLinkedin(){

        $user_id = auth()->user()->id;
        $client_id= '77qogskkj6bgop';
        $redirected_uri= 'http://127.0.0.1:8000/linkedin/auth/callback';
        $state= $user_id;
        // encrypt(auth()->user()->id);
        $url= 'https://www.linkedin.com/oauth/v2/authorization?' .http_build_query([
            'response_type' => 'code',
            'client_id' => $client_id,
            'redirect_uri' => $redirected_uri,
            'state' => $state,
            'scope' => 'openid email profile w_member_social'
        ]);

        return redirect($url);
    }


    //It will recieve code and sent to getLinkedinToken
    //It will recieve Token(from getLinedinToken) and sent to getLinkedinUserInfo
    public function handleLinkedinCallback(Request $request){
        $tokenData = $this->getLinkedinToken($request);
        $route =$this->getLinkedinUserInfo($tokenData);

        if($route='home'){
            return redirect()->route('two-factor-setup')->with('success','Linkedin connected successfully');
        }else{
            return redirect()->route('linkedin.redirect');
        }
    }


    //Function 1: Fetch Token
    //It will recieve code and request Token
    public function getLinkedinToken(Request $request){

        $code = $request->get('code');
        $state = $request->get('state');

        $user_id = auth()->user()->id;
        if($state !== "$user_id"){
            dd($user_id, $state);
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

        return $response->json();
    }


    //Function 2: get UserInfo using Token
    //It will recieve Token and request userInfo and sent to manageLinkedinUser
    public function getLinkedinUserInfo($tokenData){
        
        // Check if token is not empty
        if(isset($tokenData['access_token'])){
            $token = $tokenData['access_token'];
        }else{
            return 'linkedin.redirect';
        }
            

            $responseUserInfo = Http::withToken($token)->get('https://api.linkedin.com/v2/userinfo');

            $userinfo = $responseUserInfo->json();


            $route= $this->manageLinkedinUser($userinfo, $token);
            return $route;
    }



    //Function 3: Save Token & UserInfo in database
    //It will recieve Token & userInfo and save it in database
    public function manageLinkedinUser($userinfo, $token){
            $name = $userinfo['name'];
            $email = $userinfo['email'];
            $id = $userinfo['sub'];

            $user_id = auth()->user()->id;

            $existingUser = User::where('id', $user_id)->first();

            //TOKEN SHOULD NOT BE NULL
            if($token != null){
                if($existingUser){
                    $existingUser->linkedin_token = $token;
                    $existingUser->linkedin_id = $id;
                    $existingUser->save();
                    //dd("OK Token:" ,$token, "Existing user: ", $existingUser);
                } else{
    
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'email_verified_At' => Carbon::now(),
                        'linkedin_token' => $token,
                        'linkedin_id' => $id,
                        'password' => null,
                    ]);
                    //dd($token);
                }

                return 'home';
            }else{
                // return view('linkedin.redirect');
                return 'linkedin.redirect';
            }
            


            // dd('USER LINKED');
            //dd($token);
            // Auth::login($existingUser);
           //  return view('home');

           //$id = Auth::user()->id;
           //dd(auth()->user()->id);
           //dd("HI");
           //return view('home');
    }


    public function postOnLinkedin(Request $request)
    {
        try{
        //Fetching user_id from users table
        $user_id = auth()->user()->id;
        $Token = User::where('id', $user_id)->value('linkedin_token');
        $linkedin_id = User::where('id', $user_id)->value('linkedin_id');

        if($Token!=null && $linkedin_id!=null){
            

        // CONCATENATE TITLE & DESCRIPTION
        //$productId = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');
        $combinedContent = $title . ' ' . $description;

        //PREPARING REQUEST DATA
            $url = 'https://api.linkedin.com/v2/ugcPosts'; 

            $body = [
                'author' => 'urn:li:person:' . $linkedin_id, 
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $combinedContent
                        ],
                        'shareMediaCategory' => 'NONE'
                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ];

            //POST request with headers and Bearer Token authorization
            $response = Http::withHeaders([
                'X-Restli-Protocol-Version' => '2.0.0',
                'Content-Type' => 'application/json',
            ])->withToken($Token) 
            ->post($url, $body);

            //EXCEPTION HANDLING FOR THE REQUEST
            if($response->successful()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Posted on Linkedin Sucessfully'
                ]);
            } else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Try connecting with linkedin again'
                ]);
            }





        }else{

            // TOKEN IS EMPTY
            return response()->json([
                'status' => 'failed',
                'message' => 'First Connect with Linkedin'
            ]);
        }


    }catch(\Exception $e){

        return response()->json([
            'status' => 'failed',
            'message' => 'Try connecting with linkedin again'
        ]);
    }



            
            //Check if the request was successful
        //     if ($response->successful()) {
        //         return response()->json([
        //             'message' => 'Post successfully published on LinkedIn!',
        //             'status' => 'success',
        //         ]);
        //     } else {
        //         return response()->json([
        //             'message' => 'Failed to post on LinkedIn.',
        //             'status' => 'failed', 
        //         ], );
        // }
    }
}