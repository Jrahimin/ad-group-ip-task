<?php

namespace Tests\Feature;

use App\Contracts\Repositories\IpRepositoryInterface;
use App\Enums\HttpCodes;
use App\Models\Ip;
use App\Models\User;
use Mockery;
use Tests\TestCase;

class IpManagementTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function testUnAuthenticatedAccess(): void
    {
        $unAuthenticatedResponse = $this->json('GET', '/api/ips');
        $unAuthenticatedResponse->assertStatus(HttpCodes::UNAUTHORIZED);
    }

    /**
     * @test
     * @return void
     */
    public function testFetchAllIps(): void
    {
        $mockRepository = Mockery::mock(IpRepositoryInterface::class);
        $this->app->instance(IpRepositoryInterface::class, $mockRepository);

        $mockIpData = ['ip_address' => '127.0.0.1', 'label' => 'Localhost'];
        $mockIpList = collect([new Ip($mockIpData)]);

        $mockRepository->shouldReceive('getAll')->once()->andReturn($mockIpList);

        $user     = User::where('email', 'admin@gmail.com')->first();
        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/ips');

        $response->assertStatus(200)
                 ->assertJson([
                     'code'    => 200,
                     'message' => config('response.messages.ip_list'),
                     'data'    => [
                         'status' => 200,
                         'data'   => [$mockIpData]
                     ]
                 ]);

        Mockery::close();
    }
}