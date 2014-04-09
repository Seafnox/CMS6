<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>      
        
        <meta charset="UTF-8" />

        <?php Yii::app()->bootstrap->register(); ?>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" rel="stylesheet" />
        
    </head>
    <body>

          
        
     <?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'fixed'=>false,
    'type'=>'inverse',
    'brand'=>'RzWebSys6',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
				array('label'=>'Главная', 'url'=>'/'),
                                array('label'=>'Личный кабинет', 'url'=>array('/admin/')),
			),
        ),
        
    ),
)); ?>   
        
        
    <div class="container-fluid">
      <div class="row">
        
                
 <?php echo $content; ?>
            
            
    
      
      </div><!--/row-->

        <hr>

        <footer>
            <p>&copy; RIC 2012</p>
        </footer>

    </div><!--/.container-->


   </body>
</html>
