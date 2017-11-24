<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dvd extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	 public function __construct()
	 	{
	 		parent::__construct();
			$this->load->library('form_validation');
			$this->load->helper('url');
	 		$this->load->model('Dvd_model');
	 	}


	public function index()
	{

		$data['dvds']=$this->Dvd_model->get_all_dvd();
		$this->load->view('dvd',$data);
	}
	public function dvd_add()
		{
			$data = array(
				'titreD' => $this->input->post("titreD"),
				'auteurD' => $this->input->post("auteurD"),
				'anneeD' => $this->input->post("anneeD"),
				'categorieD' => $this->input->post("categorieD"),
				);
			$insert = $this->Dvd_model->dvd_add($data);
			echo json_encode(array("status" => TRUE));
		}
		public function ajax_edit($id)
		{
			$data = $this->Dvd_model->get_by_id($id);



			echo json_encode($data);
		}

		public function dvd_update()
	{
		$data = array(
			'titreD' => $this->input->post("titreD"),
			'auteurD' => $this->input->post("auteurD"),
			'anneeD' => $this->input->post("anneeD"),
			'categorieD' => $this->input->post("categorieD"),
			);
		$this->Dvd_model->dvd_update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function dvd_delete($id)
	{
		$this->Dvd_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}



}
