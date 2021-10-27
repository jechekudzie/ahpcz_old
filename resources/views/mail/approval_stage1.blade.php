@component('mail::message')
# Good day

Please be advised that your application has been approved and now pending registration fee payment. You can use the
link below to make your registration payment in real-time or submit the Proof of payment if you already made a payment.

@component('mail::button', ['url' => url('http://localhost:8000/my_application/'.$practitioner->id)])
View Application and Make Payment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
