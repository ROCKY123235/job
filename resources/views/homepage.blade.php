@extends('layouts.app')

@section('title', 'Home Page')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@section('content')

    <div class="container">
        <h1>Welcome to the Home Page</h1>

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
                            <!-- Edit Button -->
                            <a href="{{ route('users.edits', $update->id) }}" class="edit-btn">Edit</a>

                            <!-- Delete Button -->
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
                        <img src="{{ asset('images/' . $mediaItem->filename) }}" alt="Image" class="media-item">
                    @elseif ($mediaItem->type === 'video')
                        <video controls class="media-item">
                            <source src="{{ asset('videos/' . $mediaItem->filename) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>

    </div>
    @endsection
