<?php

namespace App\Repositories\Role;

use App\Role;




class RoleRepository implements RoleRepositoryInterface
{

    private $_role;

    private $_code;

    public function __construct(Role $role)
    {
        $this->_role = $role;
    }

    Private Const VIEW = 1;
    Private Const INSERT = 2;
    Private Const UPDATE = 4;
    Private Const DELETE = 8;

    Const ADMIN = 16;

    private $_code;

    public function setCode($code) {
        $this->_code = $code;
    }

    public function getCode() {
        return $this->_code;
    }


    public function isAdmin() {
        if (($this->ADMIN & $this->_code) == $this->ADMIN) {
            return true;
		} else {
			return false;
		}
    }

    public function setAdmin() {
        $this->_code = $this->ADMIN;
    }

	/* Retourne vrai si le rôle autorise la sélection sur les clients */
	public function isView() {
		if (($this->VIEW & $this->_code) == $this->VIEW) {
			return true;
		} else {
			return false;
		}
    }

    public function setView() {
        $this->_code += $this->VIEW;
    }

	/* Retourne vrai si le rôle autorise l'insertion de clients */
	public function isInsert() {
		if (($this->INSERT & $this->_code) == $this->INSERT) {
			return true;
		} else {
			return false;
		}
    }

    public function setInsert() {
        $this->_code += $this->INSERT;
    }



	/* Retourne vrai si le rôle autorise la mise à jour de clients */
    public function isUpdate() {
        if (($this->UPDATE & $this->_code) == $this->UPDATE) {
			return true;
		} else {
			return false;
		}
    }

    public function setUpdate() {
        $this->_code += $this->UPDATE;
    }

	/* Retourne vrai si le rôle autorise la suppression de clients */
	public function isDelete() {
		if (($this->DELETE & $this->_code) == $this->DELETE) {
			return true;
		} else {
			return false;
		}
    }

    public function setDelete() {
        $this->_code += $this->DELETE;
    }

    public function encode($tabVal){
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
