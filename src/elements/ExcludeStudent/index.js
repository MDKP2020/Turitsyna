import React from "react";
import Paper from '@material-ui/core/Paper';
import { StudentList } from '../StudentList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';

export class ExcludeStudent extends React.Component {
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

            <StudentList ivt={["ИВТ-460", "ИВТ-463", "ИВТ-464", "ИВТ-465"]}
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