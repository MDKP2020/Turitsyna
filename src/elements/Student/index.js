import React from "react";
import ListItemText from '@material-ui/core/ListItemText';
import IconButton from '@material-ui/core/IconButton';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import TextField from '@material-ui/core/TextField';
import CloseIcon from '@material-ui/icons/Close';
import Grid from '@material-ui/core/Grid';

import axios from 'axios'

export class Student extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            changeStudentDialog: false,
        };
    }

    handleDialogDeleteStudent = () => {
        axios.post("http://turitsyna.test1.seschool.ru/expulsion-api/student/" + this.props.studentId)
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
                <ListItemText onClick={this.handleClickChangeStudent} primary={this.props.surname + this.props.name + this.props.patronomyc} />

                <Dialog open={this.state.addStudentOpen} aria-labelledby="form-dialog-add-student">
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
                        <TextField label="Фамилия" disabled defaultValue={this.props.surname} className="dialogAddItem" />
                        <TextField label="Имя" disabled defaultValue={this.props.name} className="dialogAddItem" />
                        <TextField label="Отчество" disabled defaultValue={this.props.patronomyc} className="dialogAddItem" />

                        <Grid item spacing={0} container justify="center">
                            <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleDialogDeleteStudent}> Отчислить </Button>
                        </Grid>

                    </DialogContent>
                </Dialog>
            </div >
        )
    }

}