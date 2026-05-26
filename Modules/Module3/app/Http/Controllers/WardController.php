<?php

namespace Modules\Module3\app\Http\Controllers;

use App\Models\Ward;
use Modules\Module3\app\Models\Bed;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::with('beds')->get();
        return view('module3::wards.index', compact('wards'));
    }

    public function create()
    {
        return view('module3::wards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wardName' => 'required|string|max:255',
            'wardNumber' => 'required|string|unique:wards',
            'capacity' => 'required|integer|min:1',
        ]);

        Ward::create($validated);

        return redirect()->route('my-wards.index')->with('success', 'Ward created successfully.');
    }

    public function edit($id)
    {
        $ward = Ward::findOrFail($id);
        return view('module3::wards.edit', compact('ward'));
    }

    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);

        $validated = $request->validate([
            'wardName' => 'required|string|max:255',
            'wardNumber' => 'required|string|unique:wards,wardNumber,' . $ward->id,
            'capacity' => 'required|integer|min:1',
        ]);

        $ward->update($validated);

        return redirect()->route('my-wards.index')->with('success', 'Ward updated successfully.');
    }

    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();

        return redirect()->route('my-wards.index')->with('success', 'Ward deleted successfully.');
    }
}