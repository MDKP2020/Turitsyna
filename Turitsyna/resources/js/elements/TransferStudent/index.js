import React from "react";
import './style.css'
import Paper from '@material-ui/core/Paper';
import { StudentTableList } from '../StudentTableList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import IconButton from '@material-ui/core/IconButton';
import CloseIcon from '@material-ui/icons/Close';
import TextField from '@material-ui/core/TextField';
import CircularProgress from '@material-ui/core/CircularProgress';
import axios from 'axios'

export class TransferStudent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            groupList: [],
            load: true,
            transferStudentDialogOpen: false,
            renameGroupDialog: false,
            currentGroup: "ИВТ-160",
        };
    }

    componentDidMount() {
        axios.get("/student-api/getGroupStudentsList",{
            params: {
                study_year_id: null,
                course:[1,2,3],
                direction_id:null
            }
        })
            .then(result => this.setState({
                groupList: result.data,
                load: false
            }))
    }

    handleClickDialogTransfer = () => {
        this.setState({
            transferStudentDialogOpen: true,
        })
    }

    handleCloseDialogTransfer = () => {
        this.setState({
            transferStudentDialogOpen: false,
        })
    }

    handleDialogTransferStudent = () => {
        this.setState({
            transferStudentDialogOpen: false,
        })
    }

    handleClickDialogRename = () => {
        this.setState({
            renameGroupDialog: true,
        })
    }

    handleDialogRenameGroup = () => {
        this.setState({
            renameGroupDialog: false,
        })
    }

    handleCloseDialogRename = () => {
        this.setState({
            renameGroupDialog: false,
        })
    }

    handleChangeGroup = (event) => {
        this.setState({
            currentGroup: event.value,
        })
    }

    render() {
        if (this.state.load) {
            return (<CircularProgress/>)
        } else {
            return (
                <Paper elevation={3} className="paperContainer">
                    <Grid container spacing={0}>
                        <Grid item xs={9} spacing={0}>
                            <Typography variant="h5" noWrap>
                                Список групп
                            </Typography>
                        </Grid>
                    </Grid>

                    <StudentTableList ivt={this.state.groupList.ИВТ} prin={this.state.groupList.ПрИн}
                                      fiz={this.state.groupList.ИИТ} iit={this.state.groupList.Ф}/>

                    <Grid item spacing={2} container justify="center">
                        <Button variant="contained" onClick={this.handleClickDialogTransfer} color="primary"
                                className='tranferButton'> Перевести студентов </Button>
                    </Grid>

                    <Dialog open={this.state.transferStudentDialogOpen} aria-labelledby="form-dialog-tranfer-student">
                        <Grid container spacing={0}>
                            <Grid item xs={10} spacing={0}>
                                <DialogTitle>Список группы:</DialogTitle>
                            </Grid>
                            <Grid item xs={1} spacing={0} justify='flex-end'>
                                <IconButton className="dialogAddCloseButton">
                                    <CloseIcon onClick={this.handleCloseDialogTransfer}/>
                                </IconButton>
                            </Grid>
                        </Grid>
                        <DialogContent>
                            <FormControl className="dialogAddItem">
                                <InputLabel id="demo-simple-select-label">Группа</InputLabel>
                                <Select
                                    labelId="demo-simple-select-label"
                                    id="demo-simple-select"
                                    value={this.state.currentGroup}
                                    onChange={event => this.handleChangeGroup(event)}
                                >
                                    <MenuItem value={"ИВТ-160"}>ИВТ-160</MenuItem>
                                    <MenuItem value={"ИВТ-161"}>ИВТ-161</MenuItem>
                                    <MenuItem value={"ИВТ-162"}>ИВТ-162</MenuItem>
                                </Select>
                            </FormControl>

                            <Grid container spacing={2}>
                                <Grid item xs={6} spacing={0} container justify="center">
                                    <Button variant="contained" color="primary" className='tranferButton'
                                            onClick={this.handleClickDialogRename}> Переименовать </Button>
                                </Grid>

                                <Grid item xs={6} spacing={0} container justify="center">
                                    <Button variant="contained" color="primary" className='tranferButton'
                                            onClick={this.handleDialogTransferStudent}> Перевести студентов </Button>
                                </Grid>
                            </Grid>

                        </DialogContent>
                    </Dialog>

                    <Dialog open={this.state.renameGroupDialog} aria-labelledby="form-dialog-rename-group"
                            fullWidth="true" maxWidth="xs">
                        <Grid container spacing={0}>
                            <Grid item xs={10} spacing={0}>
                                <DialogTitle>Переименовать группу</DialogTitle>
                            </Grid>
                            <Grid item xs={1} spacing={0} justify='flex-end'>
                                <IconButton className="dialogAddCloseButton">
                                    <CloseIcon onClick={this.handleCloseDialogRename}/>
                                </IconButton>
                            </Grid>
                        </Grid>
                        <DialogContent>
                            <TextField label="Группа" defaultValue={this.state.currentGroup} className="dialogAddItem"/>

                            <Grid item spacing={0} container justify="center">
                                <Button variant="contained" color="primary" className='tranferButton'
                                        onClick={this.handleDialogRenameGroup}> Переименовать </Button>
                            </Grid>
                        </DialogContent>
                    </Dialog>
                </Paper>
            )
        }
    }
}
