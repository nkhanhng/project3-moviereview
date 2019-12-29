import React from 'react';

const NewsDetail = props => {
    const { title, img, des, content, date} = props.location.state;
    return (
        <div className='container'>
            <div className="news-detail">
                <h3>{title}</h3>
                <small>{date}</small>
                <p style={{fontStyle: 'italic'}}>{des}</p>
                <div className="news-img">
                    <img src={img} alt={title}></img>
                </div>
                <div style={{fontSize:"24px"}}>
                    {content}
                </div>
            </div>
        </div>
    )
};

export default NewsDetail;
