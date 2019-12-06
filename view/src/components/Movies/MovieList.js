import React, {useEffect, useState} from 'react';

const MovieList = props => {
    return(
        <div className="app-body container">
            {props.children}
        </div>
    )
}

export default MovieList;