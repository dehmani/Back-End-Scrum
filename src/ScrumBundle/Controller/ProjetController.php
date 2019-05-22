<?php
/**
 * Created by PhpStorm.
 * User: abbes
 * Date: 05/05/2019
 * Time: 6:19 PM
 */

namespace ScrumBundle\Controller;

use ScrumBundle\Entity\projet;
use ScrumBundle\Entity\project_user;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

class ProjetController  extends Controller
{

    /**
     * @Route("/projet/listeProjet", name="listeProjet",methods={"GET"})
     */
    public function AllProjectAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeProjet = $em->getRepository("ScrumBundle:projet")->findAll();

        $serializer = new Serializer([new DateTimeNormalizer(),new ObjectNormalizer()]);
        $formatted = $serializer->normalize([$listeProjet]);
        return new JsonResponse($formatted);

    }


    /**
    * @Route("/projet/addproject", name="ajoutprojet",methods={"POST"})
    */
    public function ajoutprojetAction(Request $request)
    {

         $em = $this->getDoctrine()->getManager();
        $projet = new projet();
        $projet->setNomProjet($request->get('nom_projet'));
        $projet->setDescriptionProjet($request->get('description_projet'));

        //$projet->setDateDebut(new \DateTime());
       // $projet->setDateFin(new \DateTime());
        $projet->setDateDebut($request->get('date_debut'));
      $projet->setDateFin($request->get('date_fin'));

        $usr= $em->getRepository("ScrumBundle:user")->find($request->query->get("id_user"));

        $projet->setUser($usr);

        $em->persist($projet);
        $em->flush();
        //$serializer = new Serializer([new ObjectNormalizer()]);
        //$formatted = $serializer->normalize([$projet]);
        //return new JsonResponse($formatted);
        return new JsonResponse("{sucess : true}");
    }









    /**
     * @Route("/projet/addprojectt", name="ajoutprojett",methods={"POST"})
     */
    public function ajoutttprojetAction(Request $request)
    {
        $helpers= $this->get('app.helpers');
        $jwt= $this->get('app.jwt_auth');
        $result = $helpers->authCheck($request->get("token"));
        if ($result){

            $em = $this->getDoctrine()->getManager();
            $projet = new projet();
            $projet->setNomProjet($request->get('nom_projet'));
            $projet->setDescriptionProjet($request->get('description_projet'));
            $projet->setDateDebut($request->get('date_debut'));
            $projet->setDateFin($request->get('date_fin'));


            $usr= $em->getRepository("ScrumBundle:user")->find($request->query->get("id_user"));

            $projet->setUser($usr);

            $em->persist($projet);

            $em->flush();

            $id_projet=$projet->getId();
            $em1 = $this->getDoctrine()->getManager();
            $project_user = new project_user ();

            $usr= $request->query->get("users");
            $usr = json_decode($usr,true);
            $b = '$usr = '.(str_replace(array('[',']'),array('array(',')'),$usr)).';';
            eval($b);
            for($i=0 ; $i < sizeof($usr);$i++){
                print_r($usr[$i]." ");
                $project_user->setIdUser($usr[$i]);
                $project_user->setId($id_projet);
            }
            $em1->persist($project_user);

            $em1->flush();


            return new JsonResponse( "{sucess :  $id_projet}" );
        }
        else{
            echo ("Permission Denied");
            Die;
        }
    }









    /**
     * @Route("/deleteprojet/{id}", name="deleteprojet", methods={"POST"})
     */

    public function deleteprojetAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(projet::class)->find($id);
        $em->remove($projet);
        $em->flush();

        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize($projet);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/afficheprojet/{id}", name="afficheprojet", methods={"GET"})
     */
    public function findByIdAction($id)
    {

        $projet= $this->getDoctrine()->getRepository(projet::class)->find($id);

        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(
            array('projet'=>$projet,'username'=>get_current_user())
        );
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/modifierprojet/{id}", name="modifierprojet", methods={"POST"})
     */

    public function modifierqprojetAction(Request $request, $id)
    {
        $helpers= $this->get('app.helpers');
        $jwt= $this->get('app.jwt_auth');
        $result = $helpers->authCheck($request->get("token"));
        if($result){
            $projet = $this->getDoctrine()->getRepository(projet::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $projet->setDescriptionProjet($request->get('description_projet'));
            $projet->setDateDebut($request->get('date_debut')/*new \DateTime()*/);
            $projet->setDateFin($request->get('date_fin')/*new \DateTime()*/);
            $projet->setNomProjet($request->get('nom_projet'));
            $em->flush();
            $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
            $formatted = $serializer->normalize([$projet]);
            return new JsonResponse($formatted);
        }
        else{
            echo ("Permission Denied");
            Die;
        }


    }


}