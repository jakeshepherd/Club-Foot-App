import React from 'react';

class NextCalenderEvent extends React.Component {
    render() {
        return (
            <div className="button mt-3 p-4 bg-blue-200 hover:bg-blue-500">
                <p>{this.props.eventDetails.eventName}</p>
                <p className="mt-2 text-4xl">{this.props.eventDetails.eventDate}</p>
                <p className="mt-2">At {this.props.eventDetails.eventTime}</p>
            </div>
        )
    }
}

export default NextCalenderEvent
