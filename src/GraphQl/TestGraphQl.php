<?php
namespace GraphQl;

use GraphQl\PersonResolver;
use Concrete5GraphqlWebsocket\GraphQl\SchemaBuilder;

class TestGraphQl
{
    public static function start()
    {
        //if somebody forgott to install the GraphQL Websocket Package, but is a requirement of this composer package
        if (class_exists('Concrete5GraphqlWebsocket\GraphQl\SchemaBuilder')) {
            SchemaBuilder::registerSchemaFileForMerge(__DIR__ . '/person.gql');
            SchemaBuilder::registerResolverForMerge(PersonResolver::get());
        }
    }
}
