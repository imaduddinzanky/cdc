	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	use traits\BeforeFilterTrait;

    public function __construct()
    {
    	parent::__construct();
   		$this->filter_called_method();
   		$this->form_validation->set_error_delimiters('<span class="help-inline error-validation-message">', '</span>');
   				$this->after_filter[] = array(
            'action' => '_load_flash_message'
        );
    }

    protected function _request($type)
	{
		return strtolower($this->input->server('REQUEST_METHOD')) === strtolower($type);
	}

	protected function _only_ajax()
	{
		if (!$this->input->is_ajax_request())
		{
			show_404();
		}
	}

}


use traits\SentryAuthenticationTrait;

class Base_Controller extends MY_Controller {
	use traits\ResourceTrait, traits\BreadcrumbTrait, SentryAuthenticationTrait;

	protected $layout;
	protected $rules;
	protected $boot_layout = true;
	public function __construct()
	{
		parent::__construct();
        /*$this->before_filter[] = array(
            'action' => '_initializeSentry'
        );
		if (!$this->skip_authentication)
		{
			$this->before_filter[] = array(
            	'action' => '_authenticate'
        	);
		}
        $this->before_filter[] = array(
            'action' => '_set_current_user'
        );*/
        $this->_initializeSentry();
        $this->_authenticate();
        $this->set_breadcrumb();
		$this->boot_layout();
        $this->load->helper('string');
	}

	protected function boot_layout()
	{
		if ($this->boot_layout)
		{
			$this->output->set_template($this->layout);
			$this->_set_template();
		}
	}

	protected function _set_template()
	{
		$this->load->section('header', 'admin/shared/header', array('sentry' => $this->sentry, 'route' => $this->_route(), 'current_user' => $this->current_user ));
		$this->load->section('navigation', 'admin/shared/navigation', array('base_url' => current_base_url($this->router->uri->segments)));
		$this->load->section('breadcrumbs', 'admin/shared/breadcrumbs');
		$this->load->section('footer', 'admin/shared/footer');
		$this->load->section('sidebar', 'admin/shared/sidebar', array('sentry' => $this->sentry  ,'current_user' => $this->current_user));
	}

	protected function _load_flash_message()
	{
		$this->load->section('flash_message', 'admin/shared/flash');
	}
}





class Admin_Controller extends Base_Controller
{
	protected $layout = 'admin';
	protected $folder = 'admin/';

	public function __construct()
	{
		$this->after_login_path = 'admin/home';
		$this->login_path = 'admin/login';
		parent::__construct();
		$this->before_filter[] = array(
        	'action' => '_resource',
        	'only' => array('edit','update','create_new','create', 'show','delete')
        );
	}
}

class User_Controller extends Base_Controller
{
	protected $layout = 'user';
	protected $after_login_path = 'trainings';
	protected $login_path = 'login';
	protected $use_slug = true;

	public function __construct()
	{
		$this->folder = null;
		parent::__construct();
		$this->before_filter[] = array(
        	'action' => '_resource',
        	'only' => array('edit','update','create_new','create', 'show','delete')
        );
	}

	protected function _set_template()
	{
		$this->load->section('header', 'shared/header', array('sentry' => $this->sentry, 'route' => $this->_route(), 'current_user' => $this->current_user ));
		$this->load->section('navigation', 'shared/navigation', array('base_url' => current_base_url($this->router->uri->segments)));
		$this->load->section('breadcrumbs', 'shared/breadcrumbs');
		$this->load->section('footer', 'shared/footer');
		$this->load->section('sidebar', 'shared/sidebar', array());
	}
}



use traits\SessionsTrait;

class Sessions_Controller extends MY_Controller{
	use SessionsTrait,SentryAuthenticationTrait;

	protected $layout='admin_login';

	public function __construct()
	{
		$this->before_filter[] = array(
            'action' => '_initializeSentry'
        );
		$this->before_filter[] = array(
            'action' => '_is_logged_in',
            'except' => array('delete')
        );
		$this->before_filter[] = array(
            'action' => '_init'
        );

        $this->before_filter[] = array(
            'action' => '_login_attribute'
        );
		$this->credential_keys = ['username', 'password'];
		$this->_login_attribute = 'username';
		parent::__construct();
	}

	protected function _init()
	{
		$this->output->set_template($this->layout);
	}
}



class Command extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->input->is_cli_request()
		or exit ('Execute via command line interface only');
		$this->load->library('migration');
	}
}
