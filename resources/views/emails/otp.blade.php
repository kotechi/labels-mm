<x-mail::message>
# Registration OTP

Your OTP for registration is: **{{ $otp }}**

This OTP will expire in 5 minutes.

If you didn't request this OTP, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>