<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 18px;
            font-size: 15px;
            transition: 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.4);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #b19604;
            border: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #968c56;
        }

        .error {
            color: #d00;
            font-size: 14px;
            margin-bottom: 15px;
            background: #ffe5e5;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ffb3b3;
        }

        .success {
            color: #0a7d27;
            font-size: 14px;
            margin-bottom: 15px;
            background: #e6ffed;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #9ae8b3;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Reset Your Password</h2>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label>New Password</label>
            <input type="password" name="password" placeholder="Enter new password" required>
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm password" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
