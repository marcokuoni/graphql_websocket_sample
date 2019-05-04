import React from "react";
import gql from "graphql-tag";
import { Mutation } from "react-apollo";

import PropTypes from 'prop-types';

import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import Fab from '@material-ui/core/Fab';
import AddIcon from '@material-ui/icons/Add';

import TextField from '@material-ui/core/TextField';

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

const ADD_PERSON = gql`
  mutation AddPerson($first_name: String!, $second_name: String!) {
    addPerson(first_name: $first_name, second_name: $second_name) {
        id
        first_name
        second_name
    }
  }
`;

const GET_PEOPLE = gql`
  query getPeople {
        id
        first_name
        second_name
  }
`;

class AddPerson extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            first_name: '',
            second_name: '',
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleInputChange(event) {
        const target = event.target;
        const value = target.value;
        const name = target.name;

        this.setState({
            [name]: value
        });
    }

    handleSubmit(event, addPerson) {
        event.preventDefault();
        addPerson({
            variables: {
                first_name: this.state.first_name,
                second_name: this.state.second_name,
            }
        });

        this.setState({
            first_name: '',
            second_name: '',
        })
    }

    render() {
        const { classes } = this.props;

        return (
            <div className={classes.root}>
                <Grid container spacing={24}>
                    <Grid item xs>
                        <Paper className={classes.paper}>
                            <Mutation
                                mutation={ADD_PERSON}
                            >
                                {(addPerson) => (
                                    <div>
                                        <h2>Add a Person</h2>
                                        <form
                                            onSubmit={(event) => {
                                                this.handleSubmit(event, addPerson)
                                            }}
                                        >
                                            <Grid container className={classes.demo} justify="center" spacing={16}>
                                                <Grid item >
                                                    <TextField
                                                        id="first_name"
                                                        name="first_name"
                                                        label="First name"
                                                        value={this.state.first_name}
                                                        onChange={this.handleInputChange}
                                                    />
                                                </Grid>
                                                <Grid item >
                                                    <TextField
                                                        id="second_name"
                                                        name="second_name"
                                                        label="Second name"
                                                        value={this.state.second_name}
                                                        onChange={this.handleInputChange}
                                                    />
                                                </Grid>
                                                <Grid item >
                                                    <Fab color="primary" type="submit" aria-label="Add" className={classes.fab}>
                                                        <AddIcon />
                                                    </Fab>
                                                </Grid>
                                            </Grid>
                                        </form>
                                    </div>
                                )}
                            </Mutation>
                        </Paper>
                    </Grid>
                </Grid>
            </div>
        );
    }
}

AddPerson.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(AddPerson);