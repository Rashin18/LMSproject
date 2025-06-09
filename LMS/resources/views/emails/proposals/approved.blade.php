@component('mail::message')
# Proposal Approved: {{ $proposal->project_title }}

Your proposal has been approved! Please complete the application form by clicking the button below.

**Important:** This link will expire on {{ $proposal->token_expires_at->format('F j, Y') }}.

@component('mail::button', ['url' => $applicationFormUrl])
Complete Application Form
@endcomponent

If the button doesn't work, copy and paste this URL into your browser:
{{ $applicationFormUrl }}

@component('mail::panel')
If you encounter any issues, please contact us at {{ config('mail.support_email') }} immediately.
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent