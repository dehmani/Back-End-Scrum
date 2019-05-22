<?php
/**
 * Created by PhpStorm.
 * User: abbes
 * Date: 06/05/2019
 * Time: 3:01 AM
 */

namespace ScrumBundle\Controller;


use ScrumBundle\Entity\epic;
use ScrumBundle\Entity\projet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\HttpFoundation\Request;


class EpicController extends Controller
{

    /**
     * @Route("/afficheEpicall/{idprojet}", name="afficheEpicall", methods={"GET"})
     */
    public function afficheEpicallAction($idprojet)
    {

        $epic= $this->getDoctrine()->getRepository(epic::class)->findBy(
            array('projet'=>$idprojet))
        ;

        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(
            array($epic)
        );
        return new JsonResponse($formatted);

    }


    /**
     * @Route("/afficheEpic/{idepic}", name="afficheEpic", methods={"GET"})
     */
    public function afficheEpicAction($idepic)
    {

        $epic= $this->getDoctrine()->getRepository(epic::class)->findBy(
            array('id'=>$idepic))
        ;

        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(
            $epic
        );
        return new JsonResponse($formatted);

    }


    /**
     * @Route("/ajoutepic", name="ajoutepic",methods={"POST"})
     */

    public function ajoutepicAction(Request $request)
    {


        $helpers= $this->get('app.helpers');
        $jwt= $this->get('app.jwt_auth');

        $result = $helpers->authCheck($request->get("token"));

        if ($result){
            $em = $this->getDoctrine()->getManager();
            $epic = new epic();

            $epic->setDescriptionEpic($request->get('description_epic'));
            $epic->setNomEpic($request->get('nom_epic'));

            $projet= $em->getRepository("ScrumBundle:projet")->find($request->query->get("id_projet"));
            $epic->setProjet($projet);

            $em->persist($epic);
            $em->flush();
            $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
            $formatted = $serializer->normalize([$epic]);
            return new JsonResponse($formatted);

        }
        else{
            echo"Permission Denied" ;
            die;
        }

    }


    /**
     * @Route("/deleteepic/{id}", name="deleteepic",methods={"POST"})
     */

    public function deleteepicAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $epic = $em->getRepository(epic::class)->find($id);
        $em->remove($epic);
        $em->flush();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize($epic);
        return new JsonResponse($formatted);
    }


    /**
     * @Route("/modifierepic/{id}", name="modifierepic")
     */

    public function modifierepicAction(Request $request, $id)
    {
        $helpers= $this->get('app.helpers');
        $jwt= $this->get('app.jwt_auth');

        $result = $helpers->authCheck($request->get("token"));

        if ($result){
            $epic = $this->getDoctrine()->getRepository(
                epic::class)->find($id);

            $em = $this->getDoctrine()->getManager();

            $epic->setDescriptionEpic($request->get('description_epic'));
            $epic->setNomEpic($request->get('nom_epic'));
            // $projet= $em->getRepository("ScrumBundle:projet")->find($request->query->get("id_projet"));
            // $epic->setProjet($projet);

            $em->flush();
            $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
            $formatted = $serializer->normalize([$epic]);
            return new JsonResponse($formatted);
        }
        else
        {
            echo"Permission Denied" ;
            die;
        }



    }

}