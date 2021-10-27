<!DOCTYPE html>
<html>
<head>
    <title>REGISTRATION CARD</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            min-height: 100%;
            margin: 0px;
            padding: 10px;
        }
    </style>
</head>
<body style="background-color: white;">
<div style="border-radius: 25px; border: 2px solid green ; padding: 10px;">
    <div>
        <div style="text-align: center;">
            <img style="margin-top: 5px" height="80px" src="logo/logo.png">
        </div>
        <h5 style="text-align:center;font-size: 10pt; color: black;font-weight: bolder;">ALLIED
            HEALTH PRACTITIONERS
            COUNCIL OF ZIMBABWE</h5>
        <h6 style="text-align:center;font-size: 10pt; color: black;font-weight: bolder;margin-top: -25px;">REGISTRATION CARD</h6>
        <table style="table-layout: fixed; width: 100%;margin-top: -25px;margin-bottom: 20px; ">
            <tr>
                <td style="padding: 3px">This is to certify that :</td>
                <td style="padding: 3px">{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
            </tr>
            <tr>
                <td style="padding: 3px">Registration number :</td>
                <td style="padding: 3px">{{$practitioner->prefix.''.$practitioner->registration_number}}</td>
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
