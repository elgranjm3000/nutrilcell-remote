<?php
namespace NutricionBundle\DependencyInjection;

use NutricionBundle\Entity\Planilla;
use NutricionBundle\Entity\Volumenes;
use Symfony\Bridge\Doctrine\RegistryInterface;



class FunctionsExtension extends \Twig_Extension
{
   
	protected $pvsuma;
    protected $doctrine;
    // Retrieve doctrine from the constructor
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
 public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('monto', array($this, 'montoFilter')),
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('grupal', array($this, 'grupalFilter')),
            new \Twig_SimpleFilter('diferencial', array($this, 'diferencialFilter')),
        );
    }



    public function montoFilter($number)
    {

        $em = $this->doctrine->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Volumenes p
        WHERE p.idafiliado = '$number'
        "
        );
        $datos = $queryc->getResult();
        $suma = 0;
        foreach($datos as $entity){            
            $suma = $suma + $entity->getMonto();
        } 
        $price = $suma;
        return $price;
    }




    public function priceFilter($number)
    {

        $em = $this->doctrine->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Volumenes p
        WHERE p.idafiliado = '$number'
        "
        );
        $datos = $queryc->getResult();
    	$suma = 0;
    	foreach($datos as $entity){            
            $suma = $suma + $entity->getPv();
        } 
    	$price = $suma;
        return $price;
    }

    public function grupalFilter($id,$sumatoria = 0){
		$this->pvsuma = $sumatoria;
    	 $em = $this->doctrine->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        WHERE p.cedulared = '$id'
        "
        );
        $datos = $queryc->getResult();

        
    	foreach($datos as $entity){     
    		$idhijos = $entity->getId();
    		$idcedulahijos = $entity->getCedula();
    		
    		//getCedula
    		$em = $this->doctrine->getManager();
        	$queryc = $em->createQuery(
        	"SELECT p 
        	FROM NutricionBundle:Volumenes p
        	WHERE p.idafiliado = '$idhijos'
        	"
        	);

            $datos2 = $queryc->getResult();

            $acumulador = 0;
           	 foreach($datos2 as $entity2){ 
        	  	$acumulador = $acumulador + $entity2->getPv();                       
             }
             if($acumulador<300){
                $this->pvsuma = $this->pvsuma + $acumulador;
             }
          if($acumulador<300){
        	  self::grupalFilter($idcedulahijos,$this->pvsuma);
            }

         
        } 

    	$grupo = $this->pvsuma;
    	return $grupo;
    }

    public function diferencialFilter($valor){
        $entorno = 0;
        if($valor >= 100 and $valor <= 199){
            $entorno = 10;
        }else if($valor >= 200 and $valor <= 299){
            $entorno = 15;
        }else if($valor >= 300){
            $entorno = 20;
        }

        return $entorno;
    }

    public function getName()
    {
        return 'app_extension';
    }

}