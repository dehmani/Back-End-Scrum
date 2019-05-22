<?php
/**
 * Created by PhpStorm.
 * User: abbes
 * Date: 04/05/2019
 * Time: 11:38 AM
 */

namespace ScrumBundle\Controller;
use ScrumBundle\Entity\user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;



use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class UserController extends Controller
{
    /**
     * @Route("/user/login", name="login",methods={"POST"})
     */

    public function loginAction(Request $request)
    {
        $helpers= $this->get('app.helpers');
        $jwt= $this->get('app.jwt_auth');

        $json=$request->get("json"/*,null*/);

        if($json !=null){
            $params =json_decode($json);
            $email=(isset($params->email))? $params->email: null;
            $password=(isset($params->password))? $params->password: null;
            $getHash=(isset($params->gethash))? $params->gethash: null;
            $password=hash('sha256',$password);
            //var_dump($email,$password);
            // $emailContraint=new Assert\Email();
            // $emailContraint->message="email no valide";
            //   $validate_email= $this->get("validator")->validate($email,$emailContraint);
            /*  if(count( $validate_email)==0 && $password!= null)
              {*/
            /*  if($getHash==null || $getHash=='false')
              {
                  $result = $jwt->singup($email, $password);
              }*/
            //   else {
            $result = $jwt->singup($email,$password,true);
            // }
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
            return new \Symfony\Component\HttpFoundation\JsonResponse ($result) ;

            //  }else{
            //     $result=$jwt->singup ($email,$password);
            //     return $helpers->dataJson($result);

            //   }
        }else {

            echo 'no param';
        }
        die;
    }

    /**
     * @Route("/user/new", name="new",methods={"POST"})
     */
    public function newAction(Request $request)
    {
        $helpers= $this->get('app.helpers');
        $json=$request->get("json",null);

        if($json !=null){
            $params =json_decode($json);
            $role="user";
            $email=(isset($params->email))? $params->email: null;


            $password=(isset($params->password))? $params->password: null;
            $name=(isset($params->nom))? $params->nom: null;
            $surname=(isset($params->surnom))? $params->surnom: null;
            $user= new user();
            $user->setEmail($email);
            $user->setNom($name);
            $user->setSurnom($surname);
            $user->setRole($role);


            $pwd=hash('sha256',$password);

            $user->setPassword($pwd);

            $em=$this->getDoctrine()->getManager();
            $isset=$em->getRepository("ScrumBundle:user")->findBy(array("email"=>$email));
            if(count($isset)==0){
                $em->persist($user);
                $em->flush();
                return $helpers->dataJson(array("status"=>"succes","message"=>"succes"));
            }else{
                return $helpers->dataJson(array("status"=>"error","message"=>"duplication"));
            }
        }else {

            return $helpers->dataJson(array("status"=>"error","message"=>"no param"));
        }
        return null;

    }

    /**
     * @Route("/user/AuthCheck", name="AuthCheck",methods={"POST"})
     */

    public function AuthChekAction(Request $request)
    {
        $jwtAuth= $this->get('app.helpers');
        $hash=$request->get('auth',null);
        $result=$jwtAuth->check($hash);
        return $jwtAuth->dataJson(array("status"=>$result));

    }

    /**
     * @Route("/user/getall/", name="getall", methods={"GET"})
     */
    public function GetAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeuser = $em->getRepository("ScrumBundle:user")->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($listeuser);
        return new JsonResponse($formatted);

    }



    /**
     * @Route("/afficheuser/{id}", name="afficheuser", methods={"GET"})
     */
    public function afficheuserAction($id)
    {

        $user= $this->getDoctrine()->getRepository(user::class)->find($id)
        ;


        $serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()]);
        $formatted = $serializer->normalize(
            array($user)
        );
        return new JsonResponse($formatted);

    }





























}