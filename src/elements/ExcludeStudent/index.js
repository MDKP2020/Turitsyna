import React from "react";
import Paper from '@material-ui/core/Paper';
import { StudentTableList } from '../StudentTableList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';

import axios from 'axios'

export class ExcludeStudent extends React.Component {

    componentDidMount() {
        axios.get("http://127.0.0.1:8000/student-api/getGroupStudentsList")
            .then(result => console.log("response", result.data))
    }

    render(){
         return(
            <Paper elevation={3} className="paperContainer">
            <Grid container spacing={0}>
                <Grid item xs={9} spacing={0}>
                    <Typography variant="h5" noWrap>
                        Список групп
                    </Typography>
                </Grid>
            </Grid>

            <StudentTableList ivt={["ИВТ-460", "ИВТ-463", "ИВТ-464", "ИВТ-465"]}
                prin={["ПрИн-466", "ПрИн-467"]}
                fiz={["Ф-469"]}
                iit={["ИИТ-473"]} />

            <Grid item spacing={2} container justify="center">
                <Button variant="contained" color="primary" className='tranferButton'> Отчислить студентов </Button>
            </Grid>
        </Paper>
         )
    }
}