<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiRequest;
use App\RoomService\Area\Area;
use App\RoomService\Device\Hoover;

class RoomController extends Controller
{

    /**
     * Hoover a room defined in the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function hoover(Request $request)
    {
        $json = $request->json();

        // Create area to be cleaned.
        $area = new Area($json->get('roomSize'));
        $area->setPatches($json->get('patches'));

        // Create hoover to clean the area.
        $hoover = new Hoover();
        $hoover
          ->setArea($area)
          ->setPosition($json->get('coords'))
          ->setInstructions($json->get('instructions'))
          ->run();

        // Construct response.
        $status = 201;
        $response = [
          'coords' => $hoover->getPosition(),
          'patches' => $area->getPatchesCleaned(),
        ];

        // Store the request input/output.
        ApiRequest::create([
          'endpoint' => $request->getUri(),
          'input' => json_encode($json->all()),
          'output' => json_encode($response),
          'status' => $status,
        ]);

        return response()->json($response, $status);
    }
}
