<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiRequest;

class RoomController extends Controller
{
    /**
     * Hoover a room defined in the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hoover(Request $request)
    {
        $roomSize = $request->json()->get('roomSize');
        $coords = $request->json()->get('coords');
        $patches = $request->json()->get('patches');
        $instructions = $request->json()->get('instructions');

        $response = [$roomSize, $coords, $patches, $instructions];

        // Store the request input/output.
        ApiRequest::create([
          'endpoint' => $request->getUri(),
          'input' => json_encode($request->json()->all()),
          'output' => json_encode($response),
        ]);

        return response()->json($response, 201);
    }
}
