<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 * @var $this \yii\web\View
 * @var $model \common\models\TimelineEvent
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
$this->title = Yii::t('backend', 'Campus Management Timeline');
$icons = [
    'user'=>'<i class="fa fa-user bg-blue"></i>'
];
?>
<div class="panel-group">
  <div class="panel panel-primary">
    <div class="panel-body">Following are school notifications (information, announcemenets for studenst & teachers) and fee vouchers for parents.</div>
  </div>
</div>

<?php \yii\widgets\Pjax::begin() ?>
<div class="row">
    <div class="col-md-6">
        <?php if ($dataProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach($dataProvider->getModels() as $model): ?>
                    <?php if(!isset($date) || $date != Yii::$app->formatter->asDate($model->created_at)): ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
                            </span>
                        </li>
                        <?php $date = Yii::$app->formatter->asDate($model->created_at) ?>
                    <?php endif; ?>
                    <li>
                        <?php
                            try {
                                $viewFile = sprintf('%s/%s', $model->category, $model->event);
                                echo $this->render($viewFile, ['model' => $model]);
                            } catch (\yii\base\InvalidParamException $e) {
                                echo $this->render('_item', ['model' => $model]);
                            }
                        ?>
                    </li>
                <?php endforeach; ?>
                <li>
                    <i class="fa fa-clock-o">
                    </i>
                </li>
            </ul>
        <?php else: ?>
            <?php echo Yii::t('backend', 'No events found') ?>
        <?php endif; ?>
    </div>
	<?php if(Yii::$app->user->role == 'Parent'): ?>
	<div class="col-md-6">
	<?php if ($notificationProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach($notificationProvider->getModels() as $model): ?>
                    <?php if(!isset($date) || $date != Yii::$app->formatter->asDate($model->created_at)): ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
                            </span>
                        </li>
                        <?php $date = Yii::$app->formatter->asDate($model->created_at) ?>
                    <?php endif; ?>
                    <li>
                        <?php
                            try {
                                $viewFile = sprintf('%s/%s', $model->parent_type, $model->title);
                                echo $this->render($viewFile, ['model' => $model]);
                            } catch (\yii\base\InvalidParamException $e) {
                                echo $this->render('_item_notification', ['model' => $model]);
                            }
                        ?>
                    </li>
                <?php endforeach; ?>
                <li>
                    <i class="fa fa-clock-o">
                    </i>
                </li>
            </ul>
        <?php else: ?>
            <?php echo Yii::t('backend', 'No fee/parent events found') ?>
        <?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<div class="row">	
	
    <div class="col-md-12 text-center">
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination'=>$dataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>
</div>
<?php \yii\widgets\Pjax::end() ?>

