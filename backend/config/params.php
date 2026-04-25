<?php

for ($yr = date('Y', strtotime("+1 year")); $yr > date('Y', strtotime("-8 year")); $yr-- )
$yearOptions[ $yr]= $yr;
return [
    'adminEmail' => 'admin@example.com',
    'progressType' => ['1'=>'Job description', '2'=>'Evaluation', '3'=>'Training',
        '4'=>'Disciplinarians', '5'=>'Awards','6'=>'Holidays Request', '7'=>'Complaints or concerns'],
    'comapny_name' => 'School Management',
    'currency' => 'USD',
    'annual_registration_fee' => 25.00,
    'statusOptions'=> [ '1' => 'Active', '0' => 'Disabled', 'other' => 'Other' ],
    'statusPrompt'=> ['prompt' => 'Select Status'],
    'fee_types'=> ['monthly'=>'Monthly Fee', 'term'=>'Term Fee',  'examination'=>'Examination Fee', 'admission' => 'Admission Fee'],
    'fee_months'=>   ['january'=>'January', 'february'=>'Feburary', 'March'=>'March', 'april'=>'April',
                      'may'=>'May', 'june'=>'June', 'july'=>'July', 'august'=>'August',  
                      'september'=>'September', 'october'=>'October', 'november'=>'November',
                      'december'=>'December',  ],
    'fee_years' => $yearOptions,
    'pagination_dd_options' => [5=>5, 10=>10, 20=>20, 50=>50, 100=>100, 200=>200 , 500=>500 , 1200=>1200 , 2000=>2000],
    'fee_addon_exmpt_fields' => ['id', 'school_id', 'student_fee_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'],
    'shortcut_options' =>[
        ['title'=>'Student', 'url'=>'school-management/student/index', 'index'=>'', 'icon'=>'graduation-cap'],
        ['title'=>'Fee', 'url'=>'fee-management/student-fee', 'index'=>'', 'icon'=>'money'],
        ['title'=>'Fee Receipt', 'url'=>'fee-management/student-fee-payment-receipt', 'index'=>'', 'icon'=>'info'],
		['title'=>'Attendance Summary', 'url'=>'/school-management/student-attendance/attendance-report', 'index'=>'', 'icon'=>'info'],
		['title'=>'Examination Board', 'url'=>'/school-management/examination/exam-board', 'index'=>'', 'icon'=>'list'],
        //['title'=>'Parent', 'url'=> 'user-management/user?UserSearch[gridRoleSearch]=parent', 'index'=>''],
        //['title'=>'Teacher', 'url'=> 'user-management/user?UserSearch[gridRoleSearch]=school-teacher', 'index'=>''],
    ],
    'shortcut_add_options' =>[
        ['title'=>'Student', 'url'=>'school-management/student/create', 'index'=>''],
        ['title'=>'Fee Voucher', 'url'=>'fee-management/student-fee/create', 'index'=>'' , 'icon'=>'money'],
		['title'=>'Class Attendance', 'url'=>'/school-management/student-attendance/create-multiple', 'index'=>'' , 'icon'=>'money'],
		['title'=>'Class Result', 'url'=>'/school-management/examination-schedule', 'index'=>'' , 'icon'=>'money'],
        //['title'=>'Parent', 'url'=>'user-management/user/create?role=parent', 'index'=>''],
        //['title'=>'Teacher', 'url'=>'user-management/user/create?role=school-teacher', 'index'=>''],
        
//        ['title'=>'', 'url'=>'', 'index'=>''],
//        ['title'=>'', 'url'=>'', 'index'=>''],
//        ['title'=>'', 'url'=>'', 'index'=>''],
    ],
    'examination_types' =>
        ['annual'=>'Annual / Final Examination', 'terminal'=>'Terminal Examination',
            'preliminary'=>'Preliminary Examination', 'monthly'=>'Monthly Test', 'other'=>'Other'],
    'days_of_week'=>['Monday'=>'Monday', 'Tuesday'=>'Tuesday', 'Wednesday'=>'Wednesday',
        'Thursday'=>'Thursday', 'Friday'=>'Friday','Saturday'=>'Saturday' ,'Sunday'=>'Sunday' ],
        
    
];
