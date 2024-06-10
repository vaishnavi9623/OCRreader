<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class : Login
 * @author : vaishnavi Badabe
 * @version : 3.1
 * @since : 06 sep 2022
 */

class Login extends CI_Controller {
	function __construct()
    {
        parent::__construct();
	}

	public function index()
	{
		$this->load->view('Login');
	}
	public function ValidateUser()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($this->config->item('username')==$username && $this->config->item('password')==$password)
		{
			$response['status'] = 'success';
			$response['code'] = '200';
		}
		else
		{
			$response['status'] = 'falied';
			$response['code'] = '400';
		}
		echo json_encode($response);exit;
	}
}
