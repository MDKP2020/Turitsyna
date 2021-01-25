import React from "react";
import Paper from '@material-ui/core/Paper';
import { StudentTableList } from '../StudentTableList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import CircularProgress from '@material-ui/core/CircularProgress';
import axios from 'axios'

export class ExcludeStudent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            groupList: [],
            load: true,
        };
    }

    componentDidMount() {
        axios.get("/student-api/getGroupStudentsList",{
            params: {
                study_year_id: null,
                course:[4],
                direction_id:null
            }
        })
            .then(result => this.setState({
                groupList: result.data,
                load: false
            }))
    }

    handleClickExclude = () => {
        axios.post("/expulsion-api/graduates")
            .then(result => {})
            .catch(function (error) {
                console.log(error);
            });
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
                        <Button variant="contained" color="primary" className='tranferButton' onClick={this.handleClickExclude}> Отчислить
                            студентов </Button>
                    </Grid>
                </Paper>
            )
        }
    }
}
