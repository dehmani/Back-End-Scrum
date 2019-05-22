<?php
namespace AppBundle\Services;
use Firebase\JWT\JWT;

class JwtAth{
    public $manager;
    public $key;

    public function __construct($manager)
    {
        $this->manager=$manager;
        $this->key='ghassen-dehmani-secritou';


    }

    public function singup ($email,$password,$getHash=null){
        $user=$this->manager->getRepository('ScrumBundle:user')->findOneBy(
            array("email"=>$email,"password"=>$password)
        );
       // var_dump($user); die;

        $singup=false;
        if(is_object($user))
        {
            $singup=true;
        }

        if($singup)
        {
          $token=  array(
                "sub"=>$user->getId(),
                "name"=>$user->getNom(),
              "surname"=>$user->getSurnom(),
              "email"=>$user->getEmail(),
                //"password"=>$user->getPassword(),
                //"image"=>$user->getImage(),
                "iat"=>time(),
                "exp"=>(time()+(7*24*60*60))
            );
            $jwt= JWT::encode($token,$this->key,'HS256');
            $decode=JWT::decode($jwt,$this->key,array('HS256'));
            if($getHash!=null)
            {
                return $jwt;
            }
            else
            {
                return $decode;
            }

            return array("statut"=>"succes","data"=>"succes");

        }
        else
        {

            return array("statut"=>"error","data"=>"error");
        }

    }

    public function checkToken($jwt,$getIdentity=false)
    {
        $auth=false;
        try
        {
            $decode=JWT::decode($jwt,$this->key,array('HS256'));
        }
        catch(\UnexpectedValueException $e)
        {
           // echo $e; die;
            $auth=false;
        }
        catch(\DomainException $e)
        {
           //echo $e; die;
            $auth=false;
        }
        if(isset($decode->sub))
        {
            $auth=true;
        }
        else
        {
            $auth=false;
        }
        if($getIdentity)
        {
            return $decode;
        }
        else
        {
            return $auth;
        }
    }

}