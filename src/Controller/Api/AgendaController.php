<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Calendar;

class AgendaController
{

    private EntityManagerInterface $em;

    /**
     * AgendaController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct (EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Create or update an Calendar
     *
     * @param \App\Entity\Calendar $data
     * @return \App\Entity\Calendar
     */
    public function __invoke (Calendar $data): Calendar
    {
        $repo = $this->em->getRepository(Calendar::class);
        if (($repo->findOneBy(["date" => $data->getDate()])) !== null)
        {
            $agenda = $repo->findOneBy(["date" => $data->getDate()]);
            foreach ($data->getCategories() as $category)
            {
                foreach ($agenda->getCategories() as $agendaCategory)
                {
                    if ($agendaCategory->getId() !== $category->getId())
                    {
                        $agenda->addCategory($category);
                    }
                }
            }

            return $agenda;
        }
        return $data;
    }

}
