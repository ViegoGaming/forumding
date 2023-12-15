@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>All Posts - Your Forum Title</title>

    <!-- Reddit-inspired Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/slate/bootstrap.min.css">
</head>

<body>

<div class="container my-4">

    <h1 class="mb-4">Aqu-A</h1>
    <a class="btn btn-primary mb-3" href="{{ route('forum.create') }}">Create new Post!</a>

    <div class="card">
        <div class="card-body">
            @foreach ($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->subject ?? 'N/A' }}</h5>
                        <p class="card-text">{{ $post->content ?? 'N/A' }}</p>
                        <div class="text-muted small mb-3">Posted by: {{ $post->user->name ?? 'N/A' }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-info btn-sm" href="{{ route('forum.edit', $post->id) }}">Edit</a>
                                <form action="{{ route('forum.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>

                            </div>
                            <small class="text-muted">{{ $post->created_at ? $post->created_at->diffForHumans() : 'N/A' }}</small>
                        </div>
                    </div>
                </div>

                <div class="ml-4">
                    <ul class="list-unstyled">
                        @forelse ($post->comments as $comment)
                            <li class="mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <strong>{{ $comment->user->name }}:</strong>
                                        {{ $comment->content }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-muted">No comments</li>
                        @endforelse
                    </ul>
                </div>


    <!-- Form to add a new comment -->
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="commentContent">Add a Comment:</label>
            <textarea class="form-control" id="commentContent" name="content" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Add Comment</button>
    </form>
</div>


                <hr class="my-2">
            @endforeach
        </div>
    </div>

</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

@endsection
<!-- Styling van CHATGPT
