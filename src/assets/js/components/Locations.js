import React, {Component} from 'react';
import {Route, Switch, Redirect, Link, withRouter} from 'react-router-dom';
import axios from 'axios';

class Locations extends Component {
    constructor() {
        super();
        this.state = { locations: [], loading: true};
    }

    componentDidMount() {
        this.getLocations();
    }

    getLocations() {
        axios.get(`http://127.0.0.1/api/locations`).then(locations => {
            this.setState({ locations: locations.data, loading: false})
        })
    }

    render() {
        const loading = this.state.loading;
        return(
            <div>
                <section className="row-section">
                    <div className="container">
                        <h2 className="text-center"><span>List of locations</span></h2>
                        {loading ? (
                            <div className={'row text-center'}><span className="fa fa-spin fa-spinner fa-4x"></span></div>
                        ) : (
                            <div className={'row'}>
                                { this.state.locations.map(location =>
                                    <div className="col-md-10 row-block" key={location.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="location-liust">
                                                    <h4>{location.title}</h4>
                                                    <p>{location.description}</p>
                                                    <a href={`/edit-location/location-${ location.id }`} title={location.title}>Edit location</a>
                                                    {/* <Link to={`/edit-location/location-${ location.id }`}>Edit location</Link> */}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </section>
            </div>
        )
    }
}
export default Locations;