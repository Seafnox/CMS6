<?
header("Content-type: text/xml");

$page = !empty($_GET["page"]) ? $_GET["page"] : 0;

$num = 10; // Количество результатов на страницу

$offset = $page * $num;

echo '<?xml version="1.0" encoding="windows-1251"?>';

echo '<root>
<total>100</total>      
<items>';

for ($i = $offset; $i < $offset + $num; $i++) {

    echo "<item><![CDATA[
                <p>Элемент " . $i . "</p>
            ]]></item>";

}

echo '</items>
      </root>';

exit;

?>
