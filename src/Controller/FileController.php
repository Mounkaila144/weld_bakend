<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/image/article/{img}', name: 'image')]
    public function index($img): Response
    {
        //Récupération du dossier racine grace au kernel et ensuite ajout de l'emplacement du
        //fichier
        $filename = $this->getParameter('kernel.project_dir') . '/public/file/images/article/' . $img;
        //Si le fichier existe alors on le renvoi, sinon retour 404
        if (file_exists($filename)) {
            //retour d'un new BinaryFileResponse avec le nom du fichier
            return new BinaryFileResponse($filename);
        } else {
            return new JsonResponse(null, 404);
        }
    }

    #[Route('/image/video/{img}', name: 'imageVideo')]
    public function image($img): Response
    {
        //Récupération du dossier racine grace au kernel et ensuite ajout de l'emplacement du
        //fichier
        $filename = $this->getParameter('kernel.project_dir') . '/public/file/images/video/' . $img;
        //Si le fichier existe alors on le renvoi, sinon retour 404
        if (file_exists($filename)) {
            //retour d'un new BinaryFileResponse avec le nom du fichier
            return new BinaryFileResponse($filename);
        } else {
            return new JsonResponse(null, 404);
        }
    }

    #[Route('/video/{img}', name: 'video')]
    public function video($img): Response
    {
        //Récupération du dossier racine grace au kernel et ensuite ajout de l'emplacement du
        //fichier
        $filename = $this->getParameter('kernel.project_dir') . '/public/file/video/' . $img;
        //Si le fichier existe alors on le renvoi, sinon retour 404
        if (file_exists($filename)) {
            //retour d'un new BinaryFileResponse avec le nom du fichier
            return new BinaryFileResponse($filename);
        } else {
            return new JsonResponse(null, 404);
        }
    }

}
