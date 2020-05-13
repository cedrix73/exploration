<?php

namespace App\Repositories\Permission;


interface PermissionRepositoryInterface

{
    public function check($roleAsked);

    public function setCode($code);

    public function getCode();

    public function isAdmin($roleAsked);

    public function setAdmin();

    public function isView($roleAsked);

    public function setView();

    public function isInsert($roleAsked);

    public function setInsert();

    public function isUpdate($roleAsked);

    public function setUpdate();

    public function isDelete($roleAsked);

    public function setDelete();

    public function encode($tabPermissions);
}
