import React from 'react';

class TrackingButton extends React.Component {
    constructor() {
        super();
        this.state = {
            tracking: false
        }
    }

    startTracking() {
        if (!this.state.tracking) {
            axios.post('/start-tracking')
                .then(r => {
                    console.log(r.data)
                    this.setState({tracking: !this.state.tracking})
                })
        } else {
            this.setState({tracking: !this.state.tracking})
        }
    }

    render() {
        var buttonColour = (this.state.tracking) ? buttonColour = 'bg-red' : buttonColour = 'bg-green'
        var buttonContext = (this.state.tracking) ? buttonContext = "Stop" : buttonContext = "Start"
        return (
            <button
                className={buttonColour + '-200 rounded p-3 w-1/5 mt-5 shadow-md transition duration-500 hover:shadow-lg hover:border-transparent hover:text-white hover:' + buttonColour +'-500'}
                onClick={() => {this.startTracking()}}>
                {buttonContext} Tracking Boots and Bars Time
            </button>
        );
    }
}

export default TrackingButton;
