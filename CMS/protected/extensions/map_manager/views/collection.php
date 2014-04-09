<?php

$cs = Yii::app()->clientScript;

// Стили

$cs->registerCssFile(
    Yii::app()->assetManager->publish(
        realpath(dirname(__FILE__) . "/../") . '/assets/map_manager.css'
    )
);

// Менеджер для работы с картой

$cs->registerScriptFile(
    Yii::app()->assetManager->publish(
        realpath(dirname(__FILE__) . "/../") . '/map_manager.js'
    ),
    CClientScript::POS_END
);


Yii::app()->clientScript->registerScript("map_collection_widget", "
  
 
    ymaps.ready( function (){ 
    
         map_manager.load_map('" . $this->map_id . "', " . $this->map_width . ", " . $this->map_height . ", " . $this->map_zoom . ");

         myCollection = new ymaps.GeoObjectCollection();

         eval('var objs = " . $this->jmodels . "');
         
         for(var i=0; i<objs.length; i++) {
         
            var o = objs[i];
            var num = i+1;
            
            var ballon = {
                    iconContent: num,
                    balloonContentHeader: o.title,
                    balloonContentBody: o.address,
                    balloonContentFooter: ''
                }
        
                var point = map_manager.get_point(o.coords, ballon);
        
                myCollection.add(point);
                
                var list_ul = $('#" . $this->map_id . "_collection_links');
                    
                if(list_ul.length == 0) continue

                var link = $('<a href=#>'+num+') '+o.title+'</a>');
        
                (function(point) {
        
                    link.on('click', function(event){ 
                        
                        map_manager.map.setCenter(point.geometry.getCoordinates());

                        point.balloon.open(); event.preventDefault() 
                        
                    } );
        
                })(point);

                var list_li = $('<li></li>').append(link);
                
                list_ul.append(list_li);

         }

         map_manager.map.panTo(point.geometry.getCoordinates());
         
         map_manager.put_collection(myCollection);
         
    });


 ");

?>

<?php if ($this->show_list): ?>

    <ul id="<?= $this->map_id ?>_collection_links" class="map_collection_list">
    </ul>
<?php endif; ?>
<div id="<?= $this->map_id ?>"
     style="width: <?php echo $this->map_width; ?>px; height: <?php echo $this->map_height; ?>px;"></div>
<div style="clear: both"></div>