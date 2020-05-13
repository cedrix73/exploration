<?php

namespace App\Repositories\Permission;


use App\User;
use Session;




class PermissionRepository implements PermissionRepositoryInterface
{
    private const VIEW = 1;
    private const INSERT = 2;
    private const UPDATE = 4;
    private const DELETE = 8;
    private const ADMIN = 16;


    private $_code;

    public function check($roleAsked)
    {
        $code=null;
        if (Session::has('roles')) {
            foreach (session('roles') as $role => $value) {
                if ($role===$roleAsked) {
                    $code=$value;
                }
            }
        }
        return $code;
    }




    public function setCode($code) {
        $this->_code = $code;
    }

    public function getCode() {
        return $this->_code;
    }


    public function isAdmin($roleAsked) {
        $code=$this->check($roleAsked);
        if ((self::ADMIN & $code) == self::ADMIN) {
            return true;
		} else {
			return false;
		}
    }

    public function setAdmin() {
        $this->_code = self::ADMIN;
    }

	/**
     * @name        isView
     * @description check if user has own the select right for the asked role
     * @parameter   string $roleAsked
     * @return      boolean
     */
	public function isView($roleAsked) {
        $code=$this->check($roleAsked);
		if ((self::VIEW & $code) == self::VIEW) {
			return true;
		} else {
			return false;
		}
    }

    public function setView() {
        if ((self::VIEW & $this->_code) != self::VIEW) {
            $this->_code += self::VIEW;
        }

    }

	/**
     * @name        isInsert
     * @description check if user has own the create right for the asked role
     * @parameter   string $roleAsked
     * @return      boolean
     */
	public function isInsert($roleAsked) {
        $code=$this->check($roleAsked);
		if ((self::INSERT & $code) == self::INSERT) {
			return true;
		} else {
			return false;
		}
    }

    public function setInsert() {
        if ((self::INSERT & $this->_code) != self::INSERT) {
            $this->_code += self::INSERT;
        }

    }



	/**
     * @name        isUpdate
     * @description check if user has own the update right for the asked role
     * @parameter   string $roleAsked
     * @return      boolean
     */
    public function isUpdate($roleAsked) {
        $code=$this->check($roleAsked);
        if ((self::UPDATE & $code) == self::UPDATE) {
			return TRUE;
		} else {
			return FALSE;
		}
    }

    public function setUpdate() {
        if ((self::UPDATE & $this->_code) != self::UPDATE) {
            $this->_code += self::UPDATE;
        }
    }

	/**
     * @name        isDelete
     * @description check if user has own the delete right for the asked role
     * @parameter   string $roleAsked
     * @return      boolean
     */
    public function isDelete($roleAsked) {
        $code=$this->check($roleAsked);
		if ((self::DELETE & $code) == self::DELETE) {
			return true;
		} else {
			return false;
		}
    }

    public function setDelete() {
        if ((self::DELETE & $this->_code) != self::DELETE) {
            $this->_code += self::DELETE;
        }
    }

    public function encode($tabVal) {
        /* Codage des droits sur 3 * 4 bits + 1 (que l'on écrit en base 10)
            * Delete / Update / Insert / Select
                Matériel	Réservation     Client
            |	----------	----------	----------
            |	D  U  I  S  C  D  U  I  S    D  U  I  S
        bits   12 11 10  9  8  7  6  5  4    3  2  1  0
                                    32  16   8  4  2  1

        S: select
        I: insert
        U: update
        D: delete
        */

        $rol = 0;

        // Le bit 13 permet de coder le rôle administrateur
        if ($this->_code = $this->ADMIN) {
                $rol = $this->ADMIN;
        } else {
            foreach ($tabVal as $numIndex => $boolValue) {
                if ($boolValue) {
                    $rol += pow(2, $numIndex);
                }
            }
        }
        $this->code = $rol;
    }




}
