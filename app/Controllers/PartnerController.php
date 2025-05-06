<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PartnerController extends BaseController
{
    protected $partnerModel;
    protected $validation;

    public function __construct()
    {
        $this->partnerModel = new \App\Models\PartnerModel();
        $this->validation = \Config\Services::validation();
    }

    public function view($id)
    {
        $partner = $this->partnerModel->find($id);
        
        if (!$partner) {
            return redirect()->to(previous_url())->with('error', 'Partner not found');
        }

        return view('pages/partner/partnerView', [
            'partner' => $partner
        ]);
    }

    public function create($eventID)
    {
        return view('pages/partner/partnerCreate', [
            'eventID' => $eventID
        ]);
    }

    public function createHandler()
    {
        $rules = [
            'hyperlink' => 'valid_url',
            'logo' => 'is_image[logo]|max_size[logo,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'hyperlink' => $this->request->getPost('hyperlink'),
            'eventID' => $this->request->getPost('eventID')
        ];
        if ($logo = $this->request->getFile('logo')) {
            if ($logo->isValid() && !$logo->hasMoved()) {
                $newName = $logo->getRandomName();
                $logo->move(FCPATH . 'uploads/partnerLogo', $newName);
                $data['logo'] = $newName;
            }
        }

        $this->partnerModel->insert($data);
        return redirect()->to(route_to('event.view', $data['eventID']))->with('success', 'Partner added successfully');
    }

    public function edit($id)
    {
        $partner = $this->partnerModel->find($id);
        if (!$partner) {
            return redirect()->to(previous_url())->with('error', 'Partner not found');
        }

        return view('pages/partner/partnerEdit', [
            'partner' => $partner
        ]);
    }

    public function editHandler($id)
    {
        $rules = [
            'hyperlink' => 'valid_url',
            'logo' => 'is_image[logo]|max_size[logo,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'type' => $this->request->getPost('type'),
            'hyperlink' => $this->request->getPost('hyperlink')
        ];

        $logo = $this->request->getFile('logo');
        if ($logo->isValid() && !$logo->hasMoved()) {
            $newName = $logo->getRandomName();
            $logo->move(FCPATH . 'uploads/partnerLogo', $newName);
            $data['logo'] = $newName;

            // Delete old logo
            $partner = $this->partnerModel->find($id);
            if ($partner && $partner['logo']) {
                unlink(FCPATH . 'uploads/partnerLogo/' . $partner['logo']);
            }
        }

        $this->partnerModel->update($id, $data);
        return redirect()->to(route_to('event.view', $this->request->getPost('eventID')))->with('success', 'Partner updated successfully');
    }

    public function delete($id)
    {
        $partner = $this->partnerModel->find($id);
        
        if (!$partner) {
            return redirect()->to(previous_url())->with('error', 'Partner not found');
        }

        $this->partnerModel->delete($id);
        return redirect()->to(previous_url())->with('success', 'Partner deleted successfully');
    }

    public function restore($id)
    {
        $this->partnerModel->update($id, ['deleted_at' => null]);
        return redirect()->to(previous_url())->with('success', 'Partner restored successfully');
    }
}
