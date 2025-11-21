<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class PublicDashboardController extends Controller
{
    public function index()
    {
        // KPI Cards
        $totalIncidents = Incident::count();
        $openActions = Action::where('status', 'open')->count();
        $closedActions = Action::where('status', 'closed')->count();
        $safetyObservations = 0; // Placeholder for Leading Indicator

        // Safety Tip
        $safetyTips = [
            "Selalu gunakan alat pelindung diri (APD) yang sesuai untuk pekerjaan Anda.",
            "Pastikan area kerja Anda bersih dan terorganisir untuk mencegah kecelakaan.",
            "Laporkan setiap kondisi tidak aman atau nyaris celaka kepada atasan Anda.",
            "Ikuti semua prosedur keselamatan dan operasional standar (SOP).",
            "Lakukan pemeliharaan rutin pada peralatan untuk memastikan fungsinya optimal.",
            "Berhati-hatilah saat mengangkat benda berat, gunakan teknik yang benar.",
            "Jangan pernah mengambil jalan pintas dalam prosedur keselamatan.",
            "Pahami rute evakuasi darurat dan lokasi titik kumpul.",
            "Jaga komunikasi yang baik dengan rekan kerja untuk koordinasi keselamatan.",
            "Periksa label bahan kimia sebelum menggunakannya dan pahami penanganannya.",
        ];
        $randomSafetyTip = Arr::random($safetyTips);

        // Data for Incidents per Month Chart (Last 12 Months)
        $incidentsByMonth = Incident::select(
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                return [$date->format('M Y') => $item->count];
            });

        // Fill in missing months with 0
        $incidentLabels = [];
        $incidentData = [];
        $currentMonth = Carbon::now()->subYear()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $monthKey = $currentMonth->format('M Y');
            $incidentLabels[] = $monthKey;
            $incidentData[] = $incidentsByMonth[$monthKey] ?? 0;
            $currentMonth->addMonth();
        }

        // Data for Actions by Status Chart
        $actionsByStatus = Action::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $actionStatusLabels = $actionsByStatus->keys();
        $actionStatusData = $actionsByStatus->values();

        return view('welcome', compact(
            'totalIncidents',
            'openActions',
            'closedActions',
            'safetyObservations',
            'randomSafetyTip',
            'incidentLabels',
            'incidentData',
            'actionStatusLabels',
            'actionStatusData'
        ));
    }
}