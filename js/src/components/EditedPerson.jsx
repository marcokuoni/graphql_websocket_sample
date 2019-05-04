import React from "react";
import { Subscription } from "react-apollo";
import { gql } from "apollo-boost";
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

const PERSON_SUBSCRIPTION = gql`
  subscription onPersonEdited {
    personEdited {
      id
      first_name
      second_name
    }
  }
`;

class EditedPerson extends React.Component {

    render() {
        const { classes } = this.props;

        return (
            <div className={classes.root}>
                <Grid container spacing={24}>
                    <Grid item xs>
                        <Paper className={classes.paper}>
                            <Subscription
                                subscription={PERSON_SUBSCRIPTION}
                            >
                                {
                                    ({ loading, data }) => {
                                        return (
                                            <div>
                                                <h2>Last Edited Person</h2>
                                                <p>Uses Websocket gets the information directly sent from server, open this site on different clients, <NavLink to="/create">add a new person</NavLink> and see the magic under this line happening</p>
                                                {!loading && data && data.personEdited.id && (
                                                    `${data.personEdited.id}, ${data.personEdited.first_name}, ${data.personEdited.second_name}`
                                                )}
                                            </div>
                                        )
                                    }
                                }
                            </Subscription>
                        </Paper>
                    </Grid>
                </Grid>
            </div>

        );
    }
}

EditedPerson.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(EditedPerson);