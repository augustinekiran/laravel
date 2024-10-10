<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Login</h3>
                        <form action="{{route('login.attempt')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Enter username" required>
                                @if ($errors->has('username'))
                                <div class="ms-2 small text-danger">{{ $errors->first('username') }}</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                                @if ($errors->has('username'))
                                <div class="ms-2 small text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                            @if (session('message'))
                            <div class="alert alert-danger mt-3" id="generalError">{{ session('message') }}</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>