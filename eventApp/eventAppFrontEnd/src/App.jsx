import './App.css'
import { BrowserRouter,Routes,Route } from 'react-router-dom'
import Layout from './pages/layout'
import Home from './pages/home'
import Login from './pages/auth/login'
import Register from './pages/auth/register'
import { useContext } from 'react'
import { AppContext } from './Context/AppContext'

export default function App() {

  const {user} = useContext(AppContext)


return <BrowserRouter>

<Routes>
  <Route path='/' element={<Layout/>}>
    <Route index element= {<Home/>} />
    <Route path='/register' element={user ? <Home /> : <Register />}/>
    <Route path='/login' element={user ? <Home /> : <Login />}/>
    
  </Route>
</Routes>


</BrowserRouter>

}

