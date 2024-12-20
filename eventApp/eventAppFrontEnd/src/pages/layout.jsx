import { useContext } from "react";
import { Link, Outlet, useNavigate } from "react-router-dom";
import { AppContext } from "../Context/AppContext";

export default function Layout(){
    const {user, token, setUser, setToken} = useContext(AppContext)
    const navigate = useNavigate()

    async function handleLogout(e){
        e.preventDefault()
        const res = await fetch('/api/logout',{
            method:'post',
            headers: {
                Authorization: `Bearer ${token}`,
            }
        })
        const data = await res.json()
        console.log(data)
        if(res.ok){
            setUser(null)
            setToken(null)
            localStorage.removeItem("token")
            localStorage.removeItem("userID")
            navigate('/')
        }
    }
    return(
        <>
        <header className=" bg-teal-500">
            <nav className="flex items-center justify-between flex-wrap bg-teal-500 p-6">
                <Link to = "/" className="nav-link">
                    HOME
                    </Link>
                    {user ? ( <div className="flex items-center space-x-4">
                        <p className="text-slate-400 text-xs">WELLCOME BACK {user.name}</p>
                        <Link to = "/create" className="nav-link">
                        Create Event
                    </Link>
                        <form onSubmit={handleLogout}>
                            <button className="nav-link">Logout</button>
                        </form>
                    </div>) : ( 
                    <div className="space-x-4">
                    <Link to = "/register" className="nav-link">
                        Register
                    </Link>
                    <Link to = "/login" className="nav-link">
                        Login
                    </Link>
                    
                    </div>
                    )}
            </nav>
        </header>
        <main>
            <Outlet/>
            
            
        </main>
        </>
    )
}