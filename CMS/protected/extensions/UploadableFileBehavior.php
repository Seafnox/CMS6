<?php

/**
 * Поведение позволяющее загрущать файлы на сервер 
 */
class UploadableFileBehavior extends CActiveRecordBehavior {

    /**
     * @var string название атрибута, хранящего в себе имя файла и файл
     */
    public $attributeName = 'image';

    /**
     * Возвращает путь к директории,
     * в которой будут сохраняться файлы.
     * @return string путь к директории, в которой сохраняем файлы
     */
    public function getSavePath() {
        
        $class = get_class($this->owner);
        
        return Yii::getPathOfAlias(Yii::app()->params["savePathAlias"]) . DIRECTORY_SEPARATOR . strtolower($class) . DIRECTORY_SEPARATOR;
    }

 
    /**
     * Возвращает путь к изображению для публикации на страничке
     * @return type 
     */
    
    public function getRelPath() {
        
        $class = get_class($this->owner);
        
        $url = Yii::getPathOfAlias(Yii::app()->params["savePathAlias"]) . DIRECTORY_SEPARATOR . strtolower($class) . DIRECTORY_SEPARATOR;
        
        return str_replace(Yii::getPathOfAlias('webroot'), '', $url);
    }

    
    /**
     * Проверяет существование папки для сохранения файлов модели. Если ее нет, то создает 
     * @param string $class имя класса модели 
     */
    
    protected function checkModelFolder($class) {
        
        $class = strtolower($class);
        
        $path = $this->getSavePath($class);
        
        if(is_dir($path)) return;
     
         mkdir($path, 0777); 
        
    }
    
   
    
    
    public function beforeSave($event) {


        $attr = $this->attributeName;

        $class = get_class($this->owner);

        $this->checkModelFolder($class);
        
        $files = CUploadedFile::getInstancesByName(get_class($this->owner) . '[' . $this->attributeName . ']');

        if (!empty($files)) {


            $this->owner->$attr = !empty($this->owner->$attr)?explode("|", $this->owner->$attr):array();

            $i = 0;

            $file_names = array();

            foreach ($files As $file) {
                
                $file_size = ($file->getSize()/1024)/1024; // Размер файла в мегабайтах
                              
                if( (double) $file_size > (double) Yii::app()->params['maxFileSize']) throw new AppException("Размер загружаемого файла не может превыщать ".Yii::app()->params['maxFileSize']." MB");

                $fp = explode(".", $file->getName());

                $ext = array_pop($fp);

                $file_name = implode(".", $fp);

                $file_name = Translit::t($file_name);

                $i = 0;

                $new_file_name = $file_name;
                
                while (file_exists($this->getSavePath($class) . $new_file_name . "." . $ext)) {

                    $i++;

                    $new_file_name = $file_name . "_" . $i;
                }

                $file_names[] = $new_file_name . "." . $ext;

                $save_path = $this->getSavePath($class) . $new_file_name . "." . $ext;
                
                $file->saveAs($save_path);

                chmod($save_path, 0777);
                
                // Если загружаемый файл изображение
                
                if(ImageResizer::isImg($ext)) {
                    
                    $this->processImg($save_path);
                    
                }
                
                $i++;
            }

           
            $file_names = array_merge($this->owner->$attr, $file_names);
            
            $this->owner->setAttribute($this->attributeName, $file_names);

            $this->owner->$attr = implode("|", $this->owner->$attr);
            
            
        }
        parent::beforeSave($event);
        return true;
    }

   
    
    public function beforeDelete($event) {
        $this->deleteFiles(); // удалили модель? удаляем и файл от неё
        parent::beforeDelete($event);
        return true;
    }

    /**
     * Удаление файлов связанных с моделью 
     */
    public function deleteFiles($attr = null) {

        if(empty($attr)) {
            $attr = $this->attributeName;
        }

        $files = explode("|", $this->owner->getAttribute($attr));

        foreach ($files AS $file) {

            $filePath = $this->getSavePath(get_class($this->owner)) . $file;

            if (is_file($filePath))
                unlink($filePath);
        }

        $this->owner->$attr = null;

    }
    
    /**
     * Путь до первого файла
     */
    
    public function getFirstFilePath($attr = null) {
            if(empty($attr)) {
                $attr = $this->attributeName;
            }
            return $this->getSavePath().current(explode("|", $this->owner->$attr));    
     } 
   
     /**
      * Путь до первого файла от document root
      * @return type 
      */
     
     public function getFirstFileRelPath($attr = null) {
         if(empty($attr)) {
                $attr = $this->attributeName;
         }      
         return str_replace( Yii::getPathOfAlias('webroot'), '', $this->getSavePath().current(explode("|", $this->owner->$attr)) );    
    }
    
    /**
     * Возвращает массив имен файлов
     * @param string $attr
     * @return array 
     */
    
    public function getFileNames($attr = null) {
        
        if(empty($attr)) {
                $attr = $this->attributeName;
         } 
        
         if(empty($this->owner->$attr)) {
             return array();
         }
         
         $arr = explode("|", $this->owner->$attr);
         
         return $arr;
         
    }

    /**
     * Возвращает количество файлов
     * @param string $attr
     * @return array
     */

    public function countFiles($attr = null) {

        if(empty($attr)) {
            $attr = $this->attributeName;
        }

        if(empty($this->owner->$attr)) {
            return 0;
        }

        $arr = explode("|", $this->owner->$attr);

        return count($arr);

    }
    
    
    /**
     * Обработка изображения
     * @param string $save_path путь до файла 
     */      
     
    protected function processImg($save_path) {
     
        
        $img = ImageResizer::getInstance($save_path);
        
        if(!$img) return false;
        
        $resize = false;
        
        if( $img->getWidth() > Yii::app()->params['maxImgWidth'] ) {
            
         $img->resize( Yii::app()->params['maxImgWidth'] );
         
         $resize = true; 
            
        }
        
        if( $img->getHeight() > Yii::app()->params['maxImgHeight'] ) {
            
         $img->resize( 0, Yii::app()->params['maxImgHeight'] );   
         
         $resize = true;
         
        }
        
        if($resize) $img->saveImg();
        
    } 
     

}

?>
