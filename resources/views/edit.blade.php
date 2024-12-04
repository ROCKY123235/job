<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Registration</title>
    <link rel="stylesheet" href="{{asset("css/edit.css")}}">
</head>
<body>
     <div class="form-container">
        <h3>Edit Profile</h3>
        <form action="{{ url('/edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <div class="current-picture">
                    @if($user->profile_picture)
                        <img src="{{ asset($user->profile_picture) }}" alt="Current Profile Picture">
                    @else
                        <p>No profile picture uploaded.</p>
                    @endif
                </div>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            </div>
            <div class="form-group">
                <label for="resume">Resume</label>
                <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" style="width: 100%; padding: 10px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    {{ $user->description }}
                </textarea>
            </div>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
