<?php

namespace Etiktok\EtiktokBundle\Controller;
use Etiktok\EtiktokBundle\Entity\NewProjects;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fixtures\Bundles\XmlBundle;
use Etiktok\EtiktokBundle\Entity\ProjectBeginWith;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;


class ListController extends Controller
{

    public function generateListAction()
    {
        /** @var NewProjects[] $projectList */
        $projectList = $this->getDoctrine()
            ->getRepository('EtiktokEtiktokBundle:NewProjects')
            ->findAll();


        $alphas = range('A', 'Z');
        $rootNode = new \SimpleXMLElement("<xml/>");


        $liczby=[];
            for ($i=0; $i< count($alphas); $i++ ){
                $liczba=0;
                $alphasxml = $alphas[$i];
                $alphasxml = $rootNode->addChild('letter', $alphas[$i]);

                foreach ($projectList as $project){
                    $projectName = $project->getProjectName();
                    $literkaalfabetu = $alphas[$i];
                    $literkaprojektu = strtoupper($projectName[0]);

                  if($literkaalfabetu == $literkaprojektu) {
                      $liczba++;

                  }

                }
                $liczby[$i]=$liczba;
                $liczbaxml = $alphasxml->addChild('count', $liczba);
              //echo $literkaalfabetu.":"."</br>";
              //echo$liczba;
              //echo"</br>";
            }




       $xml =  $this->render('EtiktokEtiktokBundle:List:list.html.twig', array( 'projectList' => $projectList, 'rootNode'=> $rootNode->asXML(), 'alphas' => $alphas, 'liczby' => $liczby));

$xml->headers->set("Access-Control-Allow-Origin", "http://localhost:8000/detailslist");



        return $xml;
    }

    public function jslistaAction()
    {
        return $this->render('EtiktokEtiktokBundle:List:jslista.html.twig');
    }



}
