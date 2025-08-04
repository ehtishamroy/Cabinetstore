@extends('admin.layout')

@section('title', 'Create Door Color - BH Cabinetry Admin Panel')

@section('styles')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable {
        min-height: 200px;
    }
    .gallery-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }
    .gallery-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }
    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background-color: #f9fafb;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .file-upload-area:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .file-upload-area.dragover {
        border-color: #3b82f6;
        background-color: #dbeafe;
    }
    .file-upload-area input[type="file"] {
        display: none;
    }
    .upload-icon {
        font-size: 2rem;
        color: #6b7280;
        margin-bottom: 10px;
    }
    .selected-files {
        margin-top: 10px;
        padding: 10px;
        background-color: #f3f4f6;
        border-radius: 6px;
    }
    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .file-item:last-child {
        border-bottom: none;
    }
    .file-name {
        font-size: 0.875rem;
        color: #374151;
    }
    .file-size {
        font-size: 0.75rem;
        color: #6b7280;
    }
</style>
@endsection

@section('content')
<div class="p-6 sm:p-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Door Color</h1>
        <p class="text-gray-600 mt-1">Add a new door color to the system.</p>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.door-colors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Door Color Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="e.g., Pure White, Cyber Grey, Navy Blue"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                              placeholder="Enter detailed description of this door color..."
                              rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Door Color Image (Thumbnail)</label>
                    <input type="file" name="image" id="image" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Upload a thumbnail image for this door color (optional). Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="main_image" class="block text-sm font-medium text-gray-700">Main Product Image</label>
                    <input type="file" name="main_image" id="main_image" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Upload the main product image for detailed view (optional). Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>
                    @error('main_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                    <div class="file-upload-area" id="gallery-upload-area">
                        <input type="file" name="gallery_images[]" id="gallery_images" 
                               accept="image/*" multiple>
                        <div class="upload-icon">📁</div>
                        <p class="text-sm font-medium text-gray-700">Click to select multiple images or drag & drop here</p>
                        <p class="text-xs text-gray-500 mt-1">You can select multiple images at once by holding Ctrl (or Cmd on Mac) while clicking</p>
                        <p class="text-xs text-gray-500">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB per image.</p>
                    </div>
                    <div id="selected-files" class="selected-files" style="display: none;"></div>
                    <div id="gallery-preview" class="gallery-preview"></div>
                    @error('gallery_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.door-colors.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Door Color
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize CKEditor for description
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
            placeholder: 'Enter detailed description of this door color...'
        })
        .catch(error => {
            console.error(error);
        });

    // Gallery image upload area functionality
    const uploadArea = document.getElementById('gallery-upload-area');
    const fileInput = document.getElementById('gallery_images');
    const selectedFiles = document.getElementById('selected-files');
    const galleryPreview = document.getElementById('gallery-preview');

    // Click to select files
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelection(files);
        }
    });

    // File input change handler
    fileInput.addEventListener('change', (e) => {
        handleFileSelection(e.target.files);
    });

    function handleFileSelection(files) {
        selectedFiles.innerHTML = '';
        galleryPreview.innerHTML = '';
        
        if (files.length > 0) {
            selectedFiles.style.display = 'block';
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                if (file.type.startsWith('image/')) {
                    // Add file info
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <div>
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${formatFileSize(file.size)}</div>
                        </div>
                    `;
                    selectedFiles.appendChild(fileItem);
                    
                    // Add preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.title = file.name;
                        galleryPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        } else {
            selectedFiles.style.display = 'none';
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@endsection 