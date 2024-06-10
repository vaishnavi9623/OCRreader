<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : OCR_model
 * OCR model class to save to data read by ocr and documents 
 * @author : vaishnavi Badabe
 * @version : 3.1
 * @since : 06 sep 2022
 */
class OCR_model extends CI_Model
{

	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

	public function saveUserData($data)
	{
		$this->db->insert('tbl_userdetails',$data);
		$result = $this->db->insert_id();
		return $result;
	}
	public function saveDoc($docs)
	{
		$this->db->insert('tbl_documentdetails',$docs);
		$result = $this->db->insert_id();
		return $result;
	}

}
