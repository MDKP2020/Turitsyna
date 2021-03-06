import React from "react";
import './style.css'
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import AddRoundedIcon from '@material-ui/icons/AddRounded';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';
import IconButton from '@material-ui/core/IconButton';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import TextField from '@material-ui/core/TextField';
import CloseIcon from '@material-ui/icons/Close';
import {StudentList} from "../StudentList";

class StudentShowList extends React.Component {
    render() {
        let studentListGroupButton = this.props.redact === true ?
            <Grid container spacing={0}>
                <Grid item xs={1} spacing={0}>
                    <IconButton >
                        <AddRoundedIcon color="primary" fontSize="large" />
                    </IconButton>

                </Grid>
                <Grid item xs={1} spacing={0}>
                    <IconButton>
                        <DeleteRoundedIcon color="primary" fontSize="large" />
                    </IconButton>
                </Grid>
            </Grid>
            : null
        return(
            this.props.showGroup ?
                <div>
                    <Typography variant="h6" noWrap>
                        Список группы {this.props.currentGroup}
                    </Typography>
                    {studentListGroupButton}
                    <StudentList students={this.props.studentInCurrentGroup} />
                </div>
                : null
        )
    }
}

export class StudentTableList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            redact: this.props.redact,
            ivt: this.props.ivt,
            prin: this.props.prin,
            fiz: this.props.fiz,
            iit: this.props.iit,
            studentInCurrentGroup: [],
            currentGroup: "",
            addStudentOpen: false,
            showGroup: false
        };
    }

    groupHandleClick = (name, direction) => {
        if(direction === 'ivt'){
            this.state.ivt.forEach(group =>{
                if (group.group === name){
                    this.setState({
                        studentInCurrentGroup:group.students,
                        showGroup: true,
                        currentGroup: group.group
                    })
                }
            })
        }else if (direction === 'prin'){
            this.state.prin.forEach(group =>{
                if (group.group === name){
                    this.setState({
                        studentInCurrentGroup:group.students,
                        showGroup: true,
                        currentGroup: group.group
                    })
                }
            })
        }else if (direction === 'fiz'){
            this.state.fiz.forEach(group =>{
                if (group.group === name){
                    this.setState({
                        studentInCurrentGroup:group.students,
                        showGroup: true,
                        currentGroup: group.group
                    })
                }
            })
        }else {
            this.state.iit.forEach(group =>{
                if (group.group === name){
                    this.setState({
                        studentInCurrentGroup:group.students,
                        showGroup: true,
                        currentGroup: group.group
                    })
                }
            })
        }
    }

    handleClickAdd = () => {
        this.setState({
            addStudentOpen: true
        })
    }

    handleChangeGroup = () => {

    }

    handleCloseDialogAddStudent = () => {
        this.setState({
            addStudentOpen: false
        })
    }

    handleDialogAddStudent = () => {
        this.setState({
            addStudentOpen: false
        })
    }

    render() {
        //Группы ИВТ
        let listIvt = this.state.ivt.length !== 0 ? this.state.ivt.map((group) => {
            return (
                < Grid item xs={1} >
                    <Button variant="contained" color="primary" className="groupButton"
                            onClick={() => this.groupHandleClick(group.group, 'ivt')}>
                        {group.group}
                    </Button>
                </Grid >
            )
        }) : null
        let listGridIvt = this.state.ivt.length !== 0 ?
            <Grid container item xs={12} spacing={1}>
                {listIvt}
            </Grid> :
            null

        //Группы ПрИн
        let listPrin = this.state.prin.length !== 0 ? this.state.prin.map((group) => {
            return (
                < Grid item xs={1} >
                    <Button variant="contained" color="primary" className="groupButton" onClick={() => this.groupHandleClick(group.group, 'prin')}>
                        {group.group}
                    </Button>
                </Grid >
            )
        }) : null
        let listGridPrin = this.state.prin.length !== 0 ?
            <Grid container item xs={12} spacing={1}>
                {listPrin}
            </Grid> :
            null

        //Группы Физики
        let listFiz = this.state.fiz.length !== 0 ? this.state.fiz.map((group) => {
            return (
                < Grid item xs={1} >
                    <Button variant="contained" color="primary" className="groupButton" onClick={() => this.groupHandleClick(group.group,'fiz')}>
                        {group.group}
                    </Button>
                </Grid >
            )
        }) : null
        let listGridFiz = this.state.fiz.length !== 0 ?
            <Grid container item xs={12} spacing={1}>
                {listFiz}
            </Grid> :
            null

        //Группы ИИТ
        let listIit = this.state.iit.length !== 0 ? this.state.iit.map((group) => {
            return (
                < Grid item xs={1} >
                    <Button variant="contained" color="primary" className="groupButton" onClick={() => this.groupHandleClick(group.group,'iit')}>
                        {group.group}
                    </Button>
                </Grid >
            )
        }): null
        console.log("Говно на палке ",this.state.redact)
        let listGridIit = this.state.iit.length !== 0 ?
            <Grid container item xs={12} spacing={1}>
                {listIit}
            </Grid> :
            null
        return (
            <div className="studentListGrid">
                <Grid container spacing={3}>
                    {listGridIvt}
                    {listGridPrin}
                    {listGridFiz}
                    {listGridIit}
                </Grid>
                <StudentShowList showGroup={this.state.showGroup}
                                 currentGroup={this.state.currentGroup}
                                 studentInCurrentGroup={this.state.studentInCurrentGroup}
                                 redact={this.state.redact}
                                 />
                <Dialog open={this.state.addStudentOpen} aria-labelledby="form-dialog-add-student">
                    <Grid container spacing={0}>
                        <Grid item xs={10} spacing={0}>
                            <DialogTitle>Добавить студента</DialogTitle>
                        </Grid>
                        <Grid item xs={1} spacing={0} justify='flex-end'>
                            <IconButton className="dialogAddCloseButton">
                                <CloseIcon onClick={this.handleCloseDialogAddStudent} />
                            </IconButton>
                        </Grid>
                    </Grid>
                    <DialogContent>
                        <TextField label="ФИО" className="dialogAddItem" />
                        <FormControl className="dialogAddItem">
                            <InputLabel id="demo-simple-select-label">Группа</InputLabel>
                            <Select
                                labelId="demo-simple-select-label"
                                id="demo-simple-select"
                                value={160}
                                onChange={this.handleChangeGroup}
                            >
                                <MenuItem value={160}>ИВТ-160</MenuItem>
                                <MenuItem value={161}>ИВТ-161</MenuItem>
                                <MenuItem value={162}>ИВТ-162</MenuItem>
                            </Select>
                        </FormControl>


                        <Grid item spacing={0} container justify="center">
                            <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleDialogAddStudent}> Добавить </Button>
                        </Grid>
                    </DialogContent>
                </Dialog>
            </div>

        )
    }
}
