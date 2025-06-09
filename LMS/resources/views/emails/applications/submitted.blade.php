@component('mail::message')
# New Application Submitted

**Project Title:** {{ $application->proposal->project_title }}  
**Submitted By:** {{ $application->proposal->contact_email }}  
**Submission Date:** {{ $application->created_at->format('M j, Y g:i a') }}

@component('mail::button', ['url' => $adminDashboardUrl])
View Application
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent