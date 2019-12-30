import React, { useState, useEffect } from "react";
import MovieList from "./MovieList";
import config from "../../config/config.json";
import Pagination from "react-js-pagination";
import { Link} from 'react-router-dom';
import { useParams } from "react-router";
import Loading from '../Loading/Loading';

const Movies = props => {
    const [data, setData] = useState('');
    const [totalResult, setTotal] = useState(0)
    const [activePage, setActivePage] = useState(1);
    const {searchResult} = props.location.state;
    
    // const initialPage = 1;
    let { search } = useParams();

    useEffect(() => {
        if(search){
            axios.get(`${config.MOVIEDB_URL}/search/movie?api_key=${config.API_KEY}&language=en-US&page=1&query=${search}`)
                    .then(res => {
                        setData(res.data)
                        setTotal(res.data.total_results)
                    })
                    .catch(err => console.log(err))
        }
    }, []);
    const callApi = pageNumber => {
        setActivePage(pageNumber)
        axios.get(`${config.MOVIEDB_URL}/search/movie?api_key=${config.API_KEY}&language=en-US&page=${pageNumber}&query=${search}`)
                .then(res => {
                    setData(res.data)
                    setTotal(res.data.total_results)
                })
                .catch(err => console.log(err))
    };

    const renderMovie = () => {
        if(data){
            const moviesList = data.results.map(movie => {
                return (
                    <div key={movie.id} className="col mb-4">
                        <div className="card" style={{ minWidth: "250px" }}>
                                <img
                                    src={`https://image.tmdb.org/t/p/w370_and_h556_bestv2/${movie.poster_path}`}
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
                                        Key movie: {movie.id}
                                    </p>
                                </div>
                            
                        </div>
                    </div>
                );
            });
    
            return moviesList;
        }
    };

    return (
        <MovieList>
            {data
            ?
                <React.Fragment>
                    <p>You can use these movie's keys and add to our database</p>
                    <div className="row row-cols-1 row-cols-md-3">{renderMovie()}</div>
                    <div>
                        <Pagination
                            activePage={activePage}
                            totalItemsCount={totalResult}
                            pageRangeDisplayed={5}
                            onChange={callApi}
                        />
                    </div>
                </React.Fragment>
            :   <Loading/>
            }
        </MovieList>
    );
};

export default Movies;
