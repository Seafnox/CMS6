<?php

class MailerController extends CController {
    

    /**
     *Отправка уведомления об ошибках 
     */
    
    public function actionError() {
        
        $model=new ErrorForm;
        
        $class = get_class($model);

        // Валидация
	
        if(isset($_POST['ajax']) && $_POST['ajax']==='error-form')
	    {
			echo CActiveForm::validate($model);
			Yii::app()->end();
	    }
        
        
        // Отправлен запрос на отправку формы
        
        if(isset($_POST[$class])) {
        
          $model->attributes=$_POST[$class];
			
          echo  $this->processMessage($model, 'Сообщение об ошибке', $this->getLetterMessage($model, '_error_letter'), Yii::app()->userconfig->get('adminEmail'));
                     
        }
        
      Yii::app()->end();
                
        
    }
    

    
    /**
     * Обратная связь
     */
    
    public function actionFeedback() {

        Yii::import("ext.feedback_form.models.*");

        $model=new FeedbackForm();

        $class = get_class($model);

        // Валидация

        if(isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // Отправлен запрос на отправку формы

        if(isset($_POST[$class])) {

            $model->attributes=$_POST[$class];


            echo  $this->processMessage($model, 'Обратная связей', $this->getLetterMessage($model, 'ext.feedback_form.views._letter'),  Yii::app()->userconfig->get('adminEmail'));

        }

        Yii::app()->end();
                
        
    }

    
    /**
     * Формирование шаблона письма
     * @param CFormModel $model модель формы
     * @param string $letter_tpl имя шаблона письма
     * @return string 
     */
    
  protected function getLetterMessage($model, $letter_tpl) {
  
      return $this->renderPartial($letter_tpl, array("model"=>$model), true);
      
  }  
  
  /**
   * Обработка отправки сообщения
   * @param CFormModel $model
   * @param string $theme тема письма
   * @param string $subject тело письма
   * @param string $email адрес получателя
   * @return string результат отправки в json формате
   */
  
  
  protected function processMessage($model, $theme, $subject, $email) {
      
        if($model->validate()) {
                
            $res = Yii::app()->mailer->mail($theme, $subject, $email );
                    
            if($res) {
                
                $mess = Yii::t('app', 'Mail transfered');
                
                $status = 1;
            
            }
            else {
                
                $mess = Yii::t('app', 'Mail transfer error');
                
                $status = 0;
            }
            
            
            }
            else
            {
                $mess = Yii::t('app', 'Mail transfer error');
                $status = 0;
            }
            
            
          return json_encode( array("status"=>$status, "mess"=>$mess) ); 
      
      
  }
    
    
}


?>

