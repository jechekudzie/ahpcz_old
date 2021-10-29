<!DOCTYPE html>
<html>
<head>
    <title>Certificate</title>
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
    <div style="background-image:url('logo/back.png');background-size: contain;background-position: center;
        background-repeat:
    no-repeat; border: 2px dashed green; padding: 0 2% 6.12442rem">
        <h6 style="text-align: right;"><span style="color: red">AHPCZ</span>{{substr($renewal->renewal_period_id, -2)}}/{{str_pad($renewal->certificate_number, 4, '0', STR_PAD_LEFT)}}</h6>
        <div style="text-align: center;">
            <img style="margin-top: -40px" height="120px" src="logo/logo.png">
        </div>
        <h5 style="text-align:center;font-size: 15pt; color: black;font-weight: bolder;">ALLIED HEALTH PRACTITIONERS
            COUNCIL OF ZIMBABWE</h5>
        <p style="text-align: center;font-size: 15px; margin-top: -25px;">Number 20 Worcester Road, Eastlea, Harare.
            Phone +263 242 747282/3, +263 771 056 413</p>
        <p style="text-align: center;font-size: 15px; margin-top: -10px;">Email: <a
                href="mailto: registrations@ahpcz.co.zw">registrations@ahpcz.co.zw</a>, Website: <a
                href="www.ahpcz.co.zw">www.ahpcz.co.zw</a></p>
        <h3 style="text-align: center;">Health Professions Act</h3>
        <h3 style="text-align: center;margin-top: -14px;">(Chapter 27:19)</h3>
        <h1 style="text-align: center;margin-top: 40px;">PRACTISING CERTIFICATE</h1>
        <table style="table-layout: fixed; width: 100%; ">
            <tr>
                <td style="padding: 20px">This is to certify that</td>
                <td style="padding: 20px">{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
            </tr>
            <tr>
                <td style="padding: 20px">Registration Number</td>
                <td style="padding: 20px">{{$practitioner->prefix.''.$practitioner->registration_number}}</td>
            </tr>
            <tr>
                <td style="padding: 20px">Is Authorised to practice as a/an</td>
                <td style="padding: 20px">{{$practitioner->profession->name}}</td>
            </tr>
            <tr>
                <td style="text-align: center;padding: 20px;" colspan="2">Condition/s<br/>
                    {{$register_category}}
                </td>
            </tr>
        </table>
        <p style="text-align: center;">This certificate expires on</p>
        <p style="text-align: center; text-decoration: underline;margin-bottom: 40px;">{{'31 December ' .$renewal->renewal_period_id}}</p>

        <div style="display: flex;padding: 20px;">
           <p style="margin-top: 35px">Date: {{date('d F Y',strtotime($renewal->updated_at))}}</p>
            <p style="position: absolute; right: 78px;">{!! $html !!}</p>
        </div>
    </div>
</div>
</body>
</html>
