<?php
class Not_authorized extends CI_Controller
{
	public function index()
	{
		$this->load->view('errors/custom/not_authorized');
	}
}
