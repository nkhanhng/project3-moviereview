import React, { useEffect, useState } from 'react';
import { Link} from 'react-router-dom';
import HomeBody from './Home';
import config from '../../config/config.json'
import HomeNews from './HomeNews';


const HomePage = props => {
    const [data, setData] = useState('')
    
    useEffect(() => {
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/movie/data?draw=1&start=0&length=9`)
            .then(data => setData(data.data))
            .catch(err => console.log(err))
    },[])
    
    const renderMovie = (list) => {
        if(list){
            const trendingMovie = list.data.map((movie)=>{
                return(
                    <div key={movie.id} className="card" style={{width: "18rem", marginBottom: "20px"}}>
                        <Link to={{
                            pathname: `/movie/${movie.key}`,
                            state:{
                                movId: movie.id
                            }
                        }}>
                            <img src={`${movie.image}`}
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
    }

    let list;
    let displayMovie;

    if (data) {
        var splitArray = data.split("\r\n\r\n");
        const headers = splitArray[0];
        const body = splitArray[1];
        // setData1(JSON.parse(body));
        list = JSON.parse(body);
        console.log(list)
        displayMovie = renderMovie(list)
    }
    

    return(
        <HomeBody>
            <div className="row row-cols-1 row-cols-md-3" style={{justifyContent: "space-between"}}>
                {displayMovie}
            </div>
            <HomeNews/>
        </HomeBody>
    )
}

export default HomePage;