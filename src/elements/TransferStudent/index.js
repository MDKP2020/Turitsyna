import React from "react";
import './style.css'
import Paper from '@material-ui/core/Paper';
import { StudentList } from '../StudentList'
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

export class TransferStudent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            transferStudentDialogOpen: false,
            renameGroupDialog: false,
        };
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

    render() {
        return (
            <Paper elevation={3} className="paperContainer">
                <Grid container spacing={0}>
                    <Grid item xs={9} spacing={0}>
                        <Typography variant="h5" noWrap>
                            Список групп
                        </Typography>
                    </Grid>
                </Grid>

                <StudentList ivt={["ИВТ-260", "ИВТ-261", "ИВТ-262", "ИВТ-263", "ИВТ-360", "ИВТ-363", "ИВТ-364", "ИВТ-365",
                    "ИВТ-460", "ИВТ-463", "ИВТ-464", "ИВТ-465"]}
                    prin={["ПрИн-266", "ПрИн-267", "ПрИн-366", "ПрИн-367", "ПрИн-466", "ПрИн-467"]}
                    fiz={["Ф-269", "Ф-369", "Ф-469"]}
                    iit={["ИИТ-273", "ИИТ-373", "ИИТ-473"]} />

                <Grid item spacing={2} container justify="center">
                    <Button variant="contained" onClick={this.handleClickDialogTransfer} color="primary" className='tranferButton'> Перевести студентов </Button>
                </Grid>

                <Dialog open={this.state.transferStudentDialogOpen} aria-labelledby="form-dialog-tranfer-student">
                    <Grid container spacing={0}>
                        <Grid item xs={10} spacing={0}>
                            <DialogTitle>Список группы:</DialogTitle>
                        </Grid>
                        <Grid item xs={1} spacing={0} justify='flex-end'>
                            <IconButton className="dialogAddCloseButton">
                                <CloseIcon onClick={this.handleCloseDialogTransfer} />
                            </IconButton>
                        </Grid>
                    </Grid>
                    <DialogContent>
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

                        <Grid container spacing={2}>
                            <Grid item xs={6} spacing={0} container justify="center">
                                <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleClickDialogRename}> Переименовать </Button>
                            </Grid>

                            <Grid item xs={6} spacing={0} container justify="center">
                                <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleDialogTransferStudent}> Перевести студентов </Button>
                            </Grid>
                        </Grid>

                    </DialogContent>
                </Dialog>

                <Dialog open={this.state.renameGroupDialog} aria-labelledby="form-dialog-rename-group" fullWidth="true" maxWidth="xs">
                    <Grid container spacing={0}>
                        <Grid item xs={10} spacing={0}>
                            <DialogTitle>Переименовать группу</DialogTitle>
                        </Grid>
                        <Grid item xs={1} spacing={0} justify='flex-end'>
                            <IconButton className="dialogAddCloseButton">
                                <CloseIcon onClick={this.handleCloseDialogRename} />
                            </IconButton>
                        </Grid>
                    </Grid>
                    <DialogContent>
                        <TextField label="Группа" className="dialogAddItem"/>

                        <Grid item spacing={0} container justify="center">
                            <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleDialogRenameGroup}> Переименовать </Button>
                        </Grid>
                    </DialogContent>
                </Dialog>
            </Paper>
        )
    }
}