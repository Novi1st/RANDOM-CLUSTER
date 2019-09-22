<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    /* Konstruktor Function */
    public function __construct()
    {
        parent::__construct(); //memanggil method construct yg ada di CI_Controller
        is_logged_in();

    }
    
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->model('Menu_model', 'menu');
        $data['year'] = $this->menu->dateTransaction ();
        $data['year_transaction'] = $this->input->post('year_transaction');
        $data['data_transaction'] = $this->menu->search ($data['year_transaction']);
        $view = $this->menu->viewSearch ($data['year_transaction']);
        $data['jumlah_data'] = $this->db->count_all_results('total');

        $data['numlocal'] = 2;
        $data['maxneighbor'] = 0.25 * 2 * ($data['jumlah_data'] - 2);

        $i = 1;
        for ($i=1; $i<$data['numlocal'] ; $data['numlocal']++) 
        { 
            $data['currentnode'] = $this->menu->currentnode ($data['year_transaction']);
            
            $j = 1;
            while ($j < @maxneighbor) {
                $data['medoid'] = $this->menu->medoid ($data['year_transaction']);
                $data['nonmedoid'] = $this->menu->nonmedoid ($data['year_transaction']);
        
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function cluster()
    {
        $data['title'] = 'Result Cluster';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/cluster', $data);
        $this->load->view('templates/footer');
    }

    
    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $data['role'] = $this->db->get('user_role')->result_array();

        /*rules validasi modal */
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
        
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');
            redirect('admin/role');
        }
    }

    public function deleteRole($role_id)
    {
        $data = $this->db->get_where('user_role', ['role_id' => $role_id])->row_array();
        $data2 = $this->db->get_where('user_access_menu', ['role_id' => $role_id])->row_array();
                    // $this->db->delete('user_role', $data);
                    // $this->db->where('role_id', $data2);
        
        // $this->load->model('Menu_model', 'menu');
        
        // $delete[] = $this->menu->deleteRoleAccess();
        if ($data['role_id'] != $data2['role_id']) {
            $this->db->delete('user_role', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted!</div>');
            redirect('admin/role');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Cannot delete or update a parent row!</div>');
            redirect('admin/role');
        }    
    }

    public function edit()
    {
        $r_id = $this->input->post('roleId');
        $r = $this->input->post('role');
        // $data = [
        //     'role_id' => $role_id,
        //     'role' => $role
        // ];

        // $result = $this->db->get_where('user_role', $data);

        $this->db->set('role', $r);
        $this->db->where('role_id', $r_id);
        $this->db->update('user_role');
        
        // $this->db->delete('user_role', $role_id);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been updated!</div>');
        redirect('admin/role');
    }

    public function editRole($role_id)
    {
        $data = $this->db->get_where('user_role', ['role_id' => $role_id])->row_array();
        $data2 = $this->db->get_where('user_access_menu', ['role_id' => $role_id])->row_array();

        if ($data['role_id'] != $data2['role_id']) {
            $data['title'] = 'Edit Role';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
            $data['role'] = $this->db->get_where('user_role', ['role_id' => $role_id])->row_array();
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-role-access', $data);
            $this->load->view('templates/footer'); 
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Cannot delete or update a parent row!</div>');
            redirect('admin/role');
        }    
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $data['role'] = $this->db->get_where('user_role', ['role_id' => $role_id])->row_array();

        $this->db->where('menu_id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }
}

