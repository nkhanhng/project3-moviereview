import React, { useEffect, useState } from "react";
import config from "../../config/config.json";
import { useParams } from "react-router";
import "./detail.css"
import Credits from "./Credits.js";

const MovieDetail = props => {
    const [data, setData] = useState([]);
    let { id } = useParams();

    return (
        <div className="container">
            <img
                src={`https://image.tmdb.org/t/p/w1066_and_h600_bestv2/${data.backdrop_path}`}
                className="movie-banner"
                alt="Responsive image"
            />
            <div className="movie-detail container">
                <div className="poster-info">
                    <div>
                        <img
                            src={`https://image.tmdb.org/t/p/w300_and_h450_bestv2/${data.poster_path}`}
                            alt="poster"
                        />
                    </div>
                    <div className="movie-info">
                        <h3>Infomation</h3>
                        <div>
                            <Credits renderGenres={renderGenres} info={data} id={id}/>
                        </div>
                    </div>
                </div>
                <div className="movie-review">
                    <h3 className="movie-title">{data.original_title}</h3>
                    {data ? renderGenres() : null}
                    <h4>Overview</h4>
                    <div className="movie-des">
                        {data.overview}
                    </div>
                    <div className="rate-review">
                        <form>
                            <h4>Danh gia</h4>
                            <option>
                            <select>
                                <option value="grapefruit">Grapefruit</option>
                                <option value="lime">Lime</option>
                                <option selected value="coconut">Coconut</option>
                                <option value="mango">Mango</option>
                                <option value="grapefruit">Grapefruit</option>
                                <option value="lime">Lime</option>
                                <option selected value="coconut">Coconut</option>
                                <option value="mango">Mango</option>
                                <option value="grapefruit">Grapefruit</option>
                                <option value="lime">Lime</option>
                            </select>
                            </option>
                            <textarea type="text" name="comment" placeholder="Binh luan" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default MovieDetail;
