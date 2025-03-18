<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class linkedin extends Controller
{
    //Function to call the Linkedin Login Form
    public function redirectToLinkedin()
    {

        $user_id = encrypt(auth()->user()->id);
        $state = $user_id;
        // encrypt(auth()->user()->id);
        $url = 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.linkedin.client_id'),
            'redirect_uri' => config('services.linkedin.redirect'),
            'state' => $state,
            'scope' => 'openid email profile w_member_social'
        ]);

        return redirect($url);
    }


    //It will recieve code and sent to getLinkedinToken
    //It will recieve Token(from getLinedinToken) and sent to getLinkedinUserInfo
    public function handleLinkedinCallback(Request $request)
    {
        $tokenData = $this->getLinkedinToken($request);
        $route = $this->getLinkedinUserInfo($tokenData);

        if ($route = 'home') {
            return redirect()->route('two-factor-setup')->with('success', 'Linkedin connected successfully');
        } else {
            return redirect()->route('linkedin.redirect');
        }
    }


    //Function 1: Fetch Token
    //It will recieve code and request Token
    public function getLinkedinToken(Request $request)
    {

        $code = $request->get('code');
        $state = decrypt($request->get('state'));

        $user_id = auth()->user()->id;
        if ($state !== $user_id) {
            // dd($user_id,'Userid & State are not equal' ,$state);
            abort(403, 'Invalid state Parameter');
        }

        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.linkedin.redirect'),
            'client_id' => config('services.linkedin.client_id'),
            'client_secret' => config('services.linkedin.client_secret')
        ]);

        return $response->json();
    }


    //Function 2: get UserInfo using Token
    //It will recieve Token and request userInfo and sent to manageLinkedinUser
    public function getLinkedinUserInfo($tokenData)
    {

        // Check if token is not empty
        if (isset($tokenData['access_token'])) {
            $token = $tokenData['access_token'];
        } else {
            return 'linkedin.redirect';
        }


        $responseUserInfo = Http::withToken($token)->get('https://api.linkedin.com/v2/userinfo');

        $userinfo = $responseUserInfo->json();


        $route = $this->manageLinkedinUser($userinfo, $token);
        return $route;
    }



    //Function 3: Save Token & UserInfo in database
    //It will recieve Token & userInfo and save it in database
    public function manageLinkedinUser($userinfo, $token)
    {
        $name = $userinfo['name'];
        $email = $userinfo['email'];
        $id = $userinfo['sub'];

        $user_id = auth()->user()->id;

        $existingUser = User::where('id', $user_id)->first();

        //TOKEN SHOULD NOT BE NULL
        if ($token != null) {
            if ($existingUser) {
                $existingUser->linkedin_token = $token;
                $existingUser->linkedin_id = $id;
                $existingUser->save();
                //dd("OK Token:" ,$token, "Existing user: ", $existingUser);
            } else {

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
        } else {
            // return view('linkedin.redirect');
            return 'linkedin.redirect';
        }

    }


    public function postOnLinkedin(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');


        if ($request->has('image')) {
            $Response = $this->imagePost($request->image, $title, $description);
        } else if ($request->has('video')) {
            $Response = $this->videoPost($request->video, $title, $description);
        } else {
            $Response = $this->textPost($title, $description);
        }


        // DEBUGGING
        return response()->json([
            'status' => 'success',
            'message' => $Response
        ]);




        if ($Response == 200) {

            return response()->json([
                'status' => 'success',
                'message' => 'Posted on Linkedin Sucessfully'
            ]);

        } else if ($Response == 500 || $Response == 401) {

            return response()->json([
                'status' => 'failed',
                'message' => 'Try connecting with linkedin again'
            ]);

        } else if ($Response == 404) {

            //TOKEN IS EMPTY
            return response()->json([
                'status' => 'failed',
                'message' => 'First Connect with Linkedin'
            ]);

        } else {

            return response()->json([
                'status' => 'failed',
                'message' => 'Try connecting with linkedin again'
            ]);

        }






    }




    public function videoPost($video, $title, $description)
    {

        // API CALL: Initialize Video
        $initializeRes = $this->initializeVideo();
        $decodedData = $initializeRes->getData(true);

        if($decodedData['status'] == 'success'){

            $uploadUrl = $decodedData['url'];
            $videoID = $decodedData['videoID'];

            // API CALL: Upload Video
            $uploadRes = $this->uploadVideo($uploadUrl, $video);
            $decodedUpload = $uploadRes->getData(true);
            $etag = $decodedUpload['Etag'];

            if($decodedUpload['status'] == 'success'){

                //Checking the shit if available
                // $statusRes = $this->getVideoStatus($videoID);
                // return $statusRes;
                sleep(3);

                $finalizeRes = $this->finalizeUpload($videoID, $etag);
                if($finalizeRes == 200){
                    $postVideoRes = $this->postVideo($videoID, $title, $description);

                    if($postVideoRes == 200){
                        return 'Video Posted Successfully!';
                    }else{
                        return $postVideoRes;
                    }
                }else{
                    return $finalizeRes;
                }

                

            }else{
                return $decodedUpload['message'];
            }

            

        }else{
            return $decodedData['message'];
        }



        



        

    }


    public function initializeVideo()
    {

        //Fetching user_id from users table
        $user_id = auth()->user()->id;
        $Token = User::where('id', $user_id)->value('linkedin_token');
        $linkedin_id = User::where('id', $user_id)->value('linkedin_id');

        $url = 'https://api.linkedin.com/rest/videos?action=initializeUpload';

        $body = [
            "initializeUploadRequest" => [
                "owner" => "urn:li:person:" . $linkedin_id,
                "fileSizeBytes" => 1055736,
                "uploadCaptions" => false,
                "uploadThumbnail" => false,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'LinkedIn-Version' => '202502',
                'X-Restli-Protocol-Version' => '2.0.0'
            ])->withToken($Token)
                ->post($url, $body);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }

        // DEBUGGING
        //return $response->body();

        $data = $response->json();
        if (isset($data['value']['uploadInstructions'][0]['uploadUrl'])) {
            return response()->json([
                'status' => 'success',
                'message' => 'Video Initialized!',
                'url' => $data['value']['uploadInstructions'][0]['uploadUrl'],
                'videoID' => $data['value']['video'],
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body()
            ]);
        }


    }


    public function uploadVideo($endpoint, $video){
        $video = public_path(str_replace(url('/'), '', $video));

        //Fetching user_id from users table
        $user_id = auth()->user()->id;
        $Token = User::where('id', $user_id)->value('linkedin_token');

        if(!file_exists($video)){
            return $video;
        }

        $videoStream = fopen($video,'r');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $Token,
            'Content-Type' => 'application/octet-stream'
        ])->withBody(stream_get_contents($videoStream), 'application/octet-stream')
        ->post($endpoint);

        fclose($videoStream);

        if($response->successful()){
            // return 200;
            $etag = $response->header('Etag');
            return response()->json([
                'status' => 'success',
                'message'=> '200',
                'Etag' => $etag
            ]);
        }else{
            return response()->json([
                'status' => 'failed',
                'message'=> $response->body()
            ]);
        }
    }


    public function getVideoStatus($videoID){
        //Fetching user_id from users table
        $user_id = auth()->user()->id;
        $Token = User::where('id', $user_id)->value('linkedin_token');
        if (!$Token) {
            return 401;
        }

        $videoID = str_replace('urn:li:video:' ,'', $videoID);
        $url = "https://api.linkedin.com/rest/assets/{$videoID}";

        $flag = true;
        while($flag){

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $Token,
            'LinkedIn-Version' => '202502'
        ])->get($url);

        $flag = false;
        return $response->body();



           







        $data = $response->json();
        if(isset($data['recipes'][0]['status']) && $data['recipes'][0]['status'] === 'WAITING_UPLOAD'){
            $flag = false;
            return 'WAITING_UPLOAD';
        }else{
            return 'Loop laga le bhai';
        }

    }
    }



    public function finalizeUpload($videoID, $etag){
        $user_id = auth()->user()->id;
        $Token = User::where('id', $user_id)->value('linkedin_token');

        if (!$Token) { 
            return 'Invalid Token';
        }

        $videoID = str_replace('urn:li:video:' ,'', $videoID);
        $url = 'https://api.linkedin.com/rest/videos?action=finalizeUpload';

        $body = [
            'finalizeUploadRequest' => [
            'video' => 'urn:li:video:' . $videoID,
            'uploadToken' => '',
            'uploadedPartIds' => [$etag]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $Token,
            'LinkedIn-Version' => '202502',
            'X-Restli-Protocol-Version' => '2.0.0'
        ])->post($url, $body);

        if($response->successful()){
            return 200;
        }else{
            return $response->body();
        }
    }


    public function postVideo($videoID , $title, $description){
        $combinedText = $title . ' ' . $description;
        $user_id = auth()->user()->id;
        $Token = User::where('id', $user_id)->value('linkedin_token');
        $pid = User::where('id', $user_id)->value('linkedin_id');

        if (!$Token) {
            return 'Token not found';
        }
        $videoID = str_replace('urn:li:video:' ,'', $videoID);

        $url = 'https://api.linkedin.com/v2/ugcPosts';

        $body = [
            'author' => 'urn:li:person:' . $pid,
            'lifecycleState' => 'PUBLISHED',
            'specificContent' =>[
                'com.linkedin.ugc.ShareContent' => [
                    'shareCommentary' => [
                        'text' => $combinedText,
                    ],
                    'shareMediaCategory' => 'VIDEO',
                    'media' => [
                        [
                        'status' => 'READY',
                        'description' => [
                            'text' => 'Video description'
                        ],
                        'media' => 'urn:li:digitalmediaAsset:' . $videoID,
                        'title' => [
                            'text' => $title
                        ],
                        ]
                    ],
                ],
            ],
            'visibility' => [
                'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' =>'Bearer ' . $Token,
            'Content-Type' => 'application/json',
            'LinkedIn-Version' => '202502',
            'X-Restli-Protocol-Version' => '2.0.0'
        ])->post($url, $body);

        if ($response->successful()){
            return 200;
        }else{
            return $response->body();
        }

    }





    public function textPost($title, $description)
    {

        try {
            //Fetching user_id from users table
            $user_id = auth()->user()->id;
            $Token = User::where('id', $user_id)->value('linkedin_token');
            $linkedin_id = User::where('id', $user_id)->value('linkedin_id');

            if ($Token != null && $linkedin_id != null) {

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

                $response = Http::withHeaders([
                    'X-Restli-Protocol-Version' => '2.0.0',
                    'Content-Type' => 'application/json',
                ])->withToken($Token)
                    ->post($url, $body);

                if ($response->successful()) {
                    return 200;
                } else {
                    return 401;
                }

            } else {
                return 404;
            }


        } catch (\Exception $e) {
            return 500;
        }

    }


    public function imagePost($image, $title, $description)
    {
        $uploadUrl = null;
        $asset = null;

        $registerRes = $this->registerImage();
        $decodedRegisterRes = $registerRes->getData(true);

        if ($decodedRegisterRes['status'] == 200) {

            $uploadUrl = $decodedRegisterRes['uploadUrl'];
            $asset = $decodedRegisterRes['asset']; //Its image id

            $uploadRes = $this->uploadImage($uploadUrl, $image);

            //DEBUGGING
            //return $uploadRes;

            if ($uploadRes == 200) {

                $getStatusRes = $this->getImageStatus($asset);

                //DEBUGGING
                //return 'STATUS OF IMAGE::' . $getStatusRes;

                if ($getStatusRes == 200) {

                    $postImgRes = $this->postImage($asset, $title, $description);

                    //DEBUGGING
                    // return $postImgRes;

                    if ($postImgRes == 200) {
                        return 200;
                    } else {
                        return 400;
                    }

                } else {
                    return 400;
                }



            } else {
                return 400;
            }

        } else {
            return 400;
        }




    }

    public function registerImage()
    {

        try {

            $user_id = Auth::id();
            $Token = User::where('id', $user_id)->value('linkedin_token');
            $linkedin_id = User::where('id', $user_id)->value('linkedin_id');

            if (!$Token || !$linkedin_id) {

                //Token or ID missing
                return response()->json([
                    'status' => 404,
                    'message' => 'Token or PersonID is missing',
                ]);

            }

            $url = "https://api.linkedin.com/v2/assets?action=registerUpload";
            $body = [
                "registerUploadRequest" => [
                    "recipes" => ["urn:li:digitalmediaRecipe:feedshare-image"],
                    "owner" => "urn:li:person:" . $linkedin_id,
                    "serviceRelationships" => [
                        [
                            "relationshipType" => "OWNER",
                            "identifier" => "urn:li:userGeneratedContent"
                        ]
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $Token,
                'Content-Type' => 'application/json'
            ])->post($url, $body);

            if ($response->successful()) {

                $data = $response->json();

                $uploadUrl = $data['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'] ?? null;
                $asset = $data['value']['asset'] ?? null;

                return response()->json([
                    'status' => 200,
                    'message' => 'Upload URL retrieved successfully',
                    'uploadUrl' => $uploadUrl,
                    'asset' => $asset
                ]);

            } else {

                return response()->json([
                    'status' => 401,
                    'message' => 'Request Failed',
                    'error' => $response->body()
                ], $response->status());

            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);

        }
    }




    public function uploadImage($uploadUrl, $image)
    {
        // Construct the full path to the image
        $imagePath = public_path($image);

        if (!file_exists($imagePath)) {
            return 400;
        }

        // Get the authenticated user's LinkedIn token
        $user_id = auth()->user()->id;
        $token = User::where('id', $user_id)->value('linkedin_token');

        if (!$token) {
            return 401;
        }



        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->withOptions(['verify' => false])
                ->withBody(fopen($imagePath, 'r'), 'application/octet-stream')
                ->put($uploadUrl);

            return $response->successful() ? 200 : 'something went wrong';

        } catch (\Exception $e) {
            return 'EXCEPTION CATCHED' . $e->getMessage();
        }



    }



    public function postImage($imageID, $title, $description)
    {
        // Fetch user details
        $user_id = Auth::id();
        $token = User::where('id', $user_id)->value('linkedin_token');
        $personID = User::where('id', $user_id)->value('linkedin_id');

        if (!$token || !$personID) {
            return 401;
        }

        $url = 'https://api.linkedin.com/v2/ugcPosts';

        $body = [
            "author" => "urn:li:person:" . $personID,
            "lifecycleState" => "PUBLISHED",
            "specificContent" => [
                "com.linkedin.ugc.ShareContent" => [
                    "shareCommentary" => [
                        "text" => $description
                    ],
                    "shareMediaCategory" => "IMAGE",
                    "media" => [
                        [
                            "status" => "READY",
                            "description" => [
                                "text" => "Center stage!"
                            ],
                            "media" => $imageID,
                            "title" => [
                                "text" => $title
                            ]
                        ]
                    ]
                ]
            ],
            "visibility" => [
                "com.linkedin.ugc.MemberNetworkVisibility" => "PUBLIC"
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post($url, $body);

        // return $response->successful() ? 200 : $response->status();
        $data = $response->json();
        return $response->successful() && isset($data['id']) ? 200 : $response->status();

        //DEBUGGING
        // return $response->successful() && isset($data['id']) ? $data['id'] : $response->status();

    }





    public function getImageStatus($imageID)
    {
        $imageID = str_replace('urn:li:digitalmediaAsset:', '', $imageID);

        // Fetch user token
        $user_id = Auth::id();
        $token = User::where('id', $user_id)->value('linkedin_token');

        if (!$token) {
            return 401;
        }

        // API URL
        $url = "https://api.linkedin.com/v2/assets/{$imageID}";

        $flag = true;
        while ($flag) {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();

                //Check if 'recipes' key exists
                if (isset($data['recipes'][0]['status']) && $data['recipes'][0]['status'] === 'AVAILABLE') {
                    $flag = false;
                    //DEBUGGING
                    // return $response->body();

                    return 200;
                } else {
                    return 'NOT AVAILABLE';
                }
            }


        }



        // if ($response->successful()) {
        //     $data = $response->json();

        //     //DEBUGGGGGGGGGGGGGGGGINGGGGGGGGGGGGGGGGGGGGGGG
        //     // return $data['recipes'][0]['status'];
        //     return $response->body();

        //     // Check if 'recipes' key exists
        //     // if (isset($data['recipes'][0]['status']) && $data['recipes'][0]['status'] === 'AVAILABLE') {
        //     //     return 200;
        //     // }
        // }

        // return $response->status();
    }





}