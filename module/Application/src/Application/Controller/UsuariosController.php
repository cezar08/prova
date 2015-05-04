<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuariosController extends AbstractActionController
{
    public function indexAction()
    {

        return new ViewModel(array('valor' => date('d-m-Y H:i:s')));
    }

	public function saveAction()
	{
		return new ViewModel(array('dados' => 'Action save', 'dados2' => 'teste'));
	}
}
