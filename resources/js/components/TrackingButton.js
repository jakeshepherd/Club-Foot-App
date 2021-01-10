import React from 'react';

class TrackingButton extends React.Component {
    render () {
        var buttonColour = (this.props.text === 'Stop') ? buttonColour = 'bg-red' : buttonColour = 'bg-green'
        return (
            <button className={buttonColour + '-200 rounded p-3 w-1/5 .shadow-md hover:shadow-lg hover:border-transparent hover:text-white hover:' + buttonColour +'-500'}>
                {this.props.text} Tracking Boots and Bars Time
            </button>
        );
    }
}

export default TrackingButton;