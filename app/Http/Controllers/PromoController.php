<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $query = Promo::query();

        if ($request->has('q')) {
            $query->where('question', 'like', "%{$request->q}%");
        }

        return inertia('Promo/Index', [
            'query' => $query->orderBy('created_at', 'desc')->paginate(),
        ]);
    }

    public function create()
    {
        return inertia('Promo/Form');
    }

    public function store(Request $request)
    {
        switch ($request->condition_type) {
            case 1:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code',
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'amount_buys' => 'required|numeric|gt:0',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            case 2:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code',
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'available_start_date' => 'required|date',
                    'available_end_date' => 'nullable|date|after_or_equal:available_start_date',
                    'ranges_day' => 'required|numeric|gt:0',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            case 3:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code',
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'order_start_date' => 'required|date',
                    'order_end_date' => 'nullable|date|after_or_equal:order_start_date',
                    'ranges_day' => 'required|numeric|gt:0',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            case 4:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code',
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'amount_buys' => 'required|numeric|gt:0',
                    'amount_tiket' => 'required|numeric|gt:0',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            default:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code',
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'available_start_date' => 'required|date',
                    'available_end_date' => 'nullable|date|after_or_equal:available_start_date',
                    'order_start_date' => 'nullable|date',
                    'order_end_date' => 'nullable|date|after_or_equal:available_start_date',
                    'user_perday_limit' => 'nullable|numeric',
                    'order_perday_limit' => 'nullable|numeric',
                    'condition_type' => 'required|string',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;

        }
        if ($request->discount_type == Promo::TYPE_PERCENT) {
            $request->validate([
                'discount_amount' => 'required|numeric|min:1|max:100',
            ]);
        }

        $code = Str::upper($request->code ?? Str::random(6));
        $amount_buys = $request->amount_buys;
        $amount_tiket = $request->amount_tiket;
        $ranges_day = $request->ranges_day;
        switch ($request->condition_type) {
            case '1':
                $ranges_day = null;
                $amount_tiket = null;
                break;
            case '2':
            case '3':
                $amount_buys = null;
                $amount_tiket = null;
                break;
            default:
        }

        $promo = Promo::make([
            'code' => $code,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'cover_image' => $request->cover_image,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'available_start_date' => $request->available_start_date != '' ? Carbon::parse($request->available_start_date) : '',
            'available_end_date' => $request->available_end_date != '' ? Carbon::parse($request->available_end_date) : '',
            'order_start_date' => $request->order_start_date != '' ? Carbon::parse($request->order_start_date) : '',
            'order_end_date' => $request->order_end_date != '' ? Carbon::parse($request->order_end_date) : '',
            'user_perday_limit' => $request->user_perday_limit ?? 0,
            'order_perday_limit' => $request->order_perday_limit ?? 0,
            'condition_type' => $request->condition_type,
            'amount_buys' => $amount_buys,
            'amount_tiket' => $amount_tiket,
            'ranges_day' => $ranges_day,
            'is_apply' => $request->is_apply,
        ]);

        // TODO: handle for latter , cover_image and descrition body
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $file->store('uploads', 'public');
            $promo->cover_image = $file->hashName('uploads');
        }

        $promo->save();

        return redirect()->route('promo.index')
            ->with('message', ['type' => 'success', 'message' => 'Promo has beed created']);
    }

    public function edit(Promo $promo)
    {
        if ($promo->available_start_date == '0000-00-00') {
            $promo->available_start_date = '';
        }
        if ($promo->available_end_date == '0000-00-00') {
            $promo->available_end_date = '';
        }
        if ($promo->order_start_date == '0000-00-00') {
            $promo->order_start_date = '';
        }
        if ($promo->order_end_date == '0000-00-00') {
            $promo->order_end_date = '';
        }

        return inertia('Promo/Form', ['promo' => $promo]);
    }

    public function update(Request $request, Promo $promo)
    {

        switch ($request->condition_type) {
            case 1:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code,'.$promo->id,
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'amount_buys' => 'required|numeric|gt:0',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            case 2:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code,'.$promo->id,
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'available_start_date' => 'required|date',
                    'available_end_date' => 'nullable|date|after_or_equal:available_start_date',
                    'ranges_day' => 'required|numeric|gt:0',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            case 3:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code,'.$promo->id,
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'order_start_date' => 'required|date',
                    'order_end_date' => 'nullable|date|after_or_equal:order_start_date',
                    'ranges_day' => 'required|numeric|gt:0',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            case 4:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code,'.$promo->id,
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'amount_buys' => 'required|numeric|gt:0',
                    'amount_tiket' => 'required|numeric|gt:0',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;
            default:
                $request->validate([
                    'code' => 'nullable|string|alpha_dash|unique:promos,code,'.$promo->id,
                    'name' => 'required|string',
                    'is_active' => 'required|in:0,1',
                    'cover_image' => 'nullable|image',
                    'discount_type' => 'required|in:0,1',
                    'discount_amount' => 'required|numeric|min:1',
                    'available_start_date' => 'required|date',
                    'available_end_date' => 'nullable|date|after_or_equal:available_start_date',
                    'order_start_date' => 'nullable|date',
                    'order_end_date' => 'nullable|date|after_or_equal:order_start_date',
                    'user_perday_limit' => 'nullable|numeric',
                    'order_perday_limit' => 'nullable|numeric',
                    'condition_type' => 'required|string',
                    'is_apply' => 'required|in:0,1',
                ]);
                break;

        }

        if ($request->discount_type == Promo::TYPE_PERCENT) {
            $request->validate([
                'discount_amount' => 'required|numeric|min:1|max:100',
            ]);
        }

        $code = Str::upper($request->code ?? Str::random(6));
        $amount_buys = $request->amount_buys;
        $amount_tiket = $request->amount_tiket;
        $ranges_day = $request->ranges_day;
        switch ($request->condition_type) {
            case '1':
                $ranges_day = null;
                $amount_tiket = null;
                break;
            case '2':
            case '3':
                $amount_buys = null;
                $amount_tiket = null;
                break;
            default:
        }
        $promo->fill([
            'code' => $code,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'cover_image' => $request->cover_image,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'available_start_date' => $request->available_start_date != '' ? Carbon::parse($request->available_start_date) : '',
            'available_end_date' => $request->available_end_date != '' ? Carbon::parse($request->available_end_date) : '',
            'order_start_date' => $request->order_start_date != '' ? Carbon::parse($request->order_start_date) : '',
            'order_end_date' => $request->order_end_date != '' ? Carbon::parse($request->order_end_date) : '',
            'user_perday_limit' => $request->user_perday_limit ?? 0,
            'order_perday_limit' => $request->order_perday_limit ?? 0,
            'condition_type' => $request->condition_type,
            'amount_buys' => $amount_buys,
            'amount_tiket' => $amount_tiket,
            'ranges_day' => $ranges_day,
            'is_apply' => $request->is_apply,
        ]);

        // TODO: handle for latter , cover_image and descrition body
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $file->store('uploads', 'public');
            $promo->cover_image = $file->hashName('uploads');
        }

        $promo->save();

        return redirect()->route('promo.index')
            ->with('message', ['type' => 'success', 'message' => 'Promo has beed updated']);
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        session()->flash('message', ['type' => 'success', 'message' => 'Promo has beed deleted']);
    }
}
