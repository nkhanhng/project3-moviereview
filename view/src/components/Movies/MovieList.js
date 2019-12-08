import React from 'react';

const MovieList = props => {
    return(
        <div className="app-body container">
            {/* <div className="row row-cols-1 row-cols-md-3">
            </div> */}
            {props.children}    
        </div>
    )
}

export default MovieList;