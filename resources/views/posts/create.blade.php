@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Back to Dashboard Button -->
    <div class="mb-3">
        <a href="{{ url('/dashboard') }}" class="btn btn-secondary">&larr; Back to Dashboard</a>
    </div>

    <h2>Add New Post</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <!-- User -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Author (User):</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Select a user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-success">Create Post</button>
    </form>
</div>
@endsection
