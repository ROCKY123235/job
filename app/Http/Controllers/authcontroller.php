<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\update;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup()
    {
        return view('register');
    }

    public function signupsave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login')->with('message', 'Registration successful! Please log in.');
    }

    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/homepage')->with('message', 'Logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logged out successfully!');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $name = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('profile_pictures'), $name);
            $user->profile_picture = 'profile_pictures/' . $name;
        }

        if ($request->hasFile('resume')) {
            $resumeName = time() . '.' . $request->resume->extension();
            $request->resume->move(public_path('resumes'), $resumeName);
            $user->resume = 'resumes/' . $resumeName;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->description = $request->description;
        $user->save();

        return redirect()->route('profilepage')->with('success', 'Profile updated successfully!');
    }

    public function profile()
    {
        $user = Auth::user();
        $updates = Update::with('media')->where('user_id', $user->id)->latest()->get();
        return view('profilepage', compact('user', 'updates'));
    }

    public function up(Request $request)
    {

        $request->validate([

            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:10240',
            'description' => 'nullable|string|max:1000',

        ]);


        $update=new update();
        $update->description=$request->description;
        $update->user_id=auth()->id();
        $update->save();


        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $name);
                $imagePaths[] = $name;

                media::create([
                    "updateID"=>$update->id,
                    "type"=>'image',
                    "filename"=>$name,
                ]);
            }
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $name = time() . '_' . $video->getClientOriginalName();
            $videoPath = $video->move(public_path('videos'), $name);;
            media::create([
                "updateID"=>$update->id,
                "type"=>'video',
                "filename"=>$name,
            ]);
        }

        return redirect()->back()->with('success', 'Post created successfully!');
    }
    public function homepage()
{

    $updates = Update::with('media', 'user')->latest()->get();
    return view('homepage', compact('updates'));
}
public function edits($id)
{
    $post = Update::findOrFail($id);

    if (auth()->id() !== $post->user_id) {
        abort(403);
    }

    return view('edits', compact('post'));
}

public function updatepost(Request $request, $id)
{
    $post = Update::findOrFail($id);

    if (auth()->id() !== $post->user_id) {
        abort(403);
    }

    $request->validate([
        'description' => 'required|string|max:1000',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'video' => 'nullable|mimes:mp4,avi,mov|max:10240',
    ]);

    $post->description = $request->description;
    $post->save();


    if ($request->has('delete_images')) {
        foreach ($request->delete_images as $imageId) {
            $media = Media::findOrFail($imageId);
            $filePath = public_path('images/' . $media->filename);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $media->delete();
        }
    }

    if ($request->has('delete_videos')) {
        foreach ($request->delete_videos as $videoId) {
            $media = Media::findOrFail($videoId);
            $filePath = public_path('videos/' . $media->filename);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $media->delete();
        }
    }

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);

            Media::create([
                'updateID' => $post->id,
                'type' => 'image',
                'filename' => $filename,
            ]);
        }
    }
    if ($request->hasFile('video')) {
        $video = $request->file('video');
        $filename = time() . '_' . $video->getClientOriginalName();
        $video->move(public_path('videos'), $filename);

        Media::create([
            'updateID' => $post->id,
            'type' => 'video',
            'filename' => $filename,
        ]);
    }

    return redirect()->route('profilepage')->with('success', 'Post updated successfully!');
}



public function destroy($id)
{
    $post = Update::findOrFail($id);

    if (auth()->id() !== $post->user_id)

    foreach ($post->media as $media) {
        $filePath = public_path(($media->type === 'image' ? 'images/' : 'videos/') . $media->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $media->delete();

    }

    $post->delete();

    return redirect()->route('profilepage')->with('success', 'Post deleted successfully!');
}



}
