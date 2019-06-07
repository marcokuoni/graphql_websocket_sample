<?php
namespace GraphQl;

use GraphQl\PersonResolver;
use Concrete5GraphqlWebsocket\GraphQl\SchemaBuilder;

class TestGraphQl
{
    public static function start()
    {
        SchemaBuilder::registerSchemaFileForMerge(__DIR__ . '/person.gql');
        SchemaBuilder::registerResolverForMerge(PersonResolver::get());
    }
}
