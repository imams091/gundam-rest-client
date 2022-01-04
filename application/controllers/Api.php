<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->library('form_validation');
	}

	function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	}

	function insert()
	{
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('harga', 'harga', 'required');
		$this->form_validation->set_rules('grade', 'grade', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'nama'	=>	$this->input->post('nama'),
				'harga'		=>	$this->input->post('harga'),
				'grade'		=>	$this->input->post('grade')
			);

			$this->api_model->insert_api($data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'nama_error'		=>	form_error('nama'),
				'harga_error'		=>	form_error('harga'),
				'grade_error'		=>	form_error('grade')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_single()
	{
		if($this->input->post('id'))
		{
			$data = $this->api_model->fetch_single_user($this->input->post('id'));

			foreach($data as $row)
			{
				$output['nama'] = $row['nama'];
				$output['harga'] = $row['harga'];
				$output['grade'] = $row['grade'];
			}
			echo json_encode($output);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('nama', 'nama', 'required');

		$this->form_validation->set_rules('harga', 'harga', 'required');
		if($this->form_validation->run())
		{	
			$data = array(
				'nama'		=>	$this->input->post('nama'),
				'harga'			=>	$this->input->post('harga'),
				'grade'			=>	$this->input->post('grade')
			);

			$this->api_model->update_api($this->input->post('id'), $data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'				=>	ture,
				'nama_error'	=>	form_error('nama'),
				'harga_error'	=>	form_error('harga'),
				'grade'				=>	form_error('grade')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->api_model->delete_single_user($this->input->post('id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}

}


?>