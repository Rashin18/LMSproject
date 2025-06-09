@component('mail::message')
# ATC Account Approved

Your affiliation has been approved and an ATC account has been created for you.

**Login Credentials:**  
**Email:** {{ $affiliation->form_data['contact_email'] }}  
**Password:** {{ $password }}  

@component('mail::button', ['url' => $loginUrl])
Login to ATC Portal
@endcomponent

**Security Note:**  
- Please change your password after first login  
- Never share your credentials with anyone  

Thanks,  
{{ config('app.name') }}
@endcomponent