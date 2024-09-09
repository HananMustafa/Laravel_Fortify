<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <form method="POST" action="{{ url('/reset-password') }}">
        @csrf
    
        <!-- Token -->
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
    
        <!-- Email Address -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ request()->input('email') }}" required autofocus>
        </div>
    
        <!-- Password -->
        <div>
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" required>
        </div>
    
        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
    
        <!-- Submit Button -->
        <div>
            <button type="submit">
                Reset Password
            </button>
        </div>
    </form>
    
    
</body>
</html>
