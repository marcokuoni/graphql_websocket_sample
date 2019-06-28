<?php

namespace GraphQl;

use Database;
use Siler\GraphQL as SilerGraphQL;

class PersonResolver
{
    public static function get()
    {
        $queryType = [
            'getPeople' => function () {
                $entityManager = Database::connection()->getEntityManager();
                $people = $entityManager->getRepository('\Entity\Person')
                    ->findAll();

                return json_decode(json_encode($people));
            },
        ];

        $mutationType = [
            'addPerson' => function ($root, $args) {
                $entityManager = Database::connection()->getEntityManager();
                $first_name = $args['first_name'];
                $second_name = $args['second_name'];

                $person = new \Entity\Person();
                $person->set_first_name($first_name);
                $person->set_second_name($second_name);
                $entityManager->persist($person);
                $entityManager->flush();

                SilerGraphQL\publish('personEdited', json_decode(json_encode($person)));

                return json_decode(json_encode($person));
            },
            'editPerson' => function ($root, $args) {
                $entityManager = Database::connection()->getEntityManager();
                $id = (int) ($args['id']);
                $first_name = $args['first_name'];
                $second_name = $args['second_name'];

                $person = $entityManager->find('Entity\Person', $id);
                $person->set_first_name($first_name);
                $person->set_second_name($second_name);
                $entityManager->persist($person);
                $entityManager->flush();

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
