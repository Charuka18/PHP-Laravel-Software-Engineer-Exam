@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Back to Dashboard Button -->
    <div class="mb-3">
        <a href="{{ url('/dashboard') }}" class="btn btn-secondary">&larr; Back to Dashboard</a>
    </div>
    <h2> Edit Post</h2>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" required>
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $post->content) }}</textarea>
        </div>

        <!-- User -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Author (User):</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Select a user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id', $post->user_id) == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Current Image -->
        @if($post->image)
        <div class="mb-3">
            <label class="form-label">Current Image:</label><br>
            <img src="{{ asset('post_images/' . $post->image) }}" alt="Current Image" width="150">
        </div>
        @endif

        <!-- Upload New Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Change Image (optional):</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Update Post</button>
        <a href="{{ route('posts.post_list') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
