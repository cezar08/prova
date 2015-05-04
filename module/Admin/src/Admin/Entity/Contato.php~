<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "contato")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Contato
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
    protected $nome;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $sobrenome;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column (type="date")
     *
     * @var string
     */
    protected $data_nasc;

    /**
     * @ORM\ManyToMany(targetEntity="\Admin\Entity\LocalDeTrabalho")
     *  * @ORM\JoinTable(name="contato_local_de_trabalho",
     *      joinColumns={@ORM\JoinColumn(name="id_contato", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_local_de_trabalho", referencedColumnName="id")}
     *      )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */

    protected $locais_de_trabalho;

    /**
     * @ORM\OneToMany(targetEntity="Telefone", mappedBy="contato",  cascade={"all"})
     *
     */
    protected $telefones;

    public function __construct()
    {
        $this->locais_de_trabalho = new ArrayCollection();
        $this->telefones = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getLocaisDeTrabalho()
    {
        return $this->locais_de_trabalho;
    }

    /**
     * @return ArrayCollection
     */
    public function getTelefones()
    {
        return $this->telefones;
    }

    /**
     * @return string
     */
    public function getDataNasc()
    {
        return $this->data_nasc;
    }

    /**
     * @param string $data_nasc
     */
    public function setDataNasc($data_nasc)
    {
        $this->data_nasc = $data_nasc;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * @param string $sobrenome
     */
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
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
                'name' => 'nome',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo nome não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                            'message' => 'O campo nome deve ter menos que 255 caracteres',
                        ),
                    ),
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
                'name' => 'sobrenome',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo sobrenome não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                            'message' => 'O campo sobrenome deve ter menos que 255 caracteres',
                        ),
                    ),
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
                'name' => 'email',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo e-mail não pode estar vazio')
                    ),
                    array(
                        'name' => 'EmailAddress',
                        'options' => array('message' => 'Não é um e-mail válido')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                            'message' => 'O campo e-mail deve ter menos que 255 caracteres',
                        ),
                    ),
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
                'name' => 'data_nasc',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'message' => 'Não parece uma data válida',
                            'format' => 'd-m-Y'
                        )
                    ),
                ),
            )));
          
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

?>
