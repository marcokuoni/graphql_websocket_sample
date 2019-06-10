<?php
namespace GraphQl;

use GraphQl\PersonResolver;
use Concrete5GraphqlWebsocket\SchemaBuilder;

class TestGraphQl
{
    public static function start()
    {
        SchemaBuilder::registerSchemaFileForMerge(__DIR__ . '/person.gql');
        SchemaBuilder::registerResolverForMerge(PersonResolver::get());
    }
}
