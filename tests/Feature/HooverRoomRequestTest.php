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
    public function testHooverRoomRequest($input, $output)
    {
        $response = $this->postJson('/api/room/hoover', $input);
        $response->assertStatus(201);
        $response->assertExactJson($output);
    }

    /**
     * Data provider for hoover requests.
     */
    public function hooverRoomRequestProvider()
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
          ],
        ];
    }
}
