<?php
namespace CheckRbac;

use Zend\Mvc\MvcEvent;
use CheckRbac\Model\Rbac;
use Zend\Http\Headers;

class Module
{
	public function onBootStrap(MvcEvent $e)
	{
		$eventManager = $e->getApplication()->getEventManager();
		$eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 100);
	}

	public function onDispatch(MvcEvent $e)
	{
		// get routing info
		$matches     = $e->getRouteMatch();
		$permission	 = $matches->getParam('controller') . '.' . $matches->getParam('action');
		// get services
		$sm 		 = $e->getApplication()->getServiceManager();
		$authService = $sm->get('checkrbac-auth-service');
		$rbac		 = $sm->get('checkrbac-rbac');
		// retrieve identity
		$name = 'guest';
		$role = 'guest';
		if ($authService->hasIdentity()) {
			$identity = $authService->getIdentity();
			$name = strtolower($identity->real_name);
			$role = Rbac::getRoleFromStatusCode($identity->status);
		}
		// assign name and role to the layout view model
		$layoutView = $e->getViewModel();
		$layoutView->setVariable('realName', $name);
		$layoutView->setVariable('realRole', $role);
		// verify rights
		if (!($rbac->hasRole($role) && $rbac->isGranted($role, $permission))) {
	 		$response = $e->getResponse();
	 		$headers = $response->getHeaders();
	 		$headers->clearHeaders();
	 		$headers->addHeaderLine('Location: /');
	 		$response->setStatusCode('302');
	 		$response->setHeaders($headers);
	 		return $response;
		}
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
}
