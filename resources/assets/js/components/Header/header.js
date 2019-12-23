import React, { useEffect, useState } from "react";
import { Link} from 'react-router-dom';
import config from '../../config/config.json'

const Header = props => {
    const [data, setData] = useState('')
    useEffect(() => {
        fetch(`${config.BACKEND_DOMAIN}/api/v1/user`)
        .then(res => {
            res.json()
            .then((data)=> setData(data))
        })
    },[])
    return (
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
            
                <Link className="navbar-brand" to="/">
                    Home
                </Link>
                <button
                    className="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item active">
                            <Link className="nav-link" to="/movies">
                                Movies <span className="sr-only">(current)</span>
                            </Link>
                        </li>
                        <li className="nav-item" to="/news">
                            <Link className="nav-link">
                                News
                            </Link>
                        </li>
                        {!data 
                        ? 
                            
                            <div style={{display:"flex"}}>
                                <li className="nav-item" to="/news">
                                    <a href="http://localhost:8000/login" className="nav-link">
                                        Login
                                    </a>
                                </li>
                                <li className="nav-item" to="/news">
                                    <a href="http://localhost:8000/register" className="nav-link">
                                        Register
                                    </a>
                                </li>
                            </div>
                        :
                        <li className="nav-item">
                            <a href="http://localhost:8000/movies">
                                {data.name}
                            </a>
                        </li>
                        }
                    </ul>
                    {/* <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> */}
                </div>
            
        </nav>
    );
};

export default Header;
