<?php


namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('create')->with([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ])->andReturn((object) $data);

        $this->app->instance(User::class, $userMock);

        $request = Request::create('/api/users', 'POST', $data);
        $controller = new UserController();

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => (object) [
                'name' => $data['name'],
                'email' => $data['email'],
                'created_at' => null,
                'updated_at' => null,
            ]
        ]));
    }

    /** @test */
    public function it_can_show_a_user()
    {

        $user = User::factory()->create();


        $request = Request::create('/api/users/' . $user->id, 'GET');
        $controller = new UserController();

        $response = $controller->show($request, $user->id);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode([
            'status' => true,
            'user' => $user
        ]));
    }

    /** @test */
    public function it_can_update_a_user()
    {

        $user = User::factory()->create();


        $data = [
            'name' => 'Updated User',
            'email' => 'updateduser@example.com',
            'password' => 'newpassword'
        ];

        $request = Request::create('/api/users/' . $user->id, 'PUT', $data);
        $controller = new UserController();

        $response = $controller->update($request, $user->id);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode([
            'status' => true,
            'message' => 'User updated successfully'
        ]));
    }

    /** @test */
    public function it_can_delete_a_user()
    {

        $user = User::factory()->create();


        $request = Request::create('/api/users/' . $user->id, 'DELETE');
        $controller = new UserController();

        $response = $controller->destroy($user->id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode([
            'status' => true,
            'message' => 'User deleted successfully'
        ]));
    }
}
