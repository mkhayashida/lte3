<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function jackpot()
    {
        $client = new Client();

        $data = $client->get('https://wap-api.17app.co/api/v1/gift/luckybag', [
            'headers' => [
                'Host'               => 'wap-api.17app.co',
                'language'           => 'JP',
                'cache-control'      => 'no-cache',
                'user-agent'         => '17LIVE/4 CFNetwork/1496.0.7 Darwin/23.5.0',
                'devicetype'         => 'IOS',
                'devicename'         => 'iPhone',
                'useripregion'       => 'JP',
                'packagename'        => 'com.machipopo.story17',
                'accesstoken'        => '6377497d-eed2-4072-a5a7-e1798921ace5',
                'version'            => '3.280.0',
                'deviceid'           => '25e7581970df4da79c3c3c0346b3f67f',
                'advertisementid'    => '00000000-0000-0000-0000-000000000000',
                'debug-level'        => '0',
                'hardware'           => 'iPhone16,1',
                'userselectedregion' => 'JP',
                'osversion'          => '17.5.1',
                'accept-language'    => 'ja',
                'accept'             => 'application/json'
            ]
        ]);


        return $data->getBody()->getContents();
    }
    public function rank()
    {
        $client = new Client();

        $data = $client->get('https://wap-api.17app.co/api/v1/leaderboards/eventory?containerID=fa3a73d6-06d8-4a98-abfa-b61953d62b15&cursor=&count=20', [
            'headers' => [
                'Host'               => 'wap-api.17app.co',
                'language'           => 'JP',
                'cache-control'      => 'no-cache',
                'user-agent'         => '17LIVE/4 CFNetwork/1496.0.7 Darwin/23.5.0',
                'devicetype'         => 'IOS',
                'devicename'         => 'iPhone',
                'useripregion'       => 'JP',
                'packagename'        => 'com.machipopo.story17',
                'accesstoken'        => '6377497d-eed2-4072-a5a7-e1798921ace5',
                'version'            => '3.280.0',
                'deviceid'           => '25e7581970df4da79c3c3c0346b3f67f',
                'advertisementid'    => '00000000-0000-0000-0000-000000000000',
                'debug-level'        => '0',
                'hardware'           => 'iPhone16,1',
                'userselectedregion' => 'JP',
                'osversion'          => '17.5.1',
                'accept-language'    => 'ja',
                'accept'             => 'application/json'
            ]
        ]);


        return $data->getBody()->getContents();
    }
}
