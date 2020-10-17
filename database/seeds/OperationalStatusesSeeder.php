<?php

$operational_statuses = [

    [
        'name'=>'Compliant',
        'description'=>'Everything is in order with the council',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Non-Compliant',
        'description'=>'Have outstanding issues, payments or legal.',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Suspended',
        'description'=>'Suspended from practice till further notice',
        'created_at'=>now(),
        'updated_at'=>now()
    ]

];
return $operational_statuses;