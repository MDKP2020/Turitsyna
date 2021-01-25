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
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import CircularProgress from '@material-ui/core/CircularProgress';
import axios from 'axios'

export class ApplicantsPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            groupList: [],
            load: true,
            newGroupInput: "",
            addGroupOpen: false,
            directionId: 0,
            direction:[],
        };

        this.updateInputValue = this.updateInputValue.bind(this);
        this.handleChangeDirection = this.handleChangeDirection.bind(this);
    }

    componentDidMount() {
        axios.get("/student-api/getGroupStudentsList",{
            params: {
                study_year_id: null,
                course:[1],
                direction_id:null
            }
        })
            .then(result => this.setState({
                groupList: result.data,
                load: false
            }))

        axios.get("/group-api/getDirections")
            .then(result => this.setState({
                direction: result.data
            }))
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
        let name =""
        this.state.direction.forEach(direction => {
            if (this.state.directionId === direction.id){
                name = direction.name;
            }
        })
        name = name + "-1"+ this.state.newGroupInput
        axios.post("/group-api/create")
            .then(result => {})
            .catch(function (error) {
                console.log(error);
            });
        this.setState({
            addGroupOpen: false,
        })
    }

    updateInputValue (event) {
        this.setState({
            newGroupInput: event.target.value,
        })
    }

    handleChangeDirection (event) {
        this.setState({
            directionId: event.target.value,
        })
    }

    render() {
        if (this.state.load) {
            return (<CircularProgress/>)
        } else {
            let directionSelection = this.state.direction.map(direction => (
                <MenuItem value={direction.id}>{direction.name}-1</MenuItem>
            ))
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
                                        <div className="iconButtonLabel">Назад</div>
                                        <ArrowForwardIcon/>
                                    </IconButton>
                                </Link>
                            </Grid>
                        </Grid>

                        <Grid container spacing={0}>
                            <Grid item xs={1} spacing={0}>
                                <IconButton onClick={this.handleClickAddGroup}>
                                    <AddRoundedIcon color="primary" fontSize="large"/>
                                </IconButton>

                            </Grid>
                            <Grid item xs={1} spacing={0}>
                                <IconButton>
                                    <DeleteRoundedIcon color="primary" fontSize="large"/>
                                </IconButton>
                            </Grid>
                        </Grid>

                        <StudentTableList ivt={this.state.groupList.ИВТ} prin={this.state.groupList.ПрИн}
                                          fiz={this.state.groupList.ИИТ} iit={this.state.groupList.Ф} redact={true}/>
                    </Paper>
                    <Dialog open={this.state.addGroupOpen} aria-labelledby="form-dialog-add-student">
                        <Grid container spacing={0}>
                            <Grid item xs={10} spacing={0}>
                                <DialogTitle>Добавить группу</DialogTitle>
                            </Grid>
                            <Grid item xs={1} spacing={0} justify='flex-end'>
                                <IconButton className="dialogAddCloseButton">
                                    <CloseIcon onClick={this.handleCloseDialogAddGroup}/>
                                </IconButton>
                            </Grid>
                        </Grid>
                        <DialogContent>
                            <FormControl className="DirectionSelected">
                                <InputLabel>Направление</InputLabel>
                                <Select
                                    value={this.state.directionId}
                                    onChange={this.handleChangeDirection}
                                >
                                    {directionSelection}
                                </Select>
                            </FormControl>
                            <TextField label="Номер" type="number" onChange={this.updateInputValue}
                                       value={this.state.newGroupInput}/>

                            <Grid item spacing={0} container justify="center">
                                <Button variant="contained" color="primary" className='tranferButton'
                                        onClick={this.handleDialogAddGroup}> Добавить </Button>
                            </Grid>
                        </DialogContent>
                    </Dialog>
                </div>

            )
        }
    }
}
