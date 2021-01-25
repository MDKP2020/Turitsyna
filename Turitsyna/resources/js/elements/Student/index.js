import React from "react";
import './style.css'
import ListItemText from '@material-ui/core/ListItemText';
import IconButton from '@material-ui/core/IconButton';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import CloseIcon from '@material-ui/icons/Close';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import ListItem from '@material-ui/core/ListItem';

import axios from 'axios'

export class Student extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            changeStudentDialog: false,
        };
    }

    handleDialogDeleteStudent = () => {
        axios.post("/expulsion-api/student/" + this.props.studentId)
            .catch(function (error) {
                console.log(error);
            });
    }

    handleClickChangeStudent = () => {
        this.setState({
            changeStudentDialog: true,
        })
    }

    handleCloseDialogChangeStudent = () => {
        this.setState({
            changeStudentDialog: false,
        })
    }

    render() {
        return (
            <div>
                <ListItem button onClick={this.handleClickChangeStudent}>
                    <ListItemText  primary={this.props.surname + " " + this.props.name + " " + this.props.patronomyc} />
                </ListItem>


                <Dialog fullWidth="false" open={this.state.changeStudentDialog} aria-labelledby="form-dialog-change-student">
                    <Grid container spacing={0}>
                        <Grid item xs={10} spacing={0}>
                            <DialogTitle>Редактировать студента</DialogTitle>
                        </Grid>
                        <Grid item xs={1} spacing={0} justify='flex-end'>
                            <IconButton className="dialogAddCloseButton">
                                <CloseIcon onClick={this.handleCloseDialogChangeStudent} />
                            </IconButton>
                        </Grid>
                    </Grid>
                    <DialogContent>
                        <TextField label="Фамилия" disabled defaultValue={this.props.surname} className="dialogChangeItem" />
                        <TextField label="Имя" disabled defaultValue={this.props.name} className="dialogChangeItem" />
                        <TextField label="Отчество" disabled defaultValue={this.props.patronomyc} className="dialogChangeItem" />

                        <Grid item spacing={0} container justify="center">
                            <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleDialogDeleteStudent}> Отчислить </Button>
                        </Grid>

                    </DialogContent>
                </Dialog>
            </div >
        )
    }

}
