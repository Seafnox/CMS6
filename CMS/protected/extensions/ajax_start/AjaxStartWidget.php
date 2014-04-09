<?php

/**
 * Class AjaxStartWidget Класс виджета для запуска действий через ajax с отображением процесса выполнения на прогресс баре.
 * Ответ действия должен быть в формате JSON: {"page": 1, "pagesNum": 10} В случае ошибок ответ должен выглядеть:  {"page": 1, "pagesNum": 10, "errors": ["error1", "error2"]}
 */

class AjaxStartWidget extends CWidget
{

    public $label = "Start action";

    public $url = '';

    public $callback;

    protected $buttonId;

    protected $progressId;

    protected $labelId;

    public function init()
    {

        $cs = Yii::app()->clientScript;

        $cs->registerScriptFile(CHtml::asset(__DIR__ . "/assets/starter.js"));

        $id = md5(uniqid(rand(), true));

        $this->buttonId = "button_" . $id;

        $this->progressId = "progress_" . $id;

        $this->labelId = "label_" . $id;

        $cs->registerScript($id, '$("#' . $this->buttonId . '").on("click", function(){

            var btn = $(this);

            if(btn.attr("disabled") == "disabled")
                return;

            btn.attr("disabled", "disabled");

            $("#' . $this->progressId . ' .bar").css("width", "0%");

            $("#' . $this->labelId . '").removeClass("alert-error alert-success").html("").hide("fast");

            var starter = new AjaxStarter("' . $this->url . '", function(){

                if(this.errors) {

                    $("#' . $this->progressId . ' .bar").css("width", 0+"%");

                    btn.attr("disabled", false);

                    $.each(this.errors, function(k,v){

                        var div = $("<div>"+v+"</div>");

                        $("#' . $this->labelId . '").append(div);

                    });

                    $("#' . $this->labelId . '").addClass("alert-error").show("fast");


                    return;
                }


                $("#' . $this->progressId . ' .bar").css("width", this.procents+"%");

                if(this.procents == 100) {
                     $("#' . $this->labelId . '").addClass("alert-success").html("OK").show("fast");
                     btn.attr("disabled", false);
                }



            });

            starter.request();


        })', CClientScript::POS_END);


        parent::init();

    }


    public function run()
    {


        $this->render('starter', array(

            "label" => $this->label,

            "buttonId" => $this->buttonId,

            "progressId" => $this->progressId,

            "labelId" => $this->labelId,

        ));


    }


}
