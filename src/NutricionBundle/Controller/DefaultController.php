<?php

namespace NutricionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use NutricionBundle\Entity\Planilla;
use NutricionBundle\Entity\Historial;
use NutricionBundle\Entity\Periodocierre;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;





class DefaultController extends Controller
{
private $valores = array();
    public function indexAction(Request $request)
    {
  $bancos = $this->getDoctrine()->getRepository('NutricionBundle:Bancos')->findAll();
      if($request->getMethod()=="POST"){
                  $username = $request->get("usuarios");
                  $pass = $request->get("clave");

                   $user = $this->getDoctrine()->getRepository('NutricionBundle:Planilla')->findOneBy(array("username"=>$username,"clave"=>md5($pass)));



                   if($user){
                            $session = $request->getSession();
                             $session->set("nombre",$user->getNombre());
                             $session->set("idmasterprincipal",$user->getId());
                             $session->set("tipouser",$user->getTipouser());
                  $idprincipal = $session->get("idmasterprincipal");

                        if($session->get("tipouser") == "A"){
                            return $this->redirect($this->generateUrl('table'));
                          }else{
                            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
                          }
                   }else{
                            $this->get('session')->getFlashBag()->add('fall','ACCESO INVALIDO');
                            return $this->redirect($this->generateUrl('nutricion_homepage'));
                   }
          }


        return $this->render('NutricionBundle:Default:home.html.twig', array(
        'bancos' => $bancos,
    ));
    }


    public function loginAction(Request $request)
    {

      if($request->getMethod()=="POST"){
                  $username = $request->get("usuarios");
                  $pass = $request->get("clave");

               

                   $user = $this->getDoctrine()->getRepository('NutricionBundle:Planilla')->findOneBy(array("username"=>$username,"clave"=>md5($pass)));



                   if($user){
                            $session = $request->getSession();
                             $session->set("nombre",$user->getNombre());
                             $session->set("idmasterprincipal",$user->getId());
                             $session->set("tipouser",$user->getTipouser());
                  $idprincipal = $session->get("idmasterprincipal");

                        if($session->get("tipouser") == "A"){
                            return $this->redirect($this->generateUrl('table'));
                          }else{
                            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
                          }
                   }else{
                            $this->get('session')->getFlashBag()->add('fall','ACCESO INVALIDO');
                            return $this->redirect($this->generateUrl('login'));
                   }
          }


        return $this->render('NutricionBundle:Default:login.html.twig');
    }




    public function registroAction(Request $request)
    {

     $ip=$this->getDoctrine()->getEntityManager(); 

     
    	           $fechanac = new \DateTime($_POST['nacimiento']);
                  $fechared = new \DateTime($_POST['fechared']);

         		   $datos = new Planilla();                   
         		   $datos->setCedula($_POST['cedula']);                  
                   $datos->setNombre($_POST['nombre']);                  
                   $datos->setApellido($_POST['apellidos']);                   
                   $datos->setNacimiento($fechanac);                  
                   $datos->setProfesion($_POST['profesion']);                   
                   $datos->setOcupacion($_POST['ocupacion']);                  
                   $datos->setNacionalidad($_POST['nacionalidad']);
                   $datos->setCorreo($_POST['correo']);              
                   $datos->setDireccion($_POST['direccion']);
                   $datos->setCiudad($_POST['ciudad']);                  
                   $datos->setEstado($_POST['estado']);                   
                   $datos->setPais($_POST['pais']);
                   $datos->setBancos($ip->getReference('NutricionBundle:Bancos',$_POST['bancos']));
                   $datos->setTipocuenta($_POST['tipocuenta']);
                   $datos->setNcuenta($_POST['ncuenta']);                  
                   $datos->setCedulared($_POST['cedulared']);                   
                   $datos->setNombrered($_POST['nombrered']);                  
                   $datos->setApellidored($_POST['apellidored']);
                   $datos->setBancored($_POST['bancored']);
                   $datos->setFechared($fechared);
                   $datos->setNreferencia($_POST['nreferencia']);
                   $datos->setMonto($_POST['monto']);
                   $datos->setClave(md5($_POST['clave']));
                   $datos->setUsername($_POST['username']);
                   $datos->setTelefono($_POST['telefono']);
                   $datos->setRif($_POST['rif']);
                   $em=$this->getDoctrine()->getManager();
                   $em->persist($datos);        
                   $em->flush(); 

                 

                    $generardatos = array();
                    $localidad['idplanilla'] =   $datos->getId();
                     $generardatos[] = $localidad;
                    return new JsonResponse($generardatos);

    }
     public function buscarredAction(Request $request)
    {
         $id = $request->request->get('cedulared');
        // $id = 2;
        
      


        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        WHERE p.cedula = '$id'
        "
        );
        $datos = $queryc->getResult();

    $generardatos = array();
        foreach($datos as $entity){            
            $localidad['nombre'] = $entity->getNombre();
            $localidad['apellido'] = $entity->getApellido();            
            $generardatos[] = $localidad;
        }                             
        //sleep(2);
        
                                              
            return new JsonResponse($generardatos);
    }


public function reporteAction($id){


 $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        WHERE p.id = '$id'
        "
        );
        $datos = $queryc->getResult();

    
        foreach($datos as $entity){            
            $nombre = $entity->getNombre();
            $apellido = $entity->getApellido();            
            $cedula = $entity->getCedula();            
            $fechanac = date_format($entity->getNacimiento(),'d/m/Y');    
            $profesion = $entity->getProfesion();
            $ocupacion = $entity->getOcupacion();
            $direccion = $entity->getDireccion();
            $ciudad = $entity->getCiudad();
            $estado = $entity->getEstado();
            $pais = $entity->getPais();
            $nombrered= $entity->getNombrered();
            $apellidored= $entity->getApellidored();
            $cedulared= $entity->getCedulared();
        }      



  $content = '
    <div class="row">


    <div style="flot:left;width:10px;">
      <h1 style="text-align:center;color:#008040;">PLANILLA DE AFILIACION</h1>
              <h4 style="text-align:center;color:#ff8142">NUTRICELL</h4>
              <h4 style="text-align:center;color:#008040">SOLICITUD DE DISTRIBUIDOR INDEPENDIENTE</h4>
              <h5 style="color:#ff8142;text-align:center;border-top:1px solid black;border-bottom:1px solid black">DATOS DEL SOLICITANTE</h5>

    </div>

 
          <div class="col-md-12">
              
      <table border="0" cellpadding="4">
        <thead>
          <tr>
            <th><b>Nombres:</b></th>
            <th>'.$nombre.'</th>
            <th><b>Apellidos:</b></th>
            <th>'.$apellido.'</th>
          </tr>
          <tr>
            <th><b>C.I.:</b></th>
            <th>'.$cedula.'</th>
            <th><b>Fecha de Nac:</b></th>
            <th>'.$fechanac.'</th>
            
          </tr>
          <tr>
            <th><b>Profesion:</b></th>
            <th>'.$profesion.'</th>
            <th><b>Ocupacion:</b></th>
            <th>'.$ocupacion.'</th>
          </tr>
           <tr>
            <th><b>Direccion:</b></th>
            <th colspan="2">'.$direccion.'</th>           
          </tr>
           <tr>
            <th><b>Ciudad:</b></th>
            <th>'.$ciudad.'</th>
            <th><b>Estado:</b></th>
            <th>'.$estado.'</th>
          </tr>
          <tr>
            <th><b>Pais:</b></th>
            <th>'.$pais.'</th>            
          </tr>
        </thead>
  ';


  $content .= '</table>';
 
  $content .= '
    <div class="row padding">
          <div class="col-md-12" style="text-align:center;">
               <h5 style="color:#ff8142;text-align:center;border-top:1px solid black;border-bottom:1px solid black">DATOS DEL AUSPICIADOR</h5>
            </div>
        <table cellpadding="4">
            <tr>
                <td><b>Nombre:</b></td>
                <td>'.$nombrered.'</td>
                <td><b>Apellido:</b></td>
                <td>'.$apellidored.'</td>
            </tr>
             <tr>
                <td><b>Cedula:</b></td>
                <td>'.$cedulared.'</td>                
            </tr>
        </table>
        
    

    </div>';
    
   
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('NutriCell');
        $pdf->SetTitle(('Planilla de Registro'));
        $pdf->SetSubject('Our Code World Subject');
        /*$pdf->setFontSubsetting(true);*/
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        
        $filename = 'ourcodeworld_pdf_demo';
        
  $pdf->writeHTML($content, true, 0, true, 0);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
}

public function adminAction()
{
        return $this->render('NutricionBundle:Administrador:index.html.twig');
}

public function tableAction(Request $request)
{

 $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }
$idprincipal = $session->get("idmasterprincipal");
       if ($session->get("tipouser") != "A") {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }

    $isAjax = $request->isXmlHttpRequest();

    // Get your Datatable ...
    $datatable = $this->get('app.datatable.post');
    $datatable->buildDatatable();

    // or use the DatatableFactory
    /** @var DatatableInterface $datatable */
    /*$datatable = $this->get('sg_datatables.factory')->create(PlanillaDatatable::class);
    $datatable->buildDatatable();*/

    if ($isAjax) {
        $responseService = $this->get('sg_datatables.response');
        $responseService->setDatatable($datatable);
        $responseService->getDatatableQueryBuilder();

        return $responseService->getResponse();
    }

    return $this->render('NutricionBundle:Administrador:table.html.twig', array(
        'datatable' => $datatable,
    ));
}

public function buscarhistorialAction(Request $request)
{

 $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }
$idprincipal = $session->get("idmasterprincipal");
       if ($session->get("tipouser") != "A") {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }

    $isAjax = $request->isXmlHttpRequest();

    // Get your Datatable ...
    $datatable = $this->get('historial.datatable.post');
    $datatable->buildDatatable();

    // or use the DatatableFactory
    /** @var DatatableInterface $datatable */
    /*$datatable = $this->get('sg_datatables.factory')->create(PlanillaDatatable::class);
    $datatable->buildDatatable();*/

   if ($isAjax) {
        $responseService = $this->get('sg_datatables.response');
        $responseService->setDatatable($datatable);
        $responseService->getDatatableQueryBuilder();

        return $responseService->getResponse();
    }

    return $this->render('NutricionBundle:Administrador:historial.html.twig', array(
        'datatable' => $datatable,
    ));
}

public function recursiva($rows = array(),$cedulared = 0){  


 /* $em = $this->getDoctrine()->getManager();
        $cedulared = $em->getRepository('NutricionBundle:Planilla')->find($cedularedrecursiva);
        echo $cedulared->getNombre();
        echo $this->recursiva($cedulared->getId());*/
        if(!empty($rows))
    {
      
foreach($rows as $row){
      if($row["cedulared"] == $cedulared){
        /*  echo $row["cedula"].$row["nombre"]."<br>";*/
            $this->valores[] =  array("cedulared"=>$row["cedulared"],array("cedula"=>$row["cedula"]));
           self::recursiva($rows,$row["cedula"]);

      }

      
}


}

       
}
public function arbolAction (Request $request,$id){


   $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }


$idprincipal = $session->get("idmasterprincipal");
          if ($session->get("idmasterprincipal") != $id and $session->get("tipouser") != "A") {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }
     


     
        $em = $this->getDoctrine()->getManager();
        $cedulared = $em->getRepository('NutricionBundle:Planilla')->find($id);
        $cedularedmaster =  $cedulared->getCedula();
        $nombremaster = $cedulared->getNombre();
        $apellidomaster = $cedulared->getApellido();
        $idmaster = $cedulared->getId();


         $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        where p.cedulared = '$cedularedmaster'
        "
        );
        $master = $queryc->getResult();


         $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p order by p.id asc"
        );
        $childres = $queryc->getResult();
        
        
        $puntovolumenes = $em->getRepository('NutricionBundle:Volumenes')->findAll();





         return $this->render('NutricionBundle:Administrador:cronologia.html.twig', array(
        'cedularedmaster' => $cedularedmaster,'master'=>$master,'redes'=>$childres,'nombremaster' => $nombremaster,'apellidomaster' => $apellidomaster,'puntovolumenes' => $puntovolumenes,'idmaster'=>$idmaster
    ));
}



public function logoutAction(Request $request){                             
    $session=$request->getSession();
    $session->clear();
    return $this->redirect($this->generateUrl('nutricion_homepage'));
}


 public function buscarmasterAction(Request $request)
    {
         $id = $request->request->get('cedula');
        
        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        WHERE p.cedula = '$id'
        "
        );
        $datos = $queryc->getResult();

    $generardatos = false;
        if(count($datos)>0){
            $generardatos = true;
        }                                                           
        return new JsonResponse($generardatos);
    }

    public function buscarusernameAction(Request $request)
    {
         $id = $request->request->get('username');
        
        $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        WHERE p.username = '$id'
        "
        );
        $datos = $queryc->getResult();

    $generardatos = false;
        if(count($datos)>0){
            $generardatos = true;
        }                                                           
        return new JsonResponse($generardatos);
    }

public function perfilAction (Request $request,$id){

   $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }

        $idprincipal = $session->get("idmasterprincipal");
  /*        if ($session->get("idmasterprincipal") != $id) {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }*/
     
        $em = $this->getDoctrine()->getManager();
        $master = $em->getRepository('NutricionBundle:Planilla')->find($id);
        
          // create a task and give it some dummy data for this example
        /*$task = new Planilla();*/
        $form = $this->createFormBuilder($master)
            ->add('cedula')
            ->add('nombre')
            ->add('apellido')            
            ->add('bancos', EntityType::class, array(
    // query choices from this entity
    'class' => 'NutricionBundle:Bancos',

    // use the User.username property as the visible option string
    'choice_label' => 'nombres',

    // used to render a select box, check boxes or radios
    // 'multiple' => true,
    // 'expanded' => true,
))
            ->add('ncuenta')
            ->add('correo', EmailType::class)
            ->add('telefono',TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Repetir Contraseña'),
            ))

            ->add('save', SubmitType::class, array('label' => 'Actualizar'))
            ->getForm();

    $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

  $task = $form->getData();
  $em = $this->getDoctrine()->getManager();  

         if($_FILES['foto']['name'] <> ''){
            $foto_name= $_FILES['foto']['name'];    
            $foto_size= $_FILES['foto']['size'];
            $foto_type=  $_FILES['foto']['type'];
            $foto_temporal = $_FILES['foto']['tmp_name'];               
                   
             if ($foto_type=="image/x-png" OR $foto_type=="image/png"){
                    $extension="image/png";
            }
            if ($foto_type=="image/pjpeg" OR $foto_type=="image/jpeg"){
                    $extension="image/jpeg";
            }
            if ($foto_type=="image/gif" OR $foto_type=="image/gif"){
                    $extension="image/gif";
            }
          
            $f1= fopen($foto_temporal,"rb");
            #leemos el fichero completo limitando
            #  la lectura al tamaño de fichero      
            $foto_reconvertida = fread($f1, $foto_size);   
          
           
            $master->setImage($foto_reconvertida);
             $master->setTamano($foto_size);
             $master->setFormato($extension);
              $em->persist($master); 
             $em->flush();

            }else{
              $em->persist($master); 
             $em->flush();

            }
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
      

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
       
        return $this->redirect($this->generateUrl('table'));
    }

         return $this->render('NutricionBundle:Administrador:perfil.html.twig', array(
        'master' => $master, 'form' => $form->createView(),'id'=>$id));
}


public function miniAction($id) {
    $em = $this->getDoctrine()->getManager();
                    $query = $em->createQuery('SELECT a FROM NutricionBundle:Planilla a WHERE  a.id = '.$id);
                    $datos = $query->getResult();
                    
                     $content = '';
                    foreach($datos as $valor){
                    $tipo_foto=$valor->getFormato();           
                    while(!feof($valor->getImage())){
                        $content.= fread($valor->getImage(), 1024);
                    }
                    rewind($valor->getImage());
     } 
     

$ruta =  imagecreatefromstring($content);
//$ruta="http://localhost/decobodas/web/admin/listado/19";
$ancho="300"; 
$alto="300"; 
$fuente = $ruta; 
$imgAncho = imagesx($fuente); 
$imgAlto =imagesy($fuente); 
$imagen = ImageCreateTrueColor($ancho,$alto); 
ImageCopyResampled($imagen,$fuente,0,0,0,0,$ancho,$alto,$imgAncho,$imgAlto); 


//$estampa = imagecreatefromjpeg('images/mini.jpg');
$im = $imagen;
//$margen_dcho = 0;
//$margen_inf = 0;
//$sx = imagesx($estampa);
//$sy = imagesy($estampa);
//imagecopymerge($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa), 20);     

Header("Content-type: $tipo_foto"); 
//imageJpeg($imagen);
echo imagejpeg($im);
die();
   
}


public function diferencialAction (Request $request,$id){
     


   $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }


$idprincipal = $session->get("idmasterprincipal");
          if ($session->get("idmasterprincipal") != $id and $session->get("tipouser") != "A") {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }

        $em = $this->getDoctrine()->getManager();
        $cedulared = $em->getRepository('NutricionBundle:Planilla')->find($id);
        $cedularedmaster =  $cedulared->getCedula();
        $nombremaster = $cedulared->getNombre();
        $apellidomaster = $cedulared->getApellido();
        $idmaster = $cedulared->getId();


         $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        where p.cedulared = '$cedularedmaster'
        "
        );
        $master = $queryc->getResult();


         $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p order by p.id asc"
        );
        $childres = $queryc->getResult();
        
        
        $puntovolumenes = $em->getRepository('NutricionBundle:Volumenes')->findAll();


        $valorvolumen = 2000;


         return $this->render('NutricionBundle:Administrador:diferencial.html.twig', array(
        'cedularedmaster' => $cedularedmaster,'master'=>$master,'redes'=>$childres,'nombremaster' => $nombremaster,'apellidomaster' => $apellidomaster,'puntovolumenes' => $puntovolumenes,'idmaster'=>$idmaster,'valorvolumen'=>$valorvolumen
    ));
}

public function residualAction (Request $request,$id){
     

   $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }


$idprincipal = $session->get("idmasterprincipal");
          if ($session->get("idmasterprincipal") != $id and $session->get("tipouser") != "A") {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }
        $em = $this->getDoctrine()->getManager();
        $cedulared = $em->getRepository('NutricionBundle:Planilla')->find($id);
        $cedularedmaster =  $cedulared->getCedula();
        $nombremaster = $cedulared->getNombre();
        $apellidomaster = $cedulared->getApellido();
        $idmaster = $cedulared->getId();


         $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p
        where p.cedulared = '$cedularedmaster'
        "
        );
        $master = $queryc->getResult();


         $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "SELECT p
        FROM NutricionBundle:Planilla p order by p.id asc"
        );
        $childres = $queryc->getResult();
        
        
        $puntovolumenes = $em->getRepository('NutricionBundle:Volumenes')->findAll();


        $valorvolumen = 2000;


         return $this->render('NutricionBundle:Administrador:residual.html.twig', array(
        'cedularedmaster' => $cedularedmaster,'master'=>$master,'redes'=>$childres,'nombremaster' => $nombremaster,'apellidomaster' => $apellidomaster,'puntovolumenes' => $puntovolumenes,'idmaster'=>$idmaster,'valorvolumen'=>$valorvolumen
    ));
}


public function documentoAction(Request $request)
{

 $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }
$idprincipal = $session->get("idmasterprincipal");
       if ($session->get("tipouser") != "A") {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }

    $isAjax = $request->isXmlHttpRequest();

    // Get your Datatable ...
    $datatable = $this->get('documento.datatable.post');
    $datatable->buildDatatable();

    // or use the DatatableFactory
    /** @var DatatableInterface $datatable */
    /*$datatable = $this->get('sg_datatables.factory')->create(PlanillaDatatable::class);
    $datatable->buildDatatable();*/

    if ($isAjax) {
        $responseService = $this->get('sg_datatables.response');
        $responseService->setDatatable($datatable);
        $responseService->getDatatableQueryBuilder();

        return $responseService->getResponse();
    }

    return $this->render('NutricionBundle:Administrador:table.html.twig', array(
        'datatable' => $datatable,
    ));
}




public function planillaAction (Request $request,$id){

   $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        }

        $idprincipal = $session->get("idmasterprincipal");
  /*        if ($session->get("idmasterprincipal") != $id) {
             $this->get('session')->getFlashBag()->add('fall','NO TIENES ACCESO');
            return $this->redirect($this->generateUrl('miperfil', array('id' => $idprincipal)));
          }*/
     
        $em = $this->getDoctrine()->getManager();
        $master = $em->getRepository('NutricionBundle:Planilla')->find($id);
        
          // create a task and give it some dummy data for this example
        /*$task = new Planilla();*/
        $form = $this->createFormBuilder($master)
            ->add('cedula')
            ->add('nombre')
            ->add('apellido')            
            ->add('bancos', EntityType::class, array(
    // query choices from this entity
    'class' => 'NutricionBundle:Bancos',

    // use the User.username property as the visible option string
    'choice_label' => 'nombres',

    // used to render a select box, check boxes or radios
    // 'multiple' => true,
    // 'expanded' => true,
))
            ->add('ncuenta')
            ->add('correo', EmailType::class)
            ->add('telefono',TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Repetir Contraseña'),

            ))

            ->add('save', SubmitType::class, array('label' => 'Actualizar'))
           // ->add('pdf', ButtonType::class, array('label' => 'pdf'))
            ->getForm();                

    $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

  $task = $form->getData();
  $em = $this->getDoctrine()->getManager();  

         if($_FILES['foto']['name'] <> ''){
            $foto_name= $_FILES['foto']['name'];    
            $foto_size= $_FILES['foto']['size'];
            $foto_type=  $_FILES['foto']['type'];
            $foto_temporal = $_FILES['foto']['tmp_name'];               
                   
             if ($foto_type=="image/x-png" OR $foto_type=="image/png"){
                    $extension="image/png";
            }
            if ($foto_type=="image/pjpeg" OR $foto_type=="image/jpeg"){
                    $extension="image/jpeg";
            }
            if ($foto_type=="image/gif" OR $foto_type=="image/gif"){
                    $extension="image/gif";
            }
          
            $f1= fopen($foto_temporal,"rb");
            #leemos el fichero completo limitando
            #  la lectura al tamaño de fichero      
            $foto_reconvertida = fread($f1, $foto_size);   
          
           
            $master->setImage($foto_reconvertida);
             $master->setTamano($foto_size);
             $master->setFormato($extension);
              $em->persist($master); 
             $em->flush();

            }else{
              $em->persist($master); 
             $em->flush();

            }
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
      

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
       
        return $this->redirect($this->generateUrl('documento'));
    }

         return $this->render('NutricionBundle:Administrador:perfil.html.twig', array(
        'master' => $master, 'form' => $form->createView(),'id'=>$id));
}

 public function eliminarAction(Request $request,$cedula){
   
     $session = $request->getSession();
        if (!$session->get("idmasterprincipal")) {
            $this->get('session')->getFlashBag()->add('fall','ES NECESARIO LOGUEARSE');
            return $this->redirect($this->generateUrl('nutricion_homepage'));
        };

          
    $em=$this->getDoctrine()->getManager();
    $Planilla=$em->getRepository('NutricionBundle:Planilla')->findOneBy(['cedula' => $cedula]);
    $em -> remove($Planilla);
    $em -> flush();

            return $this->redirect($this->generateUrl('documento'));
      
    }

public function periodoAction (Request $request){

          
       


   
        $periodocierre = new Periodocierre();
        $form = $this->createForm('NutricionBundle\Form\PeriodocierreType', $periodocierre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($periodocierre);
            $em->flush();


            $em = $this->getDoctrine()->getManager();
            $volumenes = $em->getRepository('NutricionBundle:Volumenes')->findAll();


  foreach($volumenes as $sourceEntity) {



            
$ip=$this->getDoctrine()->getEntityManager();  

        $targetEntity = new Historial();        
        $targetEntity->setMonto($sourceEntity->getMonto());
        $targetEntity->setPv($sourceEntity->getPv());
        $targetEntity->setFecha($sourceEntity->getFecha());
        $targetEntity->setPlanilla($ip->getReference('NutricionBundle:Planilla',$sourceEntity->getPlanilla()));
        $targetEntity->setPeriodocierre($ip->getReference('NutricionBundle:Periodocierre',$sourceEntity->getPeriodocierre()));
        
                        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($targetEntity);
            $entityManager->flush();

    }


 $em = $this->getDoctrine()->getManager();
        $queryc = $em->createQuery(
        "DELETE NutricionBundle:Volumenes p");
        $datos = $queryc->execute();





            return $this->redirectToRoute('periodocierre_show', array('id' => $periodocierre->getId()));
        }
    

        return $this->render('NutricionBundle:Administrador:periodo.html.twig', array(
            'periodocierre' => $periodocierre,
            'form' => $form->createView(),
        ));



   }

}
