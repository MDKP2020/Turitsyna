import React from "react";
import Paper from '@material-ui/core/Paper';
import { StudentList } from '../StudentList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import IconButton from '@material-ui/core/IconButton';
import Button from '@material-ui/core/Button';
import ArrowForwardIcon from '@material-ui/icons/ArrowForward';
import { Link } from 'react-router-dom';
import AddRoundedIcon from '@material-ui/icons/AddRounded';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';

export class ApplicantsPage extends React.Component {
    render() {
        return (
            <Paper elevation={3} className="paperContainer">
                <Grid container spacing={0}>
                    <Grid item xs={11} spacing={0}>
                        <Typography variant="h5" noWrap>
                            Редактировать список зачисления
                        </Typography>
                    </Grid>

                    <Grid item xs={1} spacing={0} justify='flex-end'>
                        <Link to='/'>
                            <IconButton>
                                <div className="iconButtonLabel">Назад </div>
                                <ArrowForwardIcon />
                            </IconButton>
                        </Link>
                    </Grid>
                </Grid>

                <Grid container spacing={0}>
                    <Grid item xs={1} spacing={0}>
                        <IconButton>
                            <AddRoundedIcon color="primary" fontSize="large" />
                        </IconButton>

                    </Grid>
                    <Grid item xs={1} spacing={0}>
                        <IconButton>
                            <DeleteRoundedIcon color="primary" fontSize="large" />
                        </IconButton>
                    </Grid>
                </Grid>

                <StudentList redact={true}
                    ivt={["ИВТ-160", "ИВТ-161", "ИВТ-162", "ИВТ-163"]}
                    prin={["ПрИн-166", "ПрИн-167"]}
                    fiz={["Ф-169"]}
                    iit={["ИИТ-173"]} />
            </Paper>
        )
    }
}