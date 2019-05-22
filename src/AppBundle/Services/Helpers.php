<?php
namespace AppBundle\Services;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class Helpers{
    public $jwt_auth;
    public function __construct($jwt_auth)
    {
        $this->jwt_auth=$jwt_auth;
    }

    public function check($token){
        $result=$this->jwt_auth->checkToken($token);
        return $result;
    }


    public function authCheck($hash,$getIdentity=false)
    {
        $auth=false;
        if($hash!=null)
        {
            if($getIdentity ==false)
            {
                $result=$this->jwt_auth->checkToken($hash);
                if($result==true)
                {
                    $auth=true;
                }
            }
            else
            {
                $result=$this->jwt_auth->checkToken($hash,true);
                if(is_object($result))
                {
                    $auth=$result;
                }
            }
        }
        return $auth;
    }


    public function dataJson($data)
    {
        $normalizer=array(new GetSetMethodNormalizer());
        $encoder=array("json"=> new JsonEncoder());
        $serializer=new Serializer($normalizer,$encoder);
        $json= $serializer->serialize($data,'json');
        $response =new Response();
        $response->setContent($json);
        $response->headers->set('content-type','application/json');

        return $response;

    }

}