<?php

namespace Tests\Feature;

use Tests\TestCase;

class HooverRoomRequestTest extends TestCase
{

    /**
     * Test input/output of /api/room/hoover endpoint.
     *
     * @dataProvider hooverRoomRequestProvider
     */
    public function testHooverRoomRequest($input, $output, $status)
    {
        $response = $this->postJson('/api/room/hoover', $input);
        $response->assertStatus($status);
        $response->assertExactJson($output);
    }

    /**
     * Data provider for hoover requests.
     */
    public static function hooverRoomRequestProvider()
    {
        return [
            [
                [
                    'roomSize' => [5, 5],
                    'coords' => [1, 2],
                    'patches' => [
                        [1, 0],
                        [2, 2],
                        [2, 3],
                    ],
                    'instructions' => 'NNESEESWNWW',
                ],
                [
                    'coords' => [1, 3],
                    'patches' => 1,
                ],
                201,
            ],
            [
                [
                    'roomSize' => [2, 2],
                    'coords' => [0, 0],
                    'patches' => [
                        [0, 0],
                        [0, 1],
                        [1, 1],
                        [1, 0],
                    ],
                    'instructions' => 'NESW',
                ],
                [
                    'coords' => [0, 0],
                    'patches' => 4,
                ],
                201,
            ],
            [
                [
                    'roomSize' => [2, 2, 2],
                    'coords' => [0, 0],
                    'patches' => [],
                    'instructions' => 'N',
                ],
                [
                    'message' => '[roomSize] There must be a maximum of 2 items in the array',
                ],
                400,
            ],
            [
                [
                    'roomSize' => [2, 2],
                    'coords' => [0, 0, 0],
                    'patches' => [],
                    'instructions' => 'N',
                ],
                [
                    'message' => '[coords] There must be a maximum of 2 items in the array',
                ],
                400,
            ],
            [
                [
                    'roomSize' => [2, 2],
                    'coords' => [0, 0],
                    'patches' => [
                        [0, 0, 0],
                    ],
                    'instructions' => 'N',
                ],
                [
                    'message' => '[patches[0]] There must be a maximum of 2 items in the array',
                ],
                400,
            ],
            [
                [
                    'coords' => [0, 0],
                    'patches' => [
                        [0, 0],
                    ],
                    'instructions' => 'N',
                ],
                [
                    'message' => '[roomSize] The property roomSize is required',
                ],
                400,
            ],
            [
                [
                    'roomSize' => [0, 0],
                    'patches' => [
                        [0, 0],
                    ],
                    'instructions' => 'N',
                ],
                [
                    'message' => '[coords] The property coords is required',
                ],
                400,
            ],
            [
                [
                    'roomSize' => [0, 0],
                    'coords' => [0, 0],
                    'instructions' => 'N',
                ],
                [
                    'message' => '[patches] The property patches is required',
                ],
                400,
            ],
            [
                [
                    'roomSize' => [2, 2],
                    'coords' => [0, 0],
                    'patches' => [],
                ],
                [
                    'message' => '[instructions] The property instructions is required',
                ],
                400,
            ],
        ];
    }
}
