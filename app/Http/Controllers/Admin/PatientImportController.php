<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientImportController extends Controller
{
    public function create()
    {
        return view('admin.patients.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // Max 10MB
        ]);

        $file = $request->file('file');
        
        // Guardar archivo temporal en storage/app/imports
        $filePath = $file->store('imports');

        // Despachar el Job a la cola
        \App\Jobs\ImportPatientsJob::dispatch($filePath);

        // Mensaje flash SweetAlert si es que se usa
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Importación en proceso',
            'text' => 'El archivo se está procesando en segundo plano, te notificaremos cuando termine.',
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'La importación se está procesando.');
    }
}
