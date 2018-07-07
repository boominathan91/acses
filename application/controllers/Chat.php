<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Chat';		
        render_page('chat',$data);
	}

}

/* End of file  */
/* Location: ./application/controllers/ */