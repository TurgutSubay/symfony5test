<?php

namespace App\Controller;

use App\Entity\Offices;
use App\Entity\Personnel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PersonnelController extends AbstractController
{
    /**
     * @Route("/personnel", name="personnel", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('personnel/index.html.twig', []);

    }

    /**
     * @Route("/personnelData", name="personnelData", methods={"GET","POST"})
     * @param $request
     */
    public function dataTableRead(Request $request)
    {
        $draw = $request->get('draw');
        $repository = $this->getDoctrine()->getRepository(Personnel::class);
        $products = $repository->findAll();
        $result = true;
        $recordsTotal = 0;
        foreach ($products as $item) {
            $data[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'office' => $item->getOffice(),
                'position' => $item->getPosition(),
            ];
        }
        if (!isset($data)) {
            $data = null;
            $result = false;
        } else {
            $recordsTotal = count($data);
        }

        return $this->json([
            'draw' => $draw,
            'result' => $result,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsTotal,
            'data' => $data,
        ]);
    }
}
