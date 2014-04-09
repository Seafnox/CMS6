<?php

// Загрузчик изображения для RedactorJs

class RedactorUploader extends CComponent
{

    /**
     * Массив имен файлов для загрузки
     * @var array
     */

    protected $fnames = array();

    /**
     * Массив разрешенных к загрузке mime типов
     * @var array
     */

    protected $allowed = array('png', 'jpg', 'gif', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip', 'rar', 'pdf', 'odt');

    /**
     * Массив содержащий информацию о загруженных файлов
     * @var array
     */

    protected $u_files = array();

    /**
     * Конструктор
     * @param array $fnames массив имен файлов для загрузки
     */

    public function __construct($fnames)
    {

        $this->fnames = $fnames;

    }

    /**
     * Загружает файлы
     * @return array массив путей до загруженных файлов
     */

    public function upload()
    {

        foreach ($this->fnames AS $fname) {

            $this->uploadByName($fname);

        }

        return $this->u_files;

    }

    /**
     * Загружает файлы по имени
     * @param string $name имя файла
     * @throws AppException
     */

    protected function uploadByName($name)
    {

        $files = CUploadedFile::getInstancesByName($name);

        foreach ($files AS $file) {

            $file_size = ($file->getSize() / 1024) / 1024; // Размер файла в мегабайтах

            if ((double)$file_size > (double)Yii::app()->params['maxFileSize'])
                throw new AppException("Размер загружаемого файла не может превыщать " . Yii::app()->params['maxFileSize'] . " MB");

            // Определяем имя файла

            $fp = explode(".", $file->getName());

            $ext = array_pop($fp);

            if (!in_array(strtolower($ext), $this->allowed))
                throw new AppException("Данный тип файлов запрещен к загрузке");

            $file_name = implode(".", $fp);

            $file_name = Translit::t($file_name);

            $i = 0;

            $new_file_name = $file_name;

            while (file_exists($this->getSavePath() . $new_file_name . "." . $ext)) {

                $i++;

                $new_file_name = $file_name . "_" . $i;
            }

            $full_name = $new_file_name . "." . $ext;

            $save_path = $this->getSavePath() . $full_name;

            $rel_path = $this->getRelPath() . $full_name;

            $this->u_files[] = array("name" => $full_name, "save_path" => $save_path, "rel_path" => $rel_path);

            $file->saveAs($save_path); // Сохраняем

            chmod($save_path, 0777);
        }
    }

    /**
     * Возвращает путь к директории,
     * в которой будут сохраняться файлы.
     * @return string путь к директории, в которой сохраняем файлы
     */
    public function getSavePath()
    {

        return Yii::getPathOfAlias(Yii::app()->params["savePathRedactorAlias"]) . DIRECTORY_SEPARATOR;
    }


    /**
     * Возвращает путь к директории в которой сохраняются файлы, относительно webroot
     * @return string
     */

    public function getRelPath()
    {


        $url = $this->getSavePath();

        return str_replace(Yii::getPathOfAlias('webroot'), '', $url);
    }

}

?>