<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

/**
 * Description of Statuslabel
 *
 * @author Analyst
 */
class CustomFormatter extends \yii\i18n\Formatter{
    //put your code here
    
    /**
     * 
     * @param type $status [] 
     * @return type
     */
    
    public function asStatuslabel($status = null) {
        
         if($status == '1' )   $statuslabel = "<span class='label label-success'>Active</span>";
         else if($status == '0')
            $statuslabel = "<span class='label label-danger'>In active</span>";
         else if($status == '10')
            $statuslabel = "<span class='label label-primary'>Draft</span>";
         else if($status == '101')
            $statuslabel = "<span class='label label-default'>Requested</span>";
         else if($status == '-10')
            $statuslabel = "<span class='label label-warning'>Cancelled</span>";
         else $statuslabel = $status;
        return $statuslabel;
                    
            
    }
    public function asOrderlabel($status = null) {
        
         if($status == '1' )   $statuslabel = "<span class='label label-success'>Completed</span>";
         else if($status == '3')
            $statuslabel = "<span class='label label-primary'>Delivered</span>";
         else if($status == '5')
            $statuslabel = "<span class='label label-default'>In Progress</span>";
         else if($status == '101')
            $statuslabel = "<span class='label label-default'>Requested</span>";
         else if($status == '0')
            $statuslabel = "<span class='label label-danger'>Pending</span>";
         else if($status == '10')
            $statuslabel = "<span class='label label-dark'>Draft</span>";
         else if($status == '50')
            $statuslabel = "<span class='label label-default'>Returned</span>";
         else if($status == '-10')
            $statuslabel = "<span class='label label-warning'>Cancelled</span>";
         else $statuslabel = $status;
        return $statuslabel;
                    
            
    }
    
    public function asNotificationStatus($status) {  
                                if($status == '10') { 
                                $statusLbl = "<span class='label label-success'>Delivered</span>" ;}
                                else if($status == '5')
                                $statusLbl = "<span class='label label-success'>Sent</span>";
                                 else if($status == '101')
                                $statusLbl = "<span class='label label-default'>Requested</span>";
                                else if($status == '-5')
                                $statusLbl = "<span class='label label-warning'>Cancelled</span>";
                                else if($status == '-10')
                                $statusLbl = "<span class='label label-danger'>Failed</span>";
                                else if($status == '1')
                                $statusLbl = "<span class='label label-primary'>Pending</span>";
                                else if($status == '0')
                                $statusLbl = "<span class='label label-primary'>In Active</span>";

                                return $statusLbl;
    }
    
    public function asPaymentStatuslabel($status = null) {
        
         if($status == '1' )   $statuslabel = "<span class='label label-success'>Paid</span>";
         else if($status == '0')
            $statuslabel = "<span class='label label-danger'>Pending</span>";
         else if($status == '-10')
            $statuslabel = "<span class='label label-warning'>Cancelled</span>";
         else $statuslabel = $status;
        return $statuslabel;
                    
            
    }
    public function asResponsestatus($status = null) {
        
        if($status == '1' ) 
                $format =   "<span class='label label-danger'>Pending</span>" ;
        else if($status == '0' ) $format =   "<span class='label label-success'>In Active</span>" ;
        elseif($status == '10' ) $format =   "<span class='label label-primary'>Submitted</span>" ;
        else $format = $status;
        return  $format;
                    
            
    }
    public function asUserlabel($userid = null) {
        
        $format = ucfirst(\common\models\User::findOne($userid)->userProfile->full_name);
        return  $format;
                    
            
    }
}
