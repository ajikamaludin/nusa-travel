<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Order;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Inertia\Response;

class GeneralController extends Controller
{
    public function index(): Response
    {
        $visitor_today = Visitor::whereDate('created_at', now())->count();
        $order_total = Order::count();
        $order_today = Order::whereDate('created_at', now())->count();
        $order_pending = Order::where('payment_status', Order::PAYMENT_PENDING)->count();

        return inertia('Dashboard', [
            'visitor_today' => $visitor_today,
            'order_total' => $order_total,
            'order_today' => $order_today,
            'order_pending' => $order_pending,
        ]);
    }

    public function indev(): Response
    {
        return inertia('Dev');
    }

    public function upload(Request $request)
    {
        $request->validate(['image' => 'required|file']);
        $file = $request->file('image');
        $file->store('uploads', 'public');

        $uploaded = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $file->hashName('uploads'),
        ]);

        return response()->json([
            'id' => $uploaded->id,
            'name' => $uploaded->name,
            'url' => asset($file->hashName('uploads')),
        ]);
    }
}
