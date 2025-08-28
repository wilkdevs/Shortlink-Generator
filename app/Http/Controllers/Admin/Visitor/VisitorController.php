<?php

namespace App\Http\Controllers\Admin\Visitor;

use App\Http\Controllers\Controller;
use App\Models\VisitorModel;
use App\Models\LinkModel;
use App\Models\SettingModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitorController extends Controller
{

    /**
     * Display a list of visitors for a specific link, with optional country and time filters.
     *
     * @param  string  $short
     * @return \Illuminate\Http\Response
     */
    public function index($short)
    {
        $detail = LinkModel::where('short_url', $short)->firstOrFail();

        $title = "Daftar Pengunjung untuk Link: " . $detail->title;

        // Get selected filters from the request
        $selectedCountry = request()->query('country');
        $selectedTimeFilter = request()->query('time_filter');
        $startDate = null;

        // Determine the start date based on the time filter
        if ($selectedTimeFilter) {
            switch ($selectedTimeFilter) {
                case '24h':
                    $startDate = Carbon::now()->subDay();
                    break;
                case '7d':
                    $startDate = Carbon::now()->subWeek();
                    break;
                case '1m':
                    $startDate = Carbon::now()->subMonth();
                    break;
                case '1y':
                    $startDate = Carbon::now()->subYear();
                    break;
            }
        }

        // Prepare the base query for all counts and the list
        $baseQuery = VisitorModel::where('link_id', $detail->id)
            ->whereNull('deleted_at');

        // Apply country filter to the base query
        if ($selectedCountry) {
            $baseQuery->where('country', $selectedCountry);
        }

        // Apply time filter to the base query
        if ($startDate) {
            $baseQuery->where('created_at', '>=', $startDate);
        }

        // Clone the base query to get the total click count
        $clickCount = $baseQuery->count();

        // Clone the base query to get the unique visitor count
        $visitorCount = $baseQuery->distinct('ip')->count('ip');

        // Prepare the query for the main visitor list, grouping by IP
        $visitorListquery = clone $baseQuery;
        $visitorListquery = $visitorListquery->groupBy('ip')
            ->select('ip', DB::raw('MAX(country) as country'), DB::raw('COUNT(ip) as visitor_count'))
            ->orderBy('visitor_count', 'DESC');

        // Fetch daily visitor data for the chart
        $dailyVisitors = clone $baseQuery;
        $dailyVisitors = $dailyVisitors
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Fetch the list of countries for the dropdown filter
        $visitorCountries = $detail->visitors()
            ->select('country', DB::raw('count(*) as total_visitors'))
            ->groupBy('country')
            ->orderBy('total_visitors', 'DESC')
            ->get();

        // Fetch settings data
        $setting_list = SettingModel::where('active', 1)->get();
        $setting = [];
        foreach ($setting_list as $item) {
            $setting[$item->key] = $item->value;
        }

        return view('/pages/admin/visitor/index', [
            'setting' => $setting,
            'title' => $title,
            'detail' => $detail,
            'visitorCount' => $visitorCount,
            'clickCount' => $clickCount,
            'countries' => $visitorCountries,
            'selectedCountry' => $selectedCountry,
            'list' => $visitorListquery->paginate(20)->withQueryString(),
            'dailyVisitors' => $dailyVisitors, // Pass the new data to the view
        ]);
    }

    public function loading(string $short_url)
    {
        // ---- BOT DETECTION ----
        $userAgent = request()->userAgent() ?? '';
        $blockedAgents = ['curl', 'wget', 'python', 'http', 'bot', 'checker', 'spider'];

        foreach ($blockedAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {
                return response('Forbidden', 403);
            }
        }

        if (!request()->header('Accept') || !request()->header('Accept-Language')) {
            return response('Forbidden', 403);
        }

        return view('pages.user.loading', ['short_url' => $short_url]);
    }

    /**
     * Redirects a short URL to its long URL and tracks the visit.
     *
     * @param string $short_url The unique short URL identifier.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function open(Request $request)
    {
        $data = $request->all();

        // Find the link
        $link = LinkModel::where('short_url', $data["short_url"])->first();

        if (!$link || $link->status == 0) {
            return abort(404);
        }

        // ---- BOT DETECTION ----
        $userAgent = request()->userAgent() ?? '';
        $blockedAgents = ['curl', 'wget', 'python', 'http', 'bot', 'checker', 'spider'];

        foreach ($blockedAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {
                return response('Forbidden', 403);
            }
        }

        if (!request()->header('Accept') || !request()->header('Accept-Language')) {
            return response('Forbidden', 403);
        }

        // ---- IP FETCHING ----
        $ip = $data['ip'] ?? 'Unknown';
        $country = 'Unknown';
        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode");

            if ($response->successful() && $response->json('status') === 'success') {
                $country = $response->json('country') ?? 'Unknown';
            }

            VisitorModel::create([
                'id'       => Uuid::uuid4()->toString(),
                'link_id'  => $link->id,
                'ip'       => $ip,
                'country'  => $country,
                'payload'  => json_encode([
                    'user_agent' => $userAgent,
                    'referer'    => request()->headers->get('referer'),
                ]),
            ]);

            return response()->json([
                'url' => $link->long_url,
                'status' => true
            ], 200);

        } catch (\Exception $e) {
            \Log::warning("IP lookup failed for {$ip}: " . $e->getMessage());
            VisitorModel::create([
                'id'       => Uuid::uuid4()->toString(),
                'link_id'  => $link->id,
                'ip'       => $ip,
                'country'  => $country,
                'payload'  => json_encode([
                    'user_agent' => $userAgent,
                    'referer'    => request()->headers->get('referer'),
                ]),
            ]);

            return response()->json([
                'url' => $link->long_url,
                'status' => false
            ], 200);
        }
    }
}
