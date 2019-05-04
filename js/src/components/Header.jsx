import React from "react";
import { NavLink } from 'react-router-dom';

import PropTypes from 'prop-types';

import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';

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

class Header extends React.Component {
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
                            <NavLink to="/" activeClassName="selected">
                                <Button >
                                    View
                            </Button>
                            </NavLink>
                            <NavLink to="/last-edited" activeClassName="selected">
                                <Button>
                                    Last Edited
                            </Button>
                            </NavLink>
                            <NavLink to="/create" activeClassName="selected">
                                <Button>
                                    Create
                            </Button>
                            </NavLink>
                            <NavLink to="/edit" activeClassName="selected">
                                <Button>
                                    Edit
                            </Button>
                            </NavLink>
                        </Paper>
                    </Grid>
                </Grid>
            </div >
        );
    }
}

Header.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(Header);