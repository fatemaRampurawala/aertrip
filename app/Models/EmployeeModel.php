<?php

/* 
  *@author : Fatema
 * date : 17 May 2022
 * employee model
 * @purpose Intend to make rest apis using post method .
 */

namespace App\Models;
use CodeIgniter\Model;
class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'deptid'];
    
    public function likeFunc($name){
        $builder = $this->builder();
        $builder->select('*');
        $builder->like('name','%'.$name.'%', 'both'); 
        $query = $builder->get();
        return $query->getResult();
    }
            
}

