<?php

Yii::app()->clientScript->registerCoreScript('ui');

Yii::app()->clientScript->registerScript('manage_model_file', '
    
$(".remove-image").click(function(){

if(confirm("Вы уверены?")) {

var wrap =  $(this).parent();

var value = wrap.find("span").text();

var ul = wrap.parent();

var attr = ul.data("attr");
var id = ul.data("id");
var cls = ul.data("cls");

var params = {
    
    attr: attr,
    id: id,   
    cls: cls,   
    value: value
        
}
    
var url = "' . Yii::app()->getUrlManager()->createUrl($this->ajax_del_route) . '";

$.get(url, params, function(){

wrap.remove();

});

}

});

$( ".sortable_files_list" ).sortable({
 
stop: function(event, ui) {

   if( $(this).find("li").length < 2 ) return;

    var attr = $(this).data("attr");
    var id = $(this).data("id");
    var cls = $(this).data("cls");
    
    var values = [];

    $(this).find("span").each(function(){ values.push( $(this).text() ) });

    var params = {
    
        attr: attr,
        id: id,   
        cls: cls,
        values: values
        
    }
    
    var url = "' . Yii::app()->getUrlManager()->createUrl($this->ajax_sort_route) . '";

    console.log(this.xhr);

    if(this.xhr) this.xhr.abort();
    
    this.xhr = $.get(url, params);
        

}

});

');

Yii::app()->clientScript->registerCss('manage_model_file', '

.sortable_files_list li {
    list-style-type: none;
    padding: 3px;
    margin: 5px 0;
    border: 1px dashed #ccc;
    width: 300px;
    cursor: hand;
    cursor: pointer;
}

');

?>

<ul class="sortable_files_list" data-attr="<?= $this->attr ?>" data-id="<?= $this->model_id ?>"
    data-cls="<?= $this->model_class ?>">
    <?php

    foreach ($this->files As $file) {


        if (!empty($file)):
            ?>
            <li><span><?= $file ?></span> <i class="icon-trash remove-image"></i></li>
        <?
        endif;
    }

    ?>
</ul>

<?php if (!empty($this->files)): ?>

    <p class="example_text">Для сортировки файлов перетащите их указателем мыши</p>

<?php endif; ?>
