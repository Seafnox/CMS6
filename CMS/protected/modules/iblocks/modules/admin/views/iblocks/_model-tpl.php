class <?=$classname?> extends IActiveRecord {


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations() {

        $parentRel = parent::relations();

        $rel = array(); // Массив со связями

        return array_merge($parentRel, $rel);

    }

    public function behaviors() {

        $parentBeh = parent::behaviors();

        $beh = array(); // Массив с поведениями

        return array_merge($parentBeh, $beh);

    }


    public function rules() {

        $parentRul = parent::rules();

        $rul = array(); // Массив с правилами валидации

        return array_merge($parentRul, $rul);

    }


    public function tableName()
    {
        return '<?=$tablename?>';
    }


    public function iblockId() {
        return <?=$iblock_id?>;
    }


}