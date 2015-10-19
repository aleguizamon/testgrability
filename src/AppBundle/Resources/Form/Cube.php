<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Doctrine\ORM\EntityRepository;
//use Serviremesa\BackendAdminBundle\Form\DataTransformer\DatetimeToTextTransformer;
//use Symfony\Component\Form\FormInterface;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;

class CubeType extends AbstractType
{
   /* private $idLang;
    private $country;
    private $customer;
    private $new;

    public function __construct($new,$idLang=null, $country=null, $customer = null)
    {
        $this->idLang = $idLang;
        $this->country = $country;
        $this->customer = $customer;
        $this->new = $new;
    }*/

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('address1')
            ;


       // $objCountry = $this->country;
       // $idLang = $this->idLang;
       // $customer = $this->customer;
       // $transformer = new DatetimeToTextTransformer();
/*
        $builder
            ->add('address1')
            ->add('address2', 'text', array('required' => false))
            ->add('city')
            ->add('idCustomer', 'entity', array(
                    'class'=> 'ServiremesaBackendAdminBundle:SrCustomer',
                    'label'=> 'Customer',
                    'empty_value' => 'CHOICE',
                    'required' => false,
                    'empty_data'  => null
                ))
            ->add('idBeneficiary', 'entity', array(
                    'class'=> 'ServiremesaBackendAdminBundle:SrBeneficiary',
                    'required' => false,
                    'empty_value' => 'CHOICE',
                    'empty_data'  => null
                ))
            ->add('countries', 'entity',
                array('class'=> 'ServiremesaBackendAdminBundle:SrCountry',
                    'label' => 'name',
                    'mapped' => false,
                    'empty_value' => 'CHOICE',
                    'data'  => !is_null($objCountry) ? $objCountry : ($builder->getData() && $builder->getData()->getIdState() ? $builder->getData()->getIdState()->getIdCountry() : null),
                    'query_builder' => function (EntityRepository $er) use ($idLang){
                        return $er->createQueryBuilder('c')
                            ->leftJoin('ServiremesaBackendAdminBundle:SrCountryLang', 'cl', 'WITH', 'c = cl.country')
                            ->leftJoin('ServiremesaBackendAdminBundle:SrLang', 'l', 'WITH', 'cl.lang = l')
                            ->where('l.isoCode = :idLang')
                            ->orderBy('cl.name', 'ASC')
                            ->setParameter('idLang', $idLang);
                    }
                ))
            ->add($builder->create('dateAdd', 'text')->addModelTransformer($transformer))
            ->add($builder->create('dateUpd', 'text')->addModelTransformer($transformer))
            ->add('default1', 'choice', array('choices'=> array('0'=>'NO', '1'=>'SI'), 'empty_value' => 'CHOICE'))
            ->add('active', 'choice', array('choices'=> array('0'=>'INACTIVE', '1'=>'ACTIVE')))
            ->add('type', 'choice', array('choices'=> array('customer'=>'ADDRESS_LIST_OPC_CUSTOMER', 'beneficiary'=>'ADDRESS_LIST_OPC_BENEFICIARY'),'translation_domain' => 'addresses'))
            ;
*/
        /* $formModifier = function (FormInterface $form, $idCountry = 0) {
            if(!is_null($this->country)) $idCountry = $this->country;
            $form->add('idState', 'entity', array(
                    'class'=> 'ServiremesaBackendAdminBundle:SrState',
                    'label'=> 'State',
                    'empty_value' => 'CHOICE',
                    'query_builder' => function (EntityRepository $er) use ($idCountry) {
                        return $er->createQueryBuilder('s')
                            ->where('s.idCountry = :idCountry')
                            ->orderBy('s.name', 'ASC')
                            ->setParameter('idCountry', $idCountry);
                    }
                ));
        };

       $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier, $customer) {
                $data = $event->getData();
                if($data && $data->getIdState()) $idCountry = $data->getIdState()->getIdCountry()->getId();
                else $idCountry = 0;
                $formModifier($event->getForm(), $idCountry);

                $form = $event->getForm();
                if(!is_null($customer))
                $form->add('idCustomer', 'entity', array(
                        'class'=> 'ServiremesaBackendAdminBundle:SrCustomer',
                        'label'=> 'Customer',
                        'required' => false,
                        'empty_data'  => $customer,
                        'query_builder' => function (EntityRepository $er) use ($customer){
                            return $er->createQueryBuilder('c')
                                ->where('c.id = :customer')
                                ->setParameter('customer', $customer);
                        }
                    ));

            }
        );

        $builder->get('countries')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $country = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $country ? $country->getId() : 0);
            }
        );*/

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // $validators = $this->new ? array('admin','admin_new') : array('admin');
        $resolver->setDefaults(array(
               // 'data_class' => 'Serviremesa\BackendAdminBundle\Entity\SrAddress',
               // 'alow_extra_fields' => true
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cube';
    }
}
