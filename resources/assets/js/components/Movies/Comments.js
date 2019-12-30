import React, { useEffect, useState } from 'react';
import config from '../../config/config.json';
import axios from 'axios';

const Comments = props => {
    const [data, setData] = useState('')
    const [showModal, setShowModal] = useState(false)
    useEffect(() => {
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/movie/${props.movieId}`)
            .then(data => {
                setData(data.data)
                props.setRes('')
            })
            .catch(err => console.log(err))
    }, [props.res])

    const renderComments = () => {
        if(data){
            const commentList = data.map((comment)=>{
                return(
                    <div key={comment.id} className="review">
                        <div className="info">
                            <div className="review-user">
                                {comment.user.name}
                            </div>
                            <div className="review-score">Score: {comment.score}/10</div>
                        </div>
                        <small style={{color:"#525252", fontStyle:"italic"}}>
                            {comment.created_at}
                        </small>
                        <div className="review-content">{comment.comment}</div>
                    </div>
                )
            })
            return commentList;
        }
    }

    return (
        <div className="">
            Comment
            {renderComments()}
        </div>
    )
}

export default Comments;