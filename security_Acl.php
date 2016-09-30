<?php
namespace CheckAcl\Model;

use Zend\Permissions\Acl\Acl as ZendAcl;

class Acl extends ZendAcl
{
	// maps roles to "users" table status codes
	protected static $roles = array(0 => 'guest', 1 => 'user', 2 => 'admin');
	public static function getRoleFromStatusCode($statusCode)
	{
		return (isset(self::$roles[$statusCode])) ? self::$roles[$statusCode] : self::$roles[0];
	}
	public function __construct()
	{
		$this->addRole('guest')
			 ->addRole('user', 'guest')
			 ->addRole('admin');
		// resources = controllers or controller route mappings
		$this->addResource('admin-index')
			 ->addResource('hoot-and-holler-index')
			 ->addResource('post-index')
			 ->addResource('login-index');
		// rights = actions
		$this->allow('guest', 'hoot-and-holler-index', 'index')
			 ->allow('guest', 'login-index')
			 ->allow('user', 'hoot-and-holler-index', 'hoot')
			 ->allow('user', 'post-index')
			 ->allow('admin');
	}
}