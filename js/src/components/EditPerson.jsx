import React from "react";
import gql from "graphql-tag";
import { Mutation } from "react-apollo";
import { NavLink } from 'react-router-dom'

import PropTypes from 'prop-types';

import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import TextField from '@material-ui/core/TextField';
import Fab from '@material-ui/core/Fab';
import EditIcon from '@material-ui/icons/Edit';

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

const EDIT_PERSON = gql`
  mutation EditPerson($id: Int!, $first_name: String!, $second_name: String!) {
    editPerson(id: $id, first_name: $first_name, second_name: $second_name) {
        id
        first_name
        second_name
    }
  }
`;

class EditPerson extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            id: '',
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

    handleSubmit(event, editPerson) {
        event.preventDefault();
        editPerson({
            variables: {
                id: this.state.id,
                first_name: this.state.first_name,
                second_name: this.state.second_name,
            }
        });

        this.setState({
            id: '',
            first_name: '',
            second_name: '',
        });
    }

    render() {
        const { classes } = this.props;

        return (
            <div className={classes.root}>
                <Grid container spacing={24}>
                    <Grid item xs>
                        <Paper className={classes.paper}>
                            <Mutation
                                mutation={EDIT_PERSON}
                            >
                                {(editPerson) => (
                                    <div>
                                        <h2>Edit Person</h2>
                                        <p>Use the id from the <NavLink to="/">list</NavLink> to edit a person</p>
                                        <form
                                            onSubmit={(event) => {
                                                this.handleSubmit(event, editPerson)
                                            }}
                                        >
                                            <Grid container className={classes.demo} justify="center" spacing={16}>
                                                <Grid item >
                                                    <TextField
                                                        id="id"
                                                        name="id"
                                                        label="ID"
                                                        value={this.state.id}
                                                        onChange={this.handleInputChange}
                                                    />
                                                </Grid>
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
                                                    <Fab color="secondary" type="submit" aria-label="Edit" className={classes.fab}>
                                                        <EditIcon />
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

EditPerson.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(EditPerson);