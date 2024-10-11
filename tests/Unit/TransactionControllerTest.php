<?php

namespace Tests\Unit;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;


class TransactionControllerTest extends TestCase
{

    use RefreshDatabase;

    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_transaction()
    {
        // Mock the request and transaction creation
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'amount' => 1000,
            'transaction_id' => 'TX123456789',
            'status' => 'completed'
        ];

        $transactionMock = Mockery::mock(Transaction::class);
        $transactionMock->shouldReceive('create')->with($data)->andReturn((object) $data);

        $this->app->instance(Transaction::class, $transactionMock);

        $request = Request::create('/api/transactions', 'POST', $data);


        $controller = new TransactionController();


        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode(['status' => true, 'message' => 'Transaction created successfully']));
    }

    /** @test */
    public function it_can_update_a_transaction()
    {

        $user = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user->id]);

        $data = [
            'amount' => 1500,
            'status' => 'pending'
        ];

        $request = Request::create('/api/transactions/' . $transaction->id, 'PUT', $data);

        $controller = new TransactionController();


        $response = $controller->update($request, $transaction->id);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode(['status' => true, 'message' => 'Transaction updated successfully']));
    }

    /** @test */
    public function it_can_delete_a_transaction()
    {

        $transaction = Transaction::factory()->create();


        $request = Request::create('/api/transactions/' . $transaction->id, 'DELETE');

        $controller = new TransactionController();


        $response = $controller->destroy($transaction->id);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent(), json_encode(['status' => true, 'message' => 'Transaction deleted successfully']));
    }
}
