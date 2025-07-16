<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Items</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.jpg') }}" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .btn-box {
      width: 200px;
      max-width: 150px;
      height: 200px;
      max-height: 150px;
      border-radius: 12px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: white;
      font-weight: 600;
      text-decoration: none;
      user-select: none;
      border: none;
    }

    .btn-box:hover {
      transform: scale(0.95);
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
      text-decoration: none;
      color: white;
    }

    .icon {
      width: 40px;
      height: 40px;
      background-size: cover;
      margin-bottom: 12px;
    }

    form.logout-form {
      margin: 0;
    }
  </style>
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100">

  <div class="container d-flex justify-content-center gap-4 flex-wrap">

    <!-- Add New Post -->
    <a href="{{ url('posts/create') }}" class="btn btn-danger btn-box text-center" role="button" aria-label="Add New Post">
      <div class="icon" style="background-image: url('{{ asset('images/items/addNewItem.png') }}');"></div>
      Add New Post
    </a>

    <!-- Post List -->
    <a href="{{ url('posts/post_list') }}" class="btn btn-primary btn-box text-center" role="button" aria-label="Post List">
      <div class="icon" style="background-image: url('{{ asset('images/items/itemList.png') }}');"></div>
      Post List
    </a>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
      @csrf
      <button type="submit" class="btn btn-secondary btn-box text-center">
        <div class="icon" style="background-image: url('{{ asset('images/items/logout.png') }}');"></div>
        Logout
      </button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
