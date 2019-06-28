<?php

namespace GraphQl;

use Concrete5GraphqlWebsocket\SchemaBuilder;

class TestGraphQl
{
    /**
     * @var \GraphQl\PersonResolver
     */
    protected $personResolver;

    /**
     * @param \GraphQl\PersonResolver $personResolver
     */
    public function __construct(PersonResolver $personResolver)
    {
        $this->personResolver = $personResolver;
    }

    public function start()
    {
        SchemaBuilder::registerSchemaFileForMerge(__DIR__ . '/person.gql');
        SchemaBuilder::registerResolverForMerge($this->personResolver->get());
    }
}
