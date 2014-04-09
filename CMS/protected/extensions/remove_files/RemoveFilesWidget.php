<?php

/**
 * Виджет для удаления и сортировки прикрепленных к модели файлов. Адреса файлов должны храниться в одном из свойств модели через разделитель "|"
 */

class RemoveFilesWidget extends CWidget
{


    public $model;
    public $attr;
    public $ajax_del_route = 'admin/main/service/removefile';
    public $ajax_sort_route = 'admin/main/service/sortfile';

    protected $files = array();
    protected $model_id;
    protected $model_class;

    public function init()
    {

        $attr = $this->attr;

        if (!empty($this->model->$attr)) {

            $this->files = explode("|", $this->model->$attr);

        }

        $this->model_id = !empty($this->model->id) ? $this->model->id : 0;

        $this->model_class = get_class($this->model);

    }

    public function run()
    {

        $this->render('removefiles');

    }
}

?>
