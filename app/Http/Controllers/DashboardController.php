<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Minute;
use App\Models\Committee;
use App\Models\ReportingPerson;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_minutes' => Minute::count(),
            'total_committees' => Committee::count(),
            'total_reporting_persons' => ReportingPerson::count(),
            'total_users' => User::count(),
        ];

        // Estadísticas de este mes
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $monthlyStats = [
            'minutes_this_month' => Minute::whereMonth('minutes_date', $currentMonth)
                                          ->whereYear('minutes_date', $currentYear)
                                          ->count(),
            'committees_this_month' => Committee::whereMonth('session_date', $currentMonth)
                                               ->whereYear('session_date', $currentYear)
                                               ->count(),
        ];

        // Estadísticas por tipo de incidente
        $incidentTypes = Minute::selectRaw('incident_type, COUNT(*) as count')
                               ->whereNotNull('incident_type')
                               ->groupBy('incident_type')
                               ->get();

        // Estadísticas por clase de falta
        $offenseClasses = Committee::selectRaw('offense_class, COUNT(*) as count')
                                  ->whereNotNull('offense_class')
                                  ->groupBy('offense_class')
                                  ->get();

        // Estadísticas por modalidad de asistencia
        $attendanceModes = Committee::selectRaw('attendance_mode, COUNT(*) as count')
                                   ->whereNotNull('attendance_mode')
                                   ->groupBy('attendance_mode')
                                   ->get();

        // Actas recientes (últimas 5)
        $recentMinutes = Minute::orderBy('minutes_date', 'desc')
                               ->take(5)
                               ->get();

        // Comités recientes (últimos 5)
        $recentCommittees = Committee::orderBy('session_date', 'desc')
                                    ->take(5)
                                    ->get();

        // Gráfico de tendencias (últimos 6 meses)
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trends[] = [
                'month' => $date->format('M Y'),
                'minutes' => Minute::whereMonth('minutes_date', $date->month)
                                   ->whereYear('minutes_date', $date->year)
                                   ->count(),
                'committees' => Committee::whereMonth('session_date', $date->month)
                                        ->whereYear('session_date', $date->year)
                                        ->count(),
            ];
        }

        return view('dashboard', compact(
            'stats',
            'monthlyStats',
            'incidentTypes',
            'offenseClasses',
            'attendanceModes',
            'recentMinutes',
            'recentCommittees',
            'trends'
        ));
    }
}
