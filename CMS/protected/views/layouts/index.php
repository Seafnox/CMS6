<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php Yii::app()->bootstrap->register(); ?>


    <?php

    // Подключаем фотогаллерею fancybox

    $this->widget('ext.fancybox.EFancyboxWidget',array(
        // Селектор фото
        //'selector'=>'a[href$=\'.jpg\'],a[href$=\'.png\'],a[href$=\'.gif\']',
        // Включаем колесико мыши для перематывания картинок в пределах группы.
        // По умолчанию выключено.
        'enableMouseWheel'=>true,
        // [Свойства fancybox](http://fancybox.net/api/).
        'options'=>array(
            // 'padding'=>10,
            // 'margin'=>20,
            // 'enableEscapeButton'=>true,
            // 'onComplete'=>'js:function() {$("#fancybox-wrap").hover(function() {$("#fancybox-title").show();}, function() {$("#fancybox-title").hide();});}',
        ),
    ));

    ?>
</head>
<body>


<div class="container" style="margin: 0 auto;">


    <h3 class="muted">RzWebSys6 - демо сайт</h3>
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">

                <?
                    $this->widget("application.modules.main.components.menu.MenuWidget", array("code"=>"main", "level"=>1, "htmlOptions"=>array("class"=>"nav")));
                ?>

            </div>
        </div>
    </div><!-- /.navbar -->



    <div class="row-fluid">


        <div class="span3">

        <?php $this->widget('IncludeAreaWidget', array(
	    'code'=>'leftcol',
	    'cond_type'=>'0',
	    'cond'=>'',
	    'recursive'=>false,
        ));
        ?>

      <p>

       <a class="btn btn-large btn-info feedback" style="width: 180px" href="#">Обратная cвязь</a>

          </p>

            <p>

       <a class="btn btn-large btn-success" style="width: 180px" href="/admin/">Войти в админку</a>

            </p>

        </div>
        <!--/span-->


        <div class="span9">



            <?php echo $content; ?>


        </div>
        <!--/span-->

    </div>
    <!--/row-->


    <hr style="clear: both;"/>

    <footer>
        <p>&copy; RIC <?= date("Y") ?> </p>
    </footer>

</div>
<!--/.fluid-container-->

<?$this->widget("ext.feedback_form.FeedbackFormWidget", array("selector"=>".feedback", "action"=>"/mailer/feedback/"));?>

</body>
</html>
