import React from "react";
import ReactDOM from 'react-dom';
import ApolloClient from 'apollo-client';
import { split } from 'apollo-link';
import { HttpLink } from 'apollo-link-http';
import { WebSocketLink } from 'apollo-link-ws';
import { getMainDefinition } from 'apollo-utilities';
import { ApolloProvider } from "react-apollo";
import { InMemoryCache } from 'apollo-cache-inmemory';
import { HashRouter, Route } from 'react-router-dom';

import EditedPerson from './components/EditedPerson';
import EditPerson from './components/EditPerson';
import AddPerson from './components/AddPerson';
import PeopleList from './components/PeopleList';
import Header from './components/Header';

import configMap from 'Utilities/GetGlobals';
import SetConfigMap from 'Utilities/SetConfigMap';
import log from 'Log';

function App() {
    // Create an http link:
    const httpLink = new HttpLink({
        uri: (configMap.secureProtocol ? 'https://' : 'http://') + configMap.graphqlUrl,
    });

    // Create a WebSocket link:
    const wsLink = new WebSocketLink({
        uri: (configMap.secureProtocol ? 'wss://' : 'ws:/') + configMap.websocketUrl,
        options: {
            reconnect: true
        }
    });

    // using the ability to split links, you can send data to each link
    // depending on what kind of operation is being sent
    const link = split(
        // split based on operation type
        ({ query }) => {
            const definition = getMainDefinition(query);
            return (
                definition.kind === 'OperationDefinition' &&
                definition.operation === 'subscription'
            );
        },
        wsLink,
        httpLink,
    );

    const client = new ApolloClient({
        link: link,
        cache: new InMemoryCache().restore(window.__APOLLO_STATE__),
    });

    return (
        <ApolloProvider client={client}>
            <HashRouter>
                <div>
                    <Header></Header>
                    <div>
                        <Route exact path="/" component={PeopleList} />
                        <Route exact path="/last-edited" component={EditedPerson} />
                        <Route exact path="/create" component={AddPerson} />
                        <Route exact path="/edit" component={EditPerson} />
                    </div>
                </div>
            </HashRouter>
        </ApolloProvider>
    );
}




window.person = (function () {
    const configModule = function (input_map) {
        SetConfigMap({
            input_map: input_map,
            settable_map: configMap.settable_map,
            config_map: configMap
        });
    };

    const initModule = function () {
        ReactDOM.render(<App />, document.querySelector('#person'));
        log('It is running, jap', true);
    };

    return {
        configModule: configModule,
        initModule: initModule
    };
}());