import React, { useState, useEffect } from "react";
import MovieList from "./MovieList";
import config from "../../config/config.json";
import Pagination from "react-js-pagination";
import { Link} from 'react-router-dom';
import Loading from '../Loading/Loading';
import "./style.css"

const Movies = props => {
    const [data, setData] = useState([]);
    const [totalResult, setTotal] = useState(0)
    const [activePage, setActivePage] = useState(1);
    const [displayMovie, setDisplay] = useState('');
    const limit = 10;
    // const initialPage = 1;
    useEffect(() => {
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/movie/data?draw=1&start=0&length=${limit}`)
            .then(res => {
                setData(res.data)
               
                processData(res.data)
                
            })
            .catch(err => console.log(err))
    }, []);

    const callApi = async pageNumber => {
        setActivePage(pageNumber)
        let start = (pageNumber - 1) * limit;
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/movie/data?draw=1&start=${start}&length=${limit}`)
            .then(res => {
                setData(res.data)
               
                processData(res.data)
            })
            .catch(err => console.log(err))
    };

    const renderMovie = (data) => {
        console.log(data)
        const moviesList = data.data.map(movie => {
            return (
                <div key={movie.id} className="col mb-4">
                    <div className="card" style={{ minWidth: "250px" }}>
                        <Link to={{
                            pathname: `/movie/${movie.key}`,
                            state:{
                                movId: movie.id
                            }
                        }}>
                            <img
                                src={`${movie.image}`}
                                className="card-img-top"
                                alt="..."
                            ></img>
                            <div className="card-body">
                                <h5
                                    className="card-title"
                                    style={{ fontSize: "16px" }}
                                >
                                    {movie.title}
                                </h5>
                                <p className="card-text">
                                    Id movie: {movie.id}
                                </p>
                            </div>
                        </Link>
                    </div>
                </div>
            );
        });
        

        return moviesList;
    };

    let list;
    // let displayMovie;

    const processData = (data=[]) => {
        if (data) {
            var splitArray = data.split("\r\n\r\n");
            const headers = splitArray[0];
            const body = splitArray[1];
            // setData1(JSON.parse(body));
            list = JSON.parse(body);
            setTotal(list.recordsTotal);
            setDisplay(renderMovie(list));
            // setDisplay(displayMovie);
        }
    }

    return (
        <MovieList>
            {displayMovie
            ?
                <div className="row row-cols-1 row-cols-md-3">{displayMovie}</div>
            :   <Loading/>
            }
            {totalResult
            ?
                <div>
                    <Pagination
                        activePage={activePage}
                        totalItemsCount={totalResult}
                        pageRangeDisplayed={5}
                        onChange={callApi}
                    />
                </div>
            :   <Loading/>
            }
        </MovieList>
    );
};

export default Movies;
