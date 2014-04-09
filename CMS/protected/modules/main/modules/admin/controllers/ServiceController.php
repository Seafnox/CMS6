<?php

/**
 * Контроллер сервисных функций 
 */
class ServiceController extends  AdminController  {


    /**
     * Удаляет файл привязанный к модели
     * @param int $id идентификатор модели
     * @param string $cls класс модели
     * @param string $attr атрибут
     * @param string $value значение
     */
    public function actionRemoveFile($id, $cls, $attr, $value) {

        if (Yii::app()->getRequest()->isAjaxRequest) {

            $item = $cls::model()->findByPk($id);

            $files = explode("|", $item->$attr);

            foreach ($files AS $key => $file) {

                if ($file == $value) {

                    unset($files[$key]);

                    $filePath = $item->getSavePath($cls) . $file;

                    if (is_file($filePath))
                        unlink($filePath);
                }
            }

            $item->$attr = implode('|', $files);

            $item->save();
        }

        Yii::app()->end();
    }

    /**
     * Сортирует файлы привязанные к модели
     * @param int $id идентификатор модели
     * @param string $cls класс модели
     * @param string $attr атрибут
     * @param array $values значение
     */
    public function actionSortFile($id, $cls, $attr, array $values) {

        if (Yii::app()->getRequest()->isAjaxRequest) {

            $item = $cls::model()->findByPk($id);

            $item->$attr = implode('|', $values);

            $item->save();
        }

        Yii::app()->end();
    }


      
      /**
       * Загрузка файлов Redactor
       */
      
      public function actionUpload() {
          
          $uploader = new RedactorUploader(array('file'));
          
          $arr = array_shift( $uploader->upload() );
           
          $jarr = array("filelink" => $arr["rel_path"]);
                    
          echo stripslashes( json_encode($jarr) );
          
          Yii::app()->end();
          
          
      }


}
