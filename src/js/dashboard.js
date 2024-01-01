import React from 'react';
import ReactDOM from 'react-dom/client';
import Dashboard from './components/Dashboard.js';
import '../css/dashboard.css';

ReactDOM.createRoot( document.getElementById( 'demo-plugin-dashboard' ) ).render(
    <React.StrictMode>
        <Dashboard />
    </React.StrictMode>,
)