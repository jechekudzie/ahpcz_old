@component('mail::message')
# Introduction

Dear {{$renewal->practitioner->first_name.' '.$renewal->practitioner->last_name}}<br/>
This is notify you that your renewal was a success and your Practising Certificate is now ready.

@component('mail::button', ['url' => url('http://localhost:8000/open_print'.$renewal->id)])
Print Certificate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
