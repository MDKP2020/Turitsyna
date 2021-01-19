import React from "react";
import './style.css'
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import { StudentPage } from "../src/elements/StudentPage"
import { ExcludeStudent } from "../src/elements/ExcludeStudent"
import { TransferStudent } from "../src/elements/TransferStudent"
import { ApplicantsPage } from "../src/elements/ApplicantsPage"
import { NavBar } from '../src/elements/NavBar'
// ========================================

ReactDOM.render(
    <Router>
      <NavBar />
      <Switch>
        <Route exact path="/" component={StudentPage} />
        <Route exact path="/transfer" component={TransferStudent} />
        <Route exact path="/exclude" component={ExcludeStudent} />
        <Route exact path="/applicants" component={ApplicantsPage} />
      </Switch>
    </Router>,
  document.getElementById("root")
);