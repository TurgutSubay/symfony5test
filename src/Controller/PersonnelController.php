<?php

namespace App\Controller;

use App\Entity\Offices;
use App\Entity\Personnel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use App\Repository\PersonnelRepository;

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
    public function dataTableRead(Request $request, PersonnelRepository $personnelRepository)
    {
        $result = true;
        $recordsTotal = 0;
        /*
         * JoinOfficeQueryBuilder method join two tables
         * and gives personnel data.
         */

        $personnel = $personnelRepository->JoinOfficeQueryBuilder(1);

        foreach ($personnel as $item) {
            $data[] = [
                'id' => $item[0]->getId(),
                'name' => $item[0]->getName(),
                'office' => $item['officeName'],
                'position' => $item[0]->getPosition(),
            ];
        }
        if (!isset($data)) {
            $data = null;
            $result = false;
        } else {
            $recordsTotal = count($data);
        }

        $draw = $request->get('draw');
        return $this->json([
            'draw' => $draw,
            'result' => $result,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsTotal,
            'data' => $data,
        ]);
    }
}