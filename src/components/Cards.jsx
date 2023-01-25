import React from 'react'
import Card from 'react-bootstrap/Card';
// import 'bootstrap/dist/css/bootstrap.min.css';

const Cards = (props) => {
    const agent=props.agent;
    console.log(agent);
  return (
    <div >
        <Card style={{ width: '14rem' , height:"14rem" }} className='cart shadow'>
      <Card.Body className='cart'>
        <Card.Subtitle> <p>{agent.title}</p> </Card.Subtitle>
        <Card.Text >    
        <h1 className={agent.css}>{agent.numberOfAgent}</h1>
        </Card.Text>
      </Card.Body>
    </Card>

    </div>
  )
}

export default Cards