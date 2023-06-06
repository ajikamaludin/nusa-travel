<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DepositHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositeAgentController extends Controller
{
    public function index(Request $request)
    {
        $query = DepositHistory::with(['customer']);

        if ($request->has('q')) {
            $query->where('description', 'like', "%{$request->q}%");
        }

        return inertia('DepositeAgent/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|uuid|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();
        $customer = Customer::find($request->customer_id);

        $customer->update(['deposite_balance' => $customer->deposite_balance + $request->amount]);
        $customer->depositeHistories()->create([
            'debit' => $request->amount,
            'description' => $request->description,
            'is_valid' => DepositHistory::VALID,
        ]);
        DB::commit();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function destroy(Request $request, DepositHistory $history)
    {
        if ($history->created_by != $request->user()->id) {
            session()->flash('message', ['type' => 'error', 'message' => 'Item can\'t be delete']);

            return;
        }

        DB::beginTransaction();
        $customer = Customer::withTrashed()->find($history->customer_id);

        $balance = $customer->deposite_balance - $history->debit;
        if ($balance < 0) {
            $balance = 0;
        }
        $customer->update(['deposite_balance' => $balance]);
        $history->delete();
        DB::commit();

        session()->flash('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }
}
