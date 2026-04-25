<?php

namespace backend\models;
	
use Yii;	
use yii\web\ForbiddenHttpException;
	trait AccountAlerts{
		public $sett;// = (json_decode(Yii::$app->keyStorage->get("$companyid@orderm.settings")));
		
		function setAccountSettings(){
			$schoolid =Yii::$app->user->school->id;
			$this->sett = (json_decode(Yii::$app->keyStorage->get("$schoolid@school.settings")));
		}
		function accountExpiredAlert(){
			$sett = $this->sett; $sett->subscription_expiry; 
			
			if(  strtotime($sett->subscription_expiry) - time() < 0)
				Yii::$app->session->setFlash('danger', "Your account is expired due to non payment and terminated on  ". date('d F Y', strtotime($sett->subscription_expiry)));
			else if(strtotime($sett->subscription_expiry. "-3 days")- time() < 0)
				Yii::$app->session->setFlash('danger', "Your account will expire on ". date('d F Y', strtotime($sett->subscription_expiry)). ", Please pay to continue.");
			
			else if(strtotime($sett->subscription_expiry. "-10 days")- time() < 0)
				Yii::$app->session->setFlash('warning', "Your account will expire on ". date('d F Y', strtotime($sett->subscription_expiry)). ", Please pay to continue.");
			else if(strtotime($sett->subscription_expiry. "-30 days") - time() < 0)
				Yii::$app->session->setFlash('info', "Your account will expire on ". date('d F Y', strtotime($sett->subscription_expiry)). ", Please pay to continue.");
		}	
		
		function orderLimitAlert(){
			
			$sett = $this->sett;
			$orderCount = \backend\modules\sale\models\Order::find()->where(['MONTH(date)'=>date('m'), 'Year(date)'=>date('Y'), 
				'company_id' =>Yii::$app->user->company->id])->count();
			if($sett->subscription_settings->order_monthly_limit and $orderCount > $sett->subscription_settings->order_monthly_limit/2) 	
			Yii::$app->session->setFlash('info', "You have created $orderCount of ". $sett->subscription_settings->order_monthly_limit." orders allowed for ". date('F Y'));
		}
		
		function customerLimitAlert(){
			
			$sett = $this->sett;
			$customerCount = \backend\modules\sale\models\Customer::find()->where(['status'=>1, 'company_id'=>$sett->id])->count();
			Yii::$app->session->setFlash('info', "You have created $customerCount of ". $sett->subscription_settings->customers_allowed." active cutomers allowed for your account.");	
		}
		
		function displayAlerts(){
			$this->setAccountSettings();
			$this->accountExpiredAlert();
			if(Yii::$app->controller->id == "order")$this->orderLimitAlert();
			if(Yii::$app->controller->id == "customer")$this->customerLimitAlert();
		}
		
		function isAccountExpired(){
			$this->setAccountSettings();
			$sett = $this->sett; $sett->subscription_expiry; 
			
			//print strtotime($sett->subscription_expiry) - time(); die;
			if(  strtotime($sett->subscription_expiry) - time() < 0) 
				throw new ForbiddenHttpException('The requested resource not allowed.');
		}
			
		
	}

?>