@component('mail::message')
# Good day

Please be advised that your application has been fully approved and accepted by the Council.

@component('mail::button', ['url' => url('http://localhost:8000/my_application/'.$practitioner->id)])
    View Status
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
