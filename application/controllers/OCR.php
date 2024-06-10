<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class : OCR
 * @author : vaishnavi Badabe
 * @version : 3.1
 * @since : 06 sep 2022
 */

class OCR extends CI_Controller {

	public $upload;


	function __construct()
    {
        parent::__construct();
		$this->load->model('OCR_model');


	}
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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('Home');
	}
	public function uploadDocuments()
	{
		if ($this->input->is_ajax_request() && isset($_FILES['imageFile'])) {
			// Handle image upload here
			$uploadDirectory = './uploads/'; // Set your upload directory
			$config['upload_path'] = $uploadDirectory;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|json'; // Add allowed file types
			$this->load->library('upload', $config);
	
			if ($this->upload->do_upload('imageFile')) {
				// Image uploaded successfully
				$data = $this->upload->data();
				//read data of doc using ocr...
				$url = $this->config->item('OCR_url');
				$client_id = $this->config->item('client_id');
				$secret_key = $this->config->item('secret_key');
				$api_type = $this->config->item('api_type');
				$docName = 'emirates-id';
				$finalFile = './uploads/'.$_FILES['imageFile']['name'];
				$uploadedDoc = array('Userid'=>1,'DocName'=>$_FILES['imageFile']['name'],'DocType'=>$docName);
				$result = $this->OCR_model->saveDoc($uploadedDoc);
				//-----CALL CURL FOR OCR READER-----------------
				$curl = curl_init();
				curl_setopt_array($curl, array(
				 CURLOPT_URL => $url,
				 CURLOPT_RETURNTRANSFER => true,
				 CURLOPT_ENCODING => "",
				 CURLOPT_MAXREDIRS => 10,
				 CURLOPT_TIMEOUT => 0,
				 CURLOPT_FOLLOWLOCATION => true,
				 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				 CURLOPT_CUSTOMREQUEST => "POST",
				 CURLOPT_POSTFIELDS => array('clientId' => ''.$client_id.'','secretkey' => ''.$secret_key.'','documenttype' => ''. $docName.'','file'=> new CURLFILE(''.$finalFile.'')),
			   ));
				$document_data = curl_exec($curl);
				$document_data_result_array[] = json_decode($document_data,TRUE);
			   	// print_r($document_data);exit;
				// Send a success response
				$response = array('status' => 'success', 'message' => 'Image uploaded successfully','documentData'=>$document_data_result_array);
				echo json_encode($response);
			} else {
				// Image upload failed
				$error = array('error' => $this->upload->display_errors());
				echo json_encode($error);
			}
		} else {
			// Handle non-AJAX requests or invalid requests
			show_404(); // You can change this to an appropriate response
		}	
	}

	public function saveUserData()
	{
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$emirateIdNum = $this->input->post('emirateNum');
		$gender = $this->input->post('gender');
		$dob = $this->input->post('dob');
		$nationality = $this->input->post('nationality');

		$Arr = array('Fname'=>$fname,'Lname'=>$lname,'EmiratesIdNumber'=>$emirateIdNum,'Gender'=>$gender,'DOB'=>$dob,'Nationality'=>$nationality);
		$result = $this->OCR_model->saveUserData($Arr);
		if($result){
			$response['status'] = 'success';
			$response['code'] = 200;
			// redirect('Thankyou'); // Redirect to the "Thankyou" page
		}
		else
		{
			$response['status'] = 'failed';
			$response['code'] = 400;
		}
		echo json_encode($response);exit;
		
	}
}
