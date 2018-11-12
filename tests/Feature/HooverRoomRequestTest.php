<?php

namespace Tests\Feature;

use Tests\TestCase;

class HooverRoomRequestTest extends TestCase
{

    /**
     * Test input/output of /api/room/hoover endpoint.
     *
     * @return void
     */
    public function testHooverRoomRequest()
    {
        $response = $this->postJson('/api/room/hoover', [
          'roomSize' => [5, 5],
          'coords' => [1, 2],
          'patches' => [
            [1, 0],
            [2, 2],
            [2, 3],
          ],
          'instructions' => 'NNESEESWNWW',
        ]);

        $response->assertStatus(201);
        $response->assertExactJson([
          'coords' => [1, 3],
          'patches' => 1,
        ]);
    }
}
