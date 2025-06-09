@component('mail::message')
# New Affiliation Form Submitted

**Project Title:** {{ $affiliation->application->proposal->project_title }}  
**Submitted By:** {{ $affiliation->application->data['full_name'] ?? 'N/A' }}  
**Submission Date:** {{ $affiliation->created_at->format('M j, Y g:i a') }}

@component('mail::button', ['url' => route('admin.affiliations.show', $affiliation)])
Review Affiliation
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent