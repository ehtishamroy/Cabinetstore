<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoorColor;
use Illuminate\Http\Request;

class DoorColorController extends Controller
{
    /**
     * Display a listing of door colors
     */
    public function index()
    {
        $doorColors = DoorColor::orderBy('name')->paginate(10);
        return view('admin.door-colors.index', compact('doorColors'));
    }

    /**
     * Show the form for creating a new door color
     */
    public function create()
    {
        return view('admin.door-colors.create');
    }

    /**
     * Store a newly created door color
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:door_colors',
        ]);

        DoorColor::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.door-colors.index')
            ->with('success', 'Door color created successfully.');
    }

    /**
     * Display the specified door color
     */
    public function show(DoorColor $doorColor)
    {
        return view('admin.door-colors.show', compact('doorColor'));
    }

    /**
     * Show the form for editing the specified door color
     */
    public function edit(DoorColor $doorColor)
    {
        return view('admin.door-colors.edit', compact('doorColor'));
    }

    /**
     * Update the specified door color
     */
    public function update(Request $request, DoorColor $doorColor)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:door_colors,name,' . $doorColor->id,
        ]);

        $doorColor->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.door-colors.index')
            ->with('success', 'Door color updated successfully.');
    }

    /**
     * Remove the specified door color
     */
    public function destroy(DoorColor $doorColor)
    {
        // Check if door color is being used in product lines
        if ($doorColor->productLines()->count() > 0) {
            return redirect()->route('admin.door-colors.index')
                ->with('error', 'Cannot delete door color. It is being used in product lines.');
        }

        $doorColor->delete();

        return redirect()->route('admin.door-colors.index')
            ->with('success', 'Door color deleted successfully.');
    }
}
