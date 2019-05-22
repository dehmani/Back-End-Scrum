<?php
/**
 * Created by PhpStorm.
 * User: abbes
 * Date: 07/05/2019
 * Time: 12:21 AM
 */

namespace ScrumBundle\Controller;


use ScrumBundle\Entity\user_story;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\HttpFoundation\Request;

class User_StoryController extends Controller
{

    /**
     * @Route("/ajoutUserStory", name="ajoutUserStory",methods={"POST"})
     */

    public function ajoutUserStoryAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $ustory = new user_story();

        $ustory->setNomSerStory($request->get('nom_ustory'));
        $ustory->setDescriptionUserStory($request->get('desc_ustory'));
        $ustory->setBusinessValue($request->get('bus_value'));
        $ustory->setPointComp($request->get('pt_comp'));
        $ustory->setStatut($request->get('statut'));
        $ustory->setPriorite($request->get('priorite'));

        $epic= $em->getRepository("ScrumBundle:epic")->find($request->query->get("id_epic"));
        $ustory->setEpic($epic);

        $em->persist($ustory);
        $em->flush();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize([$ustory]);
        return new JsonResponse($formatted);

    }



    /**
     * @Route("/afficheustory/{idEpic}", name="afficheustory", methods={"GET"})
     */
    public function afficheuserAction($idEpic)
    {

        $ustory= $this->getDoctrine()->getRepository(user_story::class)->findBy(
            array('id'=>$idEpic))
        ;


        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(
            $ustory
        );
        return new JsonResponse($formatted);


    }


    /**
     *@Route("/afficheustoryAll/{idUserStory}", name="afficheallustorya", methods={"GET"})
     */
    public function afficheustoryAction($idUserStory)
    {

        $ustory= $this->getDoctrine()->getRepository(user_story::class)->findBy(
            array('epic'=>$idUserStory))
        ;


        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(
            array($ustory)
        );
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/deleteustory/{id}", name="deleteustory",methods={"POST"})
     */

    public function deleteustoryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ustory = $em->getRepository(user_story::class)->find($id);
        $em->remove($ustory);
        $em->flush();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ustory);
        return new JsonResponse($formatted);
    }



    /**
     * @Route("/modifierustory/{id}", name="modifierustory",methods={"POST"})
     */

    public function modifierustoryAction(Request $request, $id)
    {
       $ustory = $this->getDoctrine()->getRepository(user_story::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $ustory->setNomSerStory($request->get('nom_ustory'));
        $ustory->setDescriptionUserStory($request->get('desc_ustory'));
        $ustory->setBusinessValue($request->get('bus_value'));
        $ustory->setPointComp($request->get('pt_comp'));
        $ustory->setStatut($request->get('statut'));
        $ustory->setPriorite($request->get('priorite'));
        $epic= $em->getRepository('ScrumBundle:epic')->find($request->query->get('id_epic'));
        $ustory->setEpic($epic);
        $em->flush();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize([$ustory]);
        return new JsonResponse($formatted);

    }




    /**
     * @Route("/modifierstatut/{id}", name="modifierstatut",methods={"POST"})
     */

    public function modifierstatutAction(Request $request, $id)
    {
        $ustory = $this->getDoctrine()->getRepository(user_story::class)->find($id);
        $em = $this->getDoctrine()->getManager();
          $ustory->setStatut($request->get('statut'));
        //$epic= $em->getRepository('ScrumBundle:epic')->find($request->query->get('id_epic'));
        //$ustory->setEpic($epic);
        $em->flush();
        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize([$ustory]);
        return new JsonResponse($formatted);

    }



























}