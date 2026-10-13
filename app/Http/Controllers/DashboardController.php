<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'studentCount'      => Student::count(),
            'roomCount'         => Room::count(),
            'roomTypeCount'     => RoomType::count(),
            'activeCount'       => Assignment::where('status', 'active')->count(),
            'totalPayments'     => Payment::sum('amount'),
            'recentAssignments' => Assignment::with(['student', 'room'])->latest()->take(5)->get(),
            'recentPayments'    => Payment::with('assignment.student')->latest()->take(5)->get(),
        ]);
    }
}