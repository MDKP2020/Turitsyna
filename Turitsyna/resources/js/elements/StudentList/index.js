import React from "react";
import ListItem from '@material-ui/core/ListItem';
import { Student } from "../Student"

import axios from 'axios'

export class StudentList extends React.Component {
    render() {
        return (
            <div>
                {this.props.students.map(item => (
                    <ListItem>
                        <Student studentId={item.id} surname={item.surname} name={item.name} patronomyc={item.patronomyc}/>
                    </ListItem>
                ))}
            </div>
        )
    }
}
