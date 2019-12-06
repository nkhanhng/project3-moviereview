import React, {useState, useEffect} from 'react';
import MovieList from './MovieList';
import config from '../../config/config.json'

const Movies = props => {
    const [data, setData] = useState([])
    useEffect(() => {
        fetch(`/movie/popular?api_key=${config.API_KEY}&language=en-US&page=1`)
            .then(res => {
                res.json()
                    .then((data)=> setData(data.results))
            })
    },[])
    return(
        <MovieList>
            <div>Hello</div>
        </MovieList>
    )
}

export default Movies;