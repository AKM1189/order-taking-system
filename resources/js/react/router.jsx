import React from 'react';
import ReactDOM from 'react-dom/client';
import {createBrowserRouter} from 'react-router-dom';
import Home from './home.jsx';
// import NotFound from './views/not-found.jsx';
// import MenuList from './views/menu/MenuList.jsx';

const router = createBrowserRouter([
    {
        path: '*',
        element: <Home/>,
    },
    // {
    //     path: '/menu',
    //     element: <MenuList/>
    // },
    // {
    //     path: '*',
    //     element: <NotFound/>
    // }
])
 
export default router;