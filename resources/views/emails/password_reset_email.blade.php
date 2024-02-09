<x-mail::message>
    # Password Reset Request

    You are receiving this email because we received a password reset request for your account.

    # Your password reset token is {{$token}}.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>