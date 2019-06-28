<?php

namespace GraphQl;

use Doctrine\ORM\EntityManagerInterface;
use Entity\Person;
use Siler\GraphQL as SilerGraphQL;

class PersonResolver
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function get()
    {
        $queryType = [
            'getPeople' => function () {
                $peopleRepository = $this->entityManager->getRepository(Person::class);
                $people = $peopleRepository->findAll();

                return json_decode(json_encode($people));
            },
        ];

        $mutationType = [
            'addPerson' => function ($root, $args) {
                $first_name = $args['first_name'];
                $second_name = $args['second_name'];

                $person = new Person();
                $person->set_first_name($first_name);
                $person->set_second_name($second_name);
                $this->entityManager->persist($person);
                $this->entityManager->flush();

                SilerGraphQL\publish('personEdited', json_decode(json_encode($person)));

                return json_decode(json_encode($person));
            },
            'editPerson' => function ($root, $args) {
                $id = (int) ($args['id']);
                $first_name = $args['first_name'];
                $second_name = $args['second_name'];

                $person = $this->entityManager->find(Person::class, $id);
                $person->set_first_name($first_name);
                $person->set_second_name($second_name);
                $this->entityManager->persist($person);
                $this->entityManager->flush();

                SilerGraphQL\publish('personEdited', json_decode(json_encode($person)));

                return json_decode(json_encode($person));
            },
        ];

        $subscriptionType = [
            'personEdited' => function ($person) {
                return $person;
            },
        ];

        return [
            'Query' => $queryType,
            'Mutation' => $mutationType,
            'Subscription' => $subscriptionType,
        ];
    }
}
