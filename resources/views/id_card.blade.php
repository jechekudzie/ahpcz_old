<!DOCTYPE html>
<html>
<head>
    <title>REGISTRATION CARD</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            min-height: max-content;
            margin: 0px;
            padding: 10px;
        }
    </style>
</head>
<body style="background-color: white;">
<div style="border-radius: 20px; border: 2px solid green ; padding: 10px;">
    <div style="background-image:url('logo/back.png');background-size: contain;background-position: center;
        background-repeat:
    no-repeat; ">
        <div style="margin-top: 2px">
            <img style="padding-left:25px;text-align:left; margin-top: 5px" height="80px" src="logo/logo.png">
            <img style="padding-left:300px; text-align:right; margin-top: 5px" height="80px" src="logo/icon.png">
        </div>

        <h5 style="text-align:center;font-size: 10pt; color: black;font-weight: bolder;margin-top: -10px">ALLIED
            HEALTH PRACTITIONERS
            COUNCIL OF ZIMBABWE</h5>
        <h6 style="text-align:center;font-size: 10pt; color: black;font-weight: bolder;margin-top: -25px;">REGISTRATION CARD</h6>
        <table style="table-layout: fixed; width: 100%;margin-top: -25px;">
            <tr>
                <td style="padding: 3px">This is to certify that :</td>
                <td style="padding: 3px">{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
            </tr>
            <tr>
                <td style="padding: 3px">Registration number :</td>
                <td style="padding: 3px">{{$practitioner->prefix.''.$practitioner->registration_number}}</td>
            </tr>
            <tr>
                <td style="padding: 3px">ID/Passport Number :</td>
                <td style="padding: 3px">{{$practitioner->id_number}}</td>
            </tr>
            <tr>
                <td style="padding: 3px">Is Authorised to practice as a/an :</td>
                <td style="padding: 3px">{{$practitioner->profession->name}}</td>
            </tr>
            <tr>
                <td style="padding: 3px">This Card expires on :</td>
                <td style="padding: 3px">{{'31 December ' .$renewal->renewal_period_id}}</td>
            </tr>
            <tr>
                <td style="padding: 3px">Registrar :</td>
                <td style="padding: 3px">{!! $html !!}</td>
            </tr>

        </table>
    </div>
</div>
</body>
</html>
