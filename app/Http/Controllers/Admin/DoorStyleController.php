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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/door-styles'), $imageName);
            $data['image'] = 'uploads/door-styles/' . $imageName;
        }

        DoorStyle::create($data);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doorStyle->image && file_exists(public_path($doorStyle->image))) {
                unlink(public_path($doorStyle->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/door-styles'), $imageName);
            $data['image'] = 'uploads/door-styles/' . $imageName;
        }

        $doorStyle->update($data);

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
