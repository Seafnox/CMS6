<?

/**
 * Класс ресайза, кропа и наложения изображений. Поддерживаемые форматы: jpeg, gif, png
 */
/*
 * Пример клиентского кода:
 * $imp = libs_img_main::getInstance('test.png')->resize(200); 
 * libs_img_main::getInstance('test.jpg')->resize(300)->impositionImg($imp, "top", "right")->outImg()->saveImg("new.jpg");
 */

abstract class ImageResizer
{

    protected $source_path; // Путь до исходного изображения
    protected $img_res; // Изображение
    protected $width; // Ширина
    protected $height; // Высота
    protected $type; // Тип
    protected $filetime; // Последнее изменение

    static function getInstance($source_path)
    { // Создает объект изображения
        if (!is_file($source_path) OR filesize($source_path) == 0 OR !self::isImg(end(explode(".", $source_path)))) { // Проверка что файл существует и является изображением
            return false;
        }
        $info = getimagesize($source_path); // Информация об исходном изображении
        $type = substr(strrchr($info['mime'], '/'), 1);
        switch ($type) {
            case "jpeg":
            {
                $obj = new ImageJpg($source_path);
                break;
            }
            case "gif":
            {
                $obj = new ImageGif($source_path);
                break;
            }
            case "png":
            {
                $obj = new ImagePng($source_path);
                break;
            }
            default:
                return false;
        }
        return $obj;
    }

    /**
     * Проверяет является ли файл изображением
     * @param string $ext расширение файла
     * @return boolean
     */
    static function isImg($ext)
    {

        $ext = strtolower($ext);

        $imgs = array("jpg", "jpeg", "gif", "png");

        if (in_array($ext, $imgs))
            return true;

        return false;
    }

    /**
     * Путь до закешированного изображения
     */
    static function getThumbUrl($img_path, $width, $height, $crop)
    {

        $filetime = filectime($img_path);

        $md5 = md5($img_path . $filetime . $width . $height . $crop);

        $ext = end(explode(".", $img_path));

        $thumb_url = Yii::getPathOfAlias(Yii::app()->params["cacheThumbAlias"]) . DIRECTORY_SEPARATOR . $md5 . "." . $ext;

        return $thumb_url;
    }

// Запуск ресайза

    static function r($img_path, $width = 0, $height = 0, $crop = 0)
    {

        if (!is_file($img_path))
            return;

        $thumb_url = self::getThumbUrl($img_path, $width, $height, $crop);

        if (!file_exists($thumb_url)) {

// Ресайзим и сохраняем в кэш

            $img = self::getInstance($img_path);

            if (!$img)
                return false;

            $img->resize($width, $height, $crop);

            $img->saveImg($thumb_url);
        }

        return str_replace(Yii::getPathOfAlias('webroot'), '', $thumb_url);
    }


    // Запуск умного ресайза. Если фото альбомное выбираются первые переданные размеры, если книжные, то вторые

    static function ri($img_path, $arrWidth = array(), $arrHeight = array(), $crop = 0)
    {

        if (!is_file($img_path))
            return;

        $width_str = var_export($arrWidth, true);

        $height_str = var_export($arrHeight, true);

        $thumb_url = self::getThumbUrl($img_path, $width_str, $height_str, $crop);

        if (!file_exists($thumb_url)) {

            // Ресайзим и сохраняем в кэш

            $img = self::getInstance($img_path);

            $key = ($img->isAlbum()) ? 0 : 1;

            $width = $arrWidth[$key];

            $height = $arrHeight[$key];

            if (!$img)
                return false;

            $img->resize($width, $height, $crop);

            $img->saveImg($thumb_url);
        }

        return str_replace(Yii::getPathOfAlias('webroot'), '', $thumb_url);
    }

    private function __construct($source_path)
    {

        $this->source_path = $source_path;

        $info = getimagesize($this->source_path); // Размер исходного изображения

        $this->width = $info[0];

        $this->height = $info[1];

        $this->type = substr(strrchr($info['mime'], '/'), 1);

        $this->filetime = filectime($this->source_path);

        $this->createImg();
    }

    function __destruct()
    {
        imagedestroy($this->img_res);
    }

    abstract function createImg();

    function resize($dest_width, $dest_height = 0, $crop = 0)
    {

        if ($dest_width == 0 AND $dest_height == 0) {
            return $this;
        }

        if ($dest_width == 0) { //Если необходимая ширина = 0 ресайзим пропорционально
            $k = $this->width / $this->height;
            $dest_width = $k * $dest_height;
            $crop = 0;
        }

        if ($dest_height == 0) { //Если необходимая высота = 0 ресайзим пропорционально
            $k = $this->height / $this->width;
            $dest_height = $k * $dest_width;
            $crop = 0;
        }

        $tmp_res = imagecreatetruecolor($dest_width, $dest_height);

        $this->processBg($tmp_res);

// Кроп

        if ($crop == 1) {
            $prop = $dest_width / $dest_height; // Пропорция до которой кропим                                 
            $this->crop($prop);
        }

// Кроп конец

        imagecopyresampled($tmp_res, $this->img_res, 0, 0, 0, 0, $dest_width, $dest_height, $this->width, $this->height);

        $this->img_res = $tmp_res;

// Переопределяем размеры

        $this->width = imagesx($this->img_res);

        $this->height = imagesy($this->img_res);

        return $this;
    }

    function processBg($img)
    {

    }

    function crop($prop)
    { // Кроп до пропорции

// Вычисляем область кропа

        $crop_height = $this->width / $prop;
        if ($crop_height > $this->height) {
            $crop_width = $this->height * $prop;
        }
        if (isset($crop_width)) {
            $crop_height = $crop_width / $prop;
        } else {
            $crop_width = $crop_height * $prop;
        }
        $crop_width = intval($crop_width);
        $crop_height = intval($crop_height);
        $x = ($this->width - $crop_width) / 2;
        $y = ($this->height - $crop_height) / 2;

// Кропим

        $crop_img = imagecreatetruecolor($crop_width, $crop_height);

        $this->processBg($crop_img);

        imagecopy($crop_img, $this->img_res, 0, 0, $x, $y, $crop_width, $crop_height);

        $this->img_res = $crop_img;

// Переопределяем размеры

        $this->width = imagesx($this->img_res);

        $this->height = imagesy($this->img_res);

        return $this;
    }

    function outImg()
    { // Вывод изображения в браузер

        header('Content-type: image/' . $this->type);

        $function = "image" . $this->type;

        $function($this->img_res);

        return $this;
    }

    function saveImg($path = "")
    { // Сохранение изображения

        if (empty($path)) {
            chmod($this->source_path, 0777);
            unlink($this->source_path);
            $path = $this->source_path;
        }

        $function = "image" . $this->type;

        if ($function == "imagejpeg") {
            $function($this->img_res, $path, 90);
        } else {
            $function($this->img_res, $path);
        }

        return $this;
    }

    function get($par)
    { // Доступ к свойствам
        if (!isset($this->$par)) {
            return null;
        } else {
            return $this->$par;
        }
    }

    function impositionImg($obj, $y, $x)
    { // Наложение изображения

        $impImg = $obj->get("img_res");
        $impWidth = $obj->get("width");
        $impHeight = $obj->get("height");

// Вычисление положения накладываемого изображения

        switch ($y) {
            case "top":
            {
                $y = 0;
                break;
            }
            case "bottom":
            {
                $y = $this->height - $impHeight;
                break;
            }
            case "center":
            {
                $y = ($this->height - $impHeight) / 2;
                break;
            }
            default:
                $y = 0;
        }


        switch ($x) {
            case "left":
            {
                $x = 0;
                break;
            }
            case "right":
            {
                $x = $this->width - $impWidth;
                break;
            }
            case "center":
            {
                $x = ($this->width - $impWidth) / 2;
                break;
            }
            default:
                $x = 0;
        }

        imagecopy($this->img_res, $impImg, $x, $y, 0, 0, $impWidth, $impHeight);

        return $this;
    }

    /**
     * Альбомная фотка
     * @return boolen
     */

    public function isAlbum()
    {

        return ($this->width > $this->height) ? true : false;

    }


    public function getWidth()
    {

        return $this->width;
    }

    public function getHeight()
    {

        return $this->height;
    }

    public function getType()
    {

        return $this->type;
    }

    public function getFileTime()
    {

        return $this->filetime;
    }

}

?>