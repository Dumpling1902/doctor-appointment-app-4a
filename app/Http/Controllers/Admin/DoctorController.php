<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Speciality;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index');
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'speciality_id' => 'nullable|exists:specialities,id',
            'medical_license_number' => 'nullable|string|max:20',
            'biography' => 'nullable|string|max:500',
        ]);

        $doctor = Doctor::create($data);

        return redirect()->route('admin.doctors.edit', $doctor)
            ->with('success', 'Doctor creado correctamente.');
    }

    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $specialities = Speciality::orderBy('name')->get();
        return view('admin.doctors.edit', compact('doctor', 'specialities'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'speciality_id' => 'nullable|exists:specialities,id',
            'medical_license_number' => 'required|string|max:20',
            'biography' => 'nullable|string|max:500',
        ]);

        $doctor->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Doctor actualizado',
            'text' => 'Los datos del doctor se guardaron correctamente'
        ]);

        return redirect()->route('admin.doctors.index');
    }

    public function destroy(Doctor $doctor)
    {
        //
    }
}