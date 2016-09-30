<?php
namespace CheckRbac\Model;

use Zend\Permissions\Rbac\Rbac as ZendRbac;
use Zend\Permissions\Rbac\Role;

class Rbac extends ZendRbac
{
	// maps roles to "users" table status codes
	protected static $roles = array(0 => 'guest', 1 => 'user', 2 => 'admin');
	public static function getRoleFromStatusCode($statusCode)
	{
		return (isset(self::$roles[$statusCode])) ? self::$roles[$statusCode] : self::$roles[0];  
	}
	public function __construct()
	{
		// assign roles
		$guest 	= new Role('guest');
		$user 	= new Role('user');
		$admin 	= new Role('admin');
		// assign permissions (controller.action)
		$guest->addPermission('hoot-and-holler-index.index')
			  ->addPermission('login-index.index')
			  ->addPermission('login-index.confirm');
		$user->addPermission('hoot-and-holler-index.index')
			  ->addPermission('login-index.index')
			  ->addPermission('login-index.confirm')
			  ->addPermission('login-index.logout')
			  ->addPermission('hoot-and-holler-index.hoot')
			  ->addPermission('post-index.index');
		$admin->addPermission('hoot-and-holler-index.index')
			  ->addPermission('login-index.index')
			  ->addPermission('login-index.confirm')
			  ->addPermission('login-index.logout')
			  ->addPermission('hoot-and-holler-index.hoot')
			  ->addPermission('post-index.index')
			  ->addPermission('admin-index.index')
			  ->addPermission('admin-index.add')
			  ->addPermission('admin-index.delete');
		// add roles with inheritance
		$this->addRole($guest)
			 ->addRole($user)
			 ->addRole($admin);
	}
}