<?php

/* 
 * @author : Fatema
 * date : 17 May 2022
 * employee controller
 * Intend to make rest apis using post method 
 */

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;

class Employee extends ResourceController{
 use ResponseTrait;
    // all users
    public function index(){
      $model = new EmployeeModel();
      $data['employees'] = $model->orderBy('id', 'DESC')->findAll();
      return $this->respond($data);
    }
    // create
    public function create() {
        $model = new EmployeeModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'deptid'  => $this->request->getVar('dept'),
        ];
        $model->insert($data);
        $response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
              'success' => 'Employee created successfully'
          ]
      ];
      return $this->respondCreated($response);
    }
    // single user
    public function show($id = null){
        $model = new EmployeeModel();
        $data = $model->where('id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No employee found');
        }
    }
    //search by name
    public function search($name = null){
        $name = trim($name)??null;
        if($name==null){
            $this->index();
        }else{
            $model = new EmployeeModel();
            $data = $model->likeFunc('name', $name);
            if($data){
                return $this->respond($data);
            }else{
                return $this->failNotFound('No employee found');
            }
        }
    }
    // update
    public function update($id = null){
        $model = new EmployeeModel();
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
            'deptid'  => $this->request->getVar('dept'),
        ];
        $model->update($id, $data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'Employee updated successfully'
          ]
      ];
      return $this->respond($response);
    }
    // delete
    public function delete($id = null){
        $model = new EmployeeModel();
        $data = $model->where('id', $id)->delete($id);
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No employee found');
        }
    }
}