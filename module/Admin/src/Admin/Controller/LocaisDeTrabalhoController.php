<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\LocalDeTrabalho as LocalDeTrabalhoForm;
use \Admin\Entity\LocalDeTrabalho;

/**
 * Controlador que gerencia os locais de trabalho
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class LocaisDeTrabalhoController extends AbstractActionController
{

    /**
     * Exibe os  locais de trabalho
     * @return void
     */
    public function indexAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $locais_de_trabalho = $em->getRepository('\Admin\Entity\LocalDeTrabalho')->findAll();

        return new ViewModel(
            array(
                'locais_de_trabalho' => $locais_de_trabalho
            )
        );
    }

    /**
     * Cria ou edita um local de trabalho
     *
     * @return void
     */
    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager
        $form = new LocalDeTrabalhoForm($em);
        $local_de_trabalho = new LocalDeTrabalho();
        $request = $this->getRequest(); //Pega os dados da requisição

        if ($request->isPost()) {
            $values = $request->getPost();
            $form->setInputFilter($local_de_trabalho->getInputFilter());
            $form->setData($values);

            if($form->isValid()) {
                $values = $form->getData();

                if ( (int) $values['id'] > 0)
                    $local_de_trabalho = $em->find('\Admin\Entity\LocalDeTrabalho', $values['id']);

                $local_de_trabalho->setNome($values['nome']);
                $em->persist($local_de_trabalho);

                try {
                    $em->flush();
                } catch (\Exception $e) {
                    echo $e;exit;
                }

                return $this->redirect()->toUrl('/admin/locais-de-trabalho');
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $local_de_trabalho = $em->find('\Admin\Entity\LocalDeTrabalho', $id);
            $form->bind($local_de_trabalho);
        }


        return new ViewModel(
            array('form' => $form)
        );
    }

    /**
     * Exclui um local de trabalho
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $local_de_trabalho = $em->find('\Admin\Entity\LocalDeTrabalho', $id);
            $em->remove($local_de_trabalho);

            try {
                $em->flush();
            } catch (\Exception $e) {

            }
        }

        return $this->redirect()->toUrl('/admin/locais-de-trabalho');
    }

}
