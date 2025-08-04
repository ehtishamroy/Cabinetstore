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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Handle main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/door-colors'), $imageName);
            $data['image'] = 'uploads/door-colors/' . $imageName;
        }

        // Handle main_image
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_main_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('uploads/door-colors'), $mainImageName);
            $data['main_image'] = 'uploads/door-colors/' . $mainImageName;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImageName = time() . '_gallery_' . uniqid() . '_' . $galleryImage->getClientOriginalName();
                $galleryImage->move(public_path('uploads/door-colors'), $galleryImageName);
                $galleryImages[] = 'uploads/door-colors/' . $galleryImageName;
            }
            $data['gallery_images'] = $galleryImages;
        }

        DoorColor::create($data);

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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Handle main image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($doorColor->image && file_exists(public_path($doorColor->image))) {
                unlink(public_path($doorColor->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/door-colors'), $imageName);
            $data['image'] = 'uploads/door-colors/' . $imageName;
        }

        // Handle main_image
        if ($request->hasFile('main_image')) {
            // Delete old main image if exists
            if ($doorColor->main_image && file_exists(public_path($doorColor->main_image))) {
                unlink(public_path($doorColor->main_image));
            }
            
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_main_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('uploads/door-colors'), $mainImageName);
            $data['main_image'] = 'uploads/door-colors/' . $mainImageName;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images if exist
            if ($doorColor->gallery_images) {
                foreach ($doorColor->gallery_images as $oldGalleryImage) {
                    if (file_exists(public_path($oldGalleryImage))) {
                        unlink(public_path($oldGalleryImage));
                    }
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImageName = time() . '_gallery_' . uniqid() . '_' . $galleryImage->getClientOriginalName();
                $galleryImage->move(public_path('uploads/door-colors'), $galleryImageName);
                $galleryImages[] = 'uploads/door-colors/' . $galleryImageName;
            }
            $data['gallery_images'] = $galleryImages;
        }

        $doorColor->update($data);

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
