<?php

$renewal_statuses = [

    [
        'name'=>'Paid',
        'description'=>'Full paid',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Payment Plan',
        'description'=>'On a payment plan',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Owing',
        'description'=>'Debtor',
        'created_at'=>now(),
        'updated_at'=>now()
    ]

];
return $renewal_statuses;