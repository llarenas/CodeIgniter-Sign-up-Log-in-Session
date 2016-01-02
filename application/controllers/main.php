<?php

class Main extends CI_Controller{

	///////////////
  public function index(){
	
	$this->login(); // sabay hatag sa view, pati ang $data
  }

public function login(){
	
	$this->load->view('login'); // sabay hatag sa view, pati ang $data
  }

	////////////////////////////////


  public function login_validation() {

$this->load->library('form_validation'); //nasa library ani ang 'form_validation', so pwede ka ka set rules sa mga textbx.
$this->form_validation->set_rules('email', 'Email', 'required|trim|callback_validate_credentials');
$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');

if ($this->form_validation->run()) { ////if nag run o wla prob sa mga inputbox kg ang validate_credentials

	 $data = array (
	 	'email' => $this->input->post('email'),
	 	'is_logged_in' => 1


	 	);
	$this->session->set_userdata($data);
	redirect('main/members');
}

else {

$this->load->view('login');



}


//echo $this->input->post('email');

  }



/////
public function validate_credentials() {

			$this->load->model('model_users');


			if( $this->model_users->can_log_in() ) {



					return true;


			} else {


					$this->form_validation->set_message('validate_credentials', 'Incorrect');
					return false;


					}
		}


///////////////


 public function members() {
 	if ($this->session->userdata('is_logged_in')) { //double chack kung may session guid

		$this->load->view('members');


 	} else { ///kung wla session

	redirect ('main/restricted');


 	}



 }


public function restricted(){
	
	$this->load->view('restricted'); // sabay hatag sa view, pati ang $data
  }

//////
public function logout(){

	$this->session->sess_destroy(); ///code for killing session
	redirect('main/login');


}

///////////

public function signup(){ 
$this->load->view('signup');


}

//////////

public function signup_validation(){ 
$this->load->library('form_validation');

//is_unique[look sa table users ang column email kung gaexist na nga daan.]
$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]'); 
$this->form_validation->set_rules('password', 'Password', 'required|trim');
////matches[check kung ang amo ni nga textbox match sa password nga textbox sa babaw]
$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');
////kung is_unique may nadetect, ipagwa nya is "Email address already exist!"
$this->form_validation->set_message('is_unique', "Email address already exist!");


if ($this->form_validation->run()) { //kung wla prob sa mga input box

	//echo "pass";
	///
//generate random key
$key = md5(uniqid());

 //set 'mailtype' as html, so pwede ka pasa link or gamit html tag/ <a href> </a>
$this->load->library('email', array('mailtype'=>'html'));
$this->load->model('model_users');

$this->email->from('admin@ronelllarenas.com', "Ronel");

$this->email->to($this->input->post('email'));

$this->email->subject("confirm your account");


$message = "<p> Thank You for signing up!</p>";
$message .= "<p> <a href=' ".base_url(). "main/register_user/$key' > click here</a> to confirm account</p>";

$this->email->message($message);

//send email to the user.


	//add to the temp
	if ($this->model_users->add_temp_users($key)) { //if maka add sa db

			if ($this->email->send()) { //add sa db and send email
				

			echo "email has been sent!" ;

			} else { 

			echo "could not send the email!"; //add db pero cant send email
			}

	} else echo "problem registering!"; //cant add db



} else { ///cant register, error in validation
//echo "no pass!!";

$this->load->view('signup');

} //closing sang if


} //closing sang function


public function register_user($key){ 
//echo $key;
$this->load->model('model_users');

if($this->model_users->is_key_valid($key)) {

		//echo "valid key";
		if ($newemail = $this->model_users->add_user($key)) {
			//echo "success";
			$data = array (
				'email' => $newemail,
				'is_logged_in' => 1

				);
			$this->session->set_userdata($data);
			redirect('main/members');


		} else echo "failed to add user. pls try again!!";


} else echo "invalid key";


									}





}

