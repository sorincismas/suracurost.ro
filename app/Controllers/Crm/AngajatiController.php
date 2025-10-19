<?php

namespace App\Controllers\Crm;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AngajatiController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data = [
            'page_title' => 'Lista Angajați',
            'angajati'   => $userModel->findAll()
        ];
        return view('Crm/angajati/list', $data);
    }

    public function form($id = null)
    {
        $userModel = new UserModel();
        $angajat = null;
        if ($id) {
            $angajat = $userModel->find($id);
        }

        $data = [
            'page_title' => $id ? 'Editare Angajat' : 'Adăugare Angajat Nou',
            'angajat'    => $angajat
        ];

        return view('Crm/angajati/form', $data);
    }

    public function save()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id');
        $email = $this->request->getPost('email');

        // Regulile de validare (email - validare de bază; unicitatea este verificată manual mai jos)
        $rules = [
            'nume'    => 'required|min_length[3]',
            'prenume' => 'required|min_length[3]',
            'email'   => 'required|valid_email',
            'rol'     => 'required|in_list[admin,operator]',
            'status'  => 'required|in_list[activ,arhivat]'
        ];

        // Verifică unicitatea email-ului
        $existing = $userModel->where('email', $email)->first();
        if ($existing) {
            if (!$id || ($existing && $existing->id != $id)) {
                return redirect()->back()->withInput()->with('errors', ['email' => 'Acest email este deja folosit.']);
            }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nume'    => $this->request->getPost('nume'),
            'prenume' => $this->request->getPost('prenume'),
            'email'   => $email,
            'rol'     => $this->request->getPost('rol'),
            'functie' => $this->request->getPost('functie'),
            'zile_concediu_an' => $this->request->getPost('zile_concediu_an'),
            'status'  => $this->request->getPost('status'),
        ];

        // dacă e update, include id în date pentru Model::save
        if ($id) {
            $data['id'] = $id;
            $message = 'Angajat actualizat cu succes.';
        } else {
            $message = 'Angajat adăugat cu succes.';
        }

        if ($userModel->save($data)) {
            return redirect()->to(site_url('crm/angajati'))->with('success', $message);
        } else {
            return redirect()->back()->withInput()->with('error', 'A apărut o eroare la salvare.');
        }
    }
}
