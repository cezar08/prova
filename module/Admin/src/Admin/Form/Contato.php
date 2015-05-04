<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Contato extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('contato');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'hidden'
            )
        );

        $this->add(array(
            'name' => 'nome',
            'type' => 'text',
            'options' => array(
                'label' => 'Nome:'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o valor',
                'id' => 'nome'
            )
        ));

        $this->add(array(
            'name' => 'sobrenome',
            'type' => 'text',
            'options' => array(
                'label' => 'Sobrenome:'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o valor',
                'id' => 'sobrenome'
            )
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'E-mail:'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o valor',
                'id' => 'email'
            )
        ));

        $this->add(array(
            'name' => 'data_nasc',
            'type' => 'text',
            'options' => array(
                'label' => 'Data nascimento:'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o valor',
                'id' => 'data_nasc'
            )
        ));

        $this->add(array(
            'name' => 'numero',
            'type' => 'text',
            'options' => array(
                'label' => 'Telefone:'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o valor',
                'id' => 'telefone'
            )
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
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'locais_de_trabalho',
            'options' => array(
                'label' => 'Locais de trabalho:*',
                'object_manager' => $em,
                'target_class' => 'Admin\Entity\LocalDeTrabalho',
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
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Salvar'
            )
        ));

    }

}
