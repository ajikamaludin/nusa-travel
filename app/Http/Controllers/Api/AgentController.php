<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FastboatDropoff;
use App\Models\FastboatTrack;
use App\Models\FastTrackGroupAgents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Nette\Utils\DateTime;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query()->where('is_agent', '1')->where('is_active', '1');
        if ($request->has('q')) {
            $query->where('name', 'like', "%{$request->q}%");
        }
        return $query->get();
    }

    public function listPriceAgent(Request $request)
    {
        if (Auth::guard('authtoken')->check()) {
            $customerId=Auth::guard('authtoken')->user()->id;
            $query = FastTrackGroupAgents::query()->with('trackGroup.fastboat', 'customer')
                ->join('fastboat_track_agents', 'fastboat_track_agents.fast_track_group_agents_id', '=', 'fast_track_group_agents.id')
                ->select('fast_track_group_agents.*', DB::raw('sum(fastboat_track_agents.price) as price'))
                ->whereHas('customer',function($query)use($customerId){
                    $query->where('customers.id','=',$customerId);
                })
                ->groupBy('fast_track_group_agents.id');
        }
        
        return $query->get();
    }

    public function gettracks(Request $request){
        $queryDeparture = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
        ->whereHas('source', function ($query) use($request) {
            $query->where('name', '=', $request->from);
        })
        ->whereHas('destination', function ($query) use ($request){
            $query->where('name', '=', $request->to);
        });

        $rdate = new DateTime($request->date);
        if ($rdate==now()) {
            $queryDeparture->whereTime('arrival_time', '>=', now());
        }
        

        if (Auth::guard('authtoken')->check()){
            $customerId=Auth::guard('authtoken')->user()->id;
            $queryDeparture->Leftjoin('fastboat_track_agents','fastboat_track_id','=','fastboat_tracks.id')
            ->select('fastboat_tracks.id as id','fastboat_tracks.fastboat_track_group_id','fastboat_source_id','fastboat_destination_id','arrival_time','departure_time',DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'),'is_publish','fastboat_tracks.created_at','fastboat_tracks.updated_at','fastboat_tracks.created_by')
            ->where('customer_id','=',$customerId)
            ;
        }
        
        return $queryDeparture->get();
    }
    public function orderAgent(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'nation' => 'required|string',
            'national_id' => 'required|numeric',
            'email' => 'required|email',
            'person' => 'required|array',
            'person.*.name' => 'required|string|max:255|min:3',
            'person.*.nation' => 'required|string',
            'person.*.national_id' => 'required|numeric',
            'cart'=>'required|array',
            
        
        ]);

    }
    public function drop_off(Request $request){
        $query = FastboatDropoff::query();

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }
        $offsite=0;
        $limit=10;
        return $query->limit($limit)->offset($offsite)->get();
    }
}