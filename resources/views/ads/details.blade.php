@extends('layout.main')

@section('content')

    <div class="container mt-2">
        @if ($adData)
            <a role="button" href="{{ route('ad.list') }}" >
                <svg class="bi bi-arrow-left-short" width="2.5em" height="2.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </a>
            <br><br>
            <div class="row">
                <div class="col-6">
                    <h1 class="mb-2">Details of ad</h1>
                </div>
                <div class="col-6">
                    @if ($isOwner)
                        <div class="float-right">
                            <a class="btn btn-primary active" role="button" href="{{ route('ad.update', $adData['id']) }}">
                                Edit
                            </a>
                        </div>
                    @endif
                </div>
            </div>


        @if ($adData['photos'])
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($adData['photos'] as $photo)
                            <div class="carousel-item @if ($loop->index === 0) active @endif">
                                <img class="d-block w-100" src="{{url($photo['src'])}}" alt="Photo">
                            </div>
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

            <div class="card mb-4">
                <div class="card-body">
                    <h4>
                        {{$adData['title']}}
                    </h4>
                    <p>
                        <b>Author:</b> {{$adData['username']}} ({{$adData['userMail']}})
                    </p>
                    <p><b>Description:</b></p>
                    {{$adData['description']}}
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        {{$adData['createdAt']}}
                    </div>
                </div>
            </div>

            @foreach($comments as $comment)
                @if($comment['isDeletable'])
                    <form class="card mb-3" action="{{ route('comment.deleteAction', $comment['id'])}}" method="post">
                        @csrf
                    @else
                    <div class="card mb-3">
                @endif
                        <div class="card-body">
                            <div class="card-title">
                                <b>{{ $comment['username'] }}</b> - {{ $comment['createdAt'] }}
                                @if ($comment['isDeletable'])
                                    <button type="submit" class="btn btn-link">Delete</button>
                                @endif
                                <hr>
                            </div>
                            <h5>{{ $comment['comment'] }}</h5>
                        </div>
                @if(!$comment['isDeletable'])
                    </div>
                @else
                    </form>
                @endif
            @endforeach

            @auth
                <form class="card mb-3" action="{{ route('comment.createAction') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control"
                                      id="comment"
                                      name="comment"
                                      placeholder="Add your comment"
                            ></textarea>
                        </div>
                        <input class="d-none" name="ad_id" value="{{$adData['id']}}">
                        <button type="submit" class="btn btn-raised btn-success">Add comment</button>
                    </div>
                </form>
            @else
                <div class="card my-3">
                    <div class="card-body">
                        <a href="{{route('login')}}">Login</a> to leave comments
                    </div>
                </div>
            @endauth


        @else
            <h1 class="mb-2">Details of ad</h1>
            <div class="alert alert-info">
                Ad not found
            </div>
        @endif
    </div>

@endsection
