import React, { useEffect, useState } from "react";
import config from "../../config/config.json";
import { useParams } from "react-router";
import "./detail.css"
import Credits from "./Credits.js";
import axios from 'axios';
import Comments from './Comments';
import Loading from '../Loading/Loading';

const MovieDetail = props => {
    const [data, setData] = useState('');
    const [rate, setRate] = useState(1);
    const [comment, setComment] = useState('');
    const [res,setRes] = useState('');
    const { movId } = props.location.state

    let { id } = useParams();
    useEffect(() => {
        fetch(
            `${config.MOVIEDB_URL}/movie/${id}?api_key=${config.API_KEY}&language=en-US`
        ).then(res => {
            res.json().then(data => setData(data));
        });
    }, []);

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.post(`${config.BACKEND_DOMAIN}/api/v1/movie/rate`,{
            'movie_id': movId,
            'score': parseInt(rate),
            'comment': comment
        }).then(data => setRes(data.data))
        .catch(err => console.log(err))
    }

    console.log(res);

    const renderGenres = () => {
        if(data.genres){
            const genres = data.genres.map((genre) => {
                return( 
                <span key={genre.id}>
                    <small>{genre.name},</small>
                </span>
                )
            })
    
            return genres
        }
    }

    return (
        <React.Fragment>
            {data
            ?
            <div className="wrapper">
                <img
                    src={`https://image.tmdb.org/t/p/w1066_and_h600_bestv2/${data.backdrop_path}`}
                    className="movie-banner"
                    alt="Responsive image"
                />
                <div className="movie-detail">
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
                            <form onSubmit={(e)=>handleSubmit(e)}>
                                <h4>Danh gia</h4>
                                <div style={{display: "flex"}}>
                                    <div class="input-group mb-3 score">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" htmlFor="inputGroupSelect01">Score</label>
                                        </div>
                                        <select class="custom-select" id="inputGroupSelect01">
                                            <option defaultValue={rate}>Choose...</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    <textarea type="text" className="comment" name="comment" placeholder="Comment" onChange={(e)=>setComment(e.target.value)} />
                                    <input type="submit" value="Submit" />
                                </div>
                                    {/* <select value={rate} onChange={(e)=>setRate(e.target.value)}>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select> */}
                               
                            </form>
                            {res === 'error'
                            ? alert("You need to login to review this movie")
                            : null}
                        </div>
                        <Comments movieId={movId} res={res} setRes={setRes}/>
                    </div>
                </div>
            </div>
            :
                <Loading/>
            }
        </React.Fragment>
    );
};

export default MovieDetail;
