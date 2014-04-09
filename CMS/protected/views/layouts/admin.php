<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php Yii::app()->bootstrap->register(); ?>

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" rel="stylesheet"/>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/functions.js"></script>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin.js"></script>

    <?php

    // Подключаем фотогаллерею fancybox

    $this->widget('ext.fancybox.EFancyboxWidget', array(
        // Селектор фото
        //'selector'=>'a[href$=\'.jpg\'],a[href$=\'.png\'],a[href$=\'.gif\']',
        // Включаем колесико мыши для перематывания картинок в пределах группы.
        // По умолчанию выключено.
        'enableMouseWheel' => true,
        // [Свойства fancybox](http://fancybox.net/api/).
        'options' => array( // 'padding'=>10,
            // 'margin'=>20,
            // 'enableEscapeButton'=>true,
            // 'onComplete'=>'js:function() {$("#fancybox-wrap").hover(function() {$("#fancybox-title").show();}, function() {$("#fancybox-title").hide();});}',
        ),
    ));
    ?>
</head>
<body>


<?php

$items = array();

$items[] = array('label' => 'Сайт', 'url' => '/');
$items[] = array('label' => Yii::t('app', 'Profile'), 'url' => array('/main/admin/users/view/', 'id' => Yii::app()->user->id));
$items[] = array('label' => Yii::t('app', 'Login'), 'url' => array('/login'), 'visible' => Yii::app()->user->isGuest);
$items[] = array('label' => Yii::t('app', 'Logout') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest);


$this->widget('bootstrap.widgets.TbNavbar', array(
    'type' => 'inverse',
    'fixed' => false,
    'brand' => 'RzWebSys 6',
    'brandUrl' => '/admin/',
    'collapse' => true, // requires bootstrap-responsive.css
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $items,
        ),

    ),
)); ?>


<div class="container-fluid">
    <div class="row-fluid">


        <div class="span3">

            <?php $this->widget('bootstrap.widgets.TbMenu', array(
                'type' => 'tabs',
                'stacked' => true, // whether this is a stacked menu'
                'items' => $this->getLeftMenuArray()
            ));
            ?>


            <?php $box = $this->beginWidget(
                'bootstrap.widgets.TbBox',
                array(
                    'title' => Yii::t('app', 'Sections'),

                )
            );?>

            <?php $this->renderPartial('application.modules.main.modules.admin.views.treesections.tree'); ?>


            <?php $this->endWidget() ?>


            <?php if (!empty($this->iblocks_menu)): ?>

                <?php $box = $this->beginWidget(
                    'bootstrap.widgets.TbBox',
                    array(
                        'title' => Yii::t('app', 'Iblocks'),

                    )
                );?>


                <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>

                <? for ($i = 0; $i < count($this->iblocks_menu); $i++): ?>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse"
                               data-parent="#accordion2" href="#collapse<?= $i ?>">
                                <?= $this->iblocks_menu[$i]["title"] ?>
                            </a>
                        </div>
                        <div id="collapse<?= $i ?>"
                             class="accordion-body collapse <? if ($this->iblocks_menu[$i]["opend"]): ?>in<? endif ?>">
                            <div class="accordion-inner">
                                <?php $this->widget('bootstrap.widgets.TbMenu', array(
                                    'type' => 'list',
                                    'items' => $this->iblocks_menu[$i]["items"]
                                )); ?>
                            </div>
                        </div>
                    </div>

                <? endfor; ?>

                <?php $this->endWidget(); ?>





                <?php $this->endWidget() ?>


            <? endif; ?>


        </div>
        <!--/span-->


        <div class="span9">


            <?php if (isset($this->breadcrumbs)): ?>
                <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
                        'homeLink'=>CHtml::link(Yii::t('app', 'Start'), Yii::app()->getUrlManager()->createUrl('admin')),
		)); ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php
            if (!empty($this->menu)):
                $this->widget('bootstrap.widgets.TbMenu', array(
                        'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
                        'stacked' => false, // whether this is a stacked menu
                        'items' => $this->menu
                    )
                );
            endif;
            ?>

            <?php echo $content; ?>


        </div>
        <!--/span-->

    </div>
    <!--/row-->


    <hr style="clear: both;"/>

    <footer>
        <p>&copy; RIC <?= date("Y") ?> <a href="#" class="send_error">Сообщить об ошибке</a></p>
    </footer>

</div>
<!--/.fluid-container-->



<?php

// Сообщить об ошибке

Yii::app()->clientScript->registerScript("error_mailer_open", "
 
                $('.send_error').click(function() { $('#errordialog').dialog('open'); return false; } );

        ");


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'errordialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Сообщить об ошибке ',
        'autoOpen' => false,
        'width' => 550,
        'height' => 550,
    ),

)); ?>


<?
$this->renderPartial('application.views.mailer.error', array("model" => new ErrorForm()));
?>


<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

</body>
</html>
