import React, { useEffect, useState } from "react";
import config from "../../config/config.json";
import "./detail.css";

const Credits = props => {
    const [data, setData] = useState([]);

    useEffect(() => {
        fetch(
            `${config.MOVIEDB_URL}/movie/${props.id}/credits?api_key=${config.API_KEY}`
        ).then(res => {
            res.json().then(data => setData(data));
        });
    }, []);
    console.log(data);

    return (
        <div>
            <small>Rated</small>
            <small>The loai</small>
            <small>Dao dien</small>
            <small>Dien vien</small>
        </div>
    );
};

export default Credits;
