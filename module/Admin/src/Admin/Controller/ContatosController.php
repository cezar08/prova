<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Entity\Contato as Contato;
use \Admin\Entity\Telefone as Telefone;
use \Admin\Form\Contato as ContatoForm;

/**
 * Controlador que gerencia os contatos
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class ContatosController extends AbstractActionController
{
    /**
     * Exibe os contatos
     * @return void
     */
    public function indexAction()
    {
		$em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$dados = $em->getRepository('\Admin\Entity\Contato')->findAll();
		
		return new ViewModel(
			array('contatos' => $dados)
		);
    }

	public function saveAction()
	{
		$request = $this->getRequest();
		$em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new ContatoForm($em);

		if ($request->isPost()) {
			$values = $request->getPost();
			$contato = new Contato();
            $telefone = new Telefone();
            $filters = $contato->getInputFilter();
            $filters->add($telefone->getInputFilter()->get('numero'));
            $filters->add($telefone->getInputFilter()->get('tipo_de_telefone'));
			$form->setInputFilter($filters);
			$form->setData($values);

			if($form->isValid()) {
				$values = $form->getData();

				if ((int)$values['id'] > 0)
					$contato = $em->find('\Admin\Entity\Contato', $values['id']);

				$contato->setDataNasc(new \DateTime($values['data_nasc']));
                $contato->setEmail($values['email']);
                $contato->setNome($values['nome']);
                $contato->setSobrenome($values['sobrenome']);
                $contato->getLocaisDeTrabalho()->clear();

                foreach ($values['locais_de_trabalho'] as $local_de_trabalho) {
                    $local = $em->find('\Admin\Entity\LocalDeTrabalho', $local_de_trabalho);
                    $contato->getLocaisDeTrabalho()->add($local);
                }

				$em->persist($contato);
                $telefone->setNumero($values['numero']);
                $tipo_de_telefone = $em->find('Admin\Entity\TipoDeTelefone', $values['tipo_de_telefone']);
                $telefone->setTipoDeTelefone($tipo_de_telefone);
                $telefone->setContato($contato);
                $em->persist($telefone);

				try{
					$em->flush();
				}catch(\Exception $e) {
                    echo $e; exit;
				}

				return $this->redirect()->toUrl('/admin/contatos/index');
			}

		}

		$id = $this->params()->fromRoute('id', 0);

		if ($id > 0) {
			$contato = $em->find('\Admin\Entity\Contato', $id);
            $telefone = $em->getRepository('\Admin\Entity\Telefone')->findOneBy(array('contato' => $contato));
            $form->bind($telefone);
			$form->bind($contato);
            $form->get('data_nasc')->setValue($contato->getDataNasc()->format('d-m-Y'));
		}

		return new ViewModel(
			array('form' => $form)
		);
	}

    /**
     * Exclui um contato
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $contato = $em->find('\Admin\Entity\Contato', $id);
            $em->remove($contato);

            try {
                $em->flush();
            } catch (\Exception $e) {
                echo $e; exit;
            }
        }

        return $this->redirect()->toUrl('/admin/contatos');
    }
}
