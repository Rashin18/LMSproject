<x-mail::message>
# Your EOI Has Been Approved!

Dear {{ $eoi->name }},

We're pleased to inform you that your Expression of Interest has been approved.

**Project Reference:** EOI-{{ $eoi->id }}

**Next Steps:**  
Please complete the full proposal form by clicking the button below.

<x-mail::button :url="$proposalFormUrl">
Complete Proposal Form
</x-mail::button>

**Deadline:** {{ now()->addDays(14)->format('F j, Y') }}

If you have any questions, please contact us at {{ config('mail.support_email') }}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>