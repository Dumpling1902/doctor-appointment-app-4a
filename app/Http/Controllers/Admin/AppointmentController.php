<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index');
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function consultation(\App\Models\Appointment $appointment)
    {
        return view('admin.appointments.consultation', compact('appointment'));
    }

    public function edit($id)
    {
        // Just for reference if needed
    }
}
