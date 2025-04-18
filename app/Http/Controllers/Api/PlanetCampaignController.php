<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanetCampaign;
use Illuminate\Http\Request;

class PlanetCampaignController extends Controller
{
    public function active(Request $request) {

        $campaigns = PlanetCampaign::where('ended_at', null)->get();

        return response()->json($campaigns, 200);

    }

    public function index(Request $request) {

        $request->validate([
            'id' => ['integer', 'nullable']
        ]);

        $campaignQuery = PlanetCampaign::query();

        if ($request->has('id')) {
            $id = $request->input('id');
            $campaignQuery->where('id', $id);
        }

        $campaigns = $campaignQuery->limit(100)->get();

        return response()->json($campaigns, 200);

    }
}
