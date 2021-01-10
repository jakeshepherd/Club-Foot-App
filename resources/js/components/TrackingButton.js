import React, { useState } from 'react';

function TrackingButton(props) {
    const [tracking, setTracking] = useState(false);

    var buttonColour = (tracking) ? buttonColour = 'bg-red' : buttonColour = 'bg-green'
    return (
        <button
            className={buttonColour + '-200 rounded p-3 w-1/5 mt-5 shadow-md hover:shadow-lg hover:border-transparent hover:text-white hover:' + buttonColour +'-500'}
            onClick={() => setTracking(!tracking)}>
            {props.text} Tracking Boots and Bars Time
        </button>
    );
}

export default TrackingButton;