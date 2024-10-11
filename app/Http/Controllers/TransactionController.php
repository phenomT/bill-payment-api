<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('user')->get();
        return TransactionResource::collection($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string|unique:transactions',
            'status' => 'required|string'
        ]);

        try {
            // Create the new transaction
            $transaction = Transaction::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Transaction created successfully',
                'transaction' => new TransactionResource($transaction)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $transaction = Transaction::with('user')->findOrFail($id);
            return new TransactionResource($transaction);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Transaction not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            // Validate the input
            $data = $request->validate([
                'user_id' => 'sometimes|required|exists:users,id',
                'amount' => 'sometimes|required|numeric',
                'transaction_id' => 'sometimes|required|string|unique:transactions,transaction_id,' . $transaction->id,
                'status' => 'sometimes|required|string'
            ]);

            // Update the transaction
            $transaction->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Transaction updated successfully',
                'transaction' => new TransactionResource($transaction)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();

            return response()->json([
                'status' => true,
                'message' => 'Transaction deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete transaction: ' . $e->getMessage()
            ], 500);
        }
    }
}
