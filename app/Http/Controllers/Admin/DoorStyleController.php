<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoorStyle;
use Illuminate\Http\Request;

class DoorStyleController extends Controller
{
    /**
     * Display a listing of door styles
     */
    public function index()
    {
        $doorStyles = DoorStyle::orderBy('name')->paginate(10);
        return view('admin.door-styles.index', compact('doorStyles'));
    }

    /**
     * Show the form for creating a new door style
     */
    public function create()
    {
        return view('admin.door-styles.create');
    }

    /**
     * Store a newly created door style
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:door_styles',
        ]);

        DoorStyle::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.door-styles.index')
            ->with('success', 'Door style created successfully.');
    }

    /**
     * Display the specified door style
     */
    public function show(DoorStyle $doorStyle)
    {
        return view('admin.door-styles.show', compact('doorStyle'));
    }

    /**
     * Show the form for editing the specified door style
     */
    public function edit(DoorStyle $doorStyle)
    {
        return view('admin.door-styles.edit', compact('doorStyle'));
    }

    /**
     * Update the specified door style
     */
    public function update(Request $request, DoorStyle $doorStyle)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:door_styles,name,' . $doorStyle->id,
        ]);

        $doorStyle->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.door-styles.index')
            ->with('success', 'Door style updated successfully.');
    }

    /**
     * Remove the specified door style
     */
    public function destroy(DoorStyle $doorStyle)
    {
        // Check if door style is being used in product lines
        if ($doorStyle->productLines()->count() > 0) {
            return redirect()->route('admin.door-styles.index')
                ->with('error', 'Cannot delete door style. It is being used in product lines.');
        }

        $doorStyle->delete();

        return redirect()->route('admin.door-styles.index')
            ->with('success', 'Door style deleted successfully.');
    }
}
