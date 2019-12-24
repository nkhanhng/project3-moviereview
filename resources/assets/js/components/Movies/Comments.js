import React, { useEffect, useState } from 'react';
import config from '../../config/config.json';
import axios from 'axios';

const Comments = props => {
    const [data, setData] = useState('')
    const [showModal, setShowModal] = useState(false)
    useEffect(() => {
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/movie/1`)
            .then(data => setData(data.data))
            .catch(err => console.log(err))
    }, [])

    const renderComments = () => {
        if(data){
            const commentList = data.map((comment)=>{
                return(
                    <div>
                        <div>Score: {comment.score}</div>
                        <div>Comment: {comment.comment}</div>
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