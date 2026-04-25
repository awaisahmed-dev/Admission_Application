<?php
use backend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\assets\NiftyAssets;
/* @var $this \yii\web\View */
/* @var $content string */

$bundle = BackendAsset::register($this);

$this->params['body-class'] = array_key_exists('body-class', $this->params) ?
    $this->params['body-class']
    : null;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
        <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#00A65A">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#00A65A">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#00A65A">

    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php if(Yii::$app->homeUrl != 'http://backend.school-management.local' and Yii::$app->homeUrl != 'https://backend.school-management.local'):?>
    <?php // echo  Yii::$app->homeUrl; ?>
    	
		
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-5H73NHRSQC"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-5H73NHRSQC');
		</script>

<?php endif;?>

</head>
<?php echo Html::beginTag('body', [
    'class' => implode(' ', [
        ArrayHelper::getValue($this->params, 'body-class'),
        Yii::$app->keyStorage->get('backend.theme-skin', 'skin-blue'),
        Yii::$app->keyStorage->get('backend.layout-fixed') ? 'fixed' : null,
        Yii::$app->keyStorage->get('backend.layout-boxed') ? 'layout-boxed' : null,
        Yii::$app->keyStorage->get('backend.layout-collapsed-sidebar') ? ' sidebar-collapse sidebar-mini' : null,
    ])
])?>
    <?php $this->beginBody() ?>
    
        <?php echo $content ?>
        <div id="loader"></div>
    <?php $this->endBody() ?>


<?php echo Html::endTag('body') ?>
</html>
<?php $this->endPage() ?>