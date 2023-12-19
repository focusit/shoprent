<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgreementController extends Controller
{
    public function index()
    {
        $agreements = Agreement::all();
        return view('agreements.index', compact('agreements'));
    }

    public function create()
    {
        return view('agreements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Add your validation rules here
        ]);

        $agreement = new Agreement([
            // Assign request data to agreement properties
        ]);

        // Handle file upload
        $documentPath = $request->file('document_field')->store('public/documents');
        $agreement->document_field = $documentPath;

        $agreement->save();

        return redirect()->route('agreements.index')->with('success', 'Agreement has been created successfully');
    }

    public function show($agreement_id)
    {
        $agreement = Agreement::findOrFail($agreement_id);
        return view('agreements.show', compact('agreement'));
    }

    public function edit($agreement_id)
    {
        $agreement = Agreement::findOrFail($agreement_id);
        return view('property-allocation.allocate_shop', compact('agreement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([]);

        $agreement = Agreement::findOrFail($id);

        $agreement->update([]);
        if ($request->hasFile('document_field')) {
            $documentPath = $request->file('document_field')->store('public/documents');
            $agreement->document_field = $documentPath;
            $agreement->save();
        }

        return redirect()->route('agreements.index')->with('success', 'Agreement has been updated successfully');
    }

    public function destroy($agreement_id)
    {
        $agreement = Agreement::findOrFail($agreement_id);
        $agreement->delete();

        return redirect()->route('agreements.index')->with('success', 'Agreement has been deleted successfully');
    }

    public function handleDocument($request, $agreement)
    {
        if ($request->hasFile('document_field')) {
            $oldFilePath = public_path('documents/' . $agreement->document_field);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $fileName = time() . '.' . $request->document_field->extension();
            $request->document_field->move(public_path('documents'), $fileName);
            $agreement->document_field = $fileName;
        }
    }
}
