<?
class ImagePng extends ImageResizer
{

    function createImg()
    {
        $this->img_res = imagecreatefrompng($this->source_path);
        $this->processBg($this->img_res);
    }

    function processBg($img)
    {

        imageAlphaBlending($img, false);

        imageSaveAlpha($img, true);

    }

}

?>