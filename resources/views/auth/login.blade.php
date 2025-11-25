<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('storage/website/mafa-logo.jpg') }}">
  <title>Login</title>

  <style>
    :root {
      --primary: #b19604;
      --white: #ffffff;
      --black: #000000;
      --light-gray: #f8f8f8;
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

    /* Card Styles */
    .login-card {
      background-color: var(--white);
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      border-top: 6px solid var(--primary);
    }

    .login-card h1 {
      color: var(--black);
      text-align: center;
      margin-bottom: 2rem;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    /* Form Group */
    .form-group {
      margin-bottom: 1.4rem;
    }

    .form-group label {
      display: block;
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--black);
      margin-bottom: 0.45rem;
      letter-spacing: 0.3px;
    }

    .form-group input {
      width: 100%;
      padding: 0.85rem 1rem;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
      transition: all 0.25s ease;
      background-color: var(--white);
    }

    .form-group input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 6px rgba(177, 150, 4, 0.25);
      outline: none;
    }

    /* Checkbox */
    .form-check {
      display: flex;
      align-items: center;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
    }

    .form-check input {
      margin-right: 0.5rem;
    }

    /* Button */
    button {
      padding: 0.78rem 1rem;
      border: none;
      border-radius: 8px;
      background-color: var(--primary);
      color: var(--white);
      width: 100%;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      transition: background 0.3s, transform 0.3s;
      letter-spacing: 0.3px;
    }

    button:hover {
      background-color: #8a7703;
      transform: translateY(-1px);
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

    /* Error Alert */
    .alert {
      background-color: #fdecea;
      color: #a94442;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border: 1px solid #f5c6cb;
    }

    /* Responsive */
    @media (max-width: 500px) {
      .login-card {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="login-card">

    <h1>Login</h1>

    @if ($errors->any())
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>

      <div class="form-check">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="text-center">
      <a href="{{ route('register') }}">Don't have an account? Register here</a>
    </div>

  </div>
</body>

</html>