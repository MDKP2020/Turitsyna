import React from "react";
import './style.css'
import Paper from '@material-ui/core/Paper';
import { StudentTableList } from '../StudentTableList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import IconButton from '@material-ui/core/IconButton';
import Button from '@material-ui/core/Button';
import ArrowForwardIcon from '@material-ui/icons/ArrowForward';
import { Link } from 'react-router-dom';
import AddRoundedIcon from '@material-ui/icons/AddRounded';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import CloseIcon from '@material-ui/icons/Close';

import axios from 'axios'

export class ApplicantsPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            addGroupOpen: false,
        };
    }

    componentDidMount() {
        axios.get("http://turitsyna.test1.seschool.ru/student-api/getGroupStudentsList")
            .then(result => console.log("response", result.data))
    }

    handleClickAddGroup = () => {
        this.setState({
            addGroupOpen: true,
        })
    }

    handleCloseDialogAddGroup = () => {
        this.setState({
            addGroupOpen: false,
        })
    }

    handleDialogAddGroup = () => {
        this.setState({
            addGroupOpen: false,
        })
    }

    render() {
        return (<div>
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
                        <IconButton onClick={this.handleClickAddGroup}>
                            <AddRoundedIcon color="primary" fontSize="large" />
                        </IconButton>

                    </Grid>
                    <Grid item xs={1} spacing={0}>
                        <IconButton>
                            <DeleteRoundedIcon color="primary" fontSize="large" />
                        </IconButton>
                    </Grid>
                </Grid>

                <StudentTableList redact={true}
                    ivt={["ИВТ-160", "ИВТ-161", "ИВТ-162", "ИВТ-163"]}
                    prin={["ПрИн-166", "ПрИн-167"]}
                    fiz={["Ф-169"]}
                    iit={["ИИТ-173"]} />
            </Paper>
            <Dialog open={this.state.addGroupOpen} aria-labelledby="form-dialog-add-student">
                    <Grid container spacing={0}>
                        <Grid item xs={10} spacing={0}>
                            <DialogTitle>Добавить группу</DialogTitle>
                        </Grid>
                        <Grid item xs={1} spacing={0} justify='flex-end'>
                            <IconButton className="dialogAddCloseButton">
                                <CloseIcon onClick={this.handleCloseDialogAddGroup} />
                            </IconButton>
                        </Grid>
                    </Grid>
                    <DialogContent>
                        <TextField label="Группа" className="dialogAddItem"/>

                        <Grid item spacing={0} container justify="center">
                            <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleDialogAddGroup}> Добавить </Button>
                        </Grid>
                    </DialogContent>
                </Dialog>
        </div>

        )
    }
}