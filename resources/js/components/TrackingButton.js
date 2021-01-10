import React from 'react';

class TrackingButton extends React.Component {
    render () {
        var style = this.props.buttonColour + ' rounded p-3 w-1/5 .shadow-md hover:shadow-lg hover:bg-green-500 hover:border-transparent hover:text-white'
        return (
            <button className={style}>{this.props.text}</button>
        );
    }
}

export default TrackingButton;