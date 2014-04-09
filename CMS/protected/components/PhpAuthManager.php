<?php
class PhpAuthManager extends CPhpAuthManager{
    public function init(){

        // Иерархию ролей расположим в файле auth.php в директории config приложения

        if($this->authFile===null) {
            $this->authFile=Yii::getPathOfAlias('application.config.auth').'.php';
        }
 
        parent::init();
 
        // Для гостей у нас и так роль по умолчанию guest.

        if(!Yii::app()->user->isGuest){
            // Связываем роль, заданную в БД с идентификатором пользователя,
            // возвращаемым UserIdentity.getId().
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }

    }

    /**
     * Возвращает имя роли суперпользователя
     * @return string
     */

    public function getRootRole() {

        return "root";

    }


    /**
     * Возвращает массив ролей для которых необходимо ограничивать права доступа
     * @return array
     */

    public function getPermRoles() {

        $permRoles = array();

        $roles = $this->getRoles();

        foreach($roles AS $k=>$role) {

            if($k == $this->getRootRole())
                continue;

            $permRoles[$k] = $role;

        }


        return $permRoles;


    }


}
?>
