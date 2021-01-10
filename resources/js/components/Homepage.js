import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';

function Homepage() {
    return (
        <div className="p-5 m-auto w-10/12 text-center">
            <h1>Your Adherance for the last 7 days</h1>
            <p>Placeholder!</p>
            <h2>14.5 hours a day on average</h2>
            <TrackingButton 
                text="Start Tracking Boots and Bars Time"
                buttonColour="bg-green-200"
            />
        </div>
    );
}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage />, document.getElementById('homepage'));
}
