@extends('layouts.app')

@section('content')
<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    background: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
    color: #555;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease-in-out;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #007bff;
}

img,
video {
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
}

input[type="checkbox"] {
    margin-left: 5px;
}

.btn {
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.btn-success {
    background-color: #28a745;
    color: #fff;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
}

@media (max-width: 768px) {
    .form-group label,
    .btn {
        font-size: 13px;
    }

    img,
    video {
        width: 100px;
    }
}
</style>
<div class="container">
    <h2>Edit Post</h2>

    <form action="{{ route('users.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $post->description) }}</textarea>
        </div>


        <div class="form-group">
            <label>Existing Images</label>
            <div>
                @foreach ($post->media->where('type', 'image') as $image)
                    <img src="{{ asset('images/' . $image->filename) }}" alt="Image" style="width: 150px; height: auto; margin-right: 10px;">
                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> Delete
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>Existing Videos</label>
            <div>
                @foreach ($post->media->where('type', 'video') as $video)
                    <video controls style="width: 150px; height: auto; margin-right: 10px;">
                        <source src="{{ asset('videos/' . $video->filename) }}" type="video/mp4">
                    </video>
                    <input type="checkbox" name="delete_videos[]" value="{{ $video->id }}"> Delete
                @endforeach
            </div>
        </div>


        <div class="form-group">
            <label for="images">Add New Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        <div class="form-group">
            <label for="video">Add New Video</label>
            <input type="file" name="video" id="video" class="form-control">
        </div>


        <button type="submit" class="btn btn-success">Update Post</button>
        <a href="{{ route('profilepage') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
