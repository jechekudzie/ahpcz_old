<!DOCTYPE html>
<html>
<head>

    <title>Student Confirmation</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
            padding: 35px;
        }

        /* Create three equal columns that floats next to each other */
        .column {
            float: left;
            width: 33.33%;
            padding: 3px;
            height: 150px; /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
    <!-- Latest compiled and minified CSS -->

</head>
<body style="background-color: white;">
<div style="width: 100%; padding: 10px;">
    <div style="margin-top:30px;background-image:url('logo/back.png');background-size: contain;background-position:
    center;
        background-repeat:
    no-repeat; padding: 0 2% 6.12442rem">
        <div class="row">
            <div class="column">
                <img style="margin-top: -40px" height="120px" src="logo/logo.png">
            </div>
            <div style="padding-left: -100px;margin-top: -50px;" class="column">
                <p style="margin-left: -100px;color:green">
                    ALLIED HEALTH<br/>
                    PRACTITIONERS<br/>
                    COUNCIL OF <br/>
                    ZIMBABWE
                </p>
            </div>
            <div class="column">
                <p style="text-align:justify;font-size: 13px; margin-top: -25px;">
                    20 Worcester Road Eastlea, Harare<br/>
                    P.O. Box A14 Avondale, Harare,<br/>
                    Tel: +263 04-303027, +263 771 056 413<br/>
                    E-mail: registrar@ahpcz.co.zw<br/>
                    Website: www.ahpcz.co.zw
                </p>
            </div>
        </div>
        <p style="margin-top:-40px;color:green;text-align:center;font-size: 10pt;font-weight: bolder;text-decoration:
        underline;text-decoration-style: double;
"> ALL CORRESPONDENCE SHOULD BE ADDRESSED TO THE REGISTRAR</p>
        <h6 style="padding: 20px;text-align: left;margin-top: -5px;">{{date('d F Y',strtotime
        ($practitioner->registration_date))}}</h6>
        <p style="padding: 20px;margin-top:-50px;color:black;text-align:left;font-size: 10pt;font-weight: bolder;
        text-decoration:
        underline;text-decoration-style: double;">STUDENT REGISTRATION CONFIRMATION</p>
        <table style="table-layout: fixed; width: 100%; padding-bottom: 60px; ">
            <tr>
                <td style="padding: 20px">Name</td>
                <td style="padding: 20px">{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
            </tr>
            <tr>
                <td style="padding: 20px">Student Registration Number</td>
                <td style="padding: 20px">A/S210225</td>
            </tr>
            <tr>
                <td style="padding: 20px">Qualification being studied</td>
                <td style="padding: 20px">
                    @if($qualification)
                        {{$qualification}}
                    @else
                        {{'No Qualification Assigned Yet'}}
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 20px">Qualification being studied</td>
                <td style="padding: 20px">
                    @if($university)
                        {{$university}}
                    @else
                        {{'No University Assigned Yet'}}
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 20px;">Condition/s</td>
                <td style="padding: 20px;">{{$register_category}}</td>
            </tr>
            <tr>
                <td style="text-align: center;padding: 20px;" colspan="2">F. Mazirir<br/>
                    Registrar
                    <br/>
                    <br/>
                    {!! $html !!}
                </td>
            </tr>
        </table>

        <div style="border-top: 5px solid green">
            <p style="text-align: center;font-weight:bolder">Council</p>
            <p style="text-align: center;font-size: 9pt;">
                Miss R Hofisi (Chairperson), Dr H Zirima (Vice-Chairperson)<br/>
                Members: Dr S Shamhu, Mr C Nyathi, Mr D Mudede, Mrs D Muchirahondo, Mr Z Magwenzi, <br/>
                Dr J January, Mr L Gremu, Dr A Makowe
            </p>
        </div>
    </div>
</div>
</body>
</html>
