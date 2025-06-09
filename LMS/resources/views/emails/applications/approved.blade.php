@component('mail::message')
# Application Approved: {{ $application->proposal->project_title }}

Your application has been officially approved!

**Project Title:** {{ $application->proposal->project_title }}  
**Approval Date:** {{ now()->format('F j, Y') }}

@component('mail::panel')
Congratulations! Your project is now approved and will move forward.
@endcomponent

@component('mail::button', ['url' => $dashboardUrl])
Access Your Dashboard
@endcomponent

If you have any questions, please contact our support team.

Thanks,  
{{ config('app.name') }}
@endcomponent