import { useContext, useState } from "react"
import { AppContext } from "../../Context/AppContext"
import { Navigate, useNavigate } from "react-router-dom"

export default function Create(){
    const navigate = useNavigate()
    const {token} = useContext(AppContext)
    const {user} = useContext(AppContext)
    const userid = localStorage.getItem("userID")
    const [formData, setFormData] = useState({
        name:'',
        description:'',
        location:'',
        organizer_id: `${userid}`
    })
    const [errors,setErrors] = useState({})
    async function handleCreate(e){
        e.preventDefault()
        console.log(user.id);
        const res = await fetch('/api/createEvent',{
            method: 'post',
            headers: {
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(formData)
        })
        const data = await res.json()
        if (data.errors) {
            setErrors(data.errors)
        } else {
            navigate('/')
        }
    }
    return(
        <>
        
        <h1 className="title">Create Event</h1>
        <form onSubmit={handleCreate} className="w-1/2 mx-auto space-y-6">
            <div>
                <input type="text" placeholder="Event owner name" value={formData.name} onChange={e =>setFormData({...formData,name: e.target.value})}/>
                {errors.name && <p className="error">{errors.name[0]}</p>}
            </div>
            <div>
                <textarea rows="6" placeholder="Post Event Description"  value={formData.description} onChange={e =>setFormData({...formData,description: e.target.value})}></textarea>
                {errors.description && <p className="error">{errors.description[0]}</p>}
            </div>
            <div>
                <input type="text" placeholder="Location" value={formData.location} onChange={e =>setFormData({...formData,location: e.target.value})}/>
                {errors.location && <p className="error">{errors.location[0]}</p>}
            </div>
            <div>
                <input type="date" placeholder="Starting Date" value={formData.starting_date} onChange={e =>setFormData({...formData,starting_date: e.target.value})}/>
            </div>
            
            <button className="primary-btn">Create</button>
        </form>
        </>
    )
}