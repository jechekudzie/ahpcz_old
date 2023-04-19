@component('mail::message')
# Good day

Please be advised that your application has been fully approved and accepted by the Council. You can now find your
Practising and Registration Certificate from our portal. Note that, also for future renewals, additional application
and other related processes, you will use the same portal. You are required to submit your ID number and Registration
number to create an account and start using the portal. Follow the link below :

@component('mail::button', ['url' => url('http://portal.ahpcz.co.zw')])
    Visit The Portal Now!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
