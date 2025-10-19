<?php

namespace App\Controllers;

use App\Models\AngajatModel;
use App\Models\FirmaModel;
use CodeIgniter\Controller;

class AngajatiController extends Controller
{
    public function index()
    {
        $model = new AngajatModel();
        
        $data['angajati'] = $model->select('angajati.*, firme.nume_firma')
                                  ->join('firme', 'firme.id = angajati.id_firma')
                                  ->findAll();

        return view('angajati/index', $data);
    }

    public function new()
    {
        helper('form');
        $firmaModel = new FirmaModel();
        $data['firme'] = $firmaModel->findAll();
        return view('angajati/form', $data);
    }

    public function create()
    {
        helper('form');
        $model = new AngajatModel();

        $rules = [
            'nume_prenume'   => 'required|min_length[3]|max_length[100]',
            'cnp'            => 'required|exact_length[13]',
            'id_firma'       => 'required|is_natural_no_zero',
            'data_angajarii' => 'required|valid_date',
        ];

        if ($this->validate($rules)) {
            $model->save($this->request->getPost());
            return redirect()->to('/angajati');
        } else {
            $firmaModel = new FirmaModel();
            $data['firme'] = $firmaModel->findAll();
            $data['validation'] = $this->validator;
            return view('angajati/form', $data);
        }
    }

    public function edit($id = null)
    {
        helper('form');
        $model = new AngajatModel();
        $firmaModel = new FirmaModel();

        $data['angajat'] = $model->find($id);
        if (empty($data['angajat'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu am putut gasi angajatul cu ID: ' . $id);
        }
        
        $data['firme'] = $firmaModel->findAll();
        return view('angajati/form', $data);
    }

    public function update($id = null)
    {
        helper('form');
        $model = new AngajatModel();

        $rules = [
            'nume_prenume'   => 'required|min_length[3]|max_length[100]',
            'cnp'            => 'required|exact_length[13]',
            'id_firma'       => 'required|is_natural_no_zero',
            'data_angajarii' => 'required|valid_date',
        ];

        if ($this->validate($rules)) {
            $model->update($id, $this->request->getPost());
            return redirect()->to('/angajati');
        } else {
            $firmaModel = new FirmaModel();
            $data['angajat'] = $model->find($id);
            $data['firme'] = $firmaModel->findAll();
            $data['validation'] = $this->validator;
            return view('angajati/form', $data);
        }
    }

    public function delete($id = null)
    {
        $model = new AngajatModel();
        $model->delete($id);
        return redirect()->to('/angajati');
    }
}
