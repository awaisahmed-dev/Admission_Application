<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if(Yii::$app->request->get('month')) $monthNYearQuery = '&month='.Yii::$app->request->get('month').'&year='.Yii::$app->request->get('year')?>
<?php echo Html::beginForm(Yii::$app->controller->action->id.'?t='.Yii::$app->request->get('t'),'get');?>
    <div class="row" >
        <div class="col-md-12">
            <div class="btn-group">
<?php echo Html::a('<i class="fa fa-school"></i> Campus View', '/dashboard/fee',
                        ['class' => 'btn btn-primary menu-group',  
                            'data'=> GuzzleHttp\json_encode(array('grid_name'=>'detail_report-grid', 'hide_col' =>'100',
                                'sub_title'=>'Class Fee Outstanding Report', 'main_title' => Yii::$app->user->school->title)) ]) ?>
<?php echo Html::a('<i class="fa fa-student"></i> Class View', '/dashboard/detail-report?t=class'.$monthNYearQuery,
                        ['class' => 'btn btn-primary',  
                            'data'=> GuzzleHttp\json_encode(array('grid_name'=>'detail_report-grid', 'hide_col' =>'100',
                                'sub_title'=>'Class Students & Fee Outstanding Report', 'main_title' => Yii::$app->user->school->title)) ]) ?>
<?php echo Html::a('<i class="fa fa-student"></i> Section View ', '/dashboard/detail-report?t=section'.$monthNYearQuery,
                        ['class' => 'btn btn-primary', 
                            'data'=> GuzzleHttp\json_encode(array('grid_name'=>'detail_report-grid', 'hide_col' =>'100',
                                'sub_title'=>'Sectiond Student & Report', 'main_title' => Yii::$app->user->school->title)) ]) ?>
<?php echo Html::a('<i class="fa fa-print"></i> Print', null,
                        ['class' => 'btn btn-primary', 'data-toggle' => "collapse", 'id' => "grid-print", 
                            'data'=> GuzzleHttp\json_encode(array('grid_name'=>'detail_report-grid', 'hide_col' =>'100',
                                'sub_title'=>'Student & Fee Report', 'main_title' => Yii::$app->user->school->title)) ]) ?>
            </div>        
        </div>
    </div>
    <div class="row bg-gray" >
        <div class="col-md-12">
        <?php //if(Yii::$app->request->get('t')): ?>
        <div class="col-md-4" >
            <div class="col-md-6" >
                <?php echo Html::dropDownList( 'month', Yii::$app->request->get('month')? Yii::$app->request->get('month'): date('F'), Yii::$app->params['fee_months'], [ 'prompt' => 'Select Month',' class' => 'form-control'] )?>
            </div>
            <div class="col-md-6" >
                <?php echo Html::dropDownList( 'year', Yii::$app->request->get('year')? Yii::$app->request->get('year'): date('Y'), Yii::$app->params['fee_years'], [ 'prompt' => 'Select Year', 'class' => 'form-control'] )?>
            </div>
        </div>
        
        <div class="col-md-2 text-left" >
            
            <?php   echo Html::checkbox('fullView', Yii::$app->request->get('fullView'), ['class' => 'btn btn-success', 'id'=>'full-report_view'] );
                    echo Html::label('Full Report View', 'full-report_view');        
                            ?>
            <br />
            <?php   echo Html::checkbox('past_months_view', Yii::$app->request->get('past_months_view'), ['class' => 'btn btn-success', 'id'=>'past_months_view'] );
                    echo Html::label('Past Months', 'past_months_view');        
                            ?>
            
        </div>    
        
        <div class="col-md-4 text-left" >
            <?php echo Html::submitButton('Filter',['class' => 'btn btn-success'] )?>
        </div>
        <?php //endif ?>
        </div>
    </div>
<?php echo Html::endForm();?>