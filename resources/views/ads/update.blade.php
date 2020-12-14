@extends('layout.main')

@section('content')

    <div class="container my-2">
        @if ($adData)
            <a role="button" href="{{ route('ad.details', $adData['id']) }}" >
                <svg class="bi bi-arrow-left-short" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </a>
            <br><br>
            <h1 class="mb-2">Edit ad</h1>

            @if ($adData['photos'])
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($adData['photos'] as $photo)
                            <form
                                action="{{ route('photo.deleteAction', $photo['id']) }}"
                                class="carousel-item @if ($loop->index === 0) active @endif"
                                method="post"
                            >
                                @csrf
                                <img class="d-block w-100" src="{{url($photo['src'])}}" alt="Photo">
                                <div class="carousel-caption d-none d-md-block">
                                    <button class="btn btn-danger" type="submit">
                                        Delete
                                    </button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            @endif

            <form class="mt-2" action="{{ route('ad.updateAction', $adData['id']) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text"
                           id="title"
                           name="title"
                           placeholder="Enter ad title"
                           value="{{$adData['title']}}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control"
                              id="description"
                              name="description"
                              placeholder="Enter ad description"
                              rows="6"
                    >{{$adData['description']}}</textarea>
                </div>
                <div class="form-group">
                    <label for="photos">Add photos</label>
                    <input type="file"
                           id="photos"
                           name="photos[]"
                           class="form-control"
                           style="padding-bottom: 2.3rem !important;"
                           multiple>
                </div>
                <button type="submit" class="btn btn-raised btn-success">Update</button>
            </form>
        @else
            <h1 class="mb-2">Details of ad</h1>
            <div class="alert alert-info">
                Ad not found
            </div>
        @endif
    </div>

@endsection
