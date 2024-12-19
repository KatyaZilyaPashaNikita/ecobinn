<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function index()
    {
        $locationResponse = Http::get('http://ip-api.com/json/');
        
        if (!$locationResponse->successful()) {
            return view('map', [
                'userLocation' => [
                    'lat' => 55.7582,
                    'lon' => 52.4302
                ],
                'recyclePoints' => []
            ]);
        }

        $location = $locationResponse->json();
        $lat = $location['lat'];
        $lon = $location['lon'];

        $offset = 0.3;
        $bbox = ($lon - $offset) . ',' . 
                ($lat - $offset) . ',' . 
                ($lon + $offset) . ',' . 
                ($lat + $offset);

        $pointsResponse = Http::get('https://recyclemap.ru/api/public/points', [
            'bbox' => $bbox,
            'size' => 100,
            'offset' => 0
        ]);

        $recyclePoints = [];
        
        if ($pointsResponse->successful()) {
            $recyclePoints = $pointsResponse->json()['data']['points'] ?? [];
        }

        return view('map', [
            'userLocation' => [
                'lat' => $lat,
                'lon' => $lon
            ],
            'recyclePoints' => $recyclePoints
        ]);
    }
}
