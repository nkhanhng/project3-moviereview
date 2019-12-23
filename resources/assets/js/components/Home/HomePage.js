import React, { useEffect, useState } from 'react';
import { Link} from 'react-router-dom';
import HomeBody from './Home';
import config from '../../config/config.json'
import HomeNews from './HomeNews';


const HomePage = props => {
    const [data, setData] = useState([])
    
    useEffect(() => {
        fetch(`${config.MOVIEDB_URL}/movie/now_playing?api_key=${config.API_KEY}&language=en-US&page=1`)
        .then(res => {
            res.json()
            .then((data)=> setData(data.results))
        })
    },[])
    

    const renderMovie = () => {
        const trendingMovie = data.slice(0,9).map((movie)=>{
            return(
                <div key={movie.id} className="card" style={{width: "18rem"}}>
                    <Link to={`/movie/${movie.id}`}>
                        <img src={`https://image.tmdb.org/t/p/w370_and_h556_bestv2/${movie.poster_path}`}
                            className="card-img-top" alt="..."></img>
                            <div className="card-body">
                                <p className="card-text">
                                    {movie.title}
                                </p>
                            </div>
                    </Link>
                </div>
            )
        })

        return trendingMovie;
    }

    return(
        <HomeBody>
            <div className="card-group">
                {renderMovie()}
            </div>
            <HomeNews/>
        </HomeBody>
    )
}

export default HomePage;