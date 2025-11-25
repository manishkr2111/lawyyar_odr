<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('storage/website/mafa-logo.jpg') }}">
  <title>Register</title>

  <style>
    :root {
      --primary: #b19604;
      --white: #ffffff;
      --light-gray: #f8f8f8;
      --black: #000000;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: var(--light-gray);
      padding: 1rem;
    }

    .register-card {
      background-color: var(--white);
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      border-top: 6px solid var(--primary);
    }

    .register-card h1 {
      text-align: center;
      color: var(--black);
      margin-bottom: 2rem;
      font-weight: 700;
    }

    .form-group {
      margin-bottom: 1.4rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.45rem;
      font-weight: 600;
      color: var(--black);
    }

    .form-group input {
      width: 100%;
      padding: 0.85rem 1rem;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(177, 150, 4, 0.25);
    }

    button {
      width: 100%;
      padding: 0.78rem 1rem;
      border: none;
      border-radius: 8px;
      background-color: var(--primary);
      color: var(--white);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      letter-spacing: 0.3px;
    }

    button:hover {
      background-color: #8a7703;
      transform: translateY(-1px);
    }

    .alert {
      background-color: #fdecea;
      color: #a94442;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border: 1px solid #f5c6cb;
    }

    .alert ul {
      padding-left: 1.2rem;
    }

    .text-center {
      text-align: center;
      margin-top: 1.5rem;
    }

    .text-center a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }

    .text-center a:hover {
      text-decoration: underline;
    }

    @media (max-width: 500px) {
      .register-card {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="register-card">
    <h1>Register</h1>

    @if ($errors->any())
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
      </div>

      <button type="submit">Register</button>
    </form>

    <div class="text-center">
      <a href="{{ route('login') }}">Already have an account? Login here</a>
    </div>

  </div>

</body>

</html>