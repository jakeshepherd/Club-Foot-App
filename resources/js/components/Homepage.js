import React from 'react';
import ReactDOM from 'react-dom';
import TrackingButton from './TrackingButton';

function Homepage() {
    return (
        <div className="container">
            <TrackingButton 
                text="Start Tracking Boots and Bars Time"
                buttonColour="bg-green-500"
            />
        </div>
    );
}

export default Homepage;

if (document.getElementById('homepage')) {
    ReactDOM.render(<Homepage />, document.getElementById('homepage'));
}
