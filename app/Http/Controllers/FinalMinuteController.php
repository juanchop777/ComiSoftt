<?php

namespace App\Http\Controllers;

use App\Models\FinalMinute;
use Illuminate\Http\Request;

class FinalMinuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $finalMinutes = FinalMinute::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.final-minutes.index', compact('finalMinutes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.final-minutes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'act_number' => 'required|string|max:10',
            'committee_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'place_link' => 'nullable|string|max:255',
            'address_regional_center' => 'nullable|string|max:255',
            'conclusions' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
        ]);

        FinalMinute::create($request->all());

        return redirect()->route('final-minutes.index')
            ->with('success', 'Acta final creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinalMinute $finalMinute)
    {
        return view('admin.final-minutes.show', compact('finalMinute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinalMinute $finalMinute)
    {
        return view('admin.final-minutes.edit', compact('finalMinute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinalMinute $finalMinute)
    {
        $request->validate([
            'act_number' => 'required|string|max:10',
            'committee_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'place_link' => 'nullable|string|max:255',
            'address_regional_center' => 'nullable|string|max:255',
            'conclusions' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
        ]);

        $finalMinute->update($request->all());

        return redirect()->route('final-minutes.index')
            ->with('success', 'Acta final actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinalMinute $finalMinute)
    {
        $finalMinute->delete();

        return redirect()->route('final-minutes.index')
            ->with('success', 'Acta final eliminada exitosamente.');
    }
}
