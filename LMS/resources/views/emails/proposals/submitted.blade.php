<x-mail::message>
# New Proposal Submitted

**Project Title:** {{ $proposal->project_title }}  
**Submitted By:** {{ $proposal->eoi->name }}  
**Budget:** ${{ number_format($proposal->budget, 2) }}  
**Timeline:** {{ $proposal->timeline }}

<x-mail::button :url="route('admin.proposals.show', $proposal)">
View Full Proposal
</x-mail::button>

**Summary:**  
{{ Str::limit($proposal->detailed_description, 200) }}

Thanks,  
{{ config('app.name') }}
</x-mail::message>