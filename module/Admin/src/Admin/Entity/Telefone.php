<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "telefone")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Telefone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     *
     *@var Zend/InputFilter/InputFilter
     */
    protected $inputFilter;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $numero;

    /**
     * @ORM\ManyToOne(targetEntity="Contato")
     * @ORM\JoinColumn(name="id_contato", referencedColumnName="id")
     *
     * @var \Admin\Entity\Contato
     */
    protected $contato;

    /**
     * @ORM\ManyToOne(targetEntity="TipoDeTelefone")
     * @ORM\JoinColumn(name="id_tipo_de_telefone", referencedColumnName="id")
     *
     * @var \Admin\Entity\TipoDeTelefone
     */
    protected $tipo_de_telefone;

    /**
     * @return Contato
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * @param Contato $contato
     */
    public function setContato(Contato $contato)
    {
        $this->contato = $contato;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return TipoDeTelefone
     */
    public function getTipoDeTelefone()
    {
        return $this->tipo_de_telefone;
    }

    /**
     * @param TipoDeTelefone $tipo_de_telefone
     */
    public function setTipoDeTelefone($tipo_de_telefone)
    {
        $this->tipo_de_telefone = $tipo_de_telefone;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     *
     * @return Zend/InputFilter/InputFilter
     */
    public function getInputFilter(){

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'numero',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo número não pode estar vazio')
                    )
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                    ),
                ),
            )));


            $inputFilter->add($factory->createInput(array(
                'name' => 'contato',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O contato é obrigatório')
                    )
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'tipo_de_telefone',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O tipo de telefone é obrigatório')
                    )
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

?>
