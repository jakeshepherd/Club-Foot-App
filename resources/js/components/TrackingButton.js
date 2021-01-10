import React from 'react';

class TrackingButton extends React.Component {
    render () {
        var style = this.props.buttonColour + ' rounded p-3 w-3/12'
        return (
            <button className={style}>{this.props.text}</button>
        );
    }
}

export default TrackingButton;