@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Back to Dashboard Button -->
    <div class="mb-3">
        <a href="{{ url('/dashboard') }}" class="btn btn-secondary">&larr; Back to Dashboard</a>
    </div>
    <h2 class="mb-4">All Posts</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Author</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th> <!-- Added -->
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ Str::limit($post->content, 50) }}</td>
                    <td>{{ $post->user->name ?? 'N/A' }}</td>
                    <td>
                        @if($post->image)
                            <img src="{{ asset('post_images/' . $post->image) }}" alt="Post Image" width="60" height="60">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('Y-m-d') }}</td>
                    <td>
                        <!-- View button -->
                        <button
                            class="btn btn-sm btn-info mb-1"
                            data-bs-toggle="modal"
                            data-bs-target="#postModal"
                            data-title="{{ $post->title }}"
                            data-content="{{ $post->content }}"
                            data-author="{{ $post->user->name ?? 'N/A' }}"
                            data-image="{{ $post->image ? asset('post_images/' . $post->image) : '' }}"
                            data-created="{{ $post->created_at->format('Y-m-d H:i') }}"
                        >
                            View
                        </button>

                        <!-- Edit button -->
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                        <!-- Delete form -->
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('posts.create') }}" class="btn btn-success">Add New Post</a>
</div>

<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postModalLabel">Post Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 id="modalTitle"></h4>
        <p><strong>Author:</strong> <span id="modalAuthor"></span></p>
        <p><strong>Created at:</strong> <span id="modalCreated"></span></p>
        <p id="modalContent"></p>
        <div id="modalImageContainer" style="text-align:center; margin-top: 15px;">
            <img id="modalImage" src="" alt="Post Image" class="img-fluid" style="max-height: 300px; display: none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS (make sure it's included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const postModal = document.getElementById('postModal')
    postModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        // Extract info from data attributes
        const title = button.getAttribute('data-title')
        const content = button.getAttribute('data-content')
        const author = button.getAttribute('data-author')
        const image = button.getAttribute('data-image')
        const created = button.getAttribute('data-created')

        // Update modal content
        postModal.querySelector('#modalTitle').textContent = title
        postModal.querySelector('#modalContent').textContent = content
        postModal.querySelector('#modalAuthor').textContent = author
        postModal.querySelector('#modalCreated').textContent = created

        const modalImage = postModal.querySelector('#modalImage')
        if(image) {
            modalImage.src = image
            modalImage.style.display = 'block'
        } else {
            modalImage.style.display = 'none'
        }
    })
</script>
@endsection
