@component('mail::message')
# Application Approved: {{ $application->proposal->project_title }}

Your application has been approved! Please complete the affiliation form to finalize your participation.

**Next Steps:**
1. Click the button below to access the affiliation form
2. Complete all required fields
3. Submit the form for final review

@component('mail::button', ['url' => $affiliationFormUrl])
Complete Affiliation Form
@endcomponent

**Important:** This link will expire on {{ now()->addDays(14)->format('F j, Y') }}.

If you have any questions, please contact us at {{ config('mail.support_email') }}.

Thanks,  
{{ config('app.name') }}
@endcomponent