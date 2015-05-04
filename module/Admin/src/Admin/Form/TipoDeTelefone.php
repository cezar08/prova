<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class TipoDeTelefone extends Form
{

    public function __construct()
    {
        parent::__construct('tipo_de_telefone');

        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'hidden',
            )
        );

        $this->add(array(
            'name' => 'descricao',
            'type' => 'text',
            'options' => array(
                'label' => 'Descrição:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe a descrição',
                'id' => 'descricao',
                'class' => 'form-control'
            )
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
