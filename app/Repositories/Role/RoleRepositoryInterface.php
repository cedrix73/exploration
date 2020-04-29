<?php

namespace App\Repositories\Role;


interface RoleRepositoryInterface
{
    public function setCode($code);

    public function getCode();

    public function isAdmin();

    public function setAdmin();

    public function isView();

    public function setView();

    public function isInsert();

    public function setInsert();

    public function isUpdate();

    public function setUpdate();

    public function isDelete();

    public function setDelete();

    public function encode($tabPermissions);
}
