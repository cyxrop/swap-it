@extends('layout.main')

@section('content')

    <!-- Main jumbotron for a primary marketing message or call to action -->
    {{--    <div class="jumbotron">--}}
    <div class="container mt-5">
        <h1>Registration</h1>
        <form action="{{ route('user-register-result')  }}" method="post">
            @csrf
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text"
                       id="login"
                       name="login"
                       placeholder="Enter your name"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="login">Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Enter your password"
                       class="form-control">
            </div>
            <button type="submit" class="btn btn-raised btn-success">Register</button>
        </form>
    </div>

    {{--    </div>--}}

@endsection
