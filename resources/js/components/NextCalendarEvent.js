import React from 'react';

class NextCalenderEvent extends React.Component {
    render() {
        return (
            <div className="mt-3 m-auto p-4 rounded bg-blue-200 inline-block shadow-md transition duration-500 hover:shadow-lg hover:border-transparent hover:text-white hover:bg-blue-500 cursor-pointer">
                <p>{this.props.eventDetails.eventName}</p>
                <p className="mt-2 text-4xl">{this.props.eventDetails.eventDate}</p>
                <p className="mt-2">At {this.props.eventDetails.eventTime}</p>
            </div>
        )
    }
}

export default NextCalenderEvent
