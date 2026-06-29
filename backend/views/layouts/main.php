<?php
/**
 * @var $this yii\web\View
 */
?>
<?php $this->beginContent('@backend/views/layouts/common.php'); ?>
    <div class="box">
        <div class="box-body">
            <?php echo $content ?>
        </div>
    </div>

    <?php if (Yii::$app->session->hasFlash('browserNotification')):

        $notification = Yii::$app->session->getFlash('browserNotification');
            
        $this->registerJs("console.log('Notification JS Started');
            if(Notification.permission === 'granted'){
                var title = ".json_encode($notification['title']).";
                var body = ".json_encode($notification['body']).";
                console.log(body);    console.log(body);
                new Notification(title,{        body:body    });
            }");
        endif;
        ?>

<?php $this->endContent(); ?>

