<?php

if (!empty($menuArr)):

    $attrs = null;

    foreach ($htmlOptions AS $k => $v)
        $attrs .= ' '.$k . '="' . $v . '"';

    echo "<ul" . $attrs . ">";

    foreach ($menuArr AS $model) {


        // Для всех кроме первой итерации

        if (isset($level)) {

            if ($model->level == $level)
                echo "</li>";
            elseif ($model->level > $level)
                echo "<ul>"; else
                echo "</ul></li>";

        }


        echo '<li><a href="' . $model->link . '" target="' . $model->target . '">' . $model->title . "</a>\r\n";


        $level = $model->level;

    }

    echo str_repeat("</li></ul>", $level - 1);

endif;

?>
