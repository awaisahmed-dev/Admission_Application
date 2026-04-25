<?php
/**
 * @var $this yii\web\View
 */
use backend\assets\BackendAsset;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\Pjax;
$bundle = BackendAsset::register($this);

$cookies = Yii::$app->request->cookies;
if (($cookie = $cookies->get('__school_id__')) !== null) {
    $schoolid = $cookie->value;
}
$defaultImage = !is_null($schoolid) ? '/img/'.$schoolid.'.png' : 'img/anonymous.jpg';
?>
<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <a href="<?php echo Yii::getAlias('@backendUrl');//Yii::getAlias('@frontendUrl') ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
				<!-- mini logo for sidebar mini 50x50 pixels -->
				  <span class="logo-mini"><b>C</b></span>
				  <!-- logo for regular state and mobile devices -->
				  <span class="logo-lg"><b><?php echo Yii::$app->name ?></b></span>
                
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation" id="navbar">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?php echo Yii::t('backend', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-static-top col-md-8 col-lg-6  col-md-push-0 col-xs-3  ">
                    <ul class="nav navbar-nav">
                        
                        <li id="dropdown" class="dropdown notifications-menu hidden-sm hidden-xs <?php if(Yii::$app->user->role == 'Parent') { echo "hidden";} ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-plus fa-4"> <strong> New </strong></i>
<!--                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>-->
                            </a>
                            <ul class="dropdown-menu">
                                <!--<li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num'=>\backend\models\SystemLog::find()->count()]) ?></li>-->
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach(Yii::$app->params['shortcut_add_options'] as $addShortCut): ?>
                                            <li>
                                                <a href="<?php echo Yii::$app->urlManager->createUrl([$addShortCut['url']]) ?>">
                                                    <i class="fa fa-plus text-success "></i>
                                                    <?php echo $addShortCut['title'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
								
<!--                                <li class="footer">
                                    <?php echo Html::a(Yii::t('backend', 'View all'), ['/log/index']) ?>
                                </li>-->
                            </ul>
                        </li>
                        <li id="dropdown" class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                 <i class="fa fa-tasks"><strong> Quick </strong></i>
<!--                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>-->
                            </a>
                            <ul class="dropdown-menu">
                                <!--<li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num'=>\backend\models\SystemLog::find()->count()]) ?></li>-->
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach(Yii::$app->params['shortcut_options'] as $addShortCut): ?>
                                            <li>
                                                <a href="<?php echo Yii::$app->urlManager->createUrl([$addShortCut['url']]) ?>">
                                                    <i class="fa fa-<?php echo $addShortCut['icon'] ?> text-success "></i>
                                                    <?php echo $addShortCut['title'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
<!--                                <li class="footer">
                                    <?php echo Html::a(Yii::t('backend', 'View all'), ['/log/index']) ?>
                                </li>-->
                            </ul>
                        </li>
						<li class="text-center hidden-sm hidden-xs">
						<small class="label pull-right label-info">New</small>
						<?php echo AutoComplete::widget([
            'name' => 'student',
            'clientOptions' => [
                'autoFill'=>true,
                'source' => ['USA', 'RUS', 'pakistan'],
                'minLength' => 3,
                
            

            ], 'options'=>['class'=>"form-control", 'id'=> "studentsearch", 
				'style'=>'width:420px; margin:8px;',
                'placeholder' => 'Search SID/Voucher ID or Student Name or Father Name '] ,
                
        ]);
		
		$this->registerJs(<<<JS
        $("#studentsearch").data("ui-autocomplete")._renderItem = function( ul, item ) { 
        return $( "<li style='margin:25px 5px 5px 15px; border-top: 1px solid grey; height:120px; '></li>" )
        .data( "ui-autocomplete-item", item )
        .append( createSearchResultLiContent(item))
        .appendTo( ul );
    };

    JS
);
 ?>
		</li>
<!--                        <li id="log-dropdown" class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"><strong> Quick </strong></i>
                            </a>
                        </li>-->
                    </ul>
                    
                </div>
                <div class="navbar-custom-menu col-lg-4 col-lg-push-0 col-md-5 col-xs-6">
                    <ul class="nav navbar-nav">
                        <li id="timeline-notifications" class="notifications-menu hidden-sm hidden-xs ">
                            <a href="<?php echo Url::to(['/timeline-event/index']) ?>">
                                <i class="fa fa-bell"></i>
                                <span class="label label-success">
                                    <?php echo TimelineEvent::find()->today()->count() ?>
                                </span>
                            </a>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li id="log-dropdown" class="dropdown notifications-menu hidden-sm hidden-xs hidden-md <?php if(Yii::$app->user->role == 'Parent') { echo "hidden";} ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num'=>\backend\models\SystemLog::find()->count()]) ?></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                            <li>
                                                <a href="<?php echo Yii::$app->urlManager->createUrl(['/log/view', 'id'=>$logEntry->id]) ?>">
                                                    <i class="fa fa-warning <?php echo $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                    <?php echo $logEntry->category ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <?php echo Html::a(Yii::t('backend', 'View all'), ['/log/index']) ?>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu ">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php //if(Yii::$app->user->identity->userProfile instanceof \webvimark\modules\UserManagement\models\UserProfile):
                                    //echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle,$defaultImage)) ;
                                    //endif;
                                ?>" class="user-image">
                                <span class="hidden-xs hidden-sm"><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header light-blue">
                                    <img src="<?php //if(Yii::$app->user->identity->userProfile instanceof \webvimark\modules\UserManagement\models\UserProfile)
                                        //echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, $defaultImage)) ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo Yii::$app->user->identity->username ?>
                                        <small>
                                            <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                        </small>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo Html::a(Yii::t('backend', 'Profile'), ['/user-management/user-profile/load?userid='.Yii::$app->user->id], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-left">
                                        <?php echo Html::a(Yii::t('backend', 'Account'), ['/user-management/auth/change-own-password'], ['class'=>'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo Html::a(Yii::t('backend', 'Logout'), ['/user-management/auth/logout'], ['class'=>'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="hidden-xs hidden-md">
                            <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/site/settings'])?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php 
                        //if(Yii::$app->user->identity->userProfile instanceof \webvimark\modules\UserManagement\models\UserProfile)
                        //echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, $defaultImage)) ?>" class="img-circle" />
                    </div>
                    <div class="pull-left info">
                        <p><?php echo Yii::t('backend', 'Hello, {username}', ['username'=>Yii::$app->user->username]) ?></p>
                        <a href="<?php echo Url::to(['/sign-in/profile']) ?>">
                            <i class="fa fa-circle text-success"></i>
                            <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                        </a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?php echo Menu::widget([
                    'options'=>['class'=>'sidebar-menu'],
                    'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
                    'submenuTemplate'=>"\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                    'activateParents'=>true,
                    'items'=>[
                        [
                            'label'=>Yii::t('backend', 'Main'),
                            'options' => ['class' => 'header']
                        ],
                        [
                            'label'=>Yii::t('backend', 'Dashboard'),
                            'icon'=>'<i class="fa fa-bar-chart-o"></i>',
                            'url'=>['/dashboard'],
//                            'badge'=> TimelineEvent::find()->today()->count(),
                            'badgeBgClass'=>'label-success',
                        ],
                        [
                            'label'=>Yii::t('backend', 'Timeline'),
                            'icon'=>'<i class="fa fa-bar-chart-o"></i>',
                            'url'=>['/timeline-event/index'],
                            'badge'=> TimelineEvent::find()->today()->count(),
                            'badgeBgClass'=>'label-success',
                        ],
                        [
                        'label' => 'Admission Application',
                        'icon'=>'<i class="fa fa-graduation-cap"></i>',
                        'url' => '#',
                        'items' => [
                        [
                        'label' => 'Admission',
                        'icon'=>'<i class="fa fa-file"></i>',
                        'url' => ['/admission/form/index'],
                        ],
                        [
                        'label' => 'Parents',
                        'icon'=>'<i class="fa fa-graduation-cap"></i>',
                        'url' => ['/admission/parent/index'],
                        ],
                        [
                        'label' => 'Students',
                        'icon'=>'<i class="fa fa-graduation-cap"></i>',
                        'url' => ['/admission/student/index'],
                        ],
                        ],
                        ],
                        [
                            'label'=>Yii::t('backend', 'Content'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-edit"></i>',
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                ['label'=>Yii::t('backend', 'Static pages'), 'url'=>['/page/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Articles'), 'url'=>['/article/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Article Categories'), 'url'=>['/article-category/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Text Widgets'), 'url'=>['/widget-text/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Menu Widgets'), 'url'=>['/widget-menu/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Carousel Widgets'), 'url'=>['/widget-carousel/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                            ],
                            'visible'=>Yii::$app->user->can('administrator')
                            
                        ],
                        [
                            'label'=>Yii::t('backend', 'Users'),
                            'icon'=>'<i class="fa fa-users"></i>',
                            'url'=>['/user/index'],
                            'visible'=>Yii::$app->user->can('administrator')
                        ],
                            
                        
                    [
                        'label'=>Yii::t('backend', 'System'),
                        'options' => ['class' => 'header']
                        ,
                            'visible'=>Yii::$app->user->can('administrator')
                    ],
                        
                        [
                            'label'=>Yii::t('backend', 'Other'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-cogs"></i>',
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                [
                                    'label'=>Yii::t('backend', 'i18n'),
                                    'url' => '#',
                                    'icon'=>'<i class="fa fa-flag"></i>',
                                    'options'=>['class'=>'treeview'],
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'i18n Source Message'), 'url'=>['/i18n/i18n-source-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                        ['label'=>Yii::t('backend', 'i18n Message'), 'url'=>['/i18n/i18n-message/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                    ]
                                ],
                                ['label'=>Yii::t('backend', 'Key-Value Storage'), 'url'=>['/key-storage/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'File Storage'), 'url'=>['/file-storage/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'Cache'), 'url'=>['/cache/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                ['label'=>Yii::t('backend', 'File Manager'), 'url'=>['/file-manager/index'], 'icon'=>'<i class="fa fa-angle-double-right"></i>'],
                                [
                                    'label'=>Yii::t('backend', 'System Information'),
                                    'url'=>['/system-information/index'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>'
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Logs'),
                                    'url'=>['/log/index'],
                                    'icon'=>'<i class="fa fa-angle-double-right"></i>',
                                    'badge'=>\backend\models\SystemLog::find()->count(),
                                    'badgeBgClass'=>'label-danger',
                                ],
                            ],
                            'visible'=>Yii::$app->user->can('administrator')

                        ],
                        [
                            'label'=>Yii::t('backend', 'User'),
                            'url' => '#',
                            'icon'=>'<i class="fa fa-user"></i>',
                            'options'=>['class'=>'treeview'],
                            'items'=>[
                                ['label'=>Yii::t('backend', 'All'), 'url'=>['/user-management/user']],
                                ],
                            
                        ],
                        
                    ]
                ]) ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $this->title ?>
                    <?php if (isset($this->params['subtitle'])): ?>
                        <small><?php echo $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h1>

                <?php echo Breadcrumbs::widget([
                    'tag'=>'ol',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if ( Yii::$app->session->hasFlash('success') ): ?>
	<div class="alert alert-success text-center">
		<?= Yii::$app->session->getFlash('success') ?>
	</div>
    <?php endif;
        if ( Yii::$app->session->hasFlash('info') ): ?> 
        <div class="alert alert-info text-center">
		<?= Yii::$app->session->getFlash('info') ?>
	</div>
    <?php endif; 
        if ( Yii::$app->session->hasFlash('warning') ): ?> 
        <div class="alert alert-warning text-center">
		<?= Yii::$app->session->getFlash('warning') ?>
	</div>
    <?php endif; 
        if ( Yii::$app->session->hasFlash('danger') ): ?> 
        <div class="alert alert-danger text-center">
		<?= Yii::$app->session->getFlash('danger') ?>
	</div>
    <?php endif; ?>
                <?php echo $content ?>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

<?php $this->endContent(); ?>