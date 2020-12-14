@extends('layout.main')

@section('content')

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container mt-2">
        <h1 class="mb-2">List of ads</h1>

        @if (count($adsData) === 0)
            <div class="card my-5">
                <div class="card-body">
                    <h5 class="card-title">There are no ads yet</h5>
                    <p class="card-text">Be the first to add an ad</p>
                    <a href="{{route('ad.create.form')}}" class="btn btn-primary">Create ad</a>
                </div>
            </div>
        @endif

        @foreach($adsData as $adData)

            @if ($loop->index % 3 === 0) <div class="card-deck"> @endif

            <a class="card si-card--shadow mb-4" href="{{ route('ad.details', $adData['id']) }}">

                @if (count($adData['photos']) > 0)
                    <img class="card-img-top" src="{{url($adData['photos'][0]['src'])}}" alt="Card image cap">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{$adData['title']}}</h5>
                    <p class="card-text">
                        @if (strlen($adData['description']) < 150)
                            {{$adData['description']}}
                        @else
                            {{substr($adData['description'], 0, 150) . '...'}}
                        @endif
                    </p>
                </div>
                <div class="text-secondary card-footer">
                    <div class="float-left" data-toggle="tooltip" data-placement="bottom" title="Comments">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-left-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v11.586l2-2A2 2 0 0 1 4.414 11H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        &nbsp;
                        {{$adData['commentsCount']}}
                    </div>

                    <div class="float-right">
                        {{$adData['createdAt']}}
                    </div>
                </div>
            </a>
            @if ($loop->last || $loop->index % 3 === 2) </div> @endif
        @endforeach

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item @if ($pagination['page'] <= 1) disabled @endif">
                    <a
                        class="page-link"
                        href="{{route('ad.list', ['perPage' => $pagination['perPage'], 'page' => 1])}}"
                    >First</a>
                </li>
                <li class="page-item @if ($pagination['page'] <= 1) disabled @endif">
                    <a
                        class="page-link"
                        href="{{route('ad.list', ['perPage' => $pagination['perPage'], 'page' => $pagination['page'] - 1])}}"
                    >Previous</a>
                </li>
                @if ($pagination['page'] - 1 > 0)
                    <li class="page-item">
                        <a
                            class="page-link"
                            href="{{route('ad.list', ['perPage' => $pagination['perPage'], 'page' => $pagination['page'] - 1])}}"
                        >
                            {{$pagination['page'] - 1}}
                        </a>
                    </li>
                @endif
                <li class="page-item active">
                    <a class="page-link">{{$pagination['page']}}</a>
                    <span class="sr-only">(current)</span>
                </li>
                @if ($pagination['page'] + 1 <= $pagination['maxPage'])
                    <li class="page-item">
                        <a
                            class="page-link"
                            href="{{route('ad.list', ['perPage' => $pagination['perPage'], 'page' => $pagination['page'] + 1])}}"
                        >
                            {{$pagination['page'] + 1}}
                        </a>
                    </li>
                @endif
                <li class="page-item @if ($pagination['page'] === $pagination['maxPage']) disabled @endif">
                    <a
                        class="page-link"
                        href="{{route('ad.list', ['perPage' => $pagination['perPage'], 'page' => $pagination['page'] + 1])}}"
                    >Next</a>
                </li>
                <li class="page-item @if ($pagination['page'] === $pagination['maxPage']) disabled @endif">
                    <a
                        class="page-link"
                        href="{{route('ad.list', ['perPage' => $pagination['perPage'], 'page' => $pagination['maxPage']])}}"
                    >Last</a>
                </li>
            </ul>
        </nav>
    </div>

@endsection
