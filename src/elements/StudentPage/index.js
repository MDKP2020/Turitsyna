import React from "react";
import './style.css'
import Paper from '@material-ui/core/Paper';
import { Search } from '../Search'
import { Filters } from '../Filters'
import { StudentList } from '../StudentList'
import IconButton from '@material-ui/core/IconButton';
import CreateIcon from '@material-ui/icons/Create';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Divider from '@material-ui/core/Divider';
import { Link } from 'react-router-dom';

const axios = require('axios');

export class StudentPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            academicYear: 0,
            course: [],
            trainingProgrammes: []
        };
    }

    componentDidMount() {
        axios.get("http://localhost:8000/student-api/getGroupStudentsList")
            .then(result => console.log("response", result.data))
    }


    filterChange(academicYear, course, trainingProgrammes) {
        this.setState({
            academicYear: academicYear,
            course: course,
            trainingProgrammes: trainingProgrammes
        })
    }

    handleClickFilters = () => {
        console.log(this.state)
    }

    render() {
        const { academicYear, course, trainingProgrammes } = this.state;
        return (<div>
            <Paper elevation={3} className="paperContainer">
                <Grid container spacing={0}>
                    <Grid item xs={9} spacing={0}>
                        <Typography variant="h5" noWrap>
                            Список групп
                        </Typography>
                    </Grid>

                    <Grid item xs={3} spacing={0} justify='flex-end'>
                        <Link to='/applicants'>
                            <IconButton>
                                <CreateIcon />
                                <div className="iconButtonLabel"> Редактировать список зачисления</div>
                            </IconButton>
                        </Link>
                    </Grid>
                </Grid>
                <Search />
                <Divider variant="middle" />
                <Filters
                    academicYear={academicYear}
                    course={course}
                    trainingProgrammes={trainingProgrammes}
                    onClick={this.handleClickFilters}
                    onChange={(academicYear, course, trainingProgrammes) => this.filterChange(academicYear, course, trainingProgrammes)} />
                <Divider variant="middle" />

                <StudentList ivt={["ИВТ-160", "ИВТ-161", "ИВТ-162", "ИВТ-163", "ИВТ-260", "ИВТ-261", "ИВТ-262",
                    "ИВТ-263", "ИВТ-360", "ИВТ-363", "ИВТ-364", "ИВТ-365", "ИВТ-460", "ИВТ-463", "ИВТ-464", "ИВТ-465"]}
                    prin={["ПрИн-166", "ПрИн-167", "ПрИн-266", "ПрИн-267", "ПрИн-366", "ПрИн-367", "ПрИн-466", "ПрИн-467"]}
                    fiz={["Ф-169", "Ф-269", "Ф-369", "Ф-469"]}
                    iit={["ИИТ-173", "ИИТ-273", "ИИТ-373", "ИИТ-473"]} />
            </Paper>
        </div>)
    }
}