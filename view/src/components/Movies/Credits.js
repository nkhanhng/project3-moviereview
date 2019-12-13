import React, { useEffect, useState } from "react";
import config from "../../config/config.json";
import "./detail.css";

const Credits = props => {
    const [data, setData] = useState([]);
    const { info } = props;
    useEffect(() => {
        fetch(
            `${config.MOVIEDB_URL}/movie/${props.id}/credits?api_key=${config.API_KEY}`
        ).then(res => {
            res.json().then(data => setData(data));
        });
    }, []);

    const renderCast = () => {
        if(data.cast){
            const mainCast = data.cast.slice(0,5).map((character)=>{
                return(
                    <li key={character.cast_id}>{character.name}</li>
                )
            })
            return mainCast;
        }
    }

    return (
        <div>
            <div>Rated: {info.vote_average}</div>
            <div>Thể loại: {props.renderGenres()}</div>
            <div>Đạo diễn: {data.crew ? data.crew['12'].name :'loading'}</div>
            <div>Diễn viên: 
                <ul>
                    {renderCast()}
                </ul>
            </div>
        </div>
    );
};

export default Credits;
