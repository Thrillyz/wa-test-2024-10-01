<?php

namespace App\Controller\Api;

use App\Entity\Job;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class CreateJobController extends AbstractController
{

    public function __invoke($id, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Job
    {
        $person = $entityManager->getRepository(Person::class)->find($id);

        if (!$person) {
            throw new NotFoundHttpException('Person not found');
        }
        $job = $serializer->deserialize($request->getContent(), Job::class, 'json', ['groups' => ['write']]);
        $job->setPerson($person);

        return $job;
    }
}
