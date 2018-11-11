<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiRequest;
use App\RoomService\Room;
use App\RoomService\Hoover;

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
        $json = $request->json();

        $room = new Room($json->get('roomSize'));
        $room->setPatches($json->get('patches'));

        $hoover = new Hoover();
        $hoover
          ->setRoom($room)
          ->setPosition($json->get('coords'))
          ->setInstructions($json->get('instructions'))
          ->run();

        // Construct response.
        $response = [
          'coords' => $hoover->getPosition(),
          'patches' => count($room->getPatches()),
        ];

        // Store the request input/output.
        ApiRequest::create([
          'endpoint' => $request->getUri(),
          'input' => json_encode($request->json()->all()),
          'output' => json_encode($response),
        ]);

        return response()->json($response, 201);
    }
}
