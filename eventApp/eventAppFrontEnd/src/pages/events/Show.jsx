import { useContext, useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom"
import { AppContext } from "../../Context/AppContext";

export default function Show(){

    const {id} = useParams()
    const {user} = useContext(AppContext)
    const [event,setEvent] = useState(null)
    const userid = localStorage.getItem("userID")
    async function getEvents() {
        const res = await fetch(`/api/events/${id}`);
        const data = await res.json();
        if (res.ok) {
            setEvent(data);
        }
        console.log(data)
    }
    useEffect(() =>{
        getEvents()
    },[])
    
    return(
        <>
        {event ? (
                <div key={event.id} className="mb-4 p-4 border-double border-4 border-sky-500">
                    <div className="mb-2 flex items-start justify-between">
                        <div>
                            <h1 className="font-bold text-2xl">Event : {event.description}</h1>
                            <h2 className="font-bold text-1xl text-teal-400">Location : {event.location}</h2>
                            <small className="text-xs text-slate-600">Created By {event.name}</small>
                            <br>
                            </br>
                            <small className="text-xs text-rose-700">Starting Date : {event.starting_date}</small>
                        </div>
                    </div>
                    <img 
                src= "https://www.vcs.ca/wp-content/uploads/2020/04/events.jpg" 
                alt={'eventImage'} 
                className="object-contain md:object-scale-down rounded-lg px-3 py-1"
            />
            {userid == event.organizer_id && <div className="flex items-center justify-end gap-4">
                <Link to={`/events/update/${event.id}`} className="bg-green-500 text-white text-sm rounded-sm">
                    Update
                </Link>
            </div>}
                </div>
            ):( <p>Event not Found!</p>)}
        
        </>

    )

}