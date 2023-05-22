<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FastboatTrack;
use App\Services\EkajayaService;
use Illuminate\Http\Request;

class EkajayaController extends Controller
{
    public function tracks(Request $request)
    {
        // this fetch all tracks from api
        EkajayaService::tracks();

        // get the api has been fetch
        $query = FastboatTrack::with(['source', 'destination'])
            ->where('data_source', EkajayaService::class);

        if ($request->q != '') {
            $query->where(function ($query) use ($request) {
                $query->whereHas('source', function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->q%");
                })
                    ->orWhereHas('destination', function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->q%");
                    })
                    ->orWhereHas('group.fastboat', function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->q%");
                    });
            });
        }

        return $query->get();
    }
}
