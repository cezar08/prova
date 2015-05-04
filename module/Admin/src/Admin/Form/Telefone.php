<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Telefone extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('telefone');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',

        ));

        $this->add(array(
            'name' => 'numero',
            'type' => 'text',
            'options' => array(
                'label' => 'Descrição:'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o número',
                'id' => 'numero'
            )
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'contato',
            'options' => array(
                'label' => 'Contato:*',
                'object_manager' => $em,
                'target_class' => 'Admin\Entity\Contato',
                'property' => 'nome',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('nome' => 'ASC'),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'tipo_de_telefone',
            'options' => array(
                'label' => 'Tipo de telefone:*',
                'object_manager' => $em,
                'target_class' => 'Admin\Entity\TipoDeTelefone',
                'property' => 'descricao',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('descricao' => 'ASC'),
                    ),
                ),
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Salvar'
            )
        ));

    }

}
