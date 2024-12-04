<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
     <div class="container">
        <div class="card">
            <h3>Register user</h3>
            <form action="{{url('postsignup')}}" method="post">
                @csrf
                <div class="form-group">
                <input type="text" placeholder="name" class="form-control" name="name" autofocus>
                @if ($errors->has('name'))
                <span class="text-danger">{{$errors->first('name')}}</span>
                @endif
            </div>
            <div class="form-group mb-3">
                <input type="text" placeholder="Email" id="email_address" class="form-control" name="email" autofocus>
                @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group mb-3">
                <input type="password" placeholder="Password" id="password" class="form-control" name="password">
                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
                <div class="form-group">
                    <label><input type="checkbox" name="remember">Remember Me</label>
                </div>
                <button type="submit">Signup</button>
            </form>
        </div>
     </div>
</body>
</html>
