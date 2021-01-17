import React from "react";
import './style.css'
import Paper from '@material-ui/core/Paper';
import { StudentList } from '../StudentList'
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';


export class TransferStudent extends React.Component {
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
                    <Button variant="contained" color="primary" className='tranferButton'> Перевести студентов </Button>
                </Grid>
            </Paper>
        )
    }
}