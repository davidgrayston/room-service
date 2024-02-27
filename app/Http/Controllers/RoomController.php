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
        $area = new Area($json->all('roomSize'));
        $area->setPatches($json->all('patches'));

        // Create hoover to clean the area.
        $hoover = new Hoover();
        $hoover
            ->setArea($area)
            ->setPosition($json->all('coords'))
            ->setInstructions($json->get('instructions'))
            ->run();

        // Construct response.
        $status = 201;
        $response = [
            'coords' => $hoover->getPosition(),
            'patches' => $area->getPatchesCleaned(),
        ];

        // Store the request input/output.
        $this->storeApiRequest($request, $response, $status);

        return response()->json($response, $status);
    }

    /**
     * Store the request input/output.
     *
     * @param Request $request
     * @param array $response
     * @param int $status
     */
    private function storeApiRequest(Request $request, $response, $status)
    {
        if (env('APP_STORE_API_REQUESTS', true) === false) {
            return;
        }

        ApiRequest::create([
            'endpoint' => $request->getUri(),
            'input' => json_encode($request->json()->all()),
            'output' => json_encode($response),
            'status' => $status,
        ]);
    }
}
