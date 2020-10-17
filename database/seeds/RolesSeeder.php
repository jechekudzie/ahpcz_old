<?php

$roles = [
    [
        'name'=>'System Admin',
        'description'=>'Have Access to all the system and maintains and updates system modules',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Acting User',
        'description'=>'Only stands in the gape when the actual user is not available and will be assigned only when necessary',
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    [
        'name'=>'Data Clerk',
        'description'=>'Captures all records once submitted that include, Applications and Renewal forms.',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Registration Officer',
        'description'=>'Makes sure all application and renewal forms are filled in correctly and all required documents are included.',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Accountant',
        'description'=>'Collect payments, confirms payments, issue invoices approves practitioners payment status for collection of certificate',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Approvers/Committee Member',
        'description'=>'Approves or denies all new applications',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Registrar',
        'description'=>'Issues all certificates once practitioner is approved/renewal is up to date.',
        'created_at'=>now(),
        'updated_at'=>now()
    ],

    [
        'name'=>'Practitioner',
        'description'=>'Only Uses access the system via Practitioner web portal.',
        'created_at'=>now(),
        'updated_at'=>now()
    ],
    [
        'name'=>'Student',
        'description'=>'Only Uses access the system via Student web portal.',
        'created_at'=>now(),
        'updated_at'=>now()
    ]
];
return $roles;