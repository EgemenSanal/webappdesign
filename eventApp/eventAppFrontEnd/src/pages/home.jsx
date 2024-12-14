import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

export default function Home() {
    const [events, setEvents] = useState([]);
    
    async function getEvents() {
        const res = await fetch('/api/events');
        const data = await res.json();
        
        if (res.ok) {
            setEvents(data);
        }
        console.log(data)
    }

    useEffect(() => {
        getEvents();
    }, []);

    return (
        <>
            <h1 className="title mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl ">Events</h1>

            {events.length >0 ? events.map(event =>(
                <div key={event.id} className="mb-4 p-4 border-double border-4 border-teal-500">
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
                className="object-contain md:object-scale-down"
            />
                    <Link to={`/events/${event.id}`} className="bg-blue-500 text-white text-sm rounded-lg px-3 py-1">Read More</Link>
                </div>
                
            )) : <p>There are no events</p>}


<footer class="bg-white rounded-lg shadow m-4 ">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a class="hover:underline">Event App</a>. All Rights Reserved.
    </span>
    
    </div>
</footer>

        </>
    );
}
