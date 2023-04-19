<!DOCTYPE html>
<html>
<head>
    <title>Registration Certificate</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
            padding: 35px;
        }
    </style>
</head>
<body style="background-color: #fbfae5;">
<div style="width: 100%; border: 5px solid green; padding: 10px;">
    <div style="background-image:url({{ asset('logo/back.png')}});background-size: contain;background-position: center;
        background-repeat:
        no-repeat; border: 2px dashed green; padding: 0 2% 6.12442rem">
        <h6 style="text-align: right;"><span style="color: red">AHPCZ</span>{{$practitioner->prefix.''.$practitioner->registration_number}}</h6>
        <div style="text-align: center;">
            <img style="margin-top: -40px" height="120px" src="{{ asset('logo/logo.png')}}">
        </div>
        <h5 style="text-align:center;font-size: 20pt; color: black;font-weight: bolder; margin-top:5px;">ALLIED HEALTH PRACTITIONERS
            COUNCIL OF ZIMBABWE</h5>
        <p style="text-align: center;font-size: 15px; margin-top: -25px;">Number 20 Worcester Road, Eastlea, Harare.
            Phone +263 242 747282/3, +263 771 056 413</p>
        <p style="text-align: center;font-size: 15px; margin-top: -10px;">Email: <a
                href="mailto: registrations@ahpcz.co.zw">registrations@ahpcz.co.zw</a>, Website: <a
                href="www.ahpcz.co.zw">www.ahpcz.co.zw</a></p>
        <h3 style="text-align: center;">Health Professions Act</h3>
        <h3 style="text-align: center;margin-top: -14px;">(Chapter 27:19)</h3>
        <h1 style="text-align: center;margin-top: 40px;">REGISTRATION CERTIFICATE</h1>

        <p style="text-align: center;">This is to Certify that</p>
        <p style="text-align: center;font-size: 20px;text-transform: uppercase;">{{ucwords($practitioner->first_name.' '.$practitioner->last_name)}}</p>
        <p style="text-align: center;">is registered on the register of</p>
        <p style="text-align: center;font-size: 20px;text-transform: uppercase;">{{$practitioner->profession->plural}}</p>
        <p style="text-align: center;">kept by the Allied Health Practitioners Council of Zimbabwe <br/>
            In Accordance with the provisions of the <br/>
            Health Professions Act (Chapter 27:19)
        </p>
        <p style="text-align: center;"></p>
        <p style="text-align: center;font-weight: bold;">Registration Number</p>
        <p style="text-align: center;">{{$practitioner->prefix.$practitioner->registration_number}}</p>
        <div style="display: flex;padding: 20px;">
            <p style="margin-top: 35px">Date: {{$practitioner->registration_date != null ? date('d F Y',strtotime($practitioner->registration_date)) : ''}}</p>
            <p style="position: absolute; right: 78px;">{!! $html !!}</p>
        </div>
    </div>
</div>
</body>
</html>
