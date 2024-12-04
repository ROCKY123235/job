<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}


.login-container {
    max-width: 400px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}


.text-center {
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

.text-danger {
    color: red;
    font-size: 12px;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    background-color: #d9f7d9;
    border: 1px solid #b7eb8f;
    color: #389e0d;
    border-radius: 4px;
}

.checkbox {
    font-size: 14px;
    color: #555;
}

.checkbox input[type="checkbox"] {
    margin-right: 10px;
}
.btn {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

.j {
    margin-top: 15px;
}
</style>
<div class="login-container">
    <h3 class="card-header text-center">Login</h3>
    @if (session()->has('message'))
    <div class="alert alert-info">
        {{session()->get("message")}}
    </div>
    @endif
    <form action="{{route("postlogin")}}" method="post">
        @csrf
        <div class="form-group">
            <input type="text" placeholder='Email' id="email" name="email" class="form-control">
            @if ($errors->has("email"))
            <span class="text-danger">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="form-group">
            <input type="password" placeholder="Password" id="password" class="form-control" name="password">
             @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
            <div class="j">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>
                <button type="submit" class="btn">Signin</button>

        </div>
    </form>
</div>