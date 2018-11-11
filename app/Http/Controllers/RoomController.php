<?php

namespace App\Http\Controllers;

use App\Exceptions\RoomServiceValidation;
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

        try {
            $room = new Room($json->get('roomSize'));
            $room->setPatches($json->get('patches'));

            $hoover = new Hoover();
            $hoover
              ->setRoom($room)
              ->setPosition($json->get('coords'))
              ->setInstructions($json->get('instructions'))
              ->run();

            // Construct response.
            $status = 201;
            $response = [
              'coords' => $hoover->getPosition(),
              'patches' => count($room->getPatches()),
            ];
        }
        catch (RoomServiceValidation $e) {
            $status = 400;
            $response = [
              'message' => $e->getMessage(),
            ];
        }

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
