import React, {Component} from 'react';
import axios from 'axios';

class Companies extends Component {
    constructor() {
        super();
        this.state = { locations: [], loading: true};
    }

    componentDidMount() {
        this.getCompanies();
    }

    getCompanies() {
        axios.get(`http://127.0.0.1/api/companies`).then(companies => {
            this.setState({ companies: companies.data, loading: false})
        })
    }

    render() {
        const loading = this.state.loading;
        return(
            <div>
                <section className="row-section">
                    <div className="container">
                        <h2 className="text-center"><span>List of companies</span></h2>
                        {loading ? (
                            <div className={'row text-center'}><span className="fa fa-spin fa-spinner fa-4x"></span></div>
                        ) : (
                            <div className={'row'}>
                                { this.state.companies.map(company =>
                                    <div className="col-md-10 row-block" key={company.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="companies-list">
                                                    <h4>{company.title}</h4>
                                                    <p>{company.description}</p>
                                                    <a href={`/company-detail/company-${ company.id }`} title={company.title}>Edit company</a>
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
export default Companies;