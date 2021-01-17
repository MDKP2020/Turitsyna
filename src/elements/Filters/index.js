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
    render() {
        const { academicYear, course, trainingProgrammes } = this.props;
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
                            value={this.props.academicYear}
                            onChange={event => this.props.onChange(event.target.value, course, trainingProgrammes)}
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
                            multiple
                            value={this.props.course}
                            onChange={event => this.props.onChange(academicYear, event.target.value, trainingProgrammes)}
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
                            multiple
                            value={this.props.trainingProgrammes}
                            onChange={event => this.props.onChange(academicYear, course, event.target.value)}
                            label="Направление"
                        >
                            <MenuItem value="IVT">ИВТ</MenuItem>
                            <MenuItem value="PRIN">ПрИн</MenuItem>
                            <MenuItem value="F">Физика</MenuItem>
                            <MenuItem value="IIT">ИИТ</MenuItem>
                        </Select>
                    </FormControl>
                </Grid>

                <Grid item xs={1} spacing={2}>
                    <Button variant="contained" color="primary" onClick={this.props.onClick}>
                        Применить
                    </Button>
                </Grid>

                <Grid item xs={1} spacing={2}>
                    <Button variant="contained" color="primary" onClick={event =>this.props.onChange(0, [], [])}>
                        Сбросить
                    </Button>
                </Grid>
            </Grid>
        </div>)
    }
}