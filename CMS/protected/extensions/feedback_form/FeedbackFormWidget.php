<?php

/**
 * Class FeedbackFormWidget виджет формы обратной связи открывающейся в диалоге
 */

class FeedbackFormWidget extends CWidget {

    /**
     * @var string идентификатор формы
     */

    protected $form_id;

    /**
     * @var string url для отправки данных
     */

    public $action;

    /**
     * @var string селектор по клоторому будет повешен обработчик на открытие диалога
     */

    public $selector;

    /**
     * @var string title диалога
     */

    public $title = "Отправить сообщение";

    /**
     * @var int ширина диалога
     */

    public $width = 550;

    /**
     * @var int высота диалога
     */

    public $height = 550;

    public function init() {

        $this->form_id = "form_".spl_object_hash($this);

        Yii::setPathOfAlias("feedback-form", __DIR__);

        Yii::import("feedback-form.models.*");

    }


    public function run() {

        $model = new FeedbackForm();

        if(!Yii::app()->user->isGuest)
            $model->user_id = Yii::app()->user->id;

        $cs = Yii::app()->clientScript;

        $js = "

            $('#FeedbackForm_code').val('".$model->_code."');

        ";

        if(!empty($this->selector)) {

            $js .= "

                $('".$this->selector."').on('click', function(e){

                    $('#".$this->form_id."_dialog').dialog('open');

                    e.preventDefault();

                });

            ";

        }

        $cs->registerScript("js_".$this->form_id, $js, CClientScript::POS_LOAD);

        $this->render("index", array("model"=>$model, "action"=>$this->action, "form_id"=>$this->form_id, "title"=>$this->title, "width"=>$this->width, "height"=>$this->height));

    }


}

?>