import React from 'react'

// import dependencies
import {useEffect,useState} from 'react';                   
import axios from 'axios';
// import components
import Cards from '../components/Cards';
import Head from '../components/Head';

const Dashboard = () => {

    // variable declation 
    const [data ,setData] =useState ([]);

     //  use useEffect  to rendering the page  one time
    useEffect( ()=>{
    // call DB with axios and using IPA
        axios.get(" http://localhost:3000/db/data.json")
           .then(response =>{
               console.log(response.data);

               setData(response.data.results);
           })
           .catch(err =>{console.log("thi is error came from axios in get one by id ", err);})
       },[]);


    
 // filter data and  create variable for each filter
const numberOfAllAgent = data.filter(agent => agent.id !== "000" ).length ;
const numberActive = data.filter(agent => agent.status === "active" &&  agent.id !== "000" ).length;
const numberDiconnected = data.filter(agent => agent.status === "disconnected" &&  agent.id !== "000" ).length;
const numberPendingAgents = data.filter(agent => agent.status === "pending" &&  agent.id !== "000" ).length;
const numberNeverConnected = data.filter(agent => agent.status === "never_connected" &&  agent.id !== "000" ).length;

// creates objects that contain all the information of each data type
const allAgent ={
    title :" Total agents ",
    numberOfAgent :numberOfAllAgent ,
    css : "all-Agent"
}

const agentActive ={
    title :" Active agents",
    numberOfAgent :numberActive ,
    css : "actif"
}

const disconnectedAgents  ={
    title :" Disconnected agents  ",
    numberOfAgent :numberDiconnected ,
    css : "disconnected-agents "
}
const pendingAgents   ={
    title :" Pending agents   ",
    numberOfAgent :numberPendingAgents,
    css : "pending-agents"
}

const neverConnected ={
    title :" Never connected agents ",
    numberOfAgent :numberNeverConnected,
    css : "never-connected"
}

  return (

    <div>
        <div>
            <Head />
        </div>
        {/* use props to pass parent component data to child */}
        <div className='all-carts'>
            <div>
                <Cards agent={allAgent}/>
            </div>
            
            <div>
                <Cards agent={agentActive}/>
            </div>
            <div>
                <Cards agent={disconnectedAgents}/>
            </div>
            <div>
                <Cards agent={pendingAgents}/>
            </div>
            <div>
                <Cards agent={neverConnected}/>
            </div>
        </div>
        
    </div>
  )
}

export default Dashboard