import React from "react";
import { Student } from "../Student"

import axios from 'axios'

export class StudentList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            students: []
        };
    }

    componentDidMount() {
        axios.get("http://127.0.0.1:8000/student-api/getStudentsFromGroup/" + this.props.groupId)
            .then(result => this.setState({ students: result.data.students }))
    }

    render() {
        let studentList = this.state.students.map(item => (
            <ListItem>
                <Student studentId={item.id} surname={item.surname} name={item.name} patronomyc={item.patronomyc}/>
            </ListItem>
        ))
        return (
            <div>
                {studentList}
            </div>
        )
    }
}