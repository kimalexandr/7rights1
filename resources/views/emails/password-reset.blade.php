<p>Hello,</p>
<p>You requested a password reset. Click below:</p>
<p>
    <a href="{{ url('/reset-password?token=' . $token) }}">
        Reset Password
    </a>
</p>
<p>If you did not request this, please ignore.</p>
