import React from "react";
import gql from "graphql-tag";
import { Query } from "react-apollo";
import { NavLink } from 'react-router-dom'

import PropTypes from 'prop-types';

import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';

const styles = theme => ({
    root: {
        flexGrow: 1,
    },
    paper: {
        padding: theme.spacing.unit * 2,
        textAlign: 'center',
        color: theme.palette.text.secondary,
    },
});


const GET_PEOPLE = gql`
  query GetPeople {
      getPeople {
        id
        first_name
        second_name
      }
  }
`;

class PeopleList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
        };
    }

    render() {
        const { classes } = this.props;

        return (
            <div className={classes.root}>
                <Grid container spacing={24}>
                    <Grid item xs>
                        <Paper className={classes.paper}>
                            <Query
                                query={GET_PEOPLE}
                                pollInterval={500}
                            >
                                {({ loading, error, data }) => {
                                    if (loading) return "Loading...";
                                    if (error) return `Error! ${error.message}`;

                                    return (
                                        <div>
                                            <h2>People list</h2>
                                                <p>Uses polling with an interval of 500ms, open this site on different clients, <NavLink to="/create">add a new person</NavLink> and see the magic under this line happening</p>
                                            {data && data.getPeople.map((person) => (
                                                <div key={person.id}>{`${person.id}, ${person.first_name}, ${person.second_name}`}</div>
                                            ))}
                                        </div>
                                    );
                                }}
                            </Query>
                        </Paper>
                    </Grid>
                </Grid>
            </div>
        );
    }
}

PeopleList.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(PeopleList);