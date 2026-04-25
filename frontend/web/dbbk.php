<?php
error_reporting(E_ERROR | E_PARSE);
$filename='database_backup_s'.date('G_a_m_d_y').'.sql.gz';
//if($_GET['xxx-key'] == 786){
$result=exec('mysqldump schooladmindb --password=RfTV?B#1zop} --user=uschool_admin --single-transaction | gzip>/home/deezmedia45/application_backups/'.$filename,$output);

if($output==''){
//    print "not good";
    /* no output is good */}
else {
//    print "not null";
    /* we have something to log the output here*/}
    
//}else {print "R u Carzy??";}