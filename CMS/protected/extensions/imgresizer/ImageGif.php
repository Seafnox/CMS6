<?

class ImageGif extends ImageResizer
{

    function createImg()
    {
        $this->img_res = imagecreatefromgif($this->source_path);
        $this->processBg($this->img_res);
    }

    function processBg($img)
    {

        $colorcount = imagecolorstotal($this->img_res);

        imagetruecolortopalette($img, true, $colorcount);

        imagepalettecopy($img, $this->img_res);

        $transparentcolor = imagecolortransparent($this->img_res);

        if ($transparentcolor >= 0) {

            imagefill($img, 0, 0, $transparentcolor);

            imagecolortransparent($img, $transparentcolor);
        }
    }

}

?>