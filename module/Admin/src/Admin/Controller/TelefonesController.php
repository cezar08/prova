<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Telefone as TelefoneForm;
use \Admin\Entity\Telefone as Telefone;

/**
 * Controlador que gerencia os telefones
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class TelefonesController extends AbstractActionController
{

    /**
     * Exibe os telefones
     * @return void
     */
    public function indexAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $telefones = $em->getRepository('\Admin\Entity\Telefone')->findAll();

        return new ViewModel(
            array(
                'telefones' => $telefones
            )
        );
    }

    /**
     * Cria ou edita um telefone
     * @return void
     */
    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); //EntityManager
        $form = new TelefoneForm($em);
        $request = $this->getRequest(); //Pega os dados da requisição

        if ($request->isPost()) {
            $values = $request->getPost();
            $telefone = new Telefone();
            $form->setInputFilter($telefone->getInputFilter());
            $form->setData($values);

            if ($form->isValid()) {

                if ( (int) $values['id'] > 0)
                    $telefone = $em->find('\Admin\Entity\Telefone', $values['id']);

                $telefone->setNumero($values['numero']);
                $contato = $em->find('\Admin\Entity\Contato', $values['contato']);
                $tipo_de_telefone = $em->find('\Admin\Entity\TipoDeTelefone', $values['tipo_de_telefone']);
                $telefone->setContato($contato);
                $telefone->setTipoDeTelefone($tipo_de_telefone);
                $em->persist($telefone);

                try {
                    $em->flush();
                } catch (\Exception $e) {
                    echo $e; exit;
                }

                return $this->redirect()->toUrl('/admin/telefones');
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $telefone = $em->find('\Admin\Entity\Telefone', $id);
            $form->bind($telefone);
        }


        return new ViewModel(
            array('form' => $form)
        );
    }

    /**
     * Exclui um telefone
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $telefone = $em->find('\Admin\Entity\Telefone', $id);
            $em->remove($telefone);

            try {
                $em->flush();
            } catch (\Exception $e) {
                echo $e; exit;
            }
        }

        return $this->redirect()->toUrl('/admin/telefones');
    }

}
