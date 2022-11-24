<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelUser;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelUser = new ModelUser();
            $data = $modelUser->findAll();
            $response = 
                // 'status' => 200,
                // 'error' => "false",
                // 'message' => '',
                // 'totaldata' => count ($data),
                // 'data' => $data
                $data
            ;            

            return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($cari = null)
    {
        $modelUser = new ModelUser();

        $data = $modelUser->orLike('username', $cari)
            ->orLike('email', $cari)->get()->getResult();

            if(count($data) > 1){
                $response = [
                    'status' => 200,
                    'error' => "false",
                    'message' => '',
                    'totaldata' => count($data),
                    'data' => $data
                ];

                return $this->respond($response, 200);

            }else if(count($data)==1){
                $response = [
                    'status' => 200,
                    'error' => "false",
                    'message' => '',
                    'totaldata' => count($data),
                    'data' => $data
                ];

                return $this->respond($response, 200);
            }else{
                return $this->failNotFound('Data tidak ditemukan');
            }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $modelUser = new ModelUser();
        $username = $this->request->getPost("username");
        // $passwordNotEncrypt = $this->request->getPost("password");
        // $password = password_hash($passwordNotEncrypt, PASSWORD_DEFAULT);
        $password = $this->request->getPost("password");
        $email = $this->request->getPost("email");
        $birth = $this->request->getPost("birth");
        $phone = $this->request->getPost("phone");

        $modelUser->insert([
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'birth' => $birth,
            'phone' => $phone,
        ]);

        $response = [
            'status' => 201,
            'error' => "false",
            'message' => "Data berhasil disimpan"
        ];

        return $this->respond($response, 201);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new ModelUser();

        $data = [
            'username' => $this->request->getVar("username"),
            'password' => $this->request->getVar("password"),
            'email' => $this->request->getVar("email"),
            'birth' => $this->request->getVar("birth"),
            'phone' => $this->request->getVar("phone"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data berhasil dibaharui"
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelUser = new ModelUser();

        $cekData = $modelUser->find($id);

        if($cekData) {
            $modelUser->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Data berhasil dihapus"
            ];
            return $this->respondDeleted($response);
        }else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
