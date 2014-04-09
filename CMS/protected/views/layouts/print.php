<?php
/*
 * Шаблон для  печати
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $this->metatitle; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/rpn/reset.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/rpn/print.css" rel="stylesheet" type="text/css" />

      
    </head>

    <body>
        
        <div id="wrapper">
           <?php echo $content; ?>
        
            <hr />
            <p style="text-align: right;"><a href="#" onClick="window.print(); return false;">распечатать</a></p>
        
        </div>
        
    </body>


</html>
