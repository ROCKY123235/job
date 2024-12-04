@extends('layouts.app')

@section('title', 'Profile Page')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@section('content')



<div class="profile-page-container">
    <div class="container">
        <a href="{{ url('edit') }}" class="btn btn-primary">Edit Profile</a>

        <div class="profile-header">
            <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" class="profile-picture">
            <h1>{{ $user->name }}</h1>
        </div>

         <p class="time-info">Last updated: {{ $user->updated_at->diffForHumans() }}</p>

        <p class="description">{{ $user->description }}</p>

        @if($user->resume)
           <h5 class="resume-link">Click  <a href="{{ asset($user->resume) }}" class="resume-link" download>Here</a></h5>
        @endif
    </div>

    <div class="create-post">
        <h3>Create a Post</h3>
        <form action="{{ url('poststore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea name="description" rows="3" placeholder="Write something..." required></textarea>

            <div class="upload-icons">
                <label for="images">📷
                    <input type="file" name="images[]" id="images" multiple>
                </label>
                <label for="video">🎥
                    <input type="file" name="video" id="video">
                </label>
            </div>

            <button type="submit" class="post-btn">Post</button>
        </form>
    </div>

    <div class="posts">
        @foreach ($updates as $update)
            <div class="post">
                <div class="profile-head">
                    <div class="user-info">
                        <img src="{{ asset($update->user->profile_picture) }}" alt="Profile Picture" class="profile-picture-post">
                        <h1>{{ $update->user->name }}</h1>
                    </div>
                    <div class="edit-cnt">
                    @auth
                    @if (auth()->id() === $update->user_id)
                        <div class="kebab-menu-container">
                            <div class="kebab-menu-options">
                           <a href="{{ route('users.edits', $update->id) }}" class="edit-btn">Edit</a>
                                <form action="{{ url('post', $update->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    @endauth
                </div>
                </div>
                <p>{{ $update->description }}</p>
                <div class="media-container">
                    @foreach ($update->media as $mediaItem)
                        @if ($mediaItem->type === 'image')
                            <img src="{{ asset('images/' . $mediaItem->filename) }}" alt="Image">
                        @elseif ($mediaItem->type === 'video')
                            <video controls>
                                <source src="{{ asset('videos/' . $mediaItem->filename) }}" type="video/mp4">
                            </video>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
