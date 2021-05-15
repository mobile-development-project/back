<?php

namespace App\Controller\Api;

use App\Entity\Calendar;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AgendaDeleteCategoryController
{

    private EntityManagerInterface $em;

    public function __construct (EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke (Calendar $data, Request $request): Calendar
    {
        preg_match('/[0-9]+/m', $request->getContent(), $matches);
        $id = $matches[0];
        foreach ($data->getCategories() as $category)
        {
            if ($category->getId() == $id)
            {
                $data->removeCategory($category);
            }
        }

        return $data;
    }

}
