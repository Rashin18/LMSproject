<!-- resources/views/emails/eoi/submission.blade.php -->
@component('mail::message')
# New EOI Submission Received

**From:** {{ $eoi->name }}  
**Email:** {{ $eoi->email }}  
**Submitted At:** {{ $eoi->created_at->format('Y-m-d H:i') }}

**Project Details:**  
{{ $eoi->project_details }}

@component('mail::button', ['url' => $adminUrl])
View Full Submission
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent