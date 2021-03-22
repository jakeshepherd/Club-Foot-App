import React from 'react';
import {toast} from "react-toastify";

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
    async componentDidMount() {
        await axios.get(`/get-tracking`)
            .then(r => {
                if (r.data.id > 0) {
                    this.setState({
                        trackingId: r.data.id,
                        tracking: true,
                        start_time: r.data.start_time
                    })
                    this.props.startCounting('tracking', this.state.start_time)
                } else {
                    this.props.stopCounting('stopped')
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
                    toast.success('✅ Started tracking')
                })
            this.props.startCounting('tracking')
        } else {
            this.props.stopCounting('stopped')
            axios.post(`/${this.state.trackingId}/stop-tracking`)
                .then(r => {
                    this.setState({
                        tracking: !this.state.tracking,
                        trackingDuration: r.data
                    })
                    toast.info('💾Tracking saved')
                })
        }
        // todo add pause
    }

    render() {
        let buttonColour;
        (this.state.tracking) ? buttonColour = 'bg-red' : buttonColour = 'bg-green';
        let buttonContext;
        (this.state.tracking) ? buttonContext = "Stop" : buttonContext = "Start";
        return (
            <button
                className={'button ' + buttonColour + '-200 p-3 w-3/4 text-2xl md:text-base md:w-1/5 mt-5 hover:' + buttonColour +'-500'}
                onClick={() => {this.startTracking()}}>
                {buttonContext} Tracking Boots and Bars Time
            </button>
        );
    }
}

export default TrackingButton;
