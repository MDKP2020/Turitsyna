import React from "react";
import './style.css'
import Paper from '@material-ui/core/Paper';
import { Search } from '../Search'
import { Filters } from '../Filters'
import { StudentTableList } from '../StudentTableList'
import IconButton from '@material-ui/core/IconButton';
import CreateIcon from '@material-ui/icons/Create';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Divider from '@material-ui/core/Divider';
import CircularProgress from '@material-ui/core/CircularProgress';
import { Link } from 'react-router-dom';

import axios from 'axios'

export class StudentPage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            groupList: [],
            load: true,
            academicYear: 0,
            course: [],
            trainingProgrammes: []
        };
    }

    componentDidMount() {
        axios.get("/student-api/getGroupStudentsList",{
            params: {
                study_year_id: null,
                course:null,
                direction_id:null
            }
        })
            .then(result => this.setState({
                groupList: result.data,
                load: false
            }))
    }


    filterChange(academicYear, course, trainingProgrammes) {
        this.setState({
            academicYear: academicYear,
            course: course,
            trainingProgrammes: trainingProgrammes
        })
    }

    handleClickFilters = () => {
        let course = this.state.course.length !== 0 ? this.state.course : null
        let direction_id = this.state.trainingProgrammes.length !== 0 ? this.state.trainingProgrammes : null
        axios.get("/student-api/getGroupStudentsList",{
            params: {
                study_year_id: null,
                course:course,
                direction_id:direction_id
            }
        })
            .then(result => this.setState({
                groupList: result.data,
                load: false
            }))
    }

    render() {
        const {academicYear, course, trainingProgrammes, load} = this.state;
        if (load) {
            return (<CircularProgress/>)
        } else {
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
                                    <CreateIcon/>
                                    <div className="iconButtonLabel"> Редактировать список зачисления</div>
                                </IconButton>
                            </Link>
                        </Grid>
                    </Grid>
                    <Search/>
                    <Divider variant="middle"/>
                    <Filters
                        academicYear={academicYear}
                        course={course}
                        trainingProgrammes={trainingProgrammes}
                        onClick={this.handleClickFilters}
                        onChange={(academicYear, course, trainingProgrammes) => this.filterChange(academicYear, course, trainingProgrammes)}/>
                    <Divider variant="middle"/>

                    <StudentTableList ivt={this.state.groupList.ИВТ} prin={this.state.groupList.ПрИн}
                                      fiz={this.state.groupList.ИИТ} iit={this.state.groupList.Ф}/>
                </Paper>
            </div>)
        }
    }
}
