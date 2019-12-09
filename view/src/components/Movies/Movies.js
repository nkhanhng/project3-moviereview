import React, { useState, useEffect } from "react";
import MovieList from "./MovieList";
import config from "../../config/config.json";
import Pagination from "react-js-pagination";

const Movies = props => {
    const [data, setData] = useState([]);
    const [totalResult, setTotal] = useState(0)
    const [activePage, setActivePage] = useState(1);
    // const initialPage = 1;
    useEffect(() => {
        fetch(
            `${config.MOVIEDB_URL}/movie/popular?api_key=${config.API_KEY}&language=en-US&page=${activePage}`
        ).then(res => {
            res.json().then(data => {
                setData(data.results);
                setTotal(data.total_results)
            });
        });
    }, []);

    const callApi = async pageNumber => {
        setActivePage(pageNumber)
        let response = await fetch(
            `${config.MOVIEDB_URL}/movie/popular?api_key=${config.API_KEY}&language=en-US&page=${pageNumber}`,
            {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json"
                }
            }
        );

        const dataRes = await response.json();

        setData(dataRes.results);
    };

    const renderMovie = () => {
        const moviesList = data.map(movie => {
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
                                IMDB score: {movie.vote_average}
                            </p>
                        </div>
                    </div>
                </div>
            );
        });

        return moviesList;
    };

    return (
        <MovieList>
            <div className="row row-cols-1 row-cols-md-3">{renderMovie()}</div>
            <div>
                <Pagination
                    activePage={activePage}
                    totalItemsCount={totalResult}
                    pageRangeDisplayed={5}
                    onChange={callApi}
                />
            </div>
        </MovieList>
    );
};

export default Movies;
