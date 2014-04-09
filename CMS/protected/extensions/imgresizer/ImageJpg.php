<?
class ImageJpg extends ImageResizer
{

    function createImg()
    {
        $this->img_res = imagecreatefromjpeg($this->source_path);
    }

}

?>