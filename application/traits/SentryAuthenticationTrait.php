<?php
namespace traits;

use \Sentry;
use \User;

trait SentryAuthenticationTrait{

	protected $sentry;
	protected $login_path;
	protected $after_login_path = 'admin/home';
	protected $skip_authentication = false;
	protected $skip_restriction = false;
	public $current_user;

	protected function _initializeSentry()
	{
		if (!$this->sentry instanceof Sentry){
			$this->sentry = Sentry::createSentry();
		}
	}

	protected function _authenticate()
	{
		if (!$this->skip_authentication)
		{
			if ($this->_isLogin())
			{
				$this->_set_current_user();
				$this->_restrict();
			}else
			{
				$this->getLogin();
			}
		}
	}

	protected function _restrict()
	{
		if (!$this->skip_restriction)
		{
			if (!$this->sentry->hasAccess($this->_route()))
			{
				$this->session->set_flashdata('notice', 'You have sufficient access to this page');
				show_404();
			}
		}
	}

	public function _isLogin()
	{
		return $this->sentry->check();
	}

	protected function _route()
	{
		$directory = empty($this->router->directory) ? '' : $this->router->directory.'.';
		return $directory.$this->router->class.'.'.$this->router->method;
	}

	protected function getLogin()
	{
		$this->login_path = is_null($this->login_path) ? 'sessions/new' : $this->login_path;
		redirect($this->login_path);
	}

	protected function _set_current_user()
	{
		$this->current_user = User::find($this->sentry->getUser()->id);
	}

}