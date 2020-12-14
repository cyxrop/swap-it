@extends('layout.main')

@section('content')

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container mt-2">
        <h1>New ad</h1>
        <form action="{{ route('ad.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text"
                       id="title"
                       name="title"
                       placeholder="Enter ad title"
                       value="{{ old('title') }}"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control"
                          id="description"
                          name="description"
                          placeholder="Enter ad description"
                >{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="photos">Photos</label>
                <input type="file"
                       id="photos"
                       name="photos[]"
                       class="form-control"
                       style="padding-bottom: 2.3rem !important;"
                       multiple>
            </div>
            <button type="submit" class="btn btn-raised btn-success">Register</button>
        </form>
    </div>

@endsection
