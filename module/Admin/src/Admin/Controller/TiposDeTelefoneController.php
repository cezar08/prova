<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\TipoDeTelefone as TipoDeTelefoneForm;
use \Admin\Entity\TipoDeTelefone as TipoDeTelefone;

/**
 * Controlador que gerencia os tipos de telefones
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class TiposDeTelefoneController extends AbstractActionController
{

    /**
     * Exibe os tipo de telefones telefones
     * @return void
     */
    public function indexAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $tipos_de_telefones = $em->getRepository('\Admin\Entity\TipoDeTelefone')->findAll();

        return new ViewModel(
            array(
                'tipos_de_telefones' => $tipos_de_telefones
            )
        );
    }

    /**
     * Cria ou edita um tipo de telefone
     *
     * @return void
     */
    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager
        $form = new TipoDeTelefoneForm($em);
        $request = $this->getRequest(); //Pega os dados da requisição

        if ($request->isPost()) {
            $values = $request->getPost();
            $tipo_de_telefone = new TipoDeTelefone();
            $form->setInputFilter($tipo_de_telefone->getInputFilter());
            $form->setData($values);

            if ($form->isValid()){
                $values = $form->getData();

                if ( (int) $values['id'] > 0)
                    $tipo_de_telefone = $em->find('\Admin\Entity\TipoDeTelefone', $values['id']);

                $tipo_de_telefone->setDescricao($values['descricao']);
                $em->persist($tipo_de_telefone);

                try {
                    $em->flush();
                } catch (\Exception $e) {

                }

                return $this->redirect()->toUrl('/admin/tipos-de-telefone');
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $tipos_de_telefone = $em->find('\Admin\Entity\TipoDeTelefone', $id);
            $form->bind($tipos_de_telefone);
        }


        return new ViewModel(
            array('form' => $form)
        );
    }

    /**
     * Exclui um telefone tipo de telefone
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $tipo_de_telefone = $em->find('\Admin\Entity\TipoDeTelefone', $id);
            $em->remove($tipo_de_telefone);

            try {
                $em->flush();
            } catch (\Exception $e) {
                echo $e; exit;
            }
        }

        return $this->redirect()->toUrl('/admin/tipos-de-telefone');
    }

}
