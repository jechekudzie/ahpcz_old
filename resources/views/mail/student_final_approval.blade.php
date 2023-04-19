@component('mail::message')
# Good day,

We are happy to notify you that your student application has been approved by Allied Health Practitioner's Council Of
Zimbabwe as of {{now()}}.

Welcome onboard.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
