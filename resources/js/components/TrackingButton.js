import React from 'react';

class TrackingButton extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            tracking: false,
            trackingId: 0,
            trackingDuration: 0
        }
    }

    // is there a way to do this better cos its kind of slow
    componentDidMount() {
        axios.get(`/get-tracking`)
            .then(r => {
                if (r.data.id > 0) {
                    this.setState({
                        trackingId: r.data.id,
                        tracking: true
                    })
                }
            })
    }

    startTracking() {
        if (!this.state.tracking) {
            axios.post(`/start-tracking`)
                .then(r => {
                    this.setState({
                        tracking: !this.state.tracking,
                        trackingId: r.data
                    })
                    console.log(this.state.trackingId)
                })
        } else {
            axios.post(`/${this.state.trackingId}/stop-tracking`)
                .then(r => {
                    this.setState({
                        tracking: !this.state.tracking,
                        trackingDuration: r.data
                    })
                })
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
