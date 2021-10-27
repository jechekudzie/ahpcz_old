@component('mail::message')
# Good day

{{$practitioner->first_name.' '.$practitioner->last_name}}, has just submitted registration fee payment.
Go to the account using the link below, Payments tab, on the period listed, click on payments. Look for the
registration payment and click verify if all is in order.

@component('mail::button', ['url' => url('http://localhost:8000/admin/practitioners/'.$practitioner->id)])
    View payment and Approved
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
