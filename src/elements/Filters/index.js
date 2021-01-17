import React from "react";
import './style.css'
import Typography from '@material-ui/core/Typography';
import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';

export class Filters extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            academicYear: 0,
            course: "",
            trainingProgrammes: ""
        };
    }

    academicYearHandleChange = (event) => {
        this.setState({
            academicYear: event.target.value,
        })
    }

    courseHandleChange = (event) => {
        this.setState({
            course: event.target.value,
        })
    }

    trainingProgrammesHandleChange = (event) => {
        this.setState({
            trainingProgrammes: event.target.value,
        })
    }

    deleteHandleClick = () => {
        this.setState({
            academicYear: 0,
            course: "",
            trainingProgrammes: ""
        })
    }

    render() {
        return (<div>
            <Typography variant="h5" noWrap>
                Фильтры
            </Typography>

            <Grid container spacing={3} alignItems="center">
                <Grid item xs={9} spacing={1}>
                    <FormControl variant="outlined" margin="normal">
                        <InputLabel id="academicYearLabel">Учебный год</InputLabel>
                        <Select
                            labelId="academicYearLabel"
                            id="academicYear"
                            value={this.state.academicYear}
                            onChange={this.academicYearHandleChange}
                            label="Учебный год"
                        >
                            <MenuItem value="0">2020/2021</MenuItem>
                        </Select>
                    </FormControl>

                    <FormControl variant="outlined" margin="normal">
                        <InputLabel id="courseLabel">Курс</InputLabel>
                        <Select
                            labelId="courseLabel"
                            id="course"
                            value={this.state.course}
                            onChange={this.courseHandleChange}
                            label="Курс"
                        >
                            <MenuItem value="1">1</MenuItem>
                            <MenuItem value="2">2</MenuItem>
                            <MenuItem value="3">3</MenuItem>
                            <MenuItem value="4">4</MenuItem>
                        </Select>
                    </FormControl>

                    <FormControl variant="outlined" margin="normal">
                        <InputLabel id="trainingProgrammesLabel">Направление</InputLabel>
                        <Select
                            labelId="trainingProgrammesLabel"
                            id="trainingProgrammes"
                            value={this.state.trainingProgrammes}
                            onChange={this.trainingProgrammesHandleChange}
                            label="Направление"
                        >
                            <MenuItem value="1">ИВТ</MenuItem>
                            <MenuItem value="2">ПрИн</MenuItem>
                            <MenuItem value="3">Физика</MenuItem>
                            <MenuItem value="4">ИИТ</MenuItem>
                        </Select>
                    </FormControl>
                </Grid>

                <Grid item xs={1} spacing={2}>
                    <Button variant="contained" color="primary">
                        Применить
                    </Button>
                </Grid>

                <Grid item xs={1} spacing={2}>
                    <Button variant="contained" color="primary" onClick={this.deleteHandleClick}>
                        Сбросить
                    </Button>
                </Grid>
            </Grid>
        </div>)
    }
}