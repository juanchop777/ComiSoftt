<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Minute;
use App\Models\GeneralCommittee;
use App\Models\IndividualCommittee;
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
            'individual_committees' => IndividualCommittee::count(),
            'general_committees' => GeneralCommittee::count(),
            'total_committees' => (GeneralCommittee::count() + IndividualCommittee::count()),
            'apprentices_with_contract' => Minute::where('has_contract', true)->count(),
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
            'individual_this_month' => IndividualCommittee::whereMonth('session_date', $currentMonth)
                                                          ->whereYear('session_date', $currentYear)
                                                          ->count(),
            'general_this_month' => GeneralCommittee::whereMonth('session_date', $currentMonth)
                                                    ->whereYear('session_date', $currentYear)
                                                    ->count(),
            'committees_this_month' => (
                GeneralCommittee::whereMonth('session_date', $currentMonth)->whereYear('session_date', $currentYear)->count()
                + IndividualCommittee::whereMonth('session_date', $currentMonth)->whereYear('session_date', $currentYear)->count()
            ),
        ];

        // Estadísticas por tipo de incidente
        $incidentTypes = Minute::selectRaw('incident_type, COUNT(*) as count')
                               ->whereNotNull('incident_type')
                               ->groupBy('incident_type')
                               ->get();

        // Estadísticas por clase de falta
        $offenseClasses = collect([])
            ->merge(
                GeneralCommittee::selectRaw('offense_class, COUNT(*) as count')
                    ->whereNotNull('offense_class')
                    ->groupBy('offense_class')->get()
            )
            ->merge(
                IndividualCommittee::selectRaw('offense_class, COUNT(*) as count')
                    ->whereNotNull('offense_class')
                    ->groupBy('offense_class')->get()
            );

        // Estadísticas por modalidad de asistencia
        $attendanceModes = collect([])
            ->merge(
                GeneralCommittee::selectRaw('attendance_mode, COUNT(*) as count')
                    ->whereNotNull('attendance_mode')
                    ->groupBy('attendance_mode')->get()
            )
            ->merge(
                IndividualCommittee::selectRaw('attendance_mode, COUNT(*) as count')
                    ->whereNotNull('attendance_mode')
                    ->groupBy('attendance_mode')->get()
            );

        // Actas recientes (últimas 5)
        $recentMinutes = Minute::orderBy('minutes_date', 'desc')
                               ->take(5)
                               ->get();

        // Comités recientes (últimos 5)
        $recentCommittees = collect([])
            ->merge(GeneralCommittee::orderBy('session_date', 'desc')->take(5)->get())
            ->merge(IndividualCommittee::orderBy('session_date', 'desc')->take(5)->get())
            ->sortByDesc('session_date')
            ->take(5);

        // Actividad reciente formateada
        $recentActivity = collect([]);
        
        // Agregar comités individuales recientes
        $recentIndividualCommittees = IndividualCommittee::orderBy('session_date', 'desc')->take(3)->get();
        foreach ($recentIndividualCommittees as $committee) {
            $recentActivity->push([
                'type' => 'individual',
                'description' => "Comité individual para {$committee->trainee_name}",
                'act_number' => $committee->act_number,
                'time_ago' => $committee->session_date ? Carbon::parse($committee->session_date)->diffForHumans() : 'Fecha no disponible',
                'session_date' => $committee->session_date
            ]);
        }
        
        // Agregar comités generales recientes
        $recentGeneralCommittees = GeneralCommittee::orderBy('session_date', 'desc')->take(3)->get();
        foreach ($recentGeneralCommittees as $committee) {
            $recentActivity->push([
                'type' => 'general',
                'description' => "Comité general para acta #{$committee->act_number}",
                'act_number' => $committee->act_number,
                'time_ago' => $committee->session_date ? Carbon::parse($committee->session_date)->diffForHumans() : 'Fecha no disponible',
                'session_date' => $committee->session_date
            ]);
        }
        
        // Ordenar por fecha y tomar los últimos 5
        $recentActivity = $recentActivity->sortByDesc('session_date')->take(5);

        // Gráfico de tendencias (últimos 6 meses)
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trends[] = [
                'month' => $date->format('M Y'),
                'minutes' => Minute::whereMonth('minutes_date', $date->month)
                                   ->whereYear('minutes_date', $date->year)
                                   ->count(),
                'committees' => (
                    GeneralCommittee::whereMonth('session_date', $date->month)->whereYear('session_date', $date->year)->count()
                    + IndividualCommittee::whereMonth('session_date', $date->month)->whereYear('session_date', $date->year)->count()
                ),
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
            'recentActivity',
            'trends'
        ));
    }
}
