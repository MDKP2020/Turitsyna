import React from "react";
import './style.css'
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import { StudentPage } from "../elements/StudentPage"
import { ExcludeStudent } from "../elements/ExcludeStudent"
import { TransferStudent } from "../elements/TransferStudent"
import { ApplicantsPage } from "../elements/ApplicantsPage"
import { NavBar } from '../elements/NavBar'

function Example() {
    return (
        <Router>
            <NavBar />
            <Switch>
                <Route exact path="/" component={StudentPage} />
                <Route exact path="/transfer" component={TransferStudent} />
                <Route exact path="/exclude" component={ExcludeStudent} />
                <Route exact path="/applicants" component={ApplicantsPage} />
            </Switch>
        </Router>
    );
}

export default Example;

if (document.getElementById('root')) {
    ReactDOM.render(<Example />, document.getElementById('root'));
}
