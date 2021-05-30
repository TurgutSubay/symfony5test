<?php

namespace App\Controller;

use App\Entity\Offices;
use App\Entity\Personnel;
use App\Repository\OfficesRepository;
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
    public function index(OfficesRepository $officeRepository): Response
    {
        $offices =  $officeRepository->findAll();
        $office=null;
        foreach ($offices as $item) {
            $office[] = ['id'=>$item->getId(),'name'=> $item->getName()];
        }

        return $this->render('personnel/index.html.twig', ['office'=>$office]);
    }

    /**
     * @Route("/personnelData", name="personnelData", methods={"GET","POST"})
     * @param $request
     */
    public function dataTableRead(Request $request, PersonnelRepository $personnelRepository)
    {
        $result = true;
        $recordsTotal = 0;
        $draw = $request->get('draw');
        $formFilter = $request->get('formFilter');

        if (!isset($formFilter)) {
            return $this->json([
                'draw' => 1,
                'result' => $result,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsTotal,
                'data' => [],
            ]);
        }

        /**
         * JoinOfficeQueryBuilder method join two tables
         * and gives personnel data.
         */

        $personnel = $personnelRepository->JoinOfficeQueryBuilder($formFilter);
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

        return $this->json([
            'draw' => $draw,
            'result' => $result,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsTotal,
            'data' => $data,
        ]);
    }

}