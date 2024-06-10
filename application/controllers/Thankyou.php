<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class : Thankyou page
 * @author : vaishnavi Badabe
 * @version : 3.1
 * @since : 06 sep 2022
 */

class Thankyou extends CI_Controller {

	function __construct()
    {
        parent::__construct();

	}
	public function index()
	{
		$this->load->view('Thankyou');
	}
	
}
