<?php

require_once GMS_PLUGIN_DIR. '/lib/vendor/autoload.php'; 

$client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

$CLIENT_ID = get_option('gmgt_virtual_classschedule_client_id');

$CLIENT_SECRET = get_option('gmgt_virtual_classschedule_client_secret_id');

$REDIRECT_URI = site_url().'/?page=callback';



if(empty(get_option('gmgt_virtual_classschedule_access_token')) OR get_option('gmgt_virtual_classschedule_access_token'))

{

    $response = $client->request('POST', '/oauth/token', [

    "headers" => [

        "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)

    ],

        'form_params' => [

            "grant_type" => "authorization_code",

            "code" => $_GET['code'],

            "redirect_uri" => $REDIRECT_URI

        ],

    ]);

    $token = $response->getBody()->getContents();

    update_option( 'gmgt_virtual_classschedule_access_token', $token );

    $site_url=site_url().'/wp-admin/admin.php?page=gmgt_virtual_class&tab=meeting_list&message=4';

    // $site_url= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    header('Location:'.$site_url);

    // wp_redirect($site_url);

    // exit();

}

else

{

    $get_token = get_option('gmgt_virtual_classschedule_access_token');

    $token_decode = json_decode($get_token);

    $refresh_token = $token_decode->refresh_token;

    

    $response = $client->request('POST', '/oauth/token', [

        "headers" => [

            "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)

        ],

        "query" => [

            "grant_type" => "refresh_token",

            "refresh_token" => $refresh_token

        ],

    ]);

    $token = $response->getBody()->getContents();

    update_option( 'gmgt_virtual_classschedule_access_token', $token );

    

}
?>