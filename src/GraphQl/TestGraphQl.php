<?php
namespace GraphQl;

use GraphQl\PersonResolver;
use Concrete5GraphqlWebsocket\GraphQl\SchemaBuilder;
use Exception;

class TestGraphQl
{
    public static function start()
    {
        //if somebody forgott to install the GraphQL Websocket Package in Concrete5
        if (class_exists('Concrete5GraphqlWebsocket\GraphQl\SchemaBuilder')) {
            SchemaBuilder::registerSchemaFileForMerge(__DIR__ . '/person.gql');
            SchemaBuilder::registerResolverForMerge(PersonResolver::get());
        } else {
            throw new Exception(t('You must install the GraphQL Websocket Package in Concrete5. Navigate to your Composer root directory and use "./vendor/bin/concrete5 c5:package-install concrete5_graphql_websocket" or do it through the dashboard of Concrete5.'));
        }
    }
}
