<?php

abstract class GeoModel extends CActiveRecord {

    /**
     * Возвращает название c расширенным именем типа, либо чистое название, если расширенный тип не задан
     * @return string
     */

    public function getExtTitle() {


        $title = $this->clean_title;

        if(!empty($this->type_ext))
            $title .= " ".$this->type_ext;

        return trim($title);

    }

}