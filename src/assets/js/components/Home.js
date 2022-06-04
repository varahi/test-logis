import React, {Component} from 'react';
import {Route, Switch,Redirect, Link, withRouter} from 'react-router-dom';
import Companies from './Companies';
import Locations from './Locations';

class Home extends Component {

    render() {
        return (
            <div>
                <Switch>
                    <Redirect exact from="/" to="/companies" />
                    <Route path="/companies" component={Companies} />
                    <Route path="/locations" component={Locations} />
                </Switch>
            </div>
        )
    }
}

export default Home;
